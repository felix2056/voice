<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Events\NewMail;

use App\Notifications\YouHaveNewMail;

use App\User;
use App\Mail;

class MailController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $mails = Mail::where('receiver_id', $user->id)->where('status', '!=', 'drafted')->get();

        foreach ($mails as $mail) {
            $mail['receiver'] = User::find($mail->receiver_id);
            $mail['sender'] = User::find($mail->user_id);
        }

        return response()->json(['mails' => $mails]);
    }

    public function show($slug)
    {
        $mail = Mail::where('slug', $slug)->first();
        $mail['receiver'] = User::find($mail->receiver_id);
        $mail['sender'] = User::find($mail->user_id);

        return response()->json(['mail' => $mail]);
    }

    public function sent()
    {
        $user = User::find(Auth::user()->id);
        $mails = Mail::where('user_id', $user->id)->get();

        foreach ($mails as $mail) {
            $mail['receiver'] = User::find($mail->receiver_id);
            $mail['sender'] = User::find($mail->user_id);
        }

        return response()->json(['mails' => $mails]);
    }

    public function starred()
    {
        $user = User::find(Auth::user()->id);
        $mails = Mail::where('receiver_id', $user->id)->where('status', 'starred')->get();

        foreach ($mails as $mail) {
            $mail['receiver'] = User::find($mail->receiver_id);
            $mail['sender'] = User::find($mail->user_id);
        }

        return response()->json(['mails' => $mails]);
    }

    public function drafted()
    {
        $user = User::find(Auth::user()->id);
        $mails = Mail::where('user_id', $user->id)->where('status', 'drafted')->get();

        foreach ($mails as $mail) {
            $mail['receiver'] = User::find($mail->receiver_id);
            $mail['sender'] = User::find($mail->user_id);
        }

        return response()->json(['mails' => $mails]);
    }

    public function trashed()
    {
        $user = User::find(Auth::user()->id);
        $mails = Mail::where('receiver_id', $user->id)->where('status', 'trashed')->get();

        foreach ($mails as $mail) {
            $mail['receiver'] = User::find($mail->receiver_id);
            $mail['sender'] = User::find($mail->user_id);
        }

        return response()->json(['mails' => $mails]);
    }

    public function star(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $mail = Mail::find($request->mail_id);

        if ($mail->receiver_id == $user->id) {
            $mail->status = 'starred';
            $mail->save();   
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'subject' => 'required|min:5|max:50',
            'body' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 418);
        }

        $user = User::find(Auth::user()->id);

        $receiver = User::where('email', $request->to)->first();

        if (!$receiver) {
            return response()->json([
                'error' => 'This user does not exist! Get the email right'
            ]);
        }

        $subject = $request->subject;
        $body = $request->body;

        $mail = new Mail();
        $mail->user_id = $user->id;
        $mail->receiver_id = $receiver->id;
        $mail->subject = $subject;
        $mail->body = $body;

        $mail->save();

        $data = [];
        $data['sender'] = $user->name;
        $data['link'] = $mail->slug;
        $data['body'] = $mail->body;

        
        $receiver->notify(new YouHaveNewMail($data));
        
        broadcast(new NewMail($mail->load('user')))->toOthers();
        

        return response()->json([
            'success' => 'Your mail has been sent!'
        ]);        
    }
}

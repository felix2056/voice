<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\NewMessage;

use App\User;
use App\Chatroom;
use App\Events\NewChatroomMessage;

class ChatroomController extends Controller
{
    public function chatroom()
    {
        $messages = Chatroom::with('user')->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);
          
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 418);
        }

        $user = User::find(Auth::user()->id);
        
        $body = $request->message;

        $message = new Chatroom;
        $message->user_id = $user->id;
        $message->body = $body;

        $message->save();

        broadcast(new NewChatroomMessage($message->load('user')))->toOthers();

        return response()->json([
                'message' => $message->load('user')
        ], 200);
    }
}

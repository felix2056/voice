<?php

namespace App\Http\Controllers;

use App\Broadcast;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Events\NewBroadcast;

use App\User;

class BroadcastController extends Controller
{
    public function index()
    {
        $broadcasts = Broadcast::with('user')->get();
        return response()->json(['broadcasts' => $broadcasts]);
    }

    public function stream(Request $request)
    {
        $broadcast = Broadcast::with('user')->where('id', $request->broadcast_id)->first();

        if ($broadcast) {
            $stream = $broadcast->source_url;
            
            $data = [
                'username' => $broadcast->user->name,
                'avatar' => $broadcast->user->avatar_url,
                'source' => $stream
            ];

            broadcast(new NewBroadcast($data))->toOthers();
            
            return response()->json([
                'success' => 'Broadcast now playing'
            ], 200);
        }
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json('Invalid Broadcast', 418);
        }

        $user = User::find(Auth::user()->id);

        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioname = time() . '_' . $audio->getClientOriginalName();

            $audio->storeAs('public/broadcasts/', $audioname);

            $broadcast = new Broadcast();
            $broadcast->user_id = $user->id;
            $broadcast->source = $audioname;
            $broadcast->save();
        }

        return response()->json([
            'success' => 'Your broadcast has been uploaded'
        ], 200);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'broadcast_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json('Cannot Resolve Broadcast', 418);
        }

        $broadcast = Broadcast::find($request->broadcast_id);
        $broadcast_exists = Storage::exists('public/broadcasts/' . $broadcast->source);

        if ($broadcast_exists) {
            Storage::delete('public/broadcasts/' . $broadcast->source);
        }

        $broadcast->delete();

        return response()->json([
            'success' => 'This broadcast has been deleted'
        ], 200);
    }

    public function trigger(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $message = $request->message;

        broadcast(new NewBroadcast($message))->toOthers();
    }
}

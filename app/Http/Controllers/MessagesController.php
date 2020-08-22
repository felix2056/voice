<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Conversation;
use App\User;

use App\Events\NewMessage;
use App\Events\NewNotification;

class MessagesController extends Controller
{
    public function getConversations()
    {
        $user = User::find(Auth::user()->id);

        $conversations = [];

        $receiver_conversations = Conversation::where('second_user_id', $user->id)
            ->latest()
            ->get();

        if (count($receiver_conversations)) {
            foreach ($receiver_conversations as $convo) {
                $convo['person'] = User::find($convo->first_user_id);
            }
        }

        $sender_conversations = Conversation::where('first_user_id', $user->id)
            ->latest()
            ->get();

        if (count($sender_conversations)) {
            foreach ($sender_conversations as $convo) {
                $convo['person'] = User::find($convo->second_user_id);
            }
        }

        $conversations = array_merge($receiver_conversations->toArray(), $sender_conversations->toArray());

        return response()->json(['conversations' => $conversations]);
    }

    public function fetchMessages($slug)
    {
        $user = User::find(Auth::user()->id);
        $otherUser = User::where('slug', $slug)->first();

        if ($user->id == $otherUser->id) {
            return redirect()->back();
        }

        $conversation = Conversation::where(function ($query) use ($user, $otherUser) {
            $query->where('first_user_id', $user->id)->where('second_user_id', $otherUser->id);
        })->orWhere(function ($query) use ($user, $otherUser) {
            $query->where('first_user_id', $otherUser->id)->where('second_user_id', $user->id);
        })->first();


        if (!$conversation) {
            return response()->json([
                'messages' => null,
                'otherUser' => $otherUser
            ]);
        }

        $messages = $conversation->messages;

        foreach ($messages as $message) {
            if ($message->seen === 0 && ($message->user_id !== \Auth::user()->id)) {
                $message->seen = 1;
                $message->save();
            }

            $message['user'] = User::find($message->user_id);
        }

        return response()->json([
            'messages' => $messages,
            'otherUser' => $otherUser
        ]);
    }

    public function fetchConvoMessages($conversation_id)
    {
        $conversation = Conversation::find($conversation_id);
        $messages = $conversation->messages;

        foreach ($messages as $message) {
            if ($message->seen === 0 && ($message->user_id !== \Auth::user()->id)) {
                $message->seen = 1;
                $message->save();
            }

            $message['user'] = User::find($message->user_id);
        }

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
        $otherUser = User::find($request->user_id);

        $body = $request->message;

        $conversation = Conversation::where(function ($query) use ($user, $otherUser) {
            $query->where('first_user_id', $user->id)->where('second_user_id', $otherUser->id);
        })->orWhere(function ($query) use ($user, $otherUser) {
            $query->where('first_user_id', $otherUser->id)->where('second_user_id', $user->id);
        })->first();


        if (!$conversation) {
            $conversation = new Conversation;

            $conversation->first_user_id = $user->id;
            $conversation->second_user_id = $otherUser->id;
            $conversation->save();
        }


        $message = $conversation->messages()->create([
            'user_id' => $user->id,
            'body' => $body
        ]);

        broadcast(new NewMessage($message->load('user'), $otherUser))->toOthers();

        return response()->json([
            'message' => $message->load('user')
        ], 200);
    }
}

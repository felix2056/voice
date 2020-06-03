<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\NewBroadcast;

use App\User;

class BroadcastController extends Controller
{
    public function triggerBroadcast(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $message = $request->message;

        broadcast(new NewBroadcast($message))->toOthers();
    }
}

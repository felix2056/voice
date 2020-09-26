<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('mail', function ($user) {
    return Auth::check();
});

Broadcast::channel('chat.{member}', function ($user, $member) {
    return $user->id == $member;
});

Broadcast::channel('notify.{member}', function ($user, $member) {
    return $user->id == $member;
});

Broadcast::channel('post', function ($user) {
    return Auth::check();
});

Broadcast::channel('chatroom', function ($user) {
    return Auth::check();
});

Broadcast::channel('broadcast', function ($user) {
    return Auth::check();
});
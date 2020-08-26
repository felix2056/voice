<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
    }

    public function recent()
    {
        $profiles = User::latest()->limit(9)->get();
        return response()->json(['profiles' => $profiles]);
    }

    public function members()
    {
        $viewers = User::role('Viewer')->get();

        return response()->json(['viewers' => $viewers]);
    }
    
    public function show($slug)
    {
        $profile = User::where('slug', $slug)->first();

        return response()->json([
            'profile' => $profile
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phonenumber' => 'required|numeric',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postalcode' => 'required'
        ]);

        if ( $request->has('email')) {
            if ( $request->email != Auth::user()->email ) {
                $validator['email'] = 'email|unique:users';
            }
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 418);
        }

        $user = User::find(Auth::user()->id);
        
        $user->name = $request->name;
        //$user->email = $request->email;

        //Set email verified at to null so user must re-confirm his new email
        //$user->email_verified_at = null;

        $user->phonenumber = $request->phonenumber;
        $user->street = $request->street;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->postalcode = $request->postalcode;

        $user->facebook = $request->facebook;
        $user->instagram = $request->instagram;
        $user->twitter = $request->twitter;
        $user->linkedin = $request->linkedin;

        $user->save();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $exists = Storage::exists('avatars/'. $user->id .'/avatar.png');

            if ($exists) {
               Storage::delete('avatars/'. $user->id .'/avatar.png');
            }

            $avatar->storeAs('public/avatars/'. $user->id, 'avatar.png');
        }

        return response()->json([
            'success' => 'Your records has been updated'
        ]);
    }

    public function notifications()
    {
        $user = User::find(Auth::user()->id);

        $notifications = $user->notifications;

        return response()->json([
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $notifications = $user->notifications->where('id', $request->id);
        $notifications->markAsRead();

        return response()->json([
            'notifications' => $notifications
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;
use App\User;
use App\UserProfile;
use App\ReadStatus;


class UserController extends Controller
{
  public function profile($slug)
  {
    $user = $this->getUser($slug);
    $statusModel = new ReadStatus;

    $pend = "";

    if ($user->id == auth()->user()->id) {
      $pend = $statusModel->getPendingMessage(auth()->user()->id);
    }

    $roles = DB::table('roles')->where('name', '!=', 'Admin')->get();

    return view('profile', [
      'user' => $user,
      'pend' => $pend,
      'roles' => $roles
    ]);
  }

  public function billing()
  {
    $user = $this->getUser();
    $statusModel = new ReadStatus;
    $pend = $statusModel->getPendingMessage(auth()->id());

    $classes = [
      'dashboard' => '',
      'account' => 'active',
      'admin' => '',
      'message' => ''
    ];

    return view('billing', [
      'user' => $user,
      'pend' => $pend,
      'classes' => $classes
    ]);
  }

  public function getUser($slug)
  {
    return User::where('slug', $slug)->first();
  }

  public function profileChangeRole(Request $request)
  {
    $user = User::find($request->id);

    $currentRole = $request->currentRole;
    $newRole = $request->newRole;

    $user->removeRole($currentRole);
    $user->assignRole($newRole);

    return redirect()->back()->with('success', 'Successfully updated ' .$user->name. ' role to ' .$newRole); 
  }

  public function profileEdit(Request $request)
  {
    $messages = [
        'name.required' => 'The name field is required',
        'email.required' => 'The email field is required',
        //'avatar.max' => 'The :attribute size must be under 2MB.',
        //'avatar.dimensions' => 'The :attribute dimensions max be 430 X 80.',
      ];

      $rules = [
        'name' => 'required|min:5|max:255',
        'email' => 'required|min:3|max:255',
      ];

      $this->validate($request, $rules, $messages);

      $user = User::find(auth()->user()->id);

      if ($user) {
        if($request->hasFile('avatar')) {
          $file = $request->file('avatar');
          
          $exists = Storage::exists('avatars/'. $user->id .'/avatar.png');

          if ($exists) {
            Storage::delete('avatars/'.$user->id.'/avatar.png');
          }

          $path = $image->storeAs('public/avatars/'. $user->id, 'avatar.png');
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');

        $emailExists = User::where('email', $request->get('email'))
          ->where('id', '!=', $user->id)
          ->first();

        if ($emailExists) {
          return redirect()->back()->with('error', 'This email is already taken');
        }

        if ($request->get('oldpass') && $request->get('newpass') && $request->get('confirmnewpass')) {
          if ($request->get('newpass') != $request->get('confirmnewpass')) {
            return redirect()->back()->with('error', 'Both passwords must match');
          }

          if ($request->get('oldpass') != $user->password) {
            return redirect()->back()->with('error', 'Your password is incorrect');
          }

          $user->password = $request->get('newpass');
        }

        $user->save();

        return redirect('/dashboard')->with('success', 'Your Profile has been updated successfully!'); 
      }

    return redirect()->back()->with('error', 'You have no permission to update this profile!'); 
  }
}

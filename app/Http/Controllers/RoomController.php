<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Message;
use App\User;
use App\ReadStatus;
use Pusher;

class RoomController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
  }

  public function chatRoom() {
    $messages = $this->getMessage();
    $user = User::find(Auth::user()->id);

    ReadStatus::where('user_id', Auth::user()->id)->delete();

    $classes = [
      'dashboard' => '',
      'account' => '',
      'admin' => '',
      'message' => 'active'
    ];

    return view('chatroom', [
      'user' => $user,
      'messages' => $messages,
      'classes' => $classes
    ]);
  }
  
  public function adminChatRoom() {
    $messages = $this->getMessage();
    $user = User::find(Auth::user()->id);

    /*$clients = User::whereHas('roles', function($query) {
      $query->where('role', 'viewer');
    })->get();*/

    $clients = User::role('Viewer')->get();

    $classes = [
      'dashboard' => '',
      'account' => '',
      'admin' => '',
      'message' => 'active'
    ];

    return view('admin.chatroom', [
      'user' => $user,
      'clients' => $clients,
      'messages' => $messages,
      'classes' => $classes
    ]);
  }

  public function getClients() {
    return User::whereHas('roles', function($query) {
      $query->where('role', 'viewer');
    })->get();
  }

  public function getServer() {
    return User::whereHas('roles', function($query) {
      $query->where('role', 'admin');
    })->get();
  }

  public function getMessage() {
    return Message::all();
  }

  public function sendMessage(Request $request) {
    $from = $request->sender_id;
    $color = ($request->color == '#000000') ? '#ffffff' : $request->color;
    $message = $this->convertMessage($request->message);
    $mesModel = new Message();

    $mesModel->user_id = $from;
    $mesModel->message = $message;
    $mesModel->color = $color;
    $mesModel->created_at = date("Y-m-d H:i:s");
    $mesModel->updated_at = date("Y-m-d H:i:s");
    $messageId = $mesModel->save();
    
    $this->setUnReadStatus($messageId);

    $options = array(
      'cluster' => 'us3',
      'useTLS' => true
    );
    $pusher = new Pusher(
      '79a0fc24043fa9a07d29',
      'ad28fb9c5e520d8dc3a0',
      '892326',
      $options
    );
    
    $data = [
      'type' => 'message',
      'name' => auth()->user()->name,
      'message' => $message,
      'messageId' => $messageId,
      'color' => $color,
      'created_at' => date("Y-m-d H:i:s a")
    ];
    $pusher->trigger('my-channel', 'my-event', $data);
  }

  public function authenticate(Request $request) {
    $socketId = $request->socket_id;
    $channelName = $request->channel_name;

    $options = [
      'cluster' => 'us3',
      'useTLS' => true
    ];

    $pusher = new Pusher(
      '79a0fc24043fa9a07d29', 
      'ad28fb9c5e520d8dc3a0', 
      '892326',
      $options
    );

    $presence_data = ['name' => auth()->user()->name];
    $key = $pusher->presence_auth($channelName, $socketId, auth()->id(), $presence_data);

    return response($key);
  }

  public function search($search) {
    $user = User::where('id', auth()->id())->first();
    $mes = new Message();
    $messages = $mes->where('message', 'like', '%'.$search.'%')->get();
    return view('chatroom', [
      'user' => $user,
      'messages' => $messages,
      'search' => $search
    ]);
  }

  protected function convertMessage($message) {
    $mesArray = explode(' ', $message);
    for($i = 0; $i < sizeof($mesArray); $i++) {
      if( stristr($mesArray[$i], 36) ) {
        $replace = "<span class='text-bold text-blue'>" . strtoupper($mesArray[$i]) . "</span>";
        $mesArray[$i] = str_replace($mesArray[$i], $replace, $mesArray[$i]);
      }
    }
    $message = implode(" ", $mesArray);
    
    return $message;
  }

  protected function setUnReadStatus($messageId) {
    $users = $this->getClients();
    if( sizeof($users) > 0 ) {
      foreach( $users as $user ) {
        ReadStatus::insert([
          'user_id' => $user->id,
          'message_id' => $messageId
        ]);
      }
    }
  }

  public function setReadStatus(Request $request) {
    ReadStatus::where('user_id', $request->userId)->delete();

    return "set status";
  }

}

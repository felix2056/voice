<?php

namespace App\Http\Controllers\Ant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Stream;

class AdminBroadcastController extends Controller {
    public function broadcast(){
    	$originUrl = "http://67.205.185.92:5080/";
    	$ip = "67.205.185.92";

        return view('broadcasts.admin.record',[
        	'url' => $originUrl,
        	'ip' => $ip
        ]);
    }

    public function webhook(Request $request){
        $action = $request->action;
        $id = $request->id;

        if ($action == "liveStreamStarted") {
            Stream::create(['stream_id' = $id]);
        }

        if ($action == "liveStreamEnded") {
            Stream::where('stream_id', $id)->delete();
        }
        
        return response()->json([
            'success' => 1,
            'message' => 'API hit by webhook'
        ], 200);
    }
}

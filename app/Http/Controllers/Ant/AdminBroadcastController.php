<?php

namespace App\Http\Controllers\Ant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    	\Log::info($request);
    }
}

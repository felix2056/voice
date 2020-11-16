<?php

namespace App\Http\Controllers\Ant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class BroadcastController extends Controller {
    public function broadcast(){
    	$originUrl = "http://67.205.185.92:5080/";
        $ip = "67.205.185.92:5080";

        return view('broadcasts.streams',[
        	'ip' => $ip,
        ]);
    }


    public function test(){
    	/*$originUrl = "http://67.205.185.92:5080/";
    	$response = Http::get($originUrl.'WebRTCAppEE/rest/v2/broadcasts/075101314461075315719711');


        $decoded = json_decode($response, true);
        print_r($decoded);*/

        return view('broadcasts.template');

        /*echo "<br><br>";

        echo "ID : ". $decoded['streamId'];

        echo "<br><br>";

        echo  "Name : ".$decoded['name'];

        echo "<br><br>";

        echo  "URL : ".$decoded['rtmpURL'];

        echo "<br><br>";

        echo "Status : ".$decoded['status'];

        echo "<br><br>";

        echo "Modified URL : rtmp://67.205.185.92:5080".$decoded['streamId'];*/
        
    }
}

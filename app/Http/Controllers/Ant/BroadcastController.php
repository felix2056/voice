<?php

namespace App\Http\Controllers\Ant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use App\Stream;

class BroadcastController extends Controller {
    public function broadcast(){
    	$originUrl = "http://67.205.185.92:5080/";
        $ip = "67.205.185.92:5080";

        $streams = Stream::get();

        return view('broadcasts.streams',[
        	'ip' => $ip,
            'streams' => $streams
        ]);
    }


    public function test(){
    	$originUrl = "http://67.205.185.92:5080/";
        //$originUrl = "https://ant.bmunyoki.com:5443/";
    	$response = Http::get($originUrl.'WebRTCAppEE/rest/v2/broadcasts/v2/broadcasts/count');


        $decoded = json_decode($response, true);
        print_r($decoded);

        echo "<br><br>";

        echo "ID : ". $decoded['streamId'];

        echo "<br><br>";

        echo  "Name : ".$decoded['name'];

        echo "<br><br>";

        echo  "URL : ".$decoded['rtmpURL'];

        echo "<br><br>";

        echo "Status : ".$decoded['status'];

        echo "<br><br>";

        echo "Modified URL : rtmp://67.205.185.92:5080".$decoded['streamId'];
        //echo "1";
    }
}

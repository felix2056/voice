@extends('layouts.authentication')

@section('content')
<div class="register-box">

    <div class="register-box-body" style="background: #fff; min-height: 300px; margin: 100px auto; padding: 10px;">
        <h3>Live Broadcasts</h3>
        <p>Name: {{ $data['name'] }}</p>
        <!-- <audio controls controlsList="nodownload" style="width: 100% !important">
            <source src="http://67.205.185.92:5080/LiveApp/play.html?name=543759052355131228190000">
        </audio> -->

        <!-- <iframe width="560" height="315" src="http://67.205.185.92:5080/WebRTCAppEE/play.html?name=075101314461075315719711" frameborder="0" allowfullscreen> -->

        <iframe width="560" height="315" src="http://67.205.185.92:5080/LiveApp/play.html?name=617040448705698765237201" frameborder="0" allowfullscreen></iframe>
            
        </iframe>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en" style="height: auto; min-height: 100%;">
<head>
    <?php
    $settings = App\Setting::whereIn(
            'meta_key', [
                'logo',
                'favicon',
                'site_name',
                'short_name',
                'site_desc',
                'site_link',
                'keywords',
                'email',
                'contact_address',
                'contact_email',
                'contact_phone',
                'facebook',
                'twitter',
                'instagram'
            ]
            )->get();

            $metas = [];

            foreach ($settings as $setting){
                $metas[$setting->meta_key] = $setting->meta_value;
            }
            $siteInfo = $metas;
    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="{{ @$siteInfo['site_desc'] }}">
    <meta name="author" content="{{ @$siteInfo['site_name'] }}">
    <link rel="icon" href="@if(@$siteInfo['favicon']){{asset('storage/site/'.$siteInfo['favicon'])}} @else{{ asset('assets/images/site/favicon.png') }}@endif">

    <title>{{ @$siteInfo['site_name'] }} | Authentication</title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('assets/vendor_components/bootstrap/dist/css/bootstrap.css') }}">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}">

    <!--amcharts -->
    <link href="https://www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap-extend -->
    <link rel="stylesheet" href="{{ asset('assets/src/css/bootstrap-extend.css') }}">

    <!-- theme style -->
    <link rel="stylesheet" href="{{ asset('src/css/master_style.css') }}">

    <!-- Crypto_Admin skins -->
    <link rel="stylesheet" href="{{ asset('src/css/skins/_all-skins.css') }}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body class="hold-transition login-page" data-gr-c-s-loaded="true">
    @yield('content')
    
    
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/vendor_components/jquery/dist/jquery.js') }}"></script>

    <!-- popper -->
    <script src="{{ asset('assets/vendor_components/popper/dist/popper.min.js') }}"></script>
        
    <!-- Bootstrap 4.0-->
    <script src="{{ asset('assets/vendor_components/bootstrap/dist/js/bootstrap.js') }}"></script>
    </body>
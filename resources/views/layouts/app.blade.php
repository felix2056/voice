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
    <meta name="description" content="{{ $siteInfo['site_desc'] }}">
    <meta name="author" content="{{ $siteInfo['site_name'] }}">
    <link rel="icon" href="@if($siteInfo['favicon']){{asset('storage/site/'.$siteInfo['favicon'])}} @else{{ asset('assets/images/site/favicon.png') }}@endif">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteInfo['site_name'] }} | Dashboard</title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('assets/vendor_components/bootstrap/dist/css/bootstrap.css') }}">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}">

    <!-- weather weather -->
    <link rel="stylesheet" href="{{ asset('assets/vendor_components/weather-icons/weather-icons.css') }}">
    
    <!--amcharts -->
    <link href="https://www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap-extend -->
    <link rel="stylesheet" href="{{ asset('src/css/bootstrap-extend.css') }}">

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


    <script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/libs/fabric.js/fabric.min.js" async=""></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/libs/FileSaver.js/FileSaver.min.js" async=""></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/libs/jszip/jszip.min.js" async=""></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/libs/pdfmake/pdfmake.min.js" async=""></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/libs/xlsx/xlsx.min.js" async=""></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/libs/pdfmake/vfs_fonts.js" async=""></script>

</head>

<body class="skin-yellow sidebar-mini wysihtml5-supported fixed sidebar-collapse" data-gr-c-s-loaded="true">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'roles' => Auth::user()->getRoleNames(),
            'permissions' => Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray()
        ]) !!};
    </script>

    <div id="app" class="wrapper">
		@yield('content')
    </div>
	<!-- ./wrapper -->
	
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- popper -->
    <script src="{{ asset('assets/vendor_components/popper/dist/popper.min.js') }}"></script>

    <!-- Bootstrap 4.0-->
    {{-- <script src="{{ asset('assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> --}}
    
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- FastClick -->
    <script src="{{ asset('assets/vendor_components/fastclick/lib/fastclick.js') }}"></script>

    <!--amcharts charts -->
    {{-- <script src="http://www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
    <script src="http://www.amcharts.com/lib/3/gauge.js" type="text/javascript"></script>
    <script src="http://www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
    <script src="http://www.amcharts.com/lib/3/amstock.js" type="text/javascript"></script>
    <script src="http://www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
    <script src="http://www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
    <script src="http://www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
    <script src="http://www.amcharts.com/lib/3/themes/patterns.js" type="text/javascript"></script>
    <script src="http://www.amcharts.com/lib/3/themes/dark.js" type="text/javascript"></script> --}}
    
    <!-- EChartJS JavaScript -->
    <script src="{{ asset('assets/vendor_components/echarts-master/dist/echarts-en.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/echarts-liquidfill-master/dist/echarts-liquidfill.min.js') }}"></script>

    <!-- This is data table -->
    <script src="{{ asset('assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js') }}"></script>
    
    <!-- Crypto_Admin App -->
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <!-- Icheck -->
    <script src="{{ asset('assets/vendor_plugins/iCheck/icheck.js') }}"></script>

    <!-- weather for demo purposes -->
	{{-- <script src="{{ asset('assets/vendor_plugins/weather-icons/WeatherIcon.js') }}."></script> --}}

    <!-- Crypto_Admin pages (This is only for demo purposes) -->
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/dashboard-chart.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/notification.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/mailbox.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/widget-weather.js') }}"></script> --}}

    <!-- Crypto_Admin for demo purposes -->
    {{-- <script src="{{ asset('assets/js/demo.js') }}"></script> --}}

    <!-- app.js -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Vticker -->
    <script src="{{ asset('assets/js/vticker.js') }}"></script>

    <!-- webticker -->
    <script src="{{ asset('assets/vendor_components/Web-Ticker-master/jquery.webticker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // $(function() {
            //     $('#webticker-2').vTicker();
            // });
            $('#webticker-2').webTicker();
        })
    </script>
</body>
</html>

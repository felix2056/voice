<!DOCTYPE html>
<html class="st-layout ls-top-navbar-large ls-bottom-footer show-sidebar sidebar-l3" lang="{{ app()->getLocale() }}" class="no-js">
<head>
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon-->
  <link rel="shortcut icon" href="@if($siteInfo['favicon']){{asset('storage/site/'.$siteInfo['favicon'])}} @else{{ asset('assets/images/site/favicon.png') }}@endif">

  <!-- Author Meta -->
  <meta name="author" content="CodeBreaker">

  <!-- Meta Description -->
  <meta name="description" content="{{ $siteInfo['site_desc'] }}">
  
  <!-- Meta Keyword -->
  <meta name="keywords" content="{{ $siteInfo['keywords'] }}">
  
  <!-- meta character set -->
  <meta charset="UTF-8">
  
  <!-- Site Title -->
  <title>{{ $siteInfo['site_name'] }} | Home</title>

  <link href="https://fonts.googleapis.com/css?family=Poppins:100,300,500" rel="stylesheet">
  
  <!--CSS -->
  <link rel="stylesheet" href="{{ asset('assets.landing/css/linearicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets.landing/css/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('assets.landing/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets.landing/css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('assets.landing/css/magnific-popup.css') }}">
  <link rel="stylesheet" href="{{ asset('assets.landing/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets.landing/css/main.css') }}">
</head>

<body>
  <div class="oz-body-wrap">
    <!-- Start Header Area -->
    <header class="default-header">
      <div class="container-fluid">
        <div class="header-wrap">
          <div class="header-top d-flex justify-content-between align-items-center">
            <div class="logo">
              <a href="{{ route('home') }}">
                <img style="max-width: 100px;" src="@if($siteInfo['logo']){{asset('storage/site/'.$siteInfo['logo'])}} @else{{ asset('assets/images/site/logo.png') }}@endif">
              </a>
            </div>
            <div class="main-menubar d-flex align-items-center">
              <!-- nav class="hide" -->
              <nav>
                <a href="{{ route('home') }}">Home</a>
                @auth
                  <a href="{{ route('user.dashboard') }}">Dashboard</a>
                  
                  <a href="{{ url('/dashboard/chat') }}">Messages</a>

                  <a href="{{ url('/dashboard/mailbox') }}">Mailbox</a>

                  <a href="{{ url('/dashboard/profile/' . Auth::user()->slug) }}">Profile</a>

                  <a href="{{ url('/dashboard/newsfeed') }}">Newsfeed</a>

                @else
                  <a href="{{ route('login') }}">Sign In</a>
                  <a href="{{ route('register') }}" style="margin: 25px 0; display: inline-block;">Sign Up</a>
                @endauth
              </nav>
              {{-- <div class="menu-bar"><span class="lnr lnr-menu"></span></div> --}}
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- End Header Area -->
    <!-- Start Banner Area -->
    <section class="banner-area relative">
      <div class="overlay overlay-bg"></div>
      <div class="container">
        <div class="row fullscreen align-items-center justify-content-center">
          <div class="col-lg-10">
            <div class="banner-content text-center">
              <h1 class="text-uppercase text-white">{{ $siteInfo['site_name'] }}</h1>

              @guest
                <a href="{{ route('register') }}" class="genric-btn primary circle arrow">Get Started<span class="lnr lnr-arrow-right"></span></a>
              @endguest

              @auth
              <a href="{{ route('user.dashboard') }}" class="genric-btn primary circle arrow">Dashboard<span class="lnr lnr-arrow-right"></span></a>
              @endauth
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Banner Area -->

    <!-- Strat Footer Area -->
    <footer class="section-gap">
      <div class="container">
        <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap">
          <p class="footer-text m-0">Copyright {{ $siteInfo['site_name'] }} &copy; <?php echo date('Y'); ?> All rights reserved</p>
        </div>
      </div>
    </footer>
    <!-- End Footer Area -->

  </div>

    <script src="{{ asset('assets.landing/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('assets.landing/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets.landing/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets.landing/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets.landing/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets.landing/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets.landing/js/main.js') }}"></script>
  </body>
</html>

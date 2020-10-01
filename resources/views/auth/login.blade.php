@extends('layouts.authentication')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="/dasboard"><b>Voice </b>Dashboard</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="POST" action="{{ route('login') }}" class="form-element">
            @csrf
            <div class="form-group has-feedback">
                <input name="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                @error('email')
                <span class="ion ion-email text-danger">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                @error('password')
                <span class="ion ion-locked text-danger">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="checkbox">
                        <input name="remember" type="checkbox" name="remember" id="basic_checkbox_1" {{ old('remember') ? 'checked' : '' }}>
                        <label for="basic_checkbox_1">Remember Me</label>
                    </div>
                </div>
                <!-- /.col -->
                @if (Route::has('password.request'))
                <div class="col-6">
                    <div class="fog-pwd">
                        {{-- <a href="{{ route('password.request') }}"><i class="ion ion-locked"></i> {{ __('Forgot Your Password?') }}</a><br> --}}
                        <a href="#"><i class="ion ion-locked"></i> {{ __('Forgot Your Password?') }}</a><br>
                    </div>
                </div>
                @endif
                <!-- /.col -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-info btn-block margin-top-10">{{ __('SIGN IN') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-social-icon btn-circle btn-facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" class="btn btn-social-icon btn-circle btn-google"><i class="fa fa-google-plus"></i></a>
        </div>
        <!-- /.social-auth-links -->

        <div class="margin-top-30 text-center">
            <p>Don't have an account? <a href="{{ route('register') }}" class="text-info m-l-5">Sign Up</a></p>
        </div>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection

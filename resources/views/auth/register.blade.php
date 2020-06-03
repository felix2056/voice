@extends('layouts.authentication')

@section('content')
<div class="register-box">

    <div class="register-box-body">
        <div class="register-logo">
            <a href="../../index.html"><b>Voice </b>Dashboard</a>
        </div>
        <p class="login-box-msg">Register a new membership</p>

        <form action="{{ route('register') }}" method="post" class="form-element">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="ion ion-person form-control-feedback ">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="ion ion-email form-control-feedback ">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group has-feedback">
                <input type="tel" name="phonenumber" class="form-control @error('phonenumber') is-invalid @enderror" placeholder="Phone Number" value="{{ old('phonenumber') }}" required autocomplete="phonenumber">

                @error('phonenumber')
                <span class="ion ion-phone form-control-feedback ">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">

                @error('password')
                <span class="ion ion-locked form-control-feedback ">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password">
                <span class="ion ion-log-in form-control-feedback "></span>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="checkbox">
                        <input type="checkbox" id="basic_checkbox_1">
                        <label for="basic_checkbox_1">I agree to the <a href="#"><b>Terms</b></a></label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-info btn-block margin-top-10">SIGN UP</button>
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

        <div class="margin-top-20 text-center">
            <p>Already have an account?<a href="{{ route('login') }}" class="text-info m-l-5"> Sign In</a></p>
        </div>

    </div>
    <!-- /.form-box -->
</div>
@endsection

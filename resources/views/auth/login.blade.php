<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>WATER SERVICES LOGIN</title>
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <style>
            body {
                font-family: "Karla", sans-serif;
                background-color: #d0d0ce;
                min-height: 100vh; }

            .brand-wrapper {
                margin-bottom: 19px; }
            .brand-wrapper .logo {
                height: 37px; }

            .login-card {
                border: 0;
                border-radius: 10px;
                box-shadow: 0 10px 30px 0 rgba(172, 168, 168, 0.43);
                overflow: hidden; }
            .login-card-img {
                border-radius: 0;
                position: absolute;
                width: 100%;
                height: 100%;
                -o-object-fit: cover;
                object-fit: cover; }
            .login-card .card-body {
                padding: 85px 60px 60px; }
            @media (max-width: 422px) {
                .login-card .card-body {
                    padding: 35px 24px; } }
            .login-card-description {
                font-size: 25px;
                color: #000;
                font-weight: normal;
                margin-bottom: 23px; }
            .login-card form {
                max-width: 326px; }
            .login-card .form-control {
                border: 1px solid #d5dae2;
                padding: 15px 25px;
                margin-bottom: 20px;
                min-height: 45px;
                font-size: 13px;
                line-height: 15;
                font-weight: normal; }
            .login-card .form-control::-webkit-input-placeholder {
                color: #919aa3; }
            .login-card .form-control::-moz-placeholder {
                color: #919aa3; }
            .login-card .form-control:-ms-input-placeholder {
                color: #919aa3; }
            .login-card .form-control::-ms-input-placeholder {
                color: #919aa3; }
            .login-card .form-control::placeholder {
                color: #919aa3; }
            .login-card .login-btn {
                padding: 13px 20px 12px;
                background-color: #000;
                border-radius: 4px;
                font-size: 17px;
                font-weight: bold;
                line-height: 20px;
                color: #fff;
                margin-bottom: 24px; }
            .login-card .login-btn:hover {
                border: 1px solid #000;
                background-color: transparent;
                color: #000; }
            .login-card .forgot-password-link {
                font-size: 14px;
                color: #919aa3;
                margin-bottom: 12px; }
            .login-card-footer-text {
                font-size: 16px;
                color: #0d2366;
                margin-bottom: 60px; }
            @media (max-width: 767px) {
                .login-card-footer-text {
                    margin-bottom: 24px; } }
            .login-card-footer-nav a {
                font-size: 14px;
                color: #919aa3; }

            /*# sourceMappingURL=login.css.map */

        </style>
    </head>
    <body style=" background: rgb(111,250,246);
          background: linear-gradient(0deg, rgba(111,250,246,1) 8%, rgba(45,77,253,1) 95%); ">
        <main class="d-flex align-items-center min-vh-100 py-3 py-md-0" style="margin-top: 100px;">
            <div class="container">
                <div class="card login-card">
                    <div class="row no-gutters">
                        <div class="col-md-5">
                            <img src="{{url('water-tap.jpg')}}" alt="login" class="login-card-img">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <div class="brand-wrapper">
                                    @if(\Session::has('message'))
                                    <p class="alert alert-info">
                                        {{ \Session::get('message') }}
                                    </p>
                                    @endif
                                    <h3> {{ trans('panel.site_title') }}</h3>
                                </div>
                                <p class="login-card-description">Sign into your account</p>
                                <form method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="email" class="sr-only">Email</label>
                                        <input name="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                                        @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="password" class="sr-only">Password</label>
                                        <input name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                                        @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                    </div>
                                    <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" style="background:#3054FD !important" value="Login">
                                </form>
                                <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot password?</a>
                                <!--p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p-->
                                <nav class="login-card-footer-nav">
                                    <a href="#!">Terms of use.</a>
                                    <a href="#!">Privacy policy</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
     
    </body>
</html>

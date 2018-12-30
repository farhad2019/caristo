<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
    {{--<link rel="shortcut icon" href="{{ url('storage/app/showroom//favicon-32x32.png') }}" type="image/x-icon">--}}
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

    <link rel="icon" href="{{ asset('storage/app/public/logo-mini.png') }}" type="image/x-icon">

    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('public/css/showroom/lib.css') }}">
    <link rel="stylesheet" href="{{ url('public/css/showroom/style.css') }}">
    <link rel="stylesheet" href="{{ url('public/fonts/showroom/style.css') }}">
    <link rel="stylesheet" href="{{ url('public/css/showroom/responsive.css') }}">

    <!--[if lt IE 9]>
    <script src="{{ url('public/js/showroom/html5.js') }}"></script>
    <![endif]-->

    <style>
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    @stack('css')
</head>

<body class="home-page">

<div class="overlay-bg"></div>
<noscript>
    <div id="jqcheck"><i></i></div>
</noscript>

<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 my-auto">
                <a href="{{ route('admin.dashboard') }}" title="" class="logo">
                    <img src="{{ url('storage/app/showroom/logo.svg') }}" alt="">
                </a>
            </div>
            <div class="col-8 login_info">
                @if(isset(Auth::user()->showroomDetails->logo_url))
                    <figure class="login_dp"
                            style="background-image: url({{ Auth::user()->showroomDetails->logo_url }});"></figure>{{--background-size: 40px;--}}
                @endif
                <h3 class="login_name">
                    <small>Welcome</small>
                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                </h3>
                <div class="login_dropdown">
                    <a href="{!! url('/admin/logout') !!}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign out
                    </a>

                    <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</header><!-- /header -->
<section class="container-fluid p-0 clearfix">
    @yield('content')
</section>

<div class="copyright_text">
    <p>©2018, All Rights Reserved</p>
    <p>Powered BY <a href="https://www.ingic.com" title="" target="_blank">INGIC</a></p>
</div>
<script src="{{ url('public/js/showroom/xlib.js') }}"></script>
<script src="{{ url('public/js/showroom/bootstrap-notify.min.js') }}"></script>
<script src="{{ url('public/js/showroom/script.js') }}"></script>

@stack('scripts')
</body>
</html>
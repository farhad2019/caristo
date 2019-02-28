<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('storage/app/public/logo-mini.png') }}" type="image/x-icon">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ url('public/css/bootstrap-timepicker.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ url('public/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
    <!-- Bootstrap Toggle Switch -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    {{--@yield('css')--}}

    <style>
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .unread {
            background: #afe8f5fa;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        dd {
            word-break: break-all;
        }

        #displayImageSingle {
            margin: 0 0 0 10px !important;
        }

    </style>

    @if(config('constants.laravel-echo-server'))
        <script>
            window.Laravel =
                    {!! json_encode([ 'csrfToken' => csrf_token(), ])!!}
            var module = {};
        </script>
    @endif

    @stack('css')
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ url('/admin/home') }}" class="logo">
                <span class="logo-mini">
                    <img src="{{ asset('storage/app/public/logo-mini.png') }}" width="40">
                    {{--<b style="font-size: 0.5em">{{ config('app.name') }}</b>--}}
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <b>{{ config('app.name') }}</b>
                </span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        @ability('admin' ,'comments.show')
                        @php($notifications = Auth::user()->notificationMaster()->whereHas('details', function ($details){
            return $details->where('status', App\Models\NotificationUser::STATUS_DELIVERED);
        })->where('notification_users.deleted_at', null)->orderBy('created_at', 'DESC')->get())
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle alert-msg" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-success">{{ $notifications->count() == 0?'':$notifications->count() }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You
                                    <span>{{ $notifications->count()==0?'don\'t have any ':'have '.$notifications->count() }}</span>
                                    unread notifications
                                </li>
                                <li>
                                    <ul class="menu">
                                        @foreach($notifications as $notification)
                                            <li>
                                                <a href="{{ route('admin.news.show', $notification->ref_id) }}"
                                                   target="_blank">
                                                    <i class="fa fa-comments text-aqua"></i> {{ $notification->message }}
                                                    by {{ $notification->sender->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                        {{--<li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="{!! Auth::user()->showroomDetails->logo_url !!}"
                                                         width="60" class="img-circle" alt="User Image">
                                                </div>
                                                <h5>
                                                    <strong>New Comment</strong>
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h5>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>--}}
                                    </ul>
                                </li>
                                <li class="footer"><a href="{{ route('admin.notifications.index') }}">View all</a>
                                </li>
                            </ul>
                        </li>
                        @endability
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                @if(Auth::user()->hasRole('showroom-owner'))
                                    @if(isset(Auth::user()->showroomDetails->logo_url))
                                        <img src="{!! Auth::user()->showroomDetails->logo_url !!}"
                                             class="user-image"/>
                                @endif
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">{!! Auth::user()->showroomDetails->name !!}</span>
                            </a>
                            @else
                                <img src="{!! Auth::user()->details->image_url !!}"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                                </a>
                            @endif
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    @if(Auth::user()->hasRole('showroom-owner'))
                                        @if(isset(Auth::user()->showroomDetails->logo_url))
                                            <img src="{!! Auth::user()->showroomDetails->logo_url !!}"
                                                 class="user-image"/>
                                        @endif
                                        <p>
                                            {!! Auth::user()->showroomDetails->name !!}
                                            <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                        </p>
                                    @else
                                        <img src="{!! Auth::user()->details->image_url !!}"
                                             class="img-circle" alt="User Image"/>
                                        <p>
                                            {!! Auth::user()->name !!}
                                            <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                        </p>
                                    @endif
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('admin.users.profile') }}"
                                           class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/admin/logout') !!}" class="btn btn-default btn-flat"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>

                                        <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header clearfix" style="min-height:40px">
                <h1 class="pull-left">@yield('title')</h1>
                {{ Breadcrumbs::render(Route::currentRouteName()) }}
            </section>
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © {{ date('Y')  }} <a href="https://www.ingic.com" target="_blank">INGIC</a>.</strong> All
            rights
            reserved.
        </footer>
        <!-- Modal2 -->
        <div class="modal fade" id="imageGallery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-width" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                    </div>

                    <div class="modal-body">

                        <div class="w3-content w3-display-container" id="displayImage">
                            {{-- Images display here --}}
                        </div>

                        <button class="w3-button w3-black w3-display-left prev">&#10094;</button>
                        <button class="w3-button w3-black w3-display-right next">&#10095;
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="imageGallerySingle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-width" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                    </div>

                    <div class="modal-body">

                        <div class="w3-content w3-display-container" id="displayImageSingle">
                            {{-- Images display here --}}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Modal2 -->
    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/admin/') !!}">
                    {{ config('app.name')  }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/admin/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/admin/login') !!}">Login</a></li>
                    <li><a href="{!! url('/admin/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endif

<!-- jQuery 3.1.1 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--  Bootstrap Toogle switch-->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/js/adminlte.min.js"></script>

<script src="https://adminlte.io/themes/AdminLTE/plugins/bootstrap-slider/bootstrap-slider.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- bootstrap time picker -->
<script src="{{ url('public/js/bootstrap-timepicker.min.js') }}"></script>

<!-- bootstrap datepicker -->
<script src="{{ url('public/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<!-- CK Editor -->
<script src="{{ url('public/ckeditor/ckeditor.js') }}"></script>

<!-- SweetAlert -->
<script src="{{ url('public/vendor/live_url/jquery.liveurl.js') }}"></script>

<script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>

{{--    @yield('scripts')--}}
@stack('scripts')
<script src="{{ url('public/js/admin/custom.js') }}"></script>
{{--<script src="{{ url('public/js/admin/custom_new.js') }}"></script>--}}

<script>
    function confirmCancel(id) {
        swal({
            title: "Are you sure?",
            text: "Do you want to delete this comment?",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: "confirmCancel/" + id,
                    method: 'GET'
                }).done(function (response) {
                    if (response === 'Success') {
                        swal({
                            title: "Success",
                            text: "Comment is deleted",
                            icon: "success"
                        }).then(function (willDelete) {
                            location.reload();
                        });
                    } else {
                        location.reload();
                    }
                });
            }
        });
    }

    $(document).ready(function () {
        setTimeout(function () {
            $('.alert').fadeOut('fast');
        }, 10000);
    });
</script>
@if(config('constants.laravel-echo-server'))
    <script type="text/javascript" src="{{asset('public/js/echo/echo.js')}}"></script>
    <script type="text/javascript" src="http://localhost:6001/socket.io/socket.io.js"></script>
    <script type="text/javascript">
        window.Echo = new Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001'
        });
        //        window.Echo.channel('test-event')
        //            .listen('ExampleEvent', (e) => {
        //                //console.log(e);
        //            });

        window.Echo.channel('job-{{Auth::user()->id}}')
            .listen('NewJobEvent', (e) => {
                console.log('sadsa dsad sa dsa dsd sads adsa');
                console.log(e);
            });
    </script>
@endif
</body>
</html>
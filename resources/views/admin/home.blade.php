@extends('admin.layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            @ability('super-admin' ,'users.index')
            <div class="col-lg-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $users }}</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            @endability

            @ability('super-admin' ,'roles.index')
            <div class="col-lg-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $roles }}</h3>
                        <p>Roles</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-document"></i>
                    </div>
                    <a href="{{ route('admin.roles.index') }}" class="small-box-footer">More info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @endability

            @ability('super-admin' ,'categories.index')
            <div class="col-lg-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $categories }}</h3>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-th-large"></i>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="small-box-footer">More info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @endability

            @ability('super-admin' ,'news.index')
            <div class="col-lg-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ $news }}</h3>
                        <p>News</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-th-list"></i>
                    </div>
                    <a href="{{ route('admin.news.index') }}" class="small-box-footer">More info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @endability

            @ability('super-admin' ,'cars.index')
            <div class="col-lg-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $cars }}</h3>
                        <p>Cars</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-car"></i>
                    </div>
                    <a href="{{ route('admin.cars.index') }}" class="small-box-footer">More info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @endability
        </div>
    </div>
@endsection

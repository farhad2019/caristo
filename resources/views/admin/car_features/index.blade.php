@extends('admin.layouts.app')

@section('title')
    Car Features
@endsection

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.car_features.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection


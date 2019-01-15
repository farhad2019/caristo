@extends('admin.layouts.app')

@section('title')
    Cars Evaluations
@endsection

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.cars_evaluations.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection


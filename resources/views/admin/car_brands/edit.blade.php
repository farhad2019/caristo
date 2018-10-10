@extends('admin.layouts.app')

@section('title')
    {{ $carBrand->name }}
    <small>Car Brand</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        {{--<div class="box box-primary">--}}
        {{--<div class="box-body">--}}
        <div class="row">
            {!! Form::model($carBrand, ['route' => ['admin.carBrands.update', $carBrand->id], 'method' => 'patch', 'files'=>true]) !!}

            @include('admin.car_brands.fields')

            {!! Form::close() !!}
        </div>
        {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection
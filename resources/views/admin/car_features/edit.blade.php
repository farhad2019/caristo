@extends('admin.layouts.app')

@section('title')
    Edit
    <small>Car Feature</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($carFeature, ['route' => ['admin.carFeatures.update', $carFeature->id], 'method' => 'patch', 'files' => true]) !!}
                    @include('admin.car_features.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
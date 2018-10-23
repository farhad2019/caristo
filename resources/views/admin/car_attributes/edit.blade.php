@extends('admin.layouts.app')

@section('title')
    {{ $carAttribute->name }}
    <small>Car Attribute</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($carAttribute, ['route' => ['admin.carAttributes.update', $carAttribute->id], 'method' => 'patch', 'files' => true]) !!}

                    @include('admin.car_attributes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
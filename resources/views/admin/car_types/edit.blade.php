@extends('admin.layouts.app')

@section('title')
    Edit
    <small>Segment</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($carType, ['route' => ['admin.carTypes.update', $carType->id], 'method' => 'patch', 'files' => true]) !!}

                    @include('admin.car_types.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
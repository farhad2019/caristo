@extends('admin.layouts.app')

@section('title')
    Create
    <small>Car Attribute</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.carAttributes.store', 'files' => true]) !!}

                        @include('admin.car_attributes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

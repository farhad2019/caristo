@extends('admin.layouts.app')

@section('title')
    Car Feature
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.carFeatures.store', 'files' => true]) !!}

                        @include('admin.car_features.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

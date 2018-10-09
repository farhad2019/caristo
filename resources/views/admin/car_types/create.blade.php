@extends('admin.layouts.app')

@section('title')
    Car Type
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.carTypes.store']) !!}

                        @include('admin.car_types.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

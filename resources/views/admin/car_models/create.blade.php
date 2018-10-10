@extends('admin.layouts.app')

@section('title')
    Car Model
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        {{--<div class="box box-primary">--}}
            {{--<div class="box-body">--}}
                <div class="row">
                    {!! Form::open(['route' => 'admin.carModels.store']) !!}

                        @include('admin.car_models.fields')

                    {!! Form::close() !!}
                </div>
            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection

@extends('admin.layouts.app')

@section('title')
    Cars Evaluation
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.carsEvaluations.store']) !!}

                        @include('admin.cars_evaluations.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

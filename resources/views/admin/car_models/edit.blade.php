@extends('admin.layouts.app')

@section('title')
    {{ $carModel->name }} <small>Car Model</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       {{--<div class="box box-primary">--}}
           {{--<div class="box-body">--}}
               <div class="row">
                   {!! Form::model($carModel, ['route' => ['admin.carModels.update', $carModel->id], 'method' => 'patch']) !!}

                        @include('admin.car_models.fields')

                   {!! Form::close() !!}
               </div>
           {{--</div>--}}
       {{--</div>--}}
   </div>
@endsection
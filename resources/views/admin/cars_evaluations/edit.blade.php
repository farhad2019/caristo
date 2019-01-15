@extends('admin.layouts.app')

@section('title')
    {{ $carsEvaluation->name }} <small>Cars Evaluation</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($carsEvaluation, ['route' => ['admin.carsEvaluations.update', $carsEvaluation->id], 'method' => 'patch']) !!}

                        @include('admin.cars_evaluations.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
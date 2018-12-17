@extends('admin.layouts.app')

@section('title')
    {{ $car->name }} <small>Car</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($car, ['route' => ['admin.cars.update', $car->id], 'method' => 'patch']) !!}

                        @include('admin.cars.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
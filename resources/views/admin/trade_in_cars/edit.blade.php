@extends('admin.layouts.app')

@section('title')
    {{ $tradeInCar->name }} <small>Trade In Car</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tradeInCar, ['route' => ['admin.tradeInCars.update', $tradeInCar->id], 'method' => 'patch']) !!}

                        @include('admin.trade_in_cars.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
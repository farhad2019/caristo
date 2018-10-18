@extends('admin.layouts.app')

@section('title')
    {{ $carInteraction->name }} <small>Car Interaction</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($carInteraction, ['route' => ['admin.carInteractions.update', $carInteraction->id], 'method' => 'patch']) !!}

                        @include('admin.car_interactions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
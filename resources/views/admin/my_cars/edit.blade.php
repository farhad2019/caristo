@extends('admin.layouts.app')

@section('title')
    {{ $myCar->name }} <small>My Car</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($myCar, ['route' => ['admin.myCars.update', $myCar->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.my_cars.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
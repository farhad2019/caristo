@extends('admin.layouts.app')

@section('title')
    {{ $carVersion->name }} <small>Car Version</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($carVersion, ['route' => ['admin.carVersions.update', $carVersion->id], 'method' => 'patch']) !!}

                        @include('admin.car_versions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
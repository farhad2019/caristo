@extends('admin.layouts.app')

@section('title')
    {{ $engineType->name }} <small>Engine Type</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       {{--<div class="box box-primary">--}}
           {{--<div class="box-body">--}}
               <div class="row">
                   {!! Form::model($engineType, ['route' => ['admin.engineTypes.update', $engineType->id], 'method' => 'patch']) !!}

                        @include('admin.engine_types.fields')

                   {!! Form::close() !!}
               </div>
           {{--</div>--}}
       {{--</div>--}}
   </div>
@endsection
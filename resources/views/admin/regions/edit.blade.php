@extends('admin.layouts.app')

@section('title')
    {{ $region->name }} <small>Region</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($region, ['route' => ['admin.regions.update', $region->id], 'method' => 'patch']) !!}

                        @include('admin.regions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
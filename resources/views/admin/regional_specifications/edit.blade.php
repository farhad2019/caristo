@extends('admin.layouts.app')

@section('title')
    {{ $regionalSpecification->name }} <small>Regional Specification</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($regionalSpecification, ['route' => ['admin.regionalSpecifications.update', $regionalSpecification->id], 'method' => 'patch']) !!}

                        @include('admin.regional_specifications.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
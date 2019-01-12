@extends('admin.layouts.app')

@section('title')
    {{ $reviewAspect->name }} <small>Review Aspect</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($reviewAspect, ['route' => ['admin.reviewAspects.update', $reviewAspect->id], 'method' => 'patch']) !!}

                        @include('admin.review_aspects.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
@extends('admin.layouts.app')

@section('title')
    {{ $chapter->name }} <small>Chapter</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($chapter, ['route' => ['admin.chapters.update', $chapter->id], 'method' => 'patch']) !!}

                        @include('admin.chapters.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
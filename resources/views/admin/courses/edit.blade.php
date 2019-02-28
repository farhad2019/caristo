@extends('admin.layouts.app')

@section('title')
    {{ $course->name }} <small>Course</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($course, ['route' => ['admin.courses.update', $course->id], 'method' => 'patch']) !!}

                        @include('admin.courses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
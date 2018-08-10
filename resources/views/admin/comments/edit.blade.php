@extends('admin.layouts.app')

@section('title')
    {{ $comment->name }} <small>Comment</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($comment, ['route' => ['admin.comments.update', $comment->id], 'method' => 'patch']) !!}

                        @include('admin.comments.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
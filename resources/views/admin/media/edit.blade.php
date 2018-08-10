@extends('admin.layouts.app')

@section('title')
    {{ $media->name }} <small>Media</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($media, ['route' => ['admin.media.update', $media->id], 'method' => 'patch']) !!}

                        @include('admin.media.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
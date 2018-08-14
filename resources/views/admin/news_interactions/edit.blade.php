@extends('admin.layouts.app')

@section('title')
    {{ $newsInteraction->name }} <small>News Interaction</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($newsInteraction, ['route' => ['admin.newsInteractions.update', $newsInteraction->id], 'method' => 'patch']) !!}

                        @include('admin.news_interactions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
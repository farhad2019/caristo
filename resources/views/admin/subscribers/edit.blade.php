@extends('admin.layouts.app')

@section('title')
    {{ $subscriber->name }} <small>Subscriber</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($subscriber, ['route' => ['admin.subscribers.update', $subscriber->id], 'method' => 'patch']) !!}

                        @include('admin.subscribers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
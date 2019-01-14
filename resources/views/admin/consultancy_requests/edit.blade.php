@extends('admin.layouts.app')

@section('title')
    {{ $consultancyRequest->name }} <small>Consultancy Request</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($consultancyRequest, ['route' => ['admin.consultancyRequests.update', $consultancyRequest->id], 'method' => 'patch']) !!}

                        @include('admin.consultancy_requests.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
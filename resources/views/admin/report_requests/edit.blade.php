@extends('admin.layouts.app')

@section('title')
    {{ $reportRequest->name }} <small>Report Request</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($reportRequest, ['route' => ['admin.reportRequests.update', $reportRequest->id], 'method' => 'patch']) !!}

                        @include('admin.report_requests.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
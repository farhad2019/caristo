@extends('admin.layouts.app')

@section('title')
    {{ $personalShopperRequest->name }} <small>Personal Shopper Request</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($personalShopperRequest, ['route' => ['admin.personalShopperRequests.update', $personalShopperRequest->id], 'method' => 'patch']) !!}

                        @include('admin.personal_shopper_requests.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
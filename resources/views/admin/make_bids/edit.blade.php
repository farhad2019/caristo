@extends('admin.layouts.app')

@section('title')
    {{ $makeBid->name }} <small>Make Bid</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($makeBid, ['route' => ['admin.makeBids.update', $makeBid->id], 'method' => 'patch']) !!}

                        @include('admin.make_bids.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
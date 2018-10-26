@extends('admin.layouts.app')

@section('title')
    {{ $bidsHistory->name }} <small>Bids History</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bidsHistory, ['route' => ['admin.bidsHistories.update', $bidsHistory->id], 'method' => 'patch']) !!}

                        @include('admin.bids_histories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
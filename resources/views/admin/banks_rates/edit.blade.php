@extends('admin.layouts.app')

@section('title')
    {{ $banksRate->name }} <small>Banks Rate</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($banksRate, ['route' => ['admin.banksRates.update', $banksRate->id], 'method' => 'patch']) !!}

                        @include('admin.banks_rates.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
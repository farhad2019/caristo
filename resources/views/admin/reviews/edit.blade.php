@extends('admin.layouts.app')

@section('title')
    {{ $review->name }} <small>Review</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($review, ['route' => ['admin.reviews.update', $review->id], 'method' => 'patch']) !!}

                        @include('admin.reviews.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
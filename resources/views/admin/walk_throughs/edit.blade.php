@extends('admin.layouts.app')

@section('title')
    {{ ucwords($walkThrough->title) }}
    <small>Walk Through</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                {{--<div class="row">--}}
                {!! Form::model($walkThrough, ['route' => ['admin.walkThroughs.update', $walkThrough->id], 'method' => 'patch','files'=>true]) !!}

                @include('admin.walk_throughs.fields')

                {!! Form::close() !!}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection
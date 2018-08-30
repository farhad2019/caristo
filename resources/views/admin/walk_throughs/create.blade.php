@extends('admin.layouts.app')

@section('title')
    Walk Through
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.walkThroughs.store','files'=>true]) !!}

                    @include('admin.walk_throughs.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title')
    Media
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.media.store']) !!}

                        @include('admin.media.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title')
    News
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.news.store']) !!}

                        @include('admin.news.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title')
    {{ $news->name }}
    <small>News</small>
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($news, ['route' => ['admin.news.update', $news->id], 'method' => 'patch', 'files' => true]) !!}

                    @include('admin.news.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
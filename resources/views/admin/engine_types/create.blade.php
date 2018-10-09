@extends('admin.layouts.app')

@section('title')
    Engine Type
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.engineTypes.store']) !!}

                        @include('admin.engine_types.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

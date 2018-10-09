@extends('admin.layouts.app')

@section('title')
    My Car
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.myCars.store']) !!}

                        @include('admin.my_cars.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

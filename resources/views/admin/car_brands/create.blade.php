@extends('admin.layouts.app')

@section('title')
    Car Brand
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.carBrands.store', 'files' => true]) !!}

                    @include('admin.car_brands.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

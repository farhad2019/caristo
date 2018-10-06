@extends('admin.layouts.app')

@section('title')
    Car Brand
@endsection

@section('content')
    <div class="content">
        {{--<div class="box box-primary">--}}
        {{--<div class="box-body">--}}
        <div class="row" style="padding-left: 20px">
            <dl class="dl-horizontal">
                @include('admin.car_brands.show_fields')
            </dl>
            <div class='btn-group'>
                @ability('super-admin' ,'carBrands.show')
                <a href="{!! route('admin.carBrands.index') !!}" class="btn btn-default">
                    <i class="glyphicon glyphicon-arrow-left"></i> Back
                </a>
                @endability
            </div>
            <div class='btn-group'>
                @ability('super-admin' ,'carBrands.edit')
                <a href="{{ route('admin.carBrands.edit', $carBrand->id) }}" class='btn btn-default'>
                    <i class="glyphicon glyphicon-edit"></i> Edit
                </a>
                @endability
            </div>
            <div class='btn-group'>
                {!! Form::open(['route' => ['admin.carBrands.destroy', $carBrand->id], 'method' => 'delete']) !!}
                @ability('super-admin' ,'carBrands.destroy')
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', [
                    'type' => 'submit',
                    'class' => 'btn btn-danger',
                    'onclick' => "confirmDelete($(this).parents('form')[0]); return false;"
                ]) !!}
                @endability
                {!! Form::close() !!}
            </div>
        </div>
        {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection
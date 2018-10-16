@extends('admin.layouts.app')

@section('title')
    Car Type
@endsection

@section('content')
    <div class="content">
        {{--<div class="box box-primary">--}}
            {{--<div class="box-body">--}}
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        @include('admin.car_types.show_fields')
                    </dl>
                    {!! Form::open(['route' => ['admin.carTypes.destroy', $carType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @ability('super-admin' ,'carTypes.show')
                        <a href="{!! route('admin.carTypes.index') !!}" class="btn btn-default">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back
                        </a>
                        @endability
                        @ability('super-admin' ,'carTypes.edit')
                        <a href="{{ route('admin.carTypes.edit', $carType->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        @endability
                        @ability('super-admin' ,'carTypes.destroy')
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', [
                            'type' => 'submit',
                            'class' => 'btn btn-danger',
                            'onclick' => "confirmDelete($(this).parents('form')[0]); return false;"
                        ]) !!}
                        @endability
                    </div>
                    {!! Form::close() !!}
                </div>
            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection
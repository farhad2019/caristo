@extends('admin.layouts.app')

@section('title')
    Car Model
@endsection

@section('content')
    <div class="content">
        {{--<div class="box box-primary">--}}
            {{--<div class="box-body">--}}
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        @include('admin.car_models.show_fields')
                    </dl>
                    {!! Form::open(['route' => ['admin.carModels.destroy', $carModel->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @ability('super-admin' ,'carModels.show')
                        <a href="{!! route('admin.carModels.index') !!}" class="btn btn-default">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back
                        </a>
                        @endability
                        @ability('super-admin' ,'carModels.edit')
                        <a href="{{ route('admin.carModels.edit', $carModel->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        @endability
                        @ability('super-admin' ,'carModels.destroy')
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
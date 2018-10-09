@extends('admin.layouts.app')

@section('title')
    Car Feature
@endsection

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        @include('admin.car_features.show_fields')
                    </dl>
                    {!! Form::open(['route' => ['admin.carFeatures.destroy', $carFeature->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @ability('super-admin' ,'carFeatures.show')
                        <a href="{!! route('admin.carFeatures.index') !!}" class="btn btn-default">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back
                        </a>
                        @endability
                        @ability('super-admin' ,'carFeatures.edit')
                        <a href="{{ route('admin.carFeatures.edit', $carFeature->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        @endability
                        @ability('super-admin' ,'carFeatures.destroy')
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', [
                            'type' => 'submit',
                            'class' => 'btn btn-danger',
                            'onclick' => "confirmDelete($(this).parents('form')[0]); return false;"
                        ]) !!}
                        @endability
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
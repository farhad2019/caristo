@extends('admin.layouts.app')

@section('title')
    Banks Rate
@endsection

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        @include('admin.banks_rates.show_fields')
                    </dl>
                    {!! Form::open(['route' => ['admin.banksRates.destroy', $banksRate->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @ability('super-admin' ,'banksRates.show')
                        <a href="{!! route('admin.banksRates.index') !!}" class="btn btn-default">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back
                        </a>
                        @endability
                        @ability('super-admin' ,'banksRates.edit')
                        <a href="{{ route('admin.banksRates.edit', $banksRate->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        @endability
                        @ability('super-admin' ,'banksRates.destroy')
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
@extends('admin.layouts.app')

@section('title')
    Banks Rate
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.banksRates.store', 'files' => true]) !!}

                        @include('admin.banks_rates.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title')
    Engine Type
@endsection

@section('content')
    <div class="content">
        {{--<div class="box box-primary">--}}
            {{--<div class="box-body">--}}
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        @include('admin.engine_types.show_fields')
                    </dl>
                    {!! Form::open(['route' => ['admin.engineTypes.destroy', $engineType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @ability('super-admin' ,'engineTypes.show')
                        <a href="{!! route('admin.engineTypes.index') !!}" class="btn btn-default">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back
                        </a>
                        @endability
                        @ability('super-admin' ,'engineTypes.edit')
                        <a href="{{ route('admin.engineTypes.edit', $engineType->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        @endability
                        @ability('super-admin' ,'engineTypes.destroy')
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
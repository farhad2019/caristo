@extends('admin.layouts.app')

@section('title')
    Regional Specification
@endsection

@section('content')
    <div class="content">
        {{--<div class="box box-primary">--}}
            {{--<div class="box-body">--}}
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        @include('admin.regional_specifications.show_fields')
                    </dl>
                    {!! Form::open(['route' => ['admin.regionalSpecifications.destroy', $regionalSpecification->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @ability('super-admin' ,'regionalSpecifications.show')
                        <a href="{!! route('admin.regionalSpecifications.index') !!}" class="btn btn-default">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back
                        </a>
                        @endability
                        @ability('super-admin' ,'regionalSpecifications.edit')
                        <a href="{{ route('admin.regionalSpecifications.edit', $regionalSpecification->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        @endability
                        @ability('super-admin' ,'regionalSpecifications.destroy')
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
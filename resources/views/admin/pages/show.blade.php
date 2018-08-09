@extends('admin.layouts.app')

@section('title')
    Page
@endsection

@section('content')
    <div class="content">
        <div class="box box-default">
            <div class="row" style="padding-left: 20px">
                <dl class="dl-horizontal">
                    @include('admin.pages.show_fields')
                </dl>
                {!! Form::open(['route' => ['admin.pages.destroy', $page->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @ability('super-admin' ,'pages.show')
                    <a href="{!! route('admin.pages.index') !!}" class="btn btn-default">
                        <i class="glyphicon glyphicon-arrow-left"></i> Back
                    </a>
                    @endability

                    @ability('super-admin' ,'pages.edit')
                    <a href="{{ route('admin.pages.edit', $page->id) }}" class='btn btn-default'>
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                    @endability

                    @ability('super-admin' ,'pages.destroy')
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
@endsection
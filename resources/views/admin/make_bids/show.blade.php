@extends('admin.layouts.app')

@section('title')
    Make Bid
@endsection

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        @include('admin.make_bids.show_fields')
                    </dl>
                    <div class="clearfix"></div>
                {!! Form::open(['route' => 'admin.makeBids.store']) !!}
                <!-- Amount Field -->
                    <div class="form-group col-sm-4">
                        {!! Form::label('amount', 'Bid Amount:') !!}
                        {!! Form::text('amount', empty($bid)?null:number_format($bid->amount,2), ['class' => 'form-control', empty($bid)?'':'readonly']) !!}
                    </div>
                {!! Form::hidden('car_id', $car->id) !!}
                <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        @if(empty($bid))
                            {!! Form::submit('Make Bid', ['class' => 'btn btn-primary']) !!}
                        @endif
                        <a href="{!! route('admin.makeBids.index') !!}" class="btn btn-default">Cancel</a>
                    </div>
                    {!! Form::close() !!}
                    {{--{!! Form::open(['route' => ['admin.makeBids.destroy', $makeBid->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @ability('super-admin' ,'makeBids.show')
                        <a href="{!! route('admin.makeBids.index') !!}" class="btn btn-default">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back
                        </a>
                        @endability
                        @ability('super-admin' ,'makeBids.edit')
                        <a href="{{ route('admin.makeBids.edit', $makeBid->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        @endability
                        @ability('super-admin' ,'makeBids.destroy')
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', [
                            'type' => 'submit',
                            'class' => 'btn btn-danger',
                            'onclick' => "confirmDelete($(this).parents('form')[0]); return false;"
                        ]) !!}
                        @endability
                    </div>
                    {!! Form::close() !!}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('admin.layouts.app')

@section('title')
    Make Bid
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.makeBids.store']) !!}

                        @include('admin.make_bids.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

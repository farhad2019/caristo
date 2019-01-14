@extends('admin.layouts.app')

@section('title')
    Personal Shopper Request
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.personalShopperRequests.store']) !!}

                        @include('admin.personal_shopper_requests.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

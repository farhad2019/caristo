@extends('admin.layouts.app')

@section('title')
    Consultancy Request
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.consultancyRequests.store']) !!}

                        @include('admin.consultancy_requests.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

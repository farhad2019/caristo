@if(!isset($carBrand))
    <!-- Created At Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name*:') !!}
        {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>"50"]) !!}
    </div>

    <!-- Submit Field -->
    {{--<div class="form-group col-sm-12">
        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
        {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
        {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
        <a href="{!! route('admin.carBrands.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
    </div>--}}
@else
    {{--<div class="box">--}}

    <div class="">
        <h3 class="box-title" style="margin-left: 10px">Translations</h3>
    </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach($locales as $key => $locale)
                        <li {{ $key==0?'class=active':'' }}>
                            <a href="#tab_{{$key+1}}" data-toggle="tab">
                                {{ ($locale->native_name===null)?$locale->title:$locale->native_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($locales as $key => $locale)
                        <div class="tab-pane {{$key==0?'active':''}} clearfix" id="tab_{{$key+1}}">
                        @php(App::setLocale($locale->code))
                        <!-- Title Field -->
                            <div class="form-group">
                                {!! Form::label('name', __('Name').':') !!}
                                {!! Form::text('name['.$locale->code.']', $carBrand->translate($locale->code)['name'], ['class' => 'form-control','maxlength'=>"50", 'autofocus', 'style'=>'direction:'.$locale->direction]) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box-body -->
        {{--<div class="box-footer">


        </div>--}}
        <!-- box-footer -->
    {{--</div>--}}
@endif

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Media*:') !!}
    {!! Form::file('media', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}


    @if(isset($carBrand) && count($carBrand->media)>0)

        <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;" >
            <a class='showGallery' data-id='{{ $carBrand->media[0]->id }}' data-toggle='modal'>
                <img src="{{$carBrand->media()->orderby('created_at', 'desc')->first()->fileUrl}}" style="width: 125px;">
            </a>
        </div>

        {{--<a class='showGallery' data-id='{{ $carBrand->media[0]->id }}' data-toggle='modal' data-target='#imageGallery'>
            <img class="" src="{{$carBrand->media()->orderby('created_at', 'desc')->first()->fileUrl}}"
                 alt="{{$carBrand->media()->orderby('created_at', 'desc')->first()->title}}" width="150">
        </a>--}}
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.carBrands.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
</div>
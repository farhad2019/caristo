<div class="box box-primary">
    <div class="box-body">
        <!-- Brand Id Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('brand_id', 'Brand:') !!}
            {!! Form::select('brand_id', $brands, null, ['class' => 'form-control select2']) !!}
        </div>
    @if(!isset($carModel))
        <!-- Name At Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>"20", 'size'=>"20"]) !!}
            </div>

            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
                {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
                <a href="{!! route('admin.carModels.index') !!}" class="btn btn-default">Cancel</a>
            </div>
            <div class="clearfix"></div>
        @else
    </div>
</div>
<div class="clearfix"></div>
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
                    {!! Form::text('name['.$locale->code.']', $carModel->translate($locale->code)['name'], ['class' => 'form-control','maxlength'=>"20", 'size'=>"20", 'autofocus', 'style'=>'direction:'.$locale->direction]) !!}
                </div>
            </div>
        @endforeach
    </div>
    <!-- /.tab-content -->
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.carBrands.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
</div>
</div>
@endif
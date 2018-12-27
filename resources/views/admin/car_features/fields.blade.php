<div class="form-group col-sm-3">
    {{ Form::label('icon', 'Icon') }}
    {{ Form::file('icon', ['class'=>'form-control']) }}
</div>
<div class="form-group col-sm-3">
    @if(isset($carFeature))
        @if($carFeature->media->count() > 0)
            <a class='showGallery' data-id='{{ $carFeature->media[0]->id }}' data-toggle='modal'
               data-target='#imageGallery'>
                <img src="{{ $carFeature->media[0]->file_url }}" width="50"></a>
        @endif
    @endif
</div>

@if(!isset($carFeature))
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>"20", 'size'=>"20"]) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
        {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
        {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
        <a href="{!! route('admin.carFeatures.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
    </div>
@else
    <div class="clearfix"></div>
    <div class="box">
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
                                {!! Form::text('name['.$locale->code.']', $carFeature->translate($locale->code)['name'], ['class' => 'form-control','maxlength'=>"20", 'size'=>"20", 'autofocus', 'style'=>'direction:'.$locale->direction]) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
                <a href="{!! route('admin.carFeatures.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </div>
        <!-- box-footer -->
    </div>

    <div class="clearfix"></div>
@endif
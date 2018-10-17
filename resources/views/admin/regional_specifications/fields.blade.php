@if(!isset($regionalSpecification))
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name*:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
        {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
        {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
        <a href="{!! route('admin.regionalSpecifications.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
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
                                {!! Form::text('name['.$locale->code.']', $regionalSpecification->translate($locale->code)['name'], ['class' => 'form-control', 'autofocus', 'style'=>'direction:'.$locale->direction]) !!}
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
                <a href="{!! route('admin.regionalSpecifications.index') !!}"
                   class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </div>
        <!-- box-footer -->
    </div>
    <div class="clearfix"></div>
@endif
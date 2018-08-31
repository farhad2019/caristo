<div class="row">
    <!-- Type Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('type', 'Type:') !!}
        {!! Form::select('type', \App\Models\WalkThrough::$TYPES_TEXT, null, ['class' => 'form-control select2 walkThroughSelect2']) !!}
    </div>
@if(isset($walkThrough))
    @if($walkThrough->type == 20 || $walkThrough->type == 30 || $walkThrough->type == 40 || $walkThrough->type == 60)
        <!-- Image Field -->
            <div class="form-group col-sm-6 fileUpload">
                {!! Form::label('image', 'Media:') !!}
                {!! Form::file('media') !!}
                <div class="help-block" id="module-hep">
                    * Click to delete image
                </div>
                @foreach($walkThrough->media as $media)
                    <img src="{{ $media->file_url }}" width="80" style="margin-right: 10px" class="delete_image"
                         data-id="{{ $media->id }}">

                    {{--<span class="btn-sm btn-danger delete_attachment" data-id="{{$media->id}}"
                          style="position: absolute; left: 68px; z-index: 100; cursor: hand">×</span>--}}
                @endforeach
            </div>
    @endif
@else
    <!-- Image Field -->
        <div class="form-group col-sm-6 fileUpload">
            {!! Form::label('image', 'Media:') !!}
            {!! Form::file('media') !!}
        </div>
@endif
<!-- Url Field -->
    <div class="form-group col-sm-6 url">
        {!! Form::label('url', 'Media Url:') !!}
        {!! Form::url('url', null, ['class' => 'form-control', 'placeholder'=>'http://....']) !!}
    </div>


</div>
<div class="row">
@if(!isset($walkThrough))
    <!-- Title Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder'=>'Title']) !!}
        </div>

        <!-- Content Field -->
        <div class="form-group col-sm-12 screenContent">
            {!! Form::label('content', 'Content:') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
        </div>
    @else
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach($locales as $key => $locale)
                        <li {{ $key==0?'class=active':'' }}>
                            <a href="#tab_{{$key+1}}"
                               data-toggle="tab">{{ ($locale->native_name === null)?$locale->title:$locale->native_name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($locales as $key => $locale)
                        <div class="tab-pane {{$key == 0?'active':''}}" id="tab_{{ $key+1 }}">
                            <!-- Title Field -->
                            <div class="form-group col-sm-6">
                                {!! Form::label('title', 'Title:') !!}
                                {!! Form::text('title['.$locale->code.']', isset($walkThrough->translate($locale->code)->title)?$walkThrough->translate($locale->code)->title:null, ['class' => 'form-control', 'style'=>'direction:'.$locale->direction]) !!}
                            </div>
                            <!-- Content Field -->
                            <div class="form-group col-sm-12 screenContent">
                                {!! Form::label('content', 'Content:') !!}
                                {!! Form::textarea('content['.$locale->code.']', isset($walkThrough->translate($locale->code)->content)?$walkThrough->translate($locale->code)->content:null, ['class' => 'form-control', 'style'=>'direction:'.$locale->direction]) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    @endforeach
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
@endif

<!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
        @if(!isset($walkThrough))
            {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
        @endif
        {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
        <a href="{!! route('admin.walkThroughs.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
    </div>
</div>
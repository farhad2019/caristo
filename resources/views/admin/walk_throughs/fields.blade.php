<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::select('type', \App\Models\WalkThrough::$TYPES_TEXT, null, ['class' => 'form-control select2']) !!}
</div>

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
                @foreach($locales as $key=>$locale)
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
<!-- Url Field -->
<div class="form-group col-sm-6 url" style="display: none">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::url('url', null, ['class' => 'form-control', 'placeholder'=>'http://....']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6 fileUpload" style="display: none">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('media') !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.walkThroughs.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').on('change', function () {
            var value = $(this).val();
            $('.screenContent').show();
            $('.fileUpload').hide();
            $('.url').hide();

            if (value != 10) {
                if (value == 20 || value == 30) {
                    $('.fileUpload').show();
                    $('.screenContent').hide();
                    $('.url').hide();
                }
                if (value == 40 || value == 60) {
                    $('.fileUpload').show();
                    $('.screenContent').show();
                    $('.url').hide();
                }
                if (value == 50 || value == 70) {
                    $('.fileUpload').hide();
                    $('.screenContent').show();
                    $('.url').show();
                }
            } else {
                $('.screenContent').show();
                $('.fileUpload').hide();
                $('.url').hide();
            }
        });
    });
</script>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>50]) !!}
</div>

<!-- Currency Field -->
<div class="form-group col-sm-6">
    {!! Form::label('currency', 'Currency:') !!}
    {!! Form::text('currency', null, ['class' => 'form-control','maxlength'=>50]) !!}
</div>

<br clear="all">
<!-- Flag Field -->
<div class="form-group col-sm-6">
    {!! Form::label('flag', 'Flag:') !!}
    {!! Form::file('flag', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}

    @if(isset($region))
        <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;">
            <img src="{!! $region->media[0]->file_url !!}" style="width: 125px;">
        </div>
        {{--<div class="col-sm-3">
            <img src="{!! $region->media[0]->file_url !!}" width="45">
        </div>--}}
    @endif
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.regions.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
</div>

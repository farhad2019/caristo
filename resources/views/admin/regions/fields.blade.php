<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Flag Field -->
<div class="form-group col-sm-6">
    {!! Form::label('flag', 'Flag:') !!}
    {!! Form::file('flag', ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.regions.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
</div>

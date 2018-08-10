<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::text('id', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Id:') !!}
    {!! Form::text('category_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Featured Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_featured', 'Is Featured:') !!}
    {!! Form::text('is_featured', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.news.index') !!}" class="btn btn-default">Cancel</a>
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control select2']) !!}
</div>
<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('headline', 'Headline:') !!}
    {!! Form::text('headline', null, ['class' => 'form-control']) !!}
</div>
<!-- Category Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source', 'Source:') !!}
    {!! Form::text('source', null, ['class' => 'form-control']) !!}
</div>
<!-- Is Featured Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_featured', 'Is Featured:') !!}
    {!! Form::hidden('is_featured', 0, ['class' => 'form-control']) !!}
    {!! Form::checkbox('is_featured', 1, null, ['class' => 'form-control', 'data-toggle'=>'toggle']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.news.index') !!}" class="btn btn-default">Cancel</a>
</div>

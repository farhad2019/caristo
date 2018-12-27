<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subtitle', 'Sub Title:') !!}
    {!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', 'Parent Category:') !!}
    {!! Form::select('parent_id', $root, (isset($category) ? $category->parent_id : null), ['class' => 'form-control select2']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-12">
    {!! Form::label('media[]', 'Image:') !!}
    {!! Form::file('media', null, ['class' => 'form-control']) !!}
    @if(isset($category) && count($category->media)>0)
        @foreach($category->media as $media)
            <a class='showGallery' data-id='{{ $media->id }}' data-toggle='modal' data-target='#imageGallery'>
                <img src="{{$media->fileUrl}}" alt="{{$media->title}}" width="150">
            </a>
        @endforeach
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.categories.index') !!}" class="btn btn-default">Cancel</a>
</div>

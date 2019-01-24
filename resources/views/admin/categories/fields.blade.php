<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control', isset($category)?'readonly':'']) !!}
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
<div class="form-group col-sm-6">
    {!! Form::label('media[]', 'Media:') !!}
    {!! Form::file('media', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}
    @if(isset($category) && count($category->media)>0)
        @foreach($category->media as $media)
            <div style="position: relative; display: inline; padding-right: 10px">
                <a class="showGallerySingle" data-id="{{$media->id}}" data-toggle="modal"
                   data-target="#imageGallerySingle" style="cursor: pointer;">
                    <img src="{{ $media->file_url }}"  alt="{{$media->title}}" width="150">
                </a>
                <span class="btn-sm btn-danger delete_media" data-id="{{$media->id}}"
                      style="position: absolute; right: 10px; z-index: 100; cursor: pointer">&times;
                        </span>
            </div>
        @endforeach
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.categories.index') !!}" class="btn btn-default">Cancel</a>
</div>

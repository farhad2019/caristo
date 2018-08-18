<!-- Slug Field -->
<dt>{!! Form::label('slug', 'Slug:') !!}</dt>
<dd>{!! $category->slug !!}</dd>

<!-- Name Field -->
<dt>{!! Form::label('name', 'Name:') !!}</dt>
<dd>{!! $category->name !!}</dd>

<!-- SubTitle Field -->
<dt>{!! Form::label('subtitle', 'Sub Title:') !!}</dt>
<dd>{!! $category->subtitle !!}</dd>

<!-- SubTitle Field -->
<dt>{!! Form::label('parent', 'Parent Category:') !!}</dt>
<dd>{!! $category->parentCategory ? "<span class='label label-success'>".$category->parentCategory->name."</span>" : "<span class='label label-default'>No Parent</span>" !!}</dd>

@if(isset($category) && count($category->media)>0)
    <dt>{!! Form::label('image', 'Image:') !!}</dt>

    <dd>
        @foreach($category->media as $media)
            <img src="{{$media->fileUrl}}" alt="{{$media->title}}" width="150">
        @endforeach
    </dd>
@endif

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created on:') !!}</dt>
<dd>{!! $category->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Last Updated on:') !!}</dt>
<dd>{!! $category->updated_at !!}</dd>

{{--<!-- Deleted At Field -->--}}
{{--<dt>{!! Form::label('deleted_at', 'Deleted At:') !!}</dt>--}}
{{--<dd>{!! $category->deleted_at !!}</dd>--}}


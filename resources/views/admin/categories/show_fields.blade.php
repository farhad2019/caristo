<!-- Slug Field -->
<dt>{!! Form::label('slug', 'Slug:') !!}</dt>
<dd>{!! $category->slug !!}</dd>

<!-- Name Field -->
<dt>{!! Form::label('name', 'Name:') !!}</dt>
<dd>{!! $category->name !!}</dd>

<!-- SubTitle Field -->
<dt>{!! Form::label('subtitle', 'Sub Title:') !!}</dt>
<dd>{!! !empty($category->subtitle) ? $category->subtitle : '-' !!}</dd>

<!-- SubTitle Field -->
<dt>{!! Form::label('parent', 'Parent Category:') !!}</dt>
<dd>{!! $category->parentCategory ? "<span class='label label-success'>".$category->parentCategory->name."</span>" : "<span class='label label-default'>No Parent</span>" !!}</dd>

@if(isset($category) && count($category->media->where('media_type', \App\Models\Media::IMAGE))>0)
    <dt>{!! Form::label('image', 'Image:') !!}</dt>

    <dd>
        @foreach($category->media->where('media_type', \App\Models\Media::IMAGE) as $media)
            {{--<a class='showGallery' data-id='{{ $media->id }}' data-toggle='modal' data-target='#imageGallery'>--}}
            <a class='showGallerySingle' data-id='{{ $media->id }}' data-toggle='modal'
               data-target='#imageGallerySingle'>
                <img src="{{ $media->fileUrl }}" alt="{{$media->title}}" width="150">
            </a>
        @endforeach
    </dd>
@endif
<br>
@if(isset($category) && count($category->media->where('media_type', \App\Models\Media::BANNER_IMAGE))>0)
    <dt>{!! Form::label('image', 'Banner Image:') !!}</dt>

    <dd>
        @foreach($category->media->where('media_type', \App\Models\Media::BANNER_IMAGE) as $count => $media)
            {{--<a class='showGallery' data-id='{{ $media->id }}' data-toggle='modal' data-target='#imageGallery'>--}}
            <a class='showGallery' data-id='{{ $category->id }}' data-source="{{ $count }}" data-toggle='modal' data-target='#imageGallery'>
                <img src="{{$media->fileUrl}}" alt="{{$media->title}}"  width="140" height="90" style="margin-right: 2%">
            </a>
        @endforeach
    </dd>
@endif

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created on:') !!}</dt>
<dd>{!! $category->created_at->format('d M Y') !!}</dd>
<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Last Updated on:') !!}</dt>
<dd>{!! $category->updated_at->format('d M Y') !!}</dd>
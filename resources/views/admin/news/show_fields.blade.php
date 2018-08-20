<!-- Category Id Field -->
<dt>{!! Form::label('category_id', 'Category:') !!}</dt>
{{--<dd>{!! $news->category->name !!}</dd>--}}
<dd>
    <h3 class='label label-success'>{!! $news->category->name !!}</h3>
</dd>


<!-- Headline Field -->
<dt>{!! Form::label('headline', 'Headline:') !!}</dt>
<dd>{!! $news->headline !!}</dd>

<!-- Headline Field -->
<dt>{!! Form::label('description', 'Description:') !!}</dt>
<dd>{!! nl2br($news->description) !!}</dd>

<!-- Headline Field -->
<dt>{!! Form::label('source', 'Source:') !!}</dt>
<dd>{!! $news->source !!}</dd>

<!-- Views Count Field -->
<dt>{!! Form::label('views_count', 'Views Count:') !!}</dt>
<dd><span class='badge badge-success'> <i class='fa fa-eye'></i> {!! $news->views_count  !!}</span></dd>

<!-- Favorite Count Field -->
<dt>{!! Form::label('favorite_count', 'Favorite Count:') !!}</dt>
<dd><span class='badge badge-success'>  <i class='fa fa-star'></i> {!! $news->favorite_count  !!}</span></dd>

<!-- Like Count Field -->
<dt>{!! Form::label('like_count', 'Like Count:') !!}</dt>
<dd><span class='badge badge-success'> <i class='fa fa-thumbs-up'></i> {!! $news->like_count  !!}</span></dd>

<!-- Comments Count Field -->
<dt>{!! Form::label('comments_count', 'Comments Count:') !!}</dt>
<dd><span class='badge badge-success'> <i class='fa fa-comments'></i> {!! $news->comments_count  !!}</span></dd>

<!-- Is Featured Field -->
<dt>{!! Form::label('is_featured', 'Is Featured:') !!}</dt>
<dd>
    <span class='label label-{{App\Helper\Utils::getBoolCss($news->is_featured)}}'> <i
                class='fa fa-{{$news->is_featured ? "check" : "times"}}'></i> {!! App\Helper\Utils::getBoolText($news->is_featured)  !!}</span>
</dd>

@if(isset($news) && count($news->media)>0)
    <dt>{!! Form::label('image', 'Image:') !!}</dt>

    <dd>
        @foreach($news->media as $media)
            <img src="{{$media->fileUrl}}" alt="{{$media->title}}" width="150">
        @endforeach
    </dd>
@endif

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $news->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $news->updated_at !!}</dd>

{{--<!-- Deleted At Field -->--}}
{{--<dt>{!! Form::label('deleted_at', 'Deleted At:') !!}</dt>--}}
{{--<dd>{!! $news->deleted_at !!}</dd>--}}


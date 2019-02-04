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
<dd style="padding: 0 65px 0 0;">{!! nl2br($news->description) !!}</dd>

<!-- Headline Field -->
<dt>{!! Form::label('source', 'Source:') !!}</dt>
<dd>{!! $news->source !!}</dd>

<!-- Headline Field -->
<dt>{!! Form::label('source_image', 'Source Image:') !!}</dt>
<dd>
    @if($news->source_image)
        <img src="{{$news->sourceImageUrl}}" alt="Image not found" width="150" style="padding-top: 10px">
    @endif
</dd>
<br>

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
    @if($news->media[0]->media_type == \App\Models\News::TYPE_IMAGE)
        <dt>{!! Form::label('image', 'Image:') !!}</dt>
        <dd>
            @foreach($news->media as $media)
                <a class='showGallerySingle' data-id='{{ $media->id }}' data-toggle='modal' data-target='#imageGallerySingle'>
                <img src="{{$media->fileUrl}}" alt="{{$media->title}}" width="150">
                </a>
            @endforeach
        </dd>
    @elseif($news->media[0]->media_type == \App\Models\News::TYPE_VIDEO)
        <dt>{!! Form::label('image', 'Video Link:') !!}</dt>
        <dd>
            {{--<a href="{{ $news->media[0]->fileUrl }}" target="_blank">{{ $news->media[0]->fileUrl }}</a>--}}
            @php
                $aa = explode('?v=', $news->media[0]->fileUrl);
                $bb = @$aa[1];
            @endphp
            <a href="{{$news->media[0]->fileUrl}}" target='_blank'><img src='https://img.youtube.com/vi/{{$bb}}/0.jpg'
                                                                         width='150'/></a>;
        </dd>
    @endif
@endif

@if($news->comments()->count() !== 0)
    <h3>Comments</h3>
    <hr>
    <div class="box-footer box-comments" style="width: 98%;">
        @foreach($news->comments as $row)
            <div class="box-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="{{$row->userwithtrash->detailswithtrash->image_url}}" alt="User Image">
                <div class="comment-text">
                      <span class="username">
                        {{$row->userwithtrash->detailswithtrash->first_name.' '.$row->userwithtrash->detailswithtrash->last_name}}
                          <span class="text-muted pull-right">{{ $row->created_at->timezone(session('timezone')) }}</span></br>
                          <span class="text-muted pull-right">
                              <a onclick='confirmCancel("{{ $row->id }} "); return false;' class='btn btn-xs'>
                               <i class="fa fa-trash fa-2x"></i> </a>
                             </span>
                      </span><!-- /.username -->
                    {{ $row->comment_text }}
                </div>
                <!-- /.comment-text -->
            </div>
            <!-- /.box-comment -->
        @endforeach
    </div>
@endif

{{--<!-- Created At Field -->--}}
{{--<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>--}}
{{--<dd>{!! $news->created_at !!}</dd>--}}

{{--<!-- Updated At Field -->--}}
{{--<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>--}}
{{--<dd>{!! $news->updated_at !!}</dd>--}}
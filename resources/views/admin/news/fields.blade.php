<!-- Meta Title Field -->
<div class="form-group col-sm-6 {{ $errors->has('meta_title') ? ' has-error' : '' }}">
    {!! Form::label('meta_title', 'Meta Title:*') !!}
    {!! Form::text('meta_title', isset($news->meta[0])?$news->meta[0]->title:null, ['class' => 'form-control', 'maxLength' => 55, 'required']) !!}
    @if ($errors->has('meta_title'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('meta_title') }}</strong>
        </span>
    @endif
</div>

<!-- Meta Tag Field -->
<div class="form-group col-sm-6 {{ $errors->has('meta_tag') ? ' has-error' : '' }}">
    {!! Form::label('meta_tag', 'Meta Tag:*') !!}
    {!! Form::text('meta_tag', isset($news->meta[0])?$news->meta[0]->tags:null, ['class' => 'form-control', 'maxLength' => 55, 'required']) !!}
    @if ($errors->has('meta_tag'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('meta_tag') }}</strong>
        </span>
    @endif
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-6 {{ $errors->has('Meta Description') ? ' has-error' : '' }}">
    {!! Form::label('meta_description', 'meta_description:*') !!}
    {!! Form::text('meta_description', isset($news->meta[0])?$news->meta[0]->description:null, ['class' => 'form-control', 'maxLength' => 55, 'required']) !!}
    @if ($errors->has('meta_description'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('meta_description') }}</strong>
        </span>
    @endif
</div>

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
    {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'id' => 'editor1', 'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;']) !!}
</div>

<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source', 'Source:') !!}
    {!! Form::text('source', null, ['class' => 'form-control liveUrl', 'placeholder' => 'https://www.example.com']) !!}
</div>

{{--<!-- Related Car Field -->
<div class="form-group col-sm-6">
    {!! Form::label('related_car', 'Related Car:') !!}
    {!! Form::text('related_car', null, ['class' => 'form-control liveUrl', 'placeholder' => 'https://www.example.com']) !!}
</div>--}}

<!-- Source Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source_image', 'Source Image:') !!}
    {!! Form::file('source_image', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}

    @if(isset($news))
        @if($news->source_image)
            <br>
            <img src="{{$news->sourceImageUrl}}" alt="Image not found" width="80" style="padding-top: 10px">
        @endif
    @endif
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6 ">
    {!! Form::label('mediaType', 'Media Type:') !!}
    {!! Form::select('media_type', \App\Models\News::$MEDIA_TYPE, (isset($news) && count($news->media) > 0)?$news->media[0]->media_type:null, ['class' => 'form-control select2', 'id'=>'mediaType']) !!}
</div>
<!-- Slug Field -->
<div class="form-group col-sm-6">
    <div id="image">
        {!! Form::label('image', 'Image:') !!}
        {!! Form::file('image[]',  ['class' => 'form-control', 'multiple', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}
        <br>
        @if(isset($news) && count($news->media) > 0)
            @if($news->media[0]->media_type == \App\Models\News::TYPE_IMAGE)
                @foreach($news->media as $media)
                  {{--  <img src="{{$media->fileUrl}}" alt="{{$media->title}}" width="80" style="padding-top: 10px">--}}
                    <div style="position: relative; display: inline; padding-right: 10px">
                        <a class="showGallery" data-id="{{$media->id}}" data-toggle="modal"
                           data-target="#imageGallery">
                            <img src="{{ $media->file_url }}" width="120">
                        </a>
                        <span class="btn-sm btn-danger delete_media" data-id="{{$media->id}}"
                              style="position: absolute; right: 15px; z-index: 100; cursor: hand">&times;
                        </span>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
    <div id="video" style="display:none;">
        {!! Form::label('video_url', 'Video Url:') !!}
        {!! Form::url('video_url', (isset($news) && count($news->media) > 0)?$news->media[0]->fileUrl:null, ['class' => 'form-control', 'id' => 'videoField']) !!}
    </div>
</div>

<div class="col-sm-12 clearfix"></div>
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

@push('scripts')
<script>
    $(document).ready(function () {
        CKEDITOR.replace('editor1');

        $('#image').hide();
        $('#video').hide();
        var type = $('#mediaType').val();
        if (type == 10) {
            $('#image').show();
        }
        if (type == 20) {
            $('#video').show();
        }

        $('body').on('change', '#mediaType', function () {
            $('#image').hide();
            $('#video').hide();
            $('#videoField').val('');

            var type = $(this).val();
            if (type == 10) {
                $('#image').show();
            }
            if (type == 20) {
                $('#video').show();
            }
        })
    });
</script>
@endpush
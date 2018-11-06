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
    {!! Form::text('source', null, ['class' => 'form-control liveUrl']) !!}
</div>

<!-- Is Featured Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_featured', 'Is Featured:') !!}
    {!! Form::hidden('is_featured', 0, ['class' => 'form-control']) !!}
    {!! Form::checkbox('is_featured', 1, null, ['class' => 'form-control', 'data-toggle'=>'toggle']) !!}
</div>
<div class="col-sm-12 clearfix"></div>
<!-- Slug Field -->
<div class="form-group col-sm-6 ">
    {!! Form::label('mediaType', 'Media Type:') !!}
    {!! Form::select('media_type', \App\Models\News::$MEDIA_TYPE, null, ['class' => 'form-control select2', 'id'=>'mediaType']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    <div id="image">
        {!! Form::label('media[]', 'Image:') !!}
        {!! Form::file('media[]', null, ['class' => 'form-control']) !!}
        @if(isset($news) && count($news->media)>0)
            @foreach($news->media as $media)
                <img src="{{$media->fileUrl}}" alt="{{$media->title}}" width="150">
            @endforeach
        @endif
    </div>
    <div id="video" style="display:none;">
        {!! Form::label('media[]', 'Video Url:') !!}
        {!! Form::url('media', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.news.index') !!}" class="btn btn-default">Cancel</a>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            $('body').on('change', '#mediaType', function () {
                $('#image').hide();
                $('#video').hide();

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
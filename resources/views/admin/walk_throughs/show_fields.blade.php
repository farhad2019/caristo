{{--<div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($locales as $key=>$locale)
                <li {{ $key==0?'class=active':'' }}>
                    <a href="#tab_{{$key+1}}"
                       data-toggle="tab">{{ ($locale->native_name === null)?$locale->title:$locale->native_name }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($locales as $key => $locale)
                @php(App::setLocale($locale->code,'en'))
                <div class="tab-pane {{$key == 0?'active':''}}" id="tab_{{ $key+1 }}">
                    <div class="col-sm-4">
                        <dt>{!! Form::label('title', __('Title').':') !!}</dt>
                        <dd>{!! $walkThrough->title !!}</dd>
                    </div>
                    @if($walkThrough->type != 20 && $walkThrough->type != 30)
                        <div class="col-sm-4">
                            <dt>{!! Form::label('title', __('Content').':') !!}</dt>
                            <dd>{!! $walkThrough->content !!}</dd>
                        </div>
                    @endif
                    <hr>
                </div>
            @endforeach
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
</div>--}}
<!-- /.col -->


<!-- Sort Field -->
<dt>{!! Form::label('title', 'Title:') !!}</dt>
<dd>{!! $walkThrough->title !!}</dd>

<!-- Sort Field -->
<dt>{!! Form::label('content', 'Content:') !!}</dt>
<dd>{!! $walkThrough->content !!}</dd>

<!-- Sort Field -->
<dt>{!! Form::label('sort', 'Sort:') !!}</dt>
<dd>{!! $walkThrough->sort !!}</dd>

@if($walkThrough->type == 20 || $walkThrough->type == 40)
    <!-- Sort Field -->
    <dt>{!! Form::label('sort', 'Media:') !!}</dt>
    <dd>
        @foreach($walkThrough->media as $media)
            <img src="{{ $media->file_url }}" width="80">
        @endforeach
    </dd>
@endif
<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $walkThrough->created_at->format('d M Y') !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $walkThrough->updated_at->format('d M Y')!!}</dd>


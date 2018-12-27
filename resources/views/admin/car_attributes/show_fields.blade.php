<!-- Icon Field -->
<dt>{!! Form::label('icon', 'Icon:') !!}</dt>
<dd>
    @if(isset($carAttribute))
        @if($carAttribute->media->count() > 0)
            <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;">
                <a class='showGallery' data-id='{{ $carAttribute->media[0]->id }}' data-toggle='modal'
                   data-target='#imageGallery'>
                    <img src="{!! $carAttribute->media[0]->file_url !!}" style="width: 125px;" height="75px">
                </a>
            </div>
        @endif
    @endif
</dd>

<br>

<!-- Name Field -->
<dt>{!! Form::label('name', 'Name:') !!}</dt>
<dd>{!! $carAttribute->name !!}</dd>

<!-- Type Field -->
<dt>{!! Form::label('type', 'Type:') !!}</dt>
<dd>{!! $carAttribute->type_text !!}</dd>

@if($carAttribute->type >= 30 && $carAttribute->type < 60)
    <!-- Type Field -->
    <dt>{!! Form::label('type', 'Options:') !!}</dt>
    <dd>
        @foreach($carAttribute->options as $option)
            <li>{!! $option->option !!}</li>
        @endforeach
    </dd>
@endif

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $carAttribute->created_at->format('d M Y') !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $carAttribute->updated_at->format('d M Y') !!}</dd>
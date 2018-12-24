<!-- Name Field -->
<dt>{!! Form::label('name', 'Name:') !!}</dt>
<dd>{!! $region->name !!}</dd>

<!-- Name Field -->
<dt>{!! Form::label('name', 'Flag:') !!}</dt>
<dd><img src="{!! $region->media[0]->file_url !!}" width="45"></dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $region->created_at->format('d M Y') !!}</dd>


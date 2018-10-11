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
<dd>{!! $carAttribute->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $carAttribute->updated_at !!}</dd>
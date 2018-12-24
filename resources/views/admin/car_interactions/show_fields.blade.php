<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $carInteraction->id !!}</dd>

<!-- User Id Field -->
<dt>{!! Form::label('user_id', 'User Id:') !!}</dt>
<dd>{!! $carInteraction->user_id !!}</dd>

<!-- Car Id Field -->
<dt>{!! Form::label('car_id', 'Car Id:') !!}</dt>
<dd>{!! $carInteraction->car_id !!}</dd>

<!-- Type Field -->
<dt>{!! Form::label('type', 'Type:') !!}</dt>
<dd>{!! $carInteraction->type !!}</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $carInteraction->created_at->format('d M Y') !!}</dd>



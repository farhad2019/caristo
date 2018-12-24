<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $reportRequest->id !!}</dd>

<!-- User Id Field -->
<dt>{!! Form::label('user_id', 'User Id:') !!}</dt>
<dd>{!! $reportRequest->user_id !!}</dd>

<!-- Car Id Field -->
<dt>{!! Form::label('car_id', 'Car Id:') !!}</dt>
<dd>{!! $reportRequest->car_id !!}</dd>

<!-- Message Field -->
<dt>{!! Form::label('message', 'Message:') !!}</dt>
<dd>{!! $reportRequest->message !!}</dd>

<!-- Status Field -->
<dt>{!! Form::label('status', 'Status:') !!}</dt>
<dd>{!! $reportRequest->status !!}</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $reportRequest->created_at->format('d M Y') !!}</dd>


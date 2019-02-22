<!-- Sender Id Field -->
<dt>{!! Form::label('sender_id', 'Recipients:') !!}</dt>
<dd>{!! $notification->users_csv !!}</dd>

<!-- Action Type Field -->
<dt>{!! Form::label('action_type', 'Action Type:') !!}</dt>
<dd>{!! \App\Models\Notification::$NOTIFICATION_ACTION_TYPE[$notification->action_type] !!}</dd>

<!-- Message Field -->
<dt>{!! Form::label('message', 'Message:') !!}</dt>
<dd>{!! $notification->message !!}</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Delivery time:') !!}</dt>
<dd>{!! $notification->created_at->timezone(session('timezone'))->format('M d, Y h:s') !!}</dd>
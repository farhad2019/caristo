<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $comment->id !!}</dd>

<!-- Parent Id Field -->
<dt>{!! Form::label('parent_id', 'Parent Id:') !!}</dt>
<dd>{!! $comment->parent_id !!}</dd>

<!-- Post Id Field -->
<dt>{!! Form::label('post_id', 'Post Id:') !!}</dt>
<dd>{!! $comment->post_id !!}</dd>

<!-- User Id Field -->
<dt>{!! Form::label('user_id', 'User Id:') !!}</dt>
<dd>{!! $comment->user_id !!}</dd>

<!-- Comment Text Field -->
<dt>{!! Form::label('comment_text', 'Comment Text:') !!}</dt>
<dd>{!! $comment->comment_text !!}</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $comment->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $comment->updated_at !!}</dd>

<!-- Deleted At Field -->
<dt>{!! Form::label('deleted_at', 'Deleted At:') !!}</dt>
<dd>{!! $comment->deleted_at !!}</dd>


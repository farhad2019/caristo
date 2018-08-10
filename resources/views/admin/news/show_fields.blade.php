<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $news->id !!}</dd>

<!-- Category Id Field -->
<dt>{!! Form::label('category_id', 'Category Id:') !!}</dt>
<dd>{!! $news->category_id !!}</dd>

<!-- User Id Field -->
<dt>{!! Form::label('user_id', 'User Id:') !!}</dt>
<dd>{!! $news->user_id !!}</dd>

<!-- Views Count Field -->
<dt>{!! Form::label('views_count', 'Views Count:') !!}</dt>
<dd>{!! $news->views_count !!}</dd>

<!-- Favorite Count Field -->
<dt>{!! Form::label('favorite_count', 'Favorite Count:') !!}</dt>
<dd>{!! $news->favorite_count !!}</dd>

<!-- Like Count Field -->
<dt>{!! Form::label('like_count', 'Like Count:') !!}</dt>
<dd>{!! $news->like_count !!}</dd>

<!-- Comments Count Field -->
<dt>{!! Form::label('comments_count', 'Comments Count:') !!}</dt>
<dd>{!! $news->comments_count !!}</dd>

<!-- Is Featured Field -->
<dt>{!! Form::label('is_featured', 'Is Featured:') !!}</dt>
<dd>{!! $news->is_featured !!}</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $news->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $news->updated_at !!}</dd>

<!-- Deleted At Field -->
<dt>{!! Form::label('deleted_at', 'Deleted At:') !!}</dt>
<dd>{!! $news->deleted_at !!}</dd>


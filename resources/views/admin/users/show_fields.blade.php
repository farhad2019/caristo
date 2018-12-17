<!-- Name Field -->
<dt>{!! Form::label('name', 'Name:') !!}</dt>
<dd>{!! $user->name !!}</dd>

<!-- Email Field -->
<dt>{!! Form::label('email', 'Email:') !!}</dt>
<dd>{!! $user->email !!}</dd>

<!-- Email Field -->
<dt>{!! Form::label('roles', 'Roles:') !!}</dt>
<dd>{!! $user->rolesCsv !!}</dd>

<!-- Like Field -->
{{--<dt>{!! Form::label('roles', 'Liked / Favorite/ Viewed Cars:') !!}</dt>
<dd><i class="fa fa-heart"></i><a href="#" target="_blank"> {{ $data['like'] }} </a>  <i class="fa fa-star"></i> <a href="#" target="_blank"> {{ $data['favorite'] }} </a>  <i class="fa fa-eye"></i> <a href="#" target="_blank"> {{ $data['view'] }} </a></dd>--}}

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $user->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $user->updated_at !!}</dd>


<div class="col-sm-12">
    <!-- Name Field -->
    <dt>{!! Form::label('name', 'Name:') !!}</dt>
    <dd>{!! $user->name !!}</dd>
</div>

<div class="col-sm-12">
    <!-- Email Field -->
    <dt>{!! Form::label('email', 'Email:') !!}</dt>
    <dd>{!! $user->email !!}</dd>
</div>

<div class="col-sm-12">
    <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
    <dd>{!! $user->details->phone !!}</dd>
</div>

<div class="col-sm-12">
    <dt>{!! Form::label('roles', 'Roles:') !!}</dt>
    <dd>{!! $user->rolesCsv !!}</dd>
</div>

<div class="col-sm-12">
    <dt>{!! Form::label('address', 'Address:') !!}</dt>
    <dd>{!! $user->details->address !!}</dd>
</div>

<div class="col-sm-12">
    <dt>{!! Form::label('about', 'About Us:') !!}</dt>
    <dd>{!! $user->details->about !!}</dd>
</div>


<div>
    <dt>{!! Form::label('Profile', 'Profile Picture:') !!}</dt>
    <dd>{{--<img src="{!! $user->details->image_url !!}"/> --}}
    <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;" >
        <a class='showGallery' data-id='{{ $user->id }}' data-toggle='modal'>
            <img src="{!! $user->details->image_url !!}" style="width: 125px;">
        </a>
    </div>
    </dd>
</div>


<!-- Like Field -->
{{--<dt>{!! Form::label('roles', 'Liked / Favorite/ Viewed Cars:') !!}</dt>
<dd><i class="fa fa-heart"></i><a href="#" target="_blank"> {{ $data['like'] }} </a>  <i class="fa fa-star"></i> <a href="#" target="_blank"> {{ $data['favorite'] }} </a>  <i class="fa fa-eye"></i> <a href="#" target="_blank"> {{ $data['view'] }} </a></dd>--}}

{{--<!-- Created At Field -->--}}
{{--<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>--}}
{{--<dd>{!! $user->created_at !!}</dd>--}}

{{--<!-- Updated At Field -->--}}
{{--<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>--}}
{{--<dd>{!! $user->updated_at !!}</dd>--}}


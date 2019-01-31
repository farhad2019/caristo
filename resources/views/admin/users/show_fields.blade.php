<!-- Like Field -->
{{--<dt>{!! Form::label('roles', 'Liked / Favorite/ Viewed Cars:') !!}</dt>
<dd><i class="fa fa-heart"></i><a href="#" target="_blank"> {{ $data['like'] }} </a>  <i class="fa fa-star"></i> <a href="#" target="_blank"> {{ $data['favorite'] }} </a>  <i class="fa fa-eye"></i> <a href="#" target="_blank"> {{ $data['view'] }} </a></dd>--}}

{{--<!-- Created At Field -->--}}
{{--<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>--}}
{{--<dd>{!! $user->created_at !!}</dd>--}}

{{--<!-- Updated At Field -->--}}
{{--<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>--}}
{{--<dd>{!! $user->updated_at !!}</dd>--}}

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Contact Person</h3>
        <div class="box-tools pull-right">
            <!-- Collapse Button -->
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- Property Title Field -->
        <div class="col-sm-6">
            <!-- Name Field -->
            <dt>{!! Form::label('name', 'Name:') !!}</dt>
            <dd>{!! $user->name !!}</dd>
        </div>
        @if(!isset($user->showroomDetails))
            <div class="col-sm-6">
                <!-- Email Field -->
                <dt>{!! Form::label('email', 'Email:') !!}</dt>
                <dd>{!! $user->email !!}</dd>
            </div>
        @endif

        @if($user->details->dealer_type)
            <div class="col-sm-6">
                <!-- Email Field -->
                <dt>{!! Form::label('email', 'Dealer Type:') !!}</dt>
                <dd>{!! \App\Models\User::$DEALER_TYPE[$user->details->dealer_type] !!}</dd>
            </div>
        @endif
        <div class="col-sm-6">
            <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
            <dd>{!! $user->details->phone ? ($user->details->country_code .'-'.$user->details->phone) : 'N/A' !!}</dd>
        </div>

        <div class="col-sm-6">
            <dt>{!! Form::label('roles', 'Roles:') !!}</dt>
            <dd>{!! $user->rolesCsv !!}</dd>
        </div>

        {{--<div class="col-sm-12">--}}
        {{--<dt>{!! Form::label('address', 'Address:') !!}</dt>--}}
        {{--<dd>{!! $user->details->address !!}</dd>--}}
        {{--</div>--}}

        <div class="col-sm-6">
            <dt>{!! Form::label('dob', 'Date of Birth:') !!}</dt>
            <dd>{!! $user->details->dob ? $user->details->dob : 'N/A' !!}</dd>
        </div>

        <div class="col-sm-6">
            <dt>{!! Form::label('profession', 'Profession:') !!}</dt>
            <dd>{!! $user->details->profession ? $user->details->profession : 'N/A' !!}</dd>
        </div>

        <div class="col-sm-6">
            <dt>{!! Form::label('region', 'Region:') !!}</dt>
            <dd>{!! $user->details->regionDetail->name ? @$user->details->regionDetail->name : 'N/A' !!}</dd>
        </div>

        <div class="col-sm-6">
            <dt>{!! Form::label('gender', 'Gender:') !!}</dt>
            <dd>{!! $user->details->gender == 0 ? 'N/A' : $user->details->gender_label !!}</dd>
        </div>

        {{--<div class="col-sm-12">--}}
        {{--<dt>{!! Form::label('about', 'About Us:') !!}</dt>--}}
        {{--<dd>{!! $user->details->about !!}</dd>--}}
        {{--</div>--}}

        @if(!isset($user->showroomDetails))
            <div class="col-sm-6">
                <dt>{!! Form::label('Profile', 'Profile Picture:') !!}</dt>
                <dd>{{--<img src="{!! $user->details->image_url !!}"/> --}}
                    <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;">
                        <a class='showGallerySingle' data-id='{{ $user->id }}' data-toggle='modal'
                           data-target='#imageGallerySingle'>
                            <img src="{!! $user->details->image_url !!}" style="width: 125px;">
                        </a>
                    </div>
                </dd>
            </div>
        @endif
    </div>
    <!-- /.box-body -->
    <div class="box-footer"></div>
    <!-- box-footer -->
</div>

@if(isset($user->showroomDetails))
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Showroom Information</h3>
            <div class="box-tools pull-right">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <!-- Property Title Field -->
            <div class="col-sm-6">
                <dt>{!! Form::label('gender', 'Showroom Name:') !!}</dt>
                <dd>{!! $user->showroomDetails->name? $user->showroomDetails->name : 'N/A'!!}</dd>
            </div>

            <!-- Property Title Field -->
            <div class="col-sm-6">
                <dt>{!! Form::label('gender', 'Showroom Phone:') !!}</dt>
                <dd>{!! $user->showroomDetails->phone? $user->showroomDetails->phone : 'N/A'!!}</dd>
            </div>

            <!-- Property Title Field -->
            <div class="col-sm-6">
                <dt>{!! Form::label('gender', 'Showroom Email:') !!}</dt>
                <dd>{!! $user->email? $user->email : 'N/A'!!}</dd>
            </div>

            <!-- Property Title Field -->
            <div class="col-sm-6">
                <dt>{!! Form::label('gender', 'Showroom Address:') !!}</dt>
                <dd>{!! $user->showroomDetails->address? $user->showroomDetails->address : 'N/A'!!}</dd>
            </div>

            <!-- Property Title Field -->
            <div class="col-sm-6">
                <dt>{!! Form::label('gender', 'About Showroom:') !!}</dt>
                <dd>{!! $user->showroomDetails->about? $user->showroomDetails->about : 'N/A'!!}</dd>
            </div>

            <!-- Property Title Field -->
            <div class="col-sm-12 clearfix">
                <dt>{!! Form::label('Profile', 'Profile Picture:') !!}</dt>
                <dd>{{--<img src="{!! $user->details->image_url !!}"/> --}}
                    <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;">
                        <a class='showGallerySingle' data-id='{{ $user->showroomDetails->id }}' data-toggle='modal'
                           data-target='#imageGallerySingle'>
                            <img src="{!! $user->showroomDetails->logo_url !!}" style="width: 125px;">
                        </a>
                    </div>
                </dd>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- box-footer -->
    </div>
@endif
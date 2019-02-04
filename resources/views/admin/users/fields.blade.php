@if(!isset($user))

    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:*') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength'=>"20", 'required']) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'Email:*') !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
    </div>

    @if (strpos(Request::url(), 'users') !== false)
        <!-- Roles Field -->
        {{--<div class="form-group col-sm-6">
            {!! Form::label('roles', 'Roles:') !!}
            {!! Form::select('roles[]', $roles, null, ['class' => 'form-control select2', 'multiple'=>'multiple']) !!}
        </div>--}}

        <!-- Dealer Type Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('dealer_type', 'Dealer Type:') !!}
            {!! Form::select('dealer_type', $DEALER_TYPE, null, ['class' => 'form-control select2']) !!}
        </div>

        <!-- Brands Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('brand_ids', 'Brands:') !!}
            {!! Form::select('brand_ids[]', $brands, null, ['class' => 'form-control select2', 'multiple']) !!}
        </div>
    @endif

    <!-- Roles Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('region_id', 'Region:') !!}
        {!! Form::select('region_id', $regions, null, ['class' => 'form-control select2']) !!}
    </div>

    <!-- Add Car Limit Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('limit_for_cars', 'Add Car Limit:*') !!}
        {!! Form::number('limit_for_cars', null, ['class' => 'form-control', 'placeholder' => 'Add Car Limit', 'min'=>1, 'max'=>999, 'required']) !!}
    </div>

    <!-- Featured Cars Limit Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('limit_for_featured_cars', 'Featured Cars Limit:*') !!}
        {!! Form::number('limit_for_featured_cars', null, ['class' => 'form-control', 'placeholder' => 'Featured Cars Limit', 'min'=>1, 'max'=>999, 'required']) !!}
    </div>

    <!-- Expiry Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('expiry_date', 'Date Of Expiry:*') !!}
        {!! Form::date('expiry_date', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="clearfix"></div>
    <!-- Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('password', 'Password:*') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('password_confirmation', 'Confirm Password:*') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('admin.users.index') !!}" class="btn btn-default">Cancel</a>
    </div>
@else
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Profile</a></li>
                @if($user->hasRole('showroom-owner'))
                    <li><a href="#tab_2" data-toggle="tab">Show Room Details</a></li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active clearfix" id="tab_1">
                    <!-- Name Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('name', 'Name:*') !!}
                        {!! Form::text('name', $user->details->first_name?? null, ['class' => 'form-control','maxlength'=>"20", 'size'=>"20"]) !!}
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('profession', 'Profession:*') !!}
                        {!! Form::text('profession', $user->details->profession, ['class' => 'form-control', 'maxLength'=> 15]) !!}
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('gender', 'Gender:') !!}
                        {!! Form::select('gender', $gender, $user->details->gender?? null, ['class' => 'form-control']) !!}
                    </div>
                @if(!$user->hasRole('showroom-owner'))
                    <!-- Email Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('email', 'Email:*') !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                @endif
                <!-- Country Code Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('country_code', 'Country Code:*') !!}
                        {!! Form::text('country_code', $user->details->country_code?? null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('phone', 'Phone:*') !!}
                        {!! Form::number('phone', $user->details->phone, ['class' => 'form-control', 'min'=> 1]) !!}
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('region_id', 'Region:') !!}
                        {!! Form::select('region_id', $regions, isset($user->details->region_id)? $user->details->region_id : null, ['class' => 'form-control select2']) !!}
                    </div>
                @if($user->hasRole('showroom-owner'))
                    <!-- Dealer Type Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('dealer_type', 'Dealer Type:') !!}
                            {!! Form::select('dealer_type', $DEALER_TYPE, $user->details->dealer_type, ['class' => 'form-control select2']) !!}
                        </div>

                        <!-- Brands Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('brand_ids', 'Brands:') !!}
                            {!! Form::select('brand_ids[]', $brands, $user->brands, ['class' => 'form-control select2', 'multiple']) !!}
                        </div>

                        <!-- Add Car Limit Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('limit_for_cars', 'Add Car Limit:*') !!}
                            {!! Form::number('limit_for_cars', $user->details->limit_for_cars, ['class' => 'form-control', 'placeholder' => 'Add Car Limit', 'min'=>1, 'max'=>999, 'required']) !!}
                        </div>

                        <!-- Featured Cars Limit Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('limit_for_featured_cars', 'Featured Cars Limit:*') !!}
                            {!! Form::number('limit_for_featured_cars', $user->details->limit_for_featured_cars, ['class' => 'form-control', 'placeholder' => 'Featured Cars Limit', 'min'=>1, 'max'=>999, 'required']) !!}
                        </div>

                        <!-- Expiry Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('expiry_date', 'Date Of Expiry:*') !!}
                            {!! Form::date('expiry_date', $user->details->expiry_date, ['class' => 'form-control', 'required']) !!}
                        </div>
                @endif
                <!-- Phone Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('dob', 'Date Of Birth:*') !!}
                        {!! Form::date('dob', $user->details->dob, ['class' => 'form-control']) !!}
                    </div>

                {{--<!-- Roles Field -->
                <div class="form-group col-sm-6">
                {!! Form::label('roles', 'Dealer Type:') !!}
                {!! Form::select('dealer_type', $DEALER_TYPE, old('dealer_type')??\App\Models\User::$DEALER_TYPE[$user->details->dealer_type], ['class' => 'form-control select2']) !!}
                </div>--}}
                @if (strpos(Request::url(), 'users') !== false)
                    {{--<!-- Roles Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('roles', 'Roles:') !!}
                            {!! Form::select('roles[]', $roles, null, ['class' => 'form-control select2', 'multiple'=>'multiple']) !!}
                        </div>--}}
                @endif

                <!-- About Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('about', 'About:') !!}
                        {!! Form::textarea('about', $user->details->about?? null, ['class' => 'form-control', 'style' => 'resize:none', 'rows' => 2]) !!}
                    </div>

                @if(!$user->hasRole('showroom-owner'))
                    <!-- email_updates Field -->
                        {{--<div class="form-group col-sm-3 clearfix">
                            {!! Form::label('email_updates', 'Receive Updates On Emails:') !!}
                            <div class="clearfix"></div>
                            {!! Form::hidden('email_updates', false) !!}
                            {!! Form::checkbox('email_updates', 1,  true, ['data-toggle'=>'toggle']) !!}
                        </div>--}}
                        <div class="clearfix"></div>
                        <!-- Password Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('password', 'Password:*') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Password Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('password_confirmation', 'Confirm Password:*') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>

                        <div class="clearfix"></div>
                        <!-- Image Field -->
                        <div class="form-group col-sm-3">
                            {!! Form::label('image', 'Image:') !!}
                            {!! Form::file('image', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}

                            @if($user->details)
                                {{--<img src="{{ $user->details->image_url }}" width="80">--}}
                                <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;">
                                    <a class='showGallery' data-id='{{ $user->id }}' data-toggle='modal'>
                                        <img src="{!! $user->details->image_url !!}" style="width: 125px;">
                                    </a>
                                </div>
                            @endif
                        </div>

                    @endif

                    {{--<!-- Address Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('address', 'Address:') !!}
                        {!! Form::textarea('address', $user->details->address?? null, ['class' => 'form-control']) !!}
                    </div>--}}
                </div>
                <!-- /.tab-pane -->
                @if($user->hasRole('showroom-owner'))
                    <div class="tab-pane clearfix" id="tab_2">
                        <!-- Name Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('name', 'Showroom Name:*') !!}
                            {!! Form::text('showroom[name]', $user->showroomDetails->name?? null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Address Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('address', 'Showroom Address:*') !!}
                            {!! Form::textarea('showroom[address]', $user->showroomDetails->address?? null, ['class' => 'form-control', 'style' => 'resize:none', 'rows' => 2]) !!}
                        </div>

                        <!-- About Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('about', 'About Showroom:') !!}
                            {!! Form::textarea('showroom[about]', $user->showroomDetails->about?? null, ['class' => 'form-control', 'style' => 'resize:none', 'rows' => 2]) !!}
                        </div>

                        <!-- Phone Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('phone', 'Showroom Phone:*') !!}
                            {!! Form::number('showroom[phone]', $user->showroomDetails->phone?? null, ['class' => 'form-control','min'=>1]) !!}
                        </div>

                    {{--<!-- Email Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('showroom[email]', $user->showroomDetails->email?? null, ['class' => 'form-control', isset($user)?'readonly':'']) !!}
                    </div>--}}

                    <!-- Email Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('email', 'Email:*') !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>

                        <div class="clearfix"></div>
                        <!-- Password Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('password', 'Password:*') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Password Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('password_confirmation', 'Confirm Password:*') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>

                        <div class="clearfix"></div>
                        <!-- Image Field -->
                        <div class="form-group col-sm-3">
                            {!! Form::label('image', 'Image:') !!} <br>
                            <img src="{{ $user->showroomDetails->logo_url }}"><br><br>
                            {!! Form::file('showroom_media', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}
                        </div>
                        <div class="clearfix"></div>

                        <!-- Image Field -->
                        {{--<div class="form-group col-sm-3">
                            --}}{{--@if($user->showroomDetails->media->count() > 0)--}}{{--
                            <img src="{{ $user->showroomDetails->logo_url }}">
                            --}}{{--@endif--}}{{--
                        </div>--}}
                    </div>
            @endif
            <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        @if(\Request::route()->getName() == 'admin.users.profile')
            <a href="{!! route('admin.dashboard') !!}" class="btn btn-default">Cancel</a>
        @else
            <a href="{!! route('admin.users.index') !!}" class="btn btn-default">Cancel</a>
        @endif
    </div>

    <div class="clearfix"></div>
@endif
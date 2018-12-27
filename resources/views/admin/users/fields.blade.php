@if(!isset($user))
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>"20", 'size'=>"20"]) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control', isset($use)?'readonly':'']) !!}
    </div>

    @if (strpos(Request::url(), 'users') !== false)
        <!-- Roles Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('roles', 'Roles:') !!}
            {!! Form::select('roles[]', $roles, null, ['class' => 'form-control select2', 'multiple'=>'multiple']) !!}
        </div>

        <!-- Roles Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('roles', 'Dealer Type:') !!}
            {!! Form::select('dealer_type', $DEALER_TYPE, null, ['class' => 'form-control select2']) !!}
        </div>
    @endif

    <!-- Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <!-- Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('password_confirmation', 'Confirm Password:') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
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
                    <div class="form-group col-sm-6">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', $user->details->first_name?? null, ['class' => 'form-control','maxlength'=>"20", 'size'=>"20"]) !!}
                    </div>

                    <!-- Email Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control', isset($user)?'readonly':'']) !!}
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('phone', 'Phone:') !!}
                        {!! Form::number('phone', $user->details->phone?? null, ['class' => 'form-control', 'min'=> 1,'max'=>20]) !!}
                    </div>

                @if (strpos(Request::url(), 'users') !== false)

                    <!-- Roles Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('roles', 'Roles:') !!}
                            {!! Form::select('roles[]', $roles, null, ['class' => 'form-control select2', 'multiple'=>'multiple']) !!}
                        </div>

                @endif

                <!-- Address Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('address', 'Address:') !!}
                        {!! Form::text('address', $user->details->address?? null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="clearfix"></div>

                    <!-- Image Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('image', 'Image:') !!}
                        {!! Form::file('image', ['class' => 'form-control']) !!}
                    </div>

                @if($user->details)
                    <!-- Image Field -->
                        <div class="form-group col-sm-3">
                            <img src="{{ $user->details->image_url }}" width="50">
                        </div>
                @endif

                <!-- email_updates Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('email_updates', 'Receive Updates On Emails:') !!}
                        <div class="clearfix"></div>
                        {!! Form::hidden('email_updates', false) !!}
                        {!! Form::checkbox('email_updates', 1,  true, ['data-toggle'=>'toggle']) !!}
                    </div>
                    <div class="clearfix"></div>

                    <!-- About Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('about', 'About:') !!}
                        {!! Form::textarea('about', $user->details->address?? null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="clearfix"></div>

                    <!-- Password Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('password', 'Password:') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>

                    <!-- Password Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('password_confirmation', 'Confirm Password:') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- /.tab-pane -->
                @if($user->hasRole('showroom-owner'))
                    <div class="tab-pane clearfix" id="tab_2">
                        <!-- Name Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('showroom[name]', $user->showroomDetails->name?? null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Email Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('showroom[email]', $user->showroomDetails->email?? null, ['class' => 'form-control', isset($user)?'readonly':'']) !!}
                        </div>

                        <!-- Phone Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('phone', 'Phone:') !!}
                            {!! Form::number('showroom[phone]', $user->showroomDetails->phone?? null, ['class' => 'form-control','min'=>1]) !!}
                        </div>

                        <!-- Image Field -->
                        <div class="form-group col-sm-3">
                            {!! Form::label('image', 'Image:') !!}
                            {!! Form::file('showroom_media', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Image Field -->
                        <div class="form-group col-sm-3">
                            {{--@if($user->showroomDetails->media->count() > 0)--}}
                            <img src="{{ $user->showroomDetails->logo_url }}">
                            {{--@endif--}}
                        </div>

                        <!-- Address Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('address', 'Address:') !!}
                            {!! Form::text('showroom[address]', $user->showroomDetails->address?? null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- About Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('about', 'About:') !!}
                            {!! Form::textarea('showroom[about]', $user->showroomDetails->about?? null, ['class' => 'form-control']) !!}
                        </div>
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
        <a href="{!! route('admin.users.index') !!}" class="btn btn-default">Cancel</a>
    </div>

    <div class="clearfix"></div>
@endif
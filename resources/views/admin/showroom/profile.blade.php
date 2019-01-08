@extends('admin.layouts.showroom')

@section('content')
    @include('flash::message')
    @include('adminlte-templates::common.errors')
    @push('css')
        <style>
            .right_side {
                width: 85%;
            }

            .left_side {
                width: 15%;
            }

            .dash_tabs {
                width: 100%;
            }

            .tab_serach {
                margin: 0;
            }

            .right_side {
                background: #fff;
            }

            .profile_right_side {
                border-left: 1px solid #c6c6c6;
            }

            textarea {
                font-size: 13px;
                border-bottom: 1px solid #d5d5d5;
                border-top: none;
                border-right: none;
                border-left: none;
                width: 100%;
                Resize: none
            }

        </style>
    @endpush

    <div class="left_side profile_left_side">

        {{-- side menu --}}
        <span class="icon-close2 left_side_close"></span>
        @include('admin.layouts.showroom_sidebar')
        {{-- side menu End--}}
        {{--<div class="dash_tab_content dash_tab" id="tab2">
            <div class="tab_serach">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <input type="text" name="" placeholder="Search">
                    </div>
                    <div class="col-md-6 sort_parent">
                        <label>Sort by:</label>
                        <div class="select">
                            <select>
                                <option value="">Recent</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="car_listing">
                <li class="clearfix active">
                    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                    <div class="content">
                        <h3>Luxurious Bentley Continental GT</h3>
                        <p>2013 • 77,000 km • Chassis 1541845121 <span>Reference Number: 0123456789</span></p>
                    </div>
                </li>
            </ul>
        </div>--}}

    </div>

    {!! Form::model($user, ['route' => ['admin.showroom.profile.update', $user->id], 'files' => true, 'method' => 'patch', 'class' => '']) !!}

    <div class="right_side profile_right_side" style="">
        {{--<div class="dash_tab_content " id="tab1">
            <h3>Personal Details: </h3> <br>
            <input type="text" name="name" placeholder="Name" value="{{ $user->name }}" required> <br> <br>
            <input type="text" name="email" placeholder="Email" value="{{ $user->email }}" required readonly
                   style="opacity: 0.6"> <br> <br>
            <input type="text" name="phone" placeholder="Phone" value="{{ $user->details->phone }}" required> <br>
            <br>
            <textarea name="address" placeholder="Address"
                      required>{{ $user->details->address == null ? '' : $user->details->address }}</textarea> <br>
            <br>


            <textarea name="about" placeholder="About"
                      required>{{ $user->details->about == null ? '' : $user->details->about }}</textarea> <br> <br>
            <input type="text" name="password" placeholder="Password"> <br> <br>
            <input type="text" name="password_confirmation" placeholder="Confirm Password"> <br> <br>
            <label>Profile:</label>
            <img src="{{ Auth::user()->details->image_url }}" width="70">
            <input type="file" name="image">
        </div>--}}

        <div class="car_detail_wrap" id="car_detail1">
            <div class="car_detail clearfix tab_serach"
                 style="margin-top: 0px; margin-left: 0px; padding-top: 0px; padding-left: 15px;">
                <h3>Contact Person: </h3> <br>
                <input type="text" name="name" placeholder="Name" value="{{ old('name')? old('name'): $user->name }}"
                       required maxlength="25"> <br> <br>
                <div class="left" style="width: 48%;">
                    <input type="text" name="profession" placeholder="Profession" value="{{ old('profession')? old('profession'): $user->details->profession }}" required maxlength="15"> <br> <br>
                    {{--<textarea name="address" placeholder="Address"--}}
                    {{--required>{{ old('address')?old('address'): $user->details->address }}</textarea>--}}
                    <input type="text" name="phone" placeholder="Phone" value="{{ $user->details->phone }}"  required maxlength="15">
                    {{--<input type="password" name="password" placeholder="Password"> <br> <br>--}}
                    {{--<label>Logo:</label>
                    <input type="file" name="showroom_media">--}} <br> <br>
                    <input type="date" name="dob" value="{{ old('dob')? old('dob'): $user->details->dob }}" required>
                </div>
                <div class="right" style="width: 48%;">
                    <select name="gender" required>
                        @foreach($gender as $key => $value)
                            <option value="{{ $key }}" {{ ($key == $user->details->gender)  ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select> <br> <br>
                    <input type="text" name="nationality" placeholder="Nationality" value="{{ old('nationality')? old('nationality'): $user->details->nationality }}" required maxlength="15"> <br> <br>
                    {{--<img src="{{ $user->details->image_url }}" width="80">--}}
                    <textarea name="about" placeholder="About"
                              required>{{ old('about')? old('about')  : $user->details->about }}</textarea>
                    <br>
                </div>
            </div>
        </div>

        <div class="car_detail_wrap" id="car_detail1">
            <div class="car_detail clearfix tab_serach">
                <h3>Showroom Details: </h3> <br>
                <input type="text" name="showroom_name" placeholder="Show Room Name"
                       value="{{ old('showroom_name')? old('showroom_name'):$user->showroomDetails->name }}" required>
                <br> <br>
                <div class="left" style="width: 48%;">
                    <textarea name="showroom_address" placeholder="Show Room Address"
                              required>{{ old('showroom_address')? old('showroom_address') : $user->showroomDetails->address }}</textarea>
                    <br> <br>
                    <input type="text" name="showroom_phone" placeholder="Show Room Phone"
                           value="{{ old('showroom_phone')?old('showroom_phone'): $user->showroomDetails->phone }}"
                           required> <br> <br>
                    <input type="password" name="password" placeholder="Password"><br> <br>

                    <label>Profile Image:</label>
                    <input type="file" name="showroom_media"> <br> <br>

                    <button type="submit" class="submit" name=""
                            style="font-size: 14px; color: #fff; text-align: center; background: #1f1f1f; border-radius: 30px;  border: 1px solid transparent; text-transform: uppercase; margin: 15px 0 0; transition: all 0.2s; cursor: pointer; width: 25%; height: 40px;">
                        submit
                    </button>
                </div>

                <div class="right" style="width: 48%;">
                        <textarea name="showroom_about" placeholder="Show Room About"
                                  required>{{ old('showroom_about')? old('showroom_about'): $user->showroomDetails->about }}</textarea>
                    <br> <br>
                    <input type="text" name="showroom_email" placeholder="Show Room Email"
                           value="{{ $user->email }}" required readonly style="opacity: 0.6"> <br> <br>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password"> <br> <br>
                    <img src="{{ Auth::user()->showroomDetails->logo_url }}" width="80">
                </div>
            </div>
        </div>

        <br>
    </div>
    {!! Form::close() !!}
    {{--</form>--}}
@endsection
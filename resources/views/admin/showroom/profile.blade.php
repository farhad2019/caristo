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


        <div class="table-responsive car-dtl-table">
            <div class="car_detail clearfix tab_serach">
                <h3>Quota/Country Details: </h3> <br>
                <table class="table">
                    <tbody>
                    <tr>
                        <th></th>
                        <th>Total Allowed</th>
                        <th>Active</th>
                        <th>Remaining</th>
                        <th>Sold</th>
                        <th>Inactive</th>
                    </tr>

                    <tr>
                        <td><strong>Car Limits</strong></td>
                        <td>{!! $user->details->limit_for_cars !!}</td>
                        <td>{!! $user->cars()->where('status', \App\Models\MyCar::ACTIVE)->count() !!}</td>
                        <td>{{$user->details->limit_for_cars - $user->cars->where('status', \App\Models\MyCar::ACTIVE)->count()}}</td>
                        <td>{!! $user->cars()->where('status', \App\Models\MyCar::SOLD)->count() !!}</td>
                        <td>{!! $user->cars()->where('status', \App\Models\MyCar::INACTIVE)->count() !!}</td>
                    </tr>
                    <tr>
                        <td><strong>Featured Car limit</strong></td>
                        <td>{{$user->details->limit_for_featured_cars}}</td>
                        <td>{{ $user->cars()->where('status', \App\Models\MyCar::ACTIVE)->where('is_featured',1)->count()}}</td>
                        <td>{{$user->details->limit_for_featured_cars - $user->cars()->where('status', \App\Models\MyCar::ACTIVE)->where('is_featured',1)->count() }}</td>
                        <td>{{ $user->cars()->where('status', \App\Models\MyCar::SOLD)->where('is_featured',1)->count()}}</td>
                        <td>{{ $user->cars()->where('status', \App\Models\MyCar::INACTIVE)->where('is_featured',1)->count()}}</td>
                    </tr>
                    <tr>
                        <td><strong>Account Expiry Date</strong></td>
                        <td colspan="3">{{date('d-m-Y',strtotime($user->details->expiry_date))}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Country</strong></td>
                        <td colspan="3">{{@$user->details->regionDetail->name ?? 'N/A'}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Currency</strong></td>
                        <td colspan="3">{{@$user->details->regionDetail->currency ?? 'N/A'}}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><strong>Account Type</strong></td>
                        <td colspan="3">{{@$user->details->dealer_type_text ?? 'N/A'}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        {{--<div class="car_detail_wrap" id="car_detail1">
            <div class="car_detail clearfix tab_serach">
                <h3>Quota/Country Details: </h3> <br>

                <div>
                    <span style="width: 45%">Car Limits</span>
                    <span style="width: 15%">{{$user->details->limit_for_cars}}</span>
                    <span style="width: 15%">{{ $user->cars->count() }}</span>
                    <span style="width: 15%">{{$user->details->limit_for_cars - $user->cars->count()}}</span>
                </div>
                <br>

                <div>
                    <span>Featured Car limit</span>
                    <span style="width: 15%">{{$user->details->limit_for_featured_cars}}</span>
                    <span style="width: 15%">{{ $user->cars()->where('is_featured',1)->count()}}</span>
                    <span style="width: 15%">{{$user->details->limit_for_featured_cars - $user->cars()->where('is_featured',1)->count() }}</span>
                </div>
                <br>

                <div>
                    <span>Account Expiry Date</span>
                    <span style="width: 15%">{{date('d-m-Y',strtotime($user->details->expiry_date))}}</span>
                </div>
                <br>

                <div>
                    <span>Country</span>
                    <span style="width: 15%">{{$user->details->regionDetail->name}}</span>
                </div>
                <br>

                <div>
                    <span>Currency</span>
                    <span style="width: 15%">{{$user->details->regionDetail->currency}}</span>
                </div>
                <br>

                <div>
                    <span>Account Type</span>
                    <span style="width: 15%">{{$user->details->dealer_type_text}}</span>
                </div>
                <br>

            </div>
        </div>--}}


        <div class="car_detail_wrap" id="car_detail1">
            <div class="car_detail clearfix tab_serach"
                 style="margin-top: 0px; margin-left: 0px; padding-top: 0px; padding-left: 15px;">
                <h3>Contact Person: </h3> <br>
                <input type="text" name="name" placeholder="Name" value="{{ old('name')? old('name'): $user->name }}"
                       required maxlength="25"> <br> <br>
                <div class="left" style="width: 48%;">
                    <input type="text" name="profession" placeholder="Profession"
                           value="{{ old('profession')? old('profession'): $user->details->profession }}" required
                           maxlength="15"> <br> <br>
                    {{--<textarea name="address" placeholder="Address"--}}
                    {{--required>{{ old('address')?old('address'): $user->details->address }}</textarea>--}}

                    {{--<input type="password" name="password" placeholder="Password"> <br> <br>--}}
                    {{--<label>Logo:</label>
                    <input type="file" name="showroom_media">--}} <br> <br>
                    {{--<input type="date" name="dob" value="{{ old('dob')? old('dob'): $user->details->dob }}" required>--}}
                </div>
                <div class="right" style="width: 48%;">
                    <input type="text" name="phone" placeholder="Phone" value="{{ $user->details->phone }}" required
                           maxlength="15">
                    {{--<select name="gender" required>
                        @foreach($gender as $key => $value)
                            <option value="{{ $key }}" {{ ($key == $user->details->gender)  ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select> <br> <br>
                    <select name="nationality" required>
                        @foreach($nationalities as $key => $value)
                            <option value="{{ $key }}" {{ ($key == $user->details->nationality)  ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <br> <br>
                    --}}{{--<img src="{{ $user->details->image_url }}" width="80">--}}{{--
                    <textarea name="about" placeholder="About"
                              required>{{ old('about')? old('about')  : $user->details->about }}</textarea>--}}
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

                    <label>Profile Image:<span style="color:darkgray; font-size: 13px">
                        * Media should be in 192 x 192 dimension
                    </span></label>
                    <input type="file" name="showroom_media" accept="image/x-png,image/gif,image/jpeg"><br> <br>

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
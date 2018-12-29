@extends('admin.layouts.showroom')

@section('content')
    @include('flash::message')
    <div class="left_side">
        {{-- side menu --}}

        <span class="icon-close2 left_side_close"></span>
        @include('admin.layouts.showroom_sidebar')
        {{-- side menu End--}}

        {{-- Car lsiting--}}
        <div class="dash_tab_content dash_tab" id="tab1">
            <div class="tab_serach">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <form action="{{ url('admin/'.Request::segments()[1]) }}" method="GET">
                            <input type="text" name="keyword" placeholder="Search" value="{{@$_REQUEST['keyword']}}">
                        </form>
                    </div>
                    {{--<div class="col-md-6 sort_parent">
                        <label>Sort by:</label>
                        <div class="select">
                            <select>
                                <option value="" selected disabled>Recent</option>
                            </select>
                        </div>
                    </div>--}}
                </div>
            </div>

            <div class="bit_container">
                <i class="bit_close"><span class="icon-close2"></span></i>
                <ul class="car_listing" id="car-list">

                </ul>
            </div>

            @if($cars->count() > 0)
                <ul class="car_listing parent">
                    @foreach($cars as $car)
                        <li class="clearfix current active">
                            <a href="#car_detail1" class="car" data-id="{{ $car->id }}"
                               data-type="{{ $car->owner_type }}" title="">
                                @if(isset($car->media[0]))
                                    <figure style="background-image: url({{ $car->media[0]->file_url }});"></figure>
                                @else
                                    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                                @endif
                                <div class="content">
                                    <h3>{{ $car->year }} {{ $car->carModel->brand->name }} {{ $car->carModel->name }}</h3>
                                    <p>{{ $car->year }} • {{ number_format($car->kilometer) }} km <br>
                                        Chassis {{ $car->chassis }}
                                        {{--<span>Reference Number: 0123456789</span>--}}
                                    </p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <span>No Records Found</span>
            @endif
        </div>
        {{-- Car lsiting End--}}
    </div>

    {{-- Car details--}}
    <div class="right_side">
        <a href="javascript:void(0);" title="" class="fltr_btn">Filter <span class="icon-arrow-right"></span></a>
        <div class="right_loader">
            <div class="status"></div>
        </div>
        <div class="car_detail_wrap" id="car_detail1">
            <!-- dummy car details -->
            <div class="dummy_wrap">
                <p class="ref_num">Reference Number:<span>-</span></p>
                <div class="shadow"></div>
                <div class="car_slider_warap">
                    <figure style="background-image: url({{ url('storage/app/public/dummy-img.jpg') }});"></figure>
                </div>
                <div class="car_detail clearfix">
                    <div class="left">
                        <h2 class="car_model">Car Name</h2>
                        <ul>
                            <li>
                                <span class="icon-icon-5"></span>
                                <p>
                                    <small>Model</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-6"></span>
                                <p>
                                    <small>year</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-7"></span>
                                <p>
                                    <small>KM</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-8"></span>
                                <p>
                                    <small>Chassis</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-9"></span>
                                <p>
                                    <small>Regional Specs</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-10"></span>
                                <p>
                                    <small>Exterior Color</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-11"></span>
                                <p>
                                    <small>Interior</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-12"></span>
                                <p>
                                    <small>engine type</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-cleaner"></span>
                                <p>
                                    <small>Trim</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-14"></span>
                                <p>
                                    <small>Warranty remaining</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-15"></span>
                                <p>
                                    <small>Service contract remaining</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-16"></span>
                                <p>
                                    <small>RMNG. warranty</small>
                                    -
                                </p>
                            </li>
                            <li>
                                <span class="icon-icon-17"></span>
                                <p>
                                    <small>Accident?</small>
                                    -
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- -->

            {{--@php($car = $cars[2])
            <p class="ref_num">Reference Number:<span>{{ $car->ref_num }}</span></p>
            <div class="shadow"></div>
            <div class="car_slider_warap">
                @foreach($car->media as $media)
                    <figure style="background-image: url({{ $media->file_url }});"></figure>
                @endforeach
                --}}{{--<figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>--}}{{--
            </div>

            <div class="car_detail clearfix">
                <div class="left">
                    <h2 class="car_model">{{ $car->year }} {{ $car->carModel->brand->name }} {{ $car->carModel->name }}</h2>
                    <ul>
                        <li>
                            <span class="icon-icon-5"></span>
                            <p>
                                <small>Model</small>
                                {{ $car->carModel->name }}
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-6"></span>
                            <p>
                                <small>year</small>
                                {{ $car->year }}
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-7"></span>
                            <p>
                                <small>KM</small>
                                {{ number_format($car->kilometre) }}
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-8"></span>
                            <p>
                                <small>Chassis</small>
                                {{ $car->chassis }}
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-9"></span>
                            <p>
                                <small>Regional Specs</small>
                                {{ $car->regionalSpecs->name }}
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-12"></span>
                            <p>
                                <small>engine type</small>
                                {{ $car->engineType->name?? '-' }}
                            </p>
                        </li>
                        @foreach($car->carAttributes as $attribute)
                            <li>
                                <span class="{{ $attribute->icon }}"></span>
                                <p>
                                    <small>{{ $attribute->name }}</small>
                                    @if($attribute->type == 30)
                                        {!! \App\Models\AttributeOption::find($attribute->pivot->value)['option'] !!}
                                    @elseif($attribute->type == 10 || $attribute->type == 20)
                                        {!! $attribute->pivot->value !!}
                                    @endif
                                </p>
                            </li>
                        @endforeach
                        --}}{{--<li>
                            <span class="icon-icon-14"></span>
                            <p>
                                <small>Warranty remaining</small>
                                12 Months
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-15"></span>
                            <p>
                                <small>Service contract remaining</small>
                                2 Year
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-16"></span>
                            <p>
                                <small>RMNG. warranty</small>
                                18 Months
                            </p>
                        </li>--}}{{--
                        @foreach($car->carFeatures as $carFeature)
                            <li>
                                <span class="{{ $carFeature->icon_css }}"></span>
                                <p>
                                    <small>{{ $carFeature->name }}?</small>
                                    Yes
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if(Request::segments()[1] == 'makeBids')
                    <div class="right">
                        <div class="bid_widget">
                            <img src="{{ url('storage/app/showroom/bid-icon.svg') }}" alt="" width="80">
                            <h3>Bid Expires in</h3>
                            <div class="svg_container">
                                <div class="circle">
                                    <svg viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                                        <g transform="translate(110,110)">
                                            <circle r="100" class="e-c-base"/>
                                            <g transform="rotate(-90)">
                                                <circle r="100" class="e-c-progress"/>
                                                <g id="e-pointer">
                                                    <circle cx="100" cy="0" r="8" class="e-c-pointer"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>

                                <div class="controlls">
                                    <div class="display-remain-time"></div>
                                    <button class="play" id="pause"></button>
                                </div>
                            </div>
                            <h4>Place a Bid now</h4>
                            {!! Form::open(['route' => 'admin.makeBids.store']) !!}
                            <input type="text" name="amount" placeholder="AED"
                                   {{ isset($bid)? 'readonly':'required' }} value="{{ isset($bid)? number_format($bid->amount):'' }}">
                            <button type="submit" class="submit" name="">submit</button>
                            {!! Form::hidden('car_id', $car->id) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @else
                    <div class="right">
                        <div class="bid_widget">
                            <img src="{{ url('storage/app/showroom/bid-icon.svg') }}" alt="" width="80">
                            <h3>Your Bid Amount</h3>
                            <div class="svg_container">
                                <div class="circle">
                                    <svg viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                                        <g transform="translate(110,110)">
                                            <circle r="100" class="e-c-base"/>
                                            <g transform="rotate(-90)">
                                                <circle r="100" class="e-c-progress"/>
                                                <g id="e-pointer">
                                                    <circle cx="100" cy="0" r="8" class="e-c-pointer"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="controlls">
                                    <div class="" style="font-size: 23px;">{{ number_format($bid->amount) }}
                                        AED
                                    </div>
                                    <button class="play" id="pause"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>--}}
        </div>
    </div>
    {{-- Car details end--}}

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('body').on('click', '.car', function () {
                var carId = $(this).data('id');
                var carType = $(this).data('type');

                // $('.active').toggleClass('clearfix current');
                // $(this).toggleClass('clearfix current active');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (carType === 10) {
                    $.ajax({
                        method: "GET",
                        url: '{{ url('admin/tradeInCars') }}/' + carId,
                        type: "JSON",
                        async: false
                    }).done(function (responce) {
                        var data = JSON.parse(responce).success;

                        $.each(data, function (key, car) {
                            console.log(car.id);
                            var li = "<li class=\"clearfix \">\n" +
                                "                        <a href=\"#car_detail1\" class='car' data-id='" + car.trade_against.id + "' data-trade='" + car.id + "' title=\"\">\n" +
                                "                            <figure style=\"background-image: url(' " + car.trade_against.media[0].file_url + " ');\"></figure>\n" +
                                "                            <div class=\"content\">\n" +
                                "                                <h3>" + car.trade_against.year + " " + car.trade_against.car_model.brand.name + " " + car.trade_against.car_model.name + "</h3>\n" +
                                "                                <p>" + car.trade_against.year + " • " + car.trade_against.kilometer + "  km • Chasis " + car.trade_against.chassis + " <span></span></p>\n" +
                                "                            </div>\n" +
                                "                        </a>\n" +
                                "                    </li>";
                            $('#car-list').append(li);
                        });

                    });
                } else {

                    var tradeInId = $(this).data('trade');

                    $.ajax({
                        method: "GET",
                        url: '{{ url('admin/'.Request::segments()[1].'/') }}/' + carId + '?tradId=' + tradeInId,
                        type: "JSON",
                        async: false
                    }).done(function (responce) {
                        $('.car_detail_wrap').html('');
                        $('.car_detail_wrap').html(responce);
                        /!* Car Slider *!/
                        $('.car_slider_warap').slick({
                            infinite: true,
                            arrows: false,
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 2000
                        });
                    });
                }
            });
        });
    </script>
@endpush
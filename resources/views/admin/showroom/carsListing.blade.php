@extends('admin.layouts.showroom')

@section('content')
    @include('flash::message')
    <div class="left_side">
        {{-- side menu --}}
        <span class="icon-close2 left_side_close"></span>
        @include('admin.layouts.showroom_sidebar')
        {{-- side menu End--}}
        @php($filerBy = app('request')->input('filerBy'))
        @php($keyword = app('request')->input('keyword'))
        {{-- Car lsiting--}}
        <div class="dash_tab_content dash_tab" id="tab1">
            @if($tradeInRequests->count() > 0)
                <div class="tab_serach">
                    <div class="row no-gutters">
                        <form action="{{ url('admin/tradeInCars') }}" name="filter" class="col-md-12" method="GET">
                        <div class="col-md-6" style="float: left">
                            {{--<form action="{{ url('admin/tradeInCars') }}" method="GET">--}}
                                <input type="text" name="keyword" placeholder="Search"
                                       value="{{ @$keyword }}">
                            {{--</form>--}}
                        </div>
                        <div class="col-md-6 sort_parent" style="float: right">
                            {{--<form action="{{ url('admin/tradeInCars') }}" name="filter" method="GET">--}}
                                <label>View:</label>
                                <div class="select" onchange="filter.submit()">
                                    <select name="filerBy">
                                        <option value="0" {{ $filerBy == '0'?'selected':'' }}>All</option>
                                        <option value="10" {{ $filerBy == '10'?'selected':'' }}>Trade In</option>
                                        <option value="20" {{ $filerBy == '20'?'selected':'' }}>Evaluation</option>
                                    </select>
                                </div>
                                <label>Total Requests:</label>
                                <div class=""> {{ $tradeInRequests->count() }}</div>
                            {{--</form>--}}
                        </div>
                        </form>
                    </div>
                </div>

                <ul class="car_listing">
                    @foreach($tradeInRequests as $tradeInRequest)
                        <li style="position: relative"
                            class="clearfix current car{{$tradeInRequest->id}} {{ $tradeInRequest->status == 20 ? 'active':'' }}">
                            <span class="label label-info"
                                  style=" padding: 3px 10px;position: absolute;right: 0; background: #ccc; font-size: 13px;">{{ $tradeInRequest->type == 10 ? 'Trade In' : 'Evaluate' }}</span>
                            <a href="#car_detail1" class="car" data-id="{{ $tradeInRequest->id }}" title="">
                                @if(isset($tradeInRequest->tradeAgainst->media[0]))
                                    <figure style="background-image: url({{ $tradeInRequest->tradeAgainst->media[0]->file_url }});"></figure>
                                @else
                                    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                                @endif
                                <div class="content">
                                    <h3>{{ @$tradeInRequest->tradeAgainst->year }} {{ @$tradeInRequest->tradeAgainst->carModel->brand->name }} {{ @$tradeInRequest->tradeAgainst->carModel->name }}</h3>
                                    <p>{{ @$tradeInRequest->tradeAgainst->year }}
                                        {{ isset( $tradeInRequest->tradeAgainst->kilometer)? ' • '. number_format($tradeInRequest->tradeAgainst->kilometer).' km' : ''}}
                                        <br>
                                        Chassis {{ @$tradeInRequest->tradeAgainst->chassis }}
                                        {{--<span>Reference Number: 0123456789</span>--}}
                                    </p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="tab_serach">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <form action="{{ url('admin/tradeInCars') }}" method="GET">
                                <input type="text" name="keyword" placeholder="Search"
                                       value="{{@$_REQUEST['keyword']}}">
                            </form>
                        </div>
                        <div class="col-md-6 sort_parent">
                            <form action="{{ url('admin/tradeInCars') }}" name="filter" method="GET">
                                <label>View:</label>
                                <div class="select" onchange="filter.submit()">
                                    <select name="filerBy">
                                        <option value="0" {{ $filerBy == '0'?'selected':'' }}>All</option>
                                        <option value="10" {{ $filerBy == '10'?'selected':'' }}>Trade In</option>
                                        <option value="20" {{ $filerBy == '20'?'selected':'' }}>Evaluation</option>
                                    </select>
                                </div>
                                <label>Total Requests:</label>
                                <div class=""> {{ $tradeInRequests->count() }}</div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                <span class="icon-icon-6"></span>
                                <p>
                                    <small>version</small>
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
                            <li>
                                <span class="icon-icon-17"></span>
                                <p>
                                    <small>Additional Notes?</small>
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
    <input type="hidden" id="current_car_id" value="">
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('body').on('click', '.car', function () {
                var id = $(this).data('id');
                var current_car_id = $('#current_car_id').val();
                //$('#current_car_id').val(0);
                if (parseInt(current_car_id) === parseInt(id)) {
                    return false;
                } else {
                    $('#current_car_id').val(id);
                }

                // $('.active').toggleClass('clearfix current');
                // $(this).toggleClass('clearfix current active');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: "GET",
                    url: '{{ url('admin/tradeInCars') }}/' + id,
                    {{--url: '{{ url('admin/makeBids/') }}/' + carId + '?tradId=' + tradeInId,--}}
                    type: "JSON",
                    async: false
                }).done(function (responce) {
                    $(".car" + id).removeClass("active");
                    var unreadCount = $('.badge').html();
                    if (unreadCount > 1) {
                        $('.badge').html(unreadCount - 1);
                    } else {
                        $('.badge').html('');
                    }
                    $('.car_detail_wrap').html('');
                    $('.bid_widget').html('');
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
            });
        });
    </script>
@endpush
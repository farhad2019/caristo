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
                            <input type="text" name="keyword" placeholder="Search">
                        </form>
                    </div>
                    <div class="col-md-6 sort_parent">
                        <label>Sort by:</label>
                        <div class="select">
                            <select>
                                <option value="" selected disabled>Recent</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @if($cars->count() > 0)
                <ul class="car_listing">
                    @foreach($cars as $car)
                        <li class="clearfix current active">
                            <a href="#car_detail1" class="car" data-id="{{ $car->id }}" title="">
                                @if(isset($car->media[0]))
                                    <figure style="background-image: url({{ $car->media[0]->file_url }});"></figure>
                                @else
                                    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                                @endif
                                <div class="content">
                                    <h3>{{ $car->name . ' ' . $car->carModel->brand->name . ' ' . $car->carModel->name }}</h3>
                                    <p>{{ $car->year }} • {{ number_format($car->kilometre) }} km •
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

        <div class="dash_tab_content dash_tab" id="tab4">
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
        </div>
        {{-- Car lsiting End--}}
    </div>

    {{-- Car details--}}
    <div class="right_side">
        <a href="javascript:;" title="" class="fltr_btn">Filter <span class="icon-arrow-right"></span></a>
        <div class="right_loader">
            <div class="status"></div>
        </div>
        <div class="car_detail_wrap" id="car_detail1">

        </div>
    </div>
    {{-- Car details end--}}

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('body').on('click', '.car', function () {
                var carId = $(this).data('id');

                // $('.active').toggleClass('clearfix current');
                // $(this).toggleClass('clearfix current active');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: "GET",
                    url: '{{ url('admin/'.Request::segments()[1].'/') }}/' + carId,
                    type: "JSON",
                    async: false
                }).done(function (responce) {

                    $('.car_detail_wrap').html('');
                    $('.car_detail_wrap').html(responce);
                    /* Car Slider */
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
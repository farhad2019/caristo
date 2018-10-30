@extends('admin.layouts.showroom')

@section('content')
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
                @foreach($cars as $car)
                    <li class="clearfix current active">
                        <a href="#car_detail1" title="">
                            <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                            <div class="content">
                                <h3>{{ $car->name . ' ' . $car->carModel->brand->name . ' ' . $car->carModel->name }}</h3>
                                <p>{{ $car->year }} • {{ number_format($car->kilometre) }} km •
                                    Chassis {{ $car->chassis }}
                                    <span>Reference Number: 0123456789</span>
                                </p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
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
            <p class="ref_num">Reference Number:<span>0123456789</span></p>
            <div class="shadow"></div>
            <div class="car_slider_warap">
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
                <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
            </div>
            <div class="car_detail clearfix">
                <div class="left">
                    <h2 class="car_model">Luxurious Bentley Continental GT</h2>
                    <ul>
                        <li>
                            <span class="icon-icon-5"></span>
                            <p>
                                <small>Model</small>
                                Luxurious Bentley Continental GT
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-6"></span>
                            <p>
                                <small>year</small>
                                2013
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-7"></span>
                            <p>
                                <small>KM</small>
                                77,000
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-8"></span>
                            <p>
                                <small>Chassis</small>
                                1541845121
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-9"></span>
                            <p>
                                <small>Regional Specs</small>
                                GCC
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-10"></span>
                            <p>
                                <small>Exterior Color</small>
                                Gold
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-11"></span>
                            <p>
                                <small>Interior</small>
                                Tan
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-12"></span>
                            <p>
                                <small>engine type</small>
                                v8 - 4L - Petrol
                            </p>
                        </li>
                        <li>
                            <span class="icon-icon-17"></span>
                            <p>
                                <small>Trim</small>
                                -
                            </p>
                        </li>
                        <li>
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
                        </li>
                        <li>
                            <span class="icon-icon-17"></span>
                            <p>
                                <small>Accident?</small>
                                No
                            </p>
                        </li>
                    </ul>
                </div>
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
                                <div class="display-remain-time">19:00</div>
                                <button class="play" id="pause"></button>
                            </div>
                        </div>

                        <h4>Place a Bid now</h4>
                        <form>
                            <input type="text" name="" placeholder="AED" required>
                            <button type="submit" class="submit" name="">submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Car details end--}}

@endsection
@section('scripts')
    {{--<script>
        //circle start
        var progressBar = document.querySelector('.e-c-progress');
        var indicator = document.getElementById('e-indicator');
        var pointer = document.getElementById('e-pointer');
        var length = Math.PI * 2 * 100;

        progressBar.style.strokeDasharray = length;

        function update(value, timePercent) {
            var offset = -length - length * value / (timePercent);
            progressBar.style.strokeDashoffset = offset;
            pointer.style.transform = `rotate(${360 * value / (timePercent)}deg)`;
        }

        //circle ends
        const displayOutput = document.querySelector('.display-remain-time')
        const pauseBtn = document.getElementById('pause');
        const setterBtns = document.querySelectorAll('button[data-setter]');

        var intervalTimer;
        var timeLeft;
        var wholeTime = 0.5 * 2400; // manage this to set the whole time
        var isPaused = false;
        var isStarted = false;


        update(wholeTime, wholeTime); //refreshes progress bar
        displayTimeLeft(wholeTime);


        function timer(seconds) { //counts time, takes seconds
            var remainTime = Date.now() + (seconds * 1000);
            displayTimeLeft(seconds);

            intervalTimer = setInterval(function () {
                timeLeft = Math.round((remainTime - Date.now()) / 1000);
                if (timeLeft < 0) {
                    clearInterval(intervalTimer);
                    isStarted = false;
                    setterBtns.forEach(function (btn) {
                        btn.disabled = false;
                        btn.style.opacity = 1;
                    });
                    displayTimeLeft(wholeTime);
                    pauseBtn.classList.remove('pause');
                    pauseBtn.classList.add('play');
                    return;
                }
                displayTimeLeft(timeLeft);
            }, 1000);
        }

        function pauseTimer(event) {
            if (isStarted === false) {
                timer(wholeTime);
                isStarted = true;
                this.classList.remove('play');
                this.classList.add('pause');

                setterBtns.forEach(function (btn) {
                    btn.disabled = true;
                    btn.style.opacity = 0.5;
                });

            } else if (isPaused) {
                this.classList.remove('play');
                this.classList.add('pause');
                timer(timeLeft);
                isPaused = isPaused ? false : true
            } else {
                this.classList.remove('pause');
                this.classList.add('play');
                clearInterval(intervalTimer);
                isPaused = isPaused ? false : true;
            }
        }

        function displayTimeLeft(timeLeft) { //displays time on the input
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;
            var displayString = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            displayOutput.textContent = displayString;
            update(timeLeft, wholeTime);
        }

        pauseBtn.addEventListener('click', pauseTimer);

    </script>--}}
@endsection()
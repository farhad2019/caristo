<p class="ref_num">Reference Number:<span>0123456789</span></p>
<div class="shadow"></div>
<div class="car_slider_warap">
    @foreach($car->media as $media)
        <figure style="background-image: url({{ $media->file_url }});"></figure>
    @endforeach
    {{--<figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>
    <figure style="background-image: url({{ url('storage/app/showroom/car-slide1.jpg') }});"></figure>--}}
</div>
<div class="car_detail clearfix">
    <div class="left">
        <h2 class="car_model">Luxurious Bentley Continental GT</h2>
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
                    {{ $car->engineType->name?? '-' }}
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
                    </div> {{--$car->bid_close_at->diffForHumans()--}}

                    <div class="controlls">
                        <div class="display-remain-time">{{ $car->bid_close_at->format('H:i') }}</div>
                        <button class="play" id="pause"></button>
                    </div>
                </div>

                <h4>Place a Bid now</h4>
                {!! Form::open(['route' => 'admin.makeBids.store']) !!}
                <input type="text" name="" placeholder="AED"
                       {{ isset($bid)? 'readonly':'required' }} value="{{ isset($bid)? number_format($bid->amount):0 }}">
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
                        <div class="display-remain-time" style="font-size: 23px;">{{ number_format($bid->amount) }} AED</div>
                        <button class="play" id="pause"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
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

    </script>
@endpush
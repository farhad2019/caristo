<p class="ref_num">Reference Number:<span>{{ $tradeInRequest->tradeAgainst->ref_num }}</span></p>
<div class="shadow"></div>
<div class="car_slider_warap">
    @foreach($tradeInRequest->tradeAgainst->media as $media)
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
        <h2 class="car_model">{{ $tradeInRequest->tradeAgainst->year }} {{ $tradeInRequest->tradeAgainst->carModel->brand->name }} {{ $tradeInRequest->tradeAgainst->carModel->name }}</h2>
        <ul>
            <li>
                <span class="icon-icon-5"></span>
                <p>
                    <small>Model</small>
                    {{ $tradeInRequest->tradeAgainst->carModel->name }}
                </p>
            </li>
            <li>
                <span class="icon-icon-6"></span>
                <p>
                    <small>year</small>
                    {{ $tradeInRequest->tradeAgainst->year }}
                </p>
            </li>
            <li>
                <span class="icon-icon-7"></span>
                <p>
                    <small>KM</small>
                    {{ ($tradeInRequest->tradeAgainst->kilometer)? number_format($tradeInRequest->tradeAgainst->kilometer) : '-' }}
                </p>
            </li>
            <li>
                <span class="icon-icon-8"></span>
                <p>
                    <small>Chassis</small>
                    {{ $tradeInRequest->tradeAgainst->chassis }}
                </p>
            </li>
            <li>
                <span class="icon-icon-9"></span>
                <p>
                    <small>Regional Specs</small>
                    {{ $tradeInRequest->tradeAgainst->regionalSpecs->name }}
                </p>
            </li>
            <li>
                <span class="icon-icon-12"></span>
                <p>
                    <small>engine type</small>
                    {{ $tradeInRequest->tradeAgainst->engineType->name?? '-' }}
                </p>
            </li>
            @foreach($tradeInRequest->tradeAgainst->myCarAttributes as $attribute)
                <li>
                    <span class="{{ $attribute->carAttribute->icon }}"></span>
                    <p>
                        <small>{{ $attribute->carAttribute->name }}</small>
                        @if($attribute->carAttribute->type == 30)
                            {!! \App\Models\AttributeOption::find($attribute->value)['option'] !!}
                        @elseif($attribute->carAttribute->type == 10 || $attribute->carAttribute->type == 20)
                            {!! $attribute->value !!}
                        @endif
                    </p>
                </li>
            @endforeach
            {{--<li>
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
            @foreach($tradeInRequest->tradeAgainst->carFeatures as $carFeature)
                <li>
                    <span class="{{ $carFeature->icon_css }}"></span>
                    <p>
                        <small>{{ $carFeature->name }}?</small>
                        Yes
                    </p>
                </li>
            @endforeach--}}
        </ul>
    </div>

    @if(empty($tradeInRequest->amount))
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
                    </div> {{--$tradeInRequest->tradeAgainst->bid_close_at->diffForHumans()--}}

                    <div class="controlls">
                        <div class="display-remain-time" style="font-size: 18px;"></div>
                        <button class="play" id="pause"></button>
                    </div>
                </div>

                <h4>Place a Bid now</h4>
                {!! Form::open(['route' => ['admin.tradeInCars.update', $tradeInRequest->id], "id"=>"submitBit", 'method' => 'patch']) !!}
                <input type="text" id="amount_bit" name="amount" placeholder="AED"
                       value="{{ isset($tradeIn)? number_format($tradeInRequest->amount):'' }}"
                       min="1">
                <button type="submit" class="submit" name="">submit</button>
                {!! Form::hidden('car_id', $tradeInRequest->tradeAgainst->id) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="right" style="margin-top: 12px">
            <div class="bid_widget">
                <h3 style="text-align: left; margin-bottom: 10px;">Trade In Against: </h3>
                @if($tradeInRequest->myCar->media->count() > 0)
                    <img src="{{ $tradeInRequest->myCar->media[0]->file_url }}" alt="" width="230" height="150">
                @else
                    <img src="{{ url('storage/app/public/dummy-img.jpg') }}" alt="" width="230" height="150">
                @endif
                <h2 style="text-align: left;">{{ $tradeInRequest->myCar->carModel->brand->name }}</h2>
                <h3 style="text-align: left;">{{ $tradeInRequest->myCar->carModel->name }}</h3>
                <h4 style="text-align: left; color: gray">{{ $tradeInRequest->myCar->year }}</h4>
                <h2 style="text-align: left;">AED {{ number_format($tradeInRequest->myCar->amount) }}</h2>
            </div>
        </div>
    @else
        <div class="right">
            <div class="bid_widget">
                {{--                <img src="{{ url('storage/app/showroom/bid-icon.svg') }}" alt="" width="80">--}}
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
                        <div class="" style="font-size: 18px;">{{ number_format($tradeInRequest->amount) }}
                            AED
                        </div>
                        <button class="play" id="pause"></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="right" style="margin-top: 12px">
            <div class="bid_widget">
                <h3 style="text-align: left; margin-bottom: 10px;">Trade In Against: </h3>
                @if($tradeInRequest->myCar->media->count() > 0)
                    <img src="{{ $tradeInRequest->myCar->media[0]->file_url }}" alt="" width="230" height="150">
                @else
                    <img src="{{ url('storage/app/public/dummy-img.jpg') }}" alt="" width="230" height="150">
                @endif
                <h2 style="text-align: left;">{{ $tradeInRequest->myCar->carModel->brand->name }}</h2>
                <h3 style="text-align: left;">{{ $tradeInRequest->myCar->carModel->name }}</h3>
                <h4 style="text-align: left; color: gray">{{ $tradeInRequest->myCar->year }}</h4>
                <h2 style="text-align: left;">AED {{ number_format($tradeInRequest->myCar->amount) }}</h2>
            </div>
        </div>
    @endif
</div>

<script>

    $(document).ready(function () {

        //circle start
        var progressBar = document.querySelector('.e-c-progress');
        var indicator = document.getElementById('e-indicator');
        var pointer = document.getElementById('e-pointer');
        var length = Math.PI * 2 * 100;

        progressBar.style.strokeDasharray = length;

        function update(value, timePercent) {
            //var offset = -length - length * value / (86400);
            var offset = -length - length * value / (timePercent);
            progressBar.style.strokeDashoffset = offset;
            pointer.style.transform = `rotate(${360 * value / (timePercent)}deg)`;
        }

        //circle ends
        const displayOutput = document.querySelector('.display-remain-time');
        const pauseBtn = document.getElementById('pause');
        const setterBtns = document.querySelectorAll('button[data-setter]');

        var intervalTimer;
        var timeLeft;
        var wholeTime = {{ $tradeInRequest->bid_close_at->diffInSeconds(now()) }}; //0.5 * 2400; // manage this to set the whole time
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
            var hours = Math.floor(timeLeft / 3600);
            var minutes = Math.floor((timeLeft) / 60) - (hours * 60);
            var seconds = timeLeft % 60;
            var displayString = `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            displayOutput.textContent = displayString;
            update(timeLeft, wholeTime);
        }

        pauseTimer();
        //pauseBtn.addEventListener('click', pauseTimer);

        $(function () {
            $(document).on('submit', '#submitBit', function () {
                if (!$.trim($('#amount_bit').val())) {
                    $('#amount_bit').css('border', '1px solid #ff081c');
                    return false;
                }
                return true
            });
        });

        jQuery('#amount_bit').keyup(function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

    });

</script>
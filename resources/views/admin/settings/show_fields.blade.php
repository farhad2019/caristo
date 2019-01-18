<div class="nav-tabs-custom col-sm-12">
    <ul class="nav nav-tabs">
        @foreach($setting->translations as $key => $translation)
            <li {{ $key == 0?'class=active':'' }}>
                <a href="#tab_{{$key+1}}" data-toggle="tab">
                    {{ $translation->language->native_name }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($setting->translations as $key => $translation)
            <div class="tab-pane {{$key==0?'active':''}}" id="tab_{{$key+1}}">
                @php(App::setLocale($translation->locale))
                <div class="box">
                    <div class="box-header with-border">

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-12">
                            <!-- depreciation_trend Field -->
                            <dt>{!! Form::label('depreciation_trend', 'Depreciation Trend:') !!}</dt>
                            <dd>{!! $setting->depreciation_trend !!}% / Year </dd>
                        </div>
                        <div class="col-md-12">
                            <!-- Title Field -->
                            <dt> {!! Form::label('ask_for_consultancy', 'Ask For Consultancy:') !!} </dt>
                            <dd style="word-break: break-all">{!! $setting->ask_for_consultancy !!}</dd>
                        </div>
                        <div class="col-md-12 "><br></div>
                        <div class="col-md-12">
                            <!-- Street Field -->
                            <dt>{!! Form::label('personal_shopper', 'Personal Shopper:') !!}</dt>
                            <dd style="word-break: break-all">{!! $setting->personal_shopper !!}</dd>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">

                    </div>
                    <!-- box-footer -->
                </div>
                <!-- /.box -->
            </div>
        @endforeach
    </div>
    <!-- /.tab-content -->
</div>
{{--<div class="clearfix"></div>
<div class="box">
    <div class="box-header with-border">

    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- /.box -->
        <div class="col-sm-6">
            <!-- Email Field -->
            <dt style="width:38%;">{!! Form::label('email', 'Depreciation Trend (%/Year):') !!}</dt>
            <dd>{!! $setting->depreciation_trend !!} % </dd>

            <!-- Playstore Field -->
            <dt>{!! Form::label('playstore', 'Add Car Limit:') !!}</dt>
            <dd>{!! $setting->limit_for_cars !!} / user</dd>

            <!-- Force Update Field -->
            <dt>{!! Form::label('force_update', 'Featured Cars Limit:') !!}</dt>
            <dd>{!! $setting->limit_for_featured_cars !!} / user</dd>

            <!-- Logo Field -->
            <dt>{!! Form::label('logo', 'Logo:') !!}</dt>
            <dd><img src="{!! $setting->image_url !!}"></dd>
        </div>
        --}}{{--<div class="col-sm-6">
            <!-- Locale Field -->
            <dt>{!! Form::label('locale', 'App Default Language:') !!}</dt>
            <dd>{!! $setting->default_language !!}</dd>

            <!-- Phone Field -->
            <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
            <dd>{!! $setting->phone !!}</dd>

            <!-- App Version Field -->
            <dt>{!! Form::label('app_version', 'App Version:') !!}</dt>
            <dd>{!! $setting->app_version !!}</dd>

            <!-- Appstore Field -->
            <dt>{!! Form::label('appstore', 'App Store:') !!}</dt>
            <dd>{!! !empty($setting->appstore)? "<a href='".$setting->appstore."' target='_blank'>App Store</a>" : "#" !!}</dd>
        @if($setting->social_links)
            @php($socaials = json_decode($setting->social_links))
            <!-- Social Links Field -->
                <dt>{!! Form::label('social_links', 'Social Links:') !!}</dt>
                <dd>@foreach($socaials as $socaial)
                        <li>
                            <a href="{{ array_values(get_object_vars($socaial))[0] }}"
                               target="_blank">{{ array_keys(get_object_vars($socaial))[0] }}</a>
                        </li>
                    @endforeach
                </dd>
            @endif
        </div>--}}{{--
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

    </div>
    <!-- box-footer -->
</div>--}}
{{--<div class="clearfix"></div>
<div class="box">
    <div class="box-header with-border">

    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group col-sm-12" id="us3" style="width: 100%; height: 400px;"></div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

    </div>
    <!-- box-footer -->
</div>--}}

{{--{!! Form::hidden('latitude', $setting->latitude,['id'=>'old-lat']) !!}
{!! Form::hidden('longitude', $setting->longitude,['id'=>'old-lon']) !!}--}}

{{--
@push('scripts')
<script type="text/javascript"
        src='https://maps.google.com/maps/api/js?key=AIzaSyBaqAOKxwrCNbg_Vb6S5DV5XatDsQ1Ydfo&sensor=false&libraries=places'></script>
<script src="{{ url('public/js/admin/locationpicker.jquery.min.js') }}"></script>
<script>
    $(function () {
        var old_lat = $('#old-lat').val() != 0 ? $('#old-lat').val() : 25.110026;
        var old_lon = $('#old-lon').val() != 0 ? $('#old-lon').val() : 55.145516;

        $('#us3').locationpicker({
            location: {
                latitude: old_lat,
                longitude: old_lon
            },
            radius: 0,
            inputBinding: {
                latitudeInput: $('#us3-lat'),
                longitudeInput: $('#us3-lon'),
                radiusInput: $('#us3-radius'),
                locationNameInput: $('#us3-address')
            },
            enableAutocomplete: true,
            onchanged: function (currentLocation, radius, isMarkerDropped) {
                // Uncomment line below to show alert on each Location Changed event
                //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
            }
        });

        $('form input#us3-address').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            return keyCode !== 13;
        });
    });
</script>
@endpush

<div class="clearfix"></div>--}}

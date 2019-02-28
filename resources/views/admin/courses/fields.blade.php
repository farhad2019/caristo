<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Media Field -->
<div class="form-group col-sm-6">
    {!! Form::label('media', 'Image:') !!}
    {!! Form::file('media', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Subtitle Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subtitle', 'subtitle:') !!}
    {!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
</div>

<!-- description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Language Field -->
<div class="form-group col-sm-6">
    {!! Form::label('language', 'Language:') !!}
    {!! Form::text('language', null, ['class' => 'form-control']) !!}
</div>

<!-- Duration Field -->
<div class="form-group col-sm-6 on-site">
    {!! Form::label('duration', 'Duration:') !!}
    {!! Form::text('duration', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Field -->
<div class="form-group col-sm-6 on-site">
    {!! Form::label('date', 'Date:') !!}
    {{--    {!! Form::text('date', null, ['class' => 'form-control']) !!}--}}
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker" name="date"
               value="{{ isset($course)?$course->date:'' }}">
    </div>
    <!-- /.input group -->
</div>

<!-- Time Field -->
<div class="form-group col-sm-6 on-site">
    {!! Form::label('time', 'Time:') !!}
    {{--{!! Form::text('time', null, ['class' => 'form-control']) !!}--}}

    <div class="input-group">
        <input type="text" class="form-control timepicker" name="time">

        <div class="input-group-addon">
            <i class="fa fa-clock-o"></i>
        </div>
    </div>
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Intro Link Field -->
<div class="form-group col-sm-6 on-line">
    {!! Form::label('intro_link', 'Intro Link:') !!}
    {!! Form::text('intro_link', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-12 on-site">
    {!! Form::label('location', __('Location').'*:') !!}
    {!! Form::text('location', null, ['class' => 'form-control', 'id'=>'us3-address']) !!}
</div>

<div class="form-group col-sm-12 on-site" id="us3" style="width: 100%; height: 400px;"></div>
{!! Form::hidden('latitude',null,['id'=>'us3-lat']) !!}
{!! Form::hidden('longitude',null,['id'=>'us3-lon']) !!}

<input type="hidden" name="old_lat" value="{{ empty(old('latitude'))?0:old('latitude') }}" id="old-lat">
<input type="hidden" name="old_long" value="{{ empty(old('longitude'))?0:old('longitude') }}" id="old-lon">

@if(isset($course))
    {!! Form::hidden('lat', $course->latitude, ['id' => 'us3-lat']) !!}
    {!! Form::hidden('long', $course->longitude, ['id' => 'us3-lon']) !!}

    {!! Form::hidden('db_lat', $course->latitude, ['id' => 'db_lat']) !!}
    {!! Form::hidden('db_long', $course->longitude, ['id' => 'db_long']) !!}
@else
    {!! Form::hidden('old_lat', empty(old('latitude'))?0:old('latitude'), ['id' => 'old-lat']) !!}
    {!! Form::hidden('old_long', empty(old('longitude'))?0:old('longitude'), ['id' => 'old-lon']) !!}
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.courses.index') !!}" class="btn btn-default">Cancel</a>
</div>

@push('scripts')
    <script type="text/javascript"
            src='https://maps.google.com/maps/api/js?key=AIzaSyAY6cT8GjO16kEHu_9SGjdysAZAPA-wHec&sensor=false&libraries=places'></script>
    <script src="{{ url('public/js/admin/locationpicker.jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let old_lat = $('#old-lat').val() != 0 ? $('#old-lat').val() : 25.110026;
            let old_lon = $('#old-lon').val() != 0 ? $('#old-lon').val() : 55.145516;

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

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            });

            //Date picker
            $('#datepicker').datepicker({
                dateFormat: 'dd-mm-yy',
                autoclose: true
            });

            if (parseInt($('#category_id').val()) === 56) {
                $('.on-site').show();
                $('.on-line').hide();
            } else {
                $('.on-line').show();
                $('.on-site').hide();
            }

            $('#category_id').on('change', function () {
                if (parseInt($(this).val()) === 56) {
                    $('.on-site').show();
                    $('.on-line').hide();
                } else {
                    $('.on-line').show();
                    $('.on-site').hide();
                }
            });
        });
    </script>
@endpush
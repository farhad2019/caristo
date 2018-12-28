<style>
    .regions {
        display: none;
    }
</style><!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Brand Field -->
<div class="form-group col-sm-6">
    {!! Form::label('brand', 'Brand:') !!}
    {!! Form::select('brand', $brands, (isset($myCar))? $myCar->carModel->brand->id: null, ['class' => 'form-control select2']) !!}
</div>

<!-- Model Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model_id', 'Model:') !!}
    {!! Form::select('model_id', $carModels, null, ['class' => 'form-control select2', 'data-url'=> route('api.carModels.index'), 'data-depends'=> 'brand']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year', 'Year:') !!}
    {!! Form::select('year', $years, date('Y'), ['class' => 'form-control select2']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6 region">
    {!! Form::label('transmission_type', 'Transmission Type:') !!}
    {!! Form::select('transmission_type', $transmission_type, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_id', 'Car Type:') !!}
    {!! Form::select('type_id', $carTypes, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('engine_type_id', 'Engine Type:') !!}
    {!! Form::select('engine_type_id', $engineType, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6 region">
    {!! Form::label('region', 'Region:') !!}
    {!! Form::select('region', $regions, null, ['class' => 'form-control select2']) !!}
</div>


<!-- Amount Field -->
<div class="form-group col-sm-6 region category2528" {{--id="mileage" style="display:none;"--}}>
    {!! Form::label('kilometers', 'Mileage(km):') !!}
    {!! Form::number('kilometer', null, ['class' => 'form-control', 'placeholder' => 'Enter Car Mileage']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount(AED):') !!}
    {!! Form::number('amount', null, ['class' => 'form-control', 'placeholder' => 'Enter Car Amount']) !!}
</div>

<!-- Average MKP Field -->
<div class="form-group col-sm-6 region category2528">
    {!! Form::label('avg_mkp', 'Average MKP(AED):') !!}
    {!! Form::number('average_mkp', null, ['class' => 'form-control', 'placeholder' => 'Enter Average Market Price']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

@php($user = \Illuminate\Support\Facades\Auth::user())
<!-- Email Field -->
<div class="form-group col-sm-6 region">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
</div>

<!-- Country Code Field -->
<div class="form-group col-sm-6 region">
    {!! Form::label('country_code', 'Country Code:') !!}
    {!! Form::text('country_code', $user->details->country_code, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6 region">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::number('phone', $user->details->phone, ['class' => 'form-control']) !!}
</div>

<!-- Regional Specification Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regional_specific1ation_id', 'Regional Specification:') !!}
    {!! Form::select('regional_specification_id', $regional_specs, null, ['class' => 'form-control select2']) !!}
</div>

@if(!isset($myCar))

    <div class="clearfix"></div>

    <div class="form-group col-sm-12 region">
        {!! Form::label('features', 'Car Features:') !!}
        <div class="col-sm-12">
            @foreach($features as $feature)
                <div class="form-group col-sm-3 region clearfix">
                    <div class="col-sm-2">
                        {!! Form::hidden('feature['.$feature->id.']', false) !!}
                        {!! Form::checkbox('feature['.$feature->id.']', 1, null) !!}
                    </div>
                    <div class="col-sm-10">
                        {!! Form::label('status', $feature->name.':', ['style' => 'word-break: break-all; width: 50%;']) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="clearfix"></div>

    @foreach($attributes as $attribute)
        @if($attribute->type == 10)
            <div class="form-group col-sm-6 region">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::text('attribute['.$attribute->id.']', null, ['class' => 'form-control', 'placeholder' => 'Enter attribute '.$attribute->name]) !!}
            </div>
        @elseif($attribute->type == 20)
            <div class="form-group col-sm-6 region">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::number('attribute['.$attribute->id.']', null, ['class' => 'form-control', 'step' =>0.1, 'placeholder' => 'Enter attribute '.$attribute->name]) !!}
            </div>
        @elseif($attribute->type == 30 || $attribute->type == 40)
            @foreach($attribute->option_array as $item)
                @php($options[$item['id']] = $item['name'])
            @endforeach
            <!-- Regional Specification Field -->
            <div class="form-group col-sm-6 region">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::select('attribute['.$attribute->id.']', $options, null, ['class' => 'form-control select2', ($attribute->type == 40)?
                'multiple':'']) !!}
            </div>
            @php($options = [])
        @else
            <div class="form-group col-sm-6 region">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::file('attribute['.$attribute->id.']', ['class' => 'form-control', ($attribute->type == 60)?
                'multiple':'']) !!}
            </div>
        @endif
    @endforeach
@else
    <div class="clearfix"></div>
    <div class="form-group col-sm-12 region">
        {!! Form::label('features', 'Car Features:') !!}
        <div class="col-sm-12">
            @foreach($features as $feature)
                <div class="form-group col-sm-3">
                    <div class="col-sm-2">
                        {!! Form::hidden('feature['.$feature->id.']', false) !!}
                        {!! Form::checkbox('feature['.$feature->id.']', 1, (in_array($feature->id, $myCar->carFeatures->pluck('id')->toArray())?? false)) !!}
                    </div>
                    <div class="col-sm-10">
                        {!! Form::label('status', $feature->name.':') !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="clearfix"></div>

    @foreach($attributes as $attribute)
        @php($value = (in_array($attribute->id, $myCar->myCarAttributes->pluck('attr_id')->toArray())?($myCar->myCarAttributes[array_search($attribute->id, $myCar->myCarAttributes->pluck('attr_id')->toArray())]->value): null))
        @if($attribute->type == 10)
            <div class="form-group col-sm-6 region">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::text('attribute['.$attribute->id.']', $value, ['class' => 'form-control', 'placeholder' => 'Enter attribute '.$attribute->name]) !!}
            </div>
        @elseif($attribute->type == 20)
            <div class="form-group col-sm-6 region">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::number('attribute['.$attribute->id.']', (int)$value, ['class' => 'form-control', 'step' =>0.1, 'placeholder' => 'Enter attribute '.$attribute->name]) !!}
            </div>
        @elseif($attribute->type == 30 || $attribute->type == 40)
            @foreach($attribute->option_array as $item)
                @php($options[$item['id']] = $item['name'])
            @endforeach
            <!-- Regional Specification Field -->
            <div class="form-group col-sm-6 region">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::select('attribute['.$attribute->id.']', $options, $value, ['class' => 'form-control select2', ($attribute->type == 40)? 'multiple':'']) !!}
            </div>
            @php($options = [])
        @else
            <div class="form-group col-sm-6 region">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::file('attribute['.$attribute->id.']', ['class' => 'form-control', ($attribute->type == 60)?
                'multiple':'']) !!}
            </div>

        @endif
    @endforeach
    {{--@foreach($myCar->myCarAttributes as $attribute)
        @if($attribute->toArray()['attr_option'] !== null)
        @endif
        @if($attribute->type == 10)
            <div class="form-group col-sm-6">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::text('attribute['.$attribute->id.']', $attribute->value, ['class' => 'form-control']) !!}
            </div>
        @elseif($attribute->type == 20)
            <div class="form-group col-sm-6">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::number('attribute['.$attribute->id.']', $attribute->value, ['class' => 'form-control', 'step' =>0.1]) !!}
            </div>
        @elseif($attribute->type == 30 || $attribute->type == 40)
            @foreach($attribute->option_array as $item)
                @php($options[$item['id']] = $item['name'])
            @endforeach
            <!-- Regional Specification Field -->
            <div class="form-group col-sm-6">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::select('attribute['.$attribute->id.']', $options, $attribute->value, ['class' => 'form-control select2', ($attribute->type == 40)?
                'multiple':'']) !!}
            </div>
            @php($options = [])
        @else
            <div class="form-group col-sm-6">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::file('attribute['.$attribute->id.']', ['class' => 'form-control', ($attribute->type == 60)?
                'multiple':'']) !!}
            </div>
        @endif
    @endforeach--}}
@endif
<!-- Limited Edition Fields -->
<div class="form-group col-sm-12 regions">
    <h3>Dimensions & Weight</h3>
    <hr>
</div>
<div class="form-group col-sm-6 regions">
    {!! Form::label('length', 'Length:') !!}
    {!! Form::number('length', isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['LENGTH']:null, ['class' => 'form-control', 'placeholder' => 'Length in MM']) !!}
</div>

<div class="form-group col-sm-6 regions">
    {!! Form::label('width', 'Width:') !!}
    {!! Form::number('width',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['WIDTH']:null, ['class' => 'form-control', 'placeholder' => 'Width in MM']) !!}
</div>

<div class="form-group col-sm-6 regions">
    {!! Form::label('height', 'Height:') !!}
    {!! Form::number('height',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['HEIGHT']:null, ['class' => 'form-control', 'placeholder' => 'Height in MM']) !!}
</div>

<div class="form-group col-sm-6 regions">
    {!! Form::label('weight_dist', 'WEIGHT DISTRIBUTION:') !!}
    {!! Form::number('weight_dist',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['WEIGHT DISTRIBUTION']:null, ['class' => 'form-control', 'placeholder' => 'WEIGHT DISTRIBUTION']) !!}
</div>

<div class="form-group col-sm-6 regions">
    {!! Form::label('trunk', 'Trunk:') !!}
    {!! Form::number('trunk',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['TRUNK']:null, ['class' => 'form-control', 'placeholder' => 'Trunk in Length']) !!}
</div>

<div class="form-group col-sm-6 regions">
    {!! Form::label('WEIGHT', 'WEIGHT:') !!}
    {!! Form::number('weight',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['WEIGHT']:null, ['class' => 'form-control', 'placeholder' => 'Weight in KG']) !!}
</div>
<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Seating Capacity</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('seats', 'MAX.NO OF SEATS:') !!}
        {!! Form::number('seats', isset($limited_edition_specs)? $limited_edition_specs['Seating_Capacity']['MAX.NO OF SEATS']:null, ['class' => 'form-control', 'placeholder' => 'MAX.NO OF SEATS']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Drivetrain</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('DRIVETRAIN', 'DRIVETRAIN:') !!}
        {!! Form::select('drivetrain', \App\Models\MyCar::$DRIVETRAIN,  isset($limited_edition_specs)? $limited_edition_specs['Drivetrain']['DRIVETRAIN']:null, ['class' => 'form-control select2']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Engine</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('DISPLACEMENT', 'DISPLACEMENT:') !!}
        {!! Form::number('displacement',  isset($limited_edition_specs)? $limited_edition_specs['Engine']['DISPLACEMENT']:null, ['class' => 'form-control', 'placeholder' => 'Displacement is CC']) !!}
    </div>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('CLYNDERS', 'NO. OF  CLYNDERS:') !!}
        {!! Form::number('clynders',  isset($limited_edition_specs)? $limited_edition_specs['Engine']['NO. OF CYLINDER']:null, ['class' => 'form-control', 'placeholder' => 'NO. OF  CLYNDERS']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Performance</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('SPEED', 'MAX SPEED:') !!}
        {!! Form::number('max_speed',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['MAX SPEED']:null, ['class' => 'form-control', 'placeholder' => 'Max speed in KM/H']) !!}
    </div>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('ACCELERATION', 'ACCELERATION') !!}
        {!! Form::number('acceleration',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['ACCELERATION 0-100']:null, ['class' => 'form-control', 'placeholder' => 'ACCELERATION 0-100 Sec']) !!}
    </div>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('RPM', 'HP / RPM') !!}
        {!! Form::number('hp_rpm',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['HP / RPM']:null, ['class' => 'form-control', 'placeholder' => 'HP / RPM']) !!}
    </div>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('TORQUE', 'TORQUE') !!}
        {!! Form::number('torque',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['TORQUE']:null, ['class' => 'form-control', 'placeholder' => 'TORQUE']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Transmission</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('GEARBOX', 'GEARBOX:') !!}
        {!! Form::number('gearbox',  isset($limited_edition_specs)? $limited_edition_specs['Transmission ']['GEARBOX']:null, ['class' => 'form-control', 'placeholder' => 'GEARBOX']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Brakes</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('Brakes_System', 'Brakes System:') !!}
        {!! Form::text('brakes',  isset($limited_edition_specs)? $limited_edition_specs['Brakes']['BRAKES SYSTEM']:null, ['class' => 'form-control', 'placeholder' => 'Brakes  System']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Suspension</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('Suspension', 'Suspension:') !!}
        {!! Form::text('suspension',  isset($limited_edition_specs)? $limited_edition_specs['Suspension']['SUSPENSION']:null, ['class' => 'form-control', 'placeholder' => 'Suspension']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Wheels & Tyres</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('FRONT_TYRE', 'Front tyre:') !!}
        {!! Form::text('front_tyre',  isset($limited_edition_specs)? $limited_edition_specs['Wheels_Tyres']['FRONT TYRE']:null, ['class' => 'form-control', 'placeholder' => 'FRONT TYRE']) !!}
    </div>

    <div class="form-group col-sm-6 regions">
        {!! Form::label('Back_TYRE', 'Back tyre:') !!}
        {!! Form::text('back_tyre',  isset($limited_edition_specs)? $limited_edition_specs['Wheels_Tyres']['BACK TYRE']:null, ['class' => 'form-control', 'placeholder' => 'Back TYRE']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Fuel</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('FUEL_CONSUMBSION', 'FUEL CONSUMBSION:') !!}
        {!! Form::number('consumbsion',  isset($limited_edition_specs)? $limited_edition_specs['Fuel']['FUEL CONSUMPTION']:null, ['class' => 'form-control', 'placeholder' => 'FUEL CONSUMPTION L/100KM']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Emission</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('Emission', 'Emission:') !!}
        {!! Form::text('emission',  isset($limited_edition_specs)? $limited_edition_specs['Emission']['EMISSION']:null, ['class' => 'form-control', 'placeholder' => 'Emission in gmCO2/KM
']) !!}
    </div>
</div>

<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Warranty & Maintenance</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('WARRANTY', 'WARRANTY:') !!}
        {!! Form::number('warranty',  isset($limited_edition_specs)? $limited_edition_specs['Warranty_Maintenance']['WARRANTY']:null, ['class' => 'form-control', 'placeholder' => 'YEARS/KM']) !!}
    </div>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('MAINTENANCE_PROGRAM ', 'MAINTENANCE PROGRAM :') !!}
        {!! Form::number('maintenance',  isset($limited_edition_specs)? $limited_edition_specs['Warranty_Maintenance']['MAINTENANCE PROGRAM ']:null, ['class' => 'form-control', 'placeholder' => 'YEARS/KM']) !!}
    </div>
</div>


<div class="form-group col-sm-12 regions">
    <hr>
    <h3>Life Cycle</h3>
    <hr>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('Lifecycle', 'From:') !!}
        {!! Form::date('from', null, ['class' => 'form-control', 'placeholder' => 'number/YEARS']) !!}
    </div>
    <div class="form-group col-sm-6 regions">
        {!! Form::label('Lifecycle', 'To:') !!}
        {!! Form::date('to', null, ['class' => 'form-control', 'placeholder' => 'number/YEARS']) !!}
    </div>
    <hr>
</div>
<div class="form-group col-sm-12 regions">
    <div class="form-group col-sm-6 regions">
        {!! Form::label('Depreciation_Trend', 'Depreciation Trend (%):') !!}
        {!! Form::number('depreciation_trend',  null, ['class' => 'form-control', 'placeholder' => 'Depreciation Trend in %']) !!}
    </div>
</div>
<!-- End of Limited Editions Field -->

<!-- Multiple Regions Selection Field -->
@if(isset($myCar))
    @foreach($myCar->carRegions as $region)
        <div class="regions">
            <div class="form-group col-sm-3">
                {!! Form::label('price','Price in '. $region->region->name) !!}
                {!! Form::hidden('regions[]',$region->region_id, null, ['class' => 'form-control']) !!}
                {!! Form::text('price[]', $region->price, ['class' => 'form-control', 'placeholder' => 'Enter Region Price']) !!}
            </div>
        </div>
    @endforeach
@else
    @foreach($regions as $key => $region)
        <div class="regions" style="display: none">
            <div class="form-group col-sm-6">
                {!! Form::label('regions','Price in '.$region, null, ['class' => 'form-control']) !!}
                {!! Form::hidden('regions[]',$key, null, ['class' => 'form-control']) !!}
                {!! Form::text('price[]', null, ['class' => 'form-control', 'placeholder' => 'Enter Region Price']) !!}
            </div>
        </div>
    @endforeach
@endif

<!-- Media Field -->
<div class="form-group col-sm-6">
    {!! Form::label('media', 'Images:') !!}
    {!! Form::file('media[]', ['class' => 'form-control', 'multiple']) !!}
    <br>
    @if(isset($myCar))
        @if($myCar->media->count() > 0)
            @foreach($myCar->media as $media)
                <div style="position: relative; display: inline;">
                    <a class="showGallery" data-id="{{$media->id}}" data-toggle="modal" data-target="#imageGallery">
                        <img src="{{ $media->file_url }}" width="120" style="margin-right: 2%">
                    </a>
                    <span class="btn-sm btn-danger delete_media" data-id="{{$media->id}}"
                          style="position: absolute; right: 2px; z-index: 100; cursor: hand">&times;
                </span>
                </div>
            @endforeach
        @endif
    @endif
</div>

<!-- Year Field -->
<div class="form-group col-sm-12 clearfix">
    {!! Form::label('notes', 'Description:') !!}
    {!! Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => 'Enter Description']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.myCars.index') !!}" class="btn btn-default">Cancel</a>
</div>
@push('scripts')
<script>
    $(document).ready(function () {
        var id = $('#category_id').val();
        if (id == 28) {
            $('.regions').show();
            $('.region').hide();
        } else {
            $('.regions').hide();
            $('.region').show();
        }

        if (parseInt(id) === 25 || parseInt(id) === 28) {
            $('.category2528').hide();
        } else if (parseInt(id) === 26 || parseInt(id) === 27) {
            $('.category2528').show();
        }

        $('#category_id').on('change', function () {
            var cat_id = $(this).val();

            if (cat_id == 28) {
                $('.regions').show();
                $('.region').hide();
            } else {
                $('.regions').hide();
                $('.region').show();
            }

            if (parseInt(cat_id) === 25 || parseInt(cat_id) === 28) {
                $('.category2528').hide();
            } else if (parseInt(cat_id) === 26 || parseInt(cat_id) === 27) {
                $('.category2528').show();
            }
        });

        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });

    });
</script>
@endpush
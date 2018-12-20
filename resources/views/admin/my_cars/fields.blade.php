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
    {!! Form::select('brand', $brands, (isset($myCar))? $myCar->carModel->brand->id: null, ['class' => 'form-control select2', 'placeholder' => 'Pick a car brand...']) !!}
</div>

<!-- Model Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model_id', 'Model:') !!}
    {!! Form::select('model_id', $carModels, null, ['class' => 'form-control select2', 'data-url'=> route('api.carModels.index'), 'data-depends'=> 'brand', 'placeholder' => 'Pick a car model...']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year', 'Year:') !!}
    {!! Form::text('year', null, ['class' => 'form-control', 'placeholder' => 'Enter Model Year']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6 region">
    {!! Form::label('transmission_type', 'Transmission Type:') !!}
    {!! Form::select('transmission_type', $transmission_type, null, ['class' => 'form-control select2', 'placeholder' => 'Pick a transmission type...']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_id', 'Car Type:') !!}
    {!! Form::select('type_id', $carTypes, null, ['class' => 'form-control select2', 'placeholder' => 'Pick a car type...']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('engine_type_id', 'Engine Type:') !!}
    {!! Form::select('engine_type_id', $engineType, null, ['class' => 'form-control select2', 'placeholder' => 'Pick a engine type...']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6 region">
    {!! Form::label('region', 'Region:') !!}
    {!! Form::select('region', $regions, null, ['class' => 'form-control select2', 'placeholder' => 'Pick a region...']) !!}
</div>


<!-- Amount Field -->
<div class="form-group col-sm-6 region" {{--id="mileage" style="display:none;"--}}>
    {!! Form::label('kilometers', 'Mileage(km):') !!}
    {!! Form::number('kilometer', null, ['class' => 'form-control', 'placeholder' => 'Enter Car Mileage']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount(AED):') !!}
    {!! Form::number('amount', null, ['class' => 'form-control', 'placeholder' => 'Enter Car Amount']) !!}
</div>

<!-- Average MKP Field -->
<div class="form-group col-sm-6 region">
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
    {!! Form::text('phone', $user->details->phone, ['class' => 'form-control']) !!}
</div>

<!-- Regional Specification Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regional_specific1ation_id', 'Regional Specification:') !!}
    {!! Form::select('regional_specification_id', $regional_specs, null, ['class' => 'form-control select2', 'placeholder' => 'Pick a regional specification...']) !!}
</div>

@if(!isset($myCar))
    <div class="clearfix"></div>

    @foreach($features as $feature)
        <div class="form-group col-sm-2 region">
            {!! Form::label('status', $feature->name.':') !!}
            {!! Form::hidden('feature['.$feature->id.']', false) !!}
            {!! Form::checkbox('feature['.$feature->id.']', 1, null) !!}
        </div>
    @endforeach
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
                'multiple':'', 'placeholder' => 'Pick attribute '.$attribute->name]) !!}
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
    @foreach($features as $feature)
        <div class="form-group col-sm-2 region">
            {!! Form::label('status', $feature->name.':') !!}
            {!! Form::hidden('feature['.$feature->id.']', false) !!}
            {!! Form::checkbox('feature['.$feature->id.']', 1, (in_array($feature->id, $myCar->carFeatures->pluck('id')->toArray())?? false)) !!}
        </div>
    @endforeach
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
                {!! Form::select('attribute['.$attribute->id.']', $options, $value, ['class' => 'form-control select2', ($attribute->type == 40)? 'multiple':'', 'placeholder' => 'Pick attribute '.$attribute->name]) !!}
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


                    <!-- Start Edit of Limited Editions Field -->
            @if($limited !== null)
                @foreach($limited as $key=>$row)
                        @if($key == 'Dimensions_Weight')
                            <div class="form-group col-sm-12">
                                <h3>Dimensions & Weight</h3>
                                <hr>
                            </div>
                            <div class="form-group col-sm-6 ">
                                {!! Form::label('length', 'Length:') !!}
                                {!! Form::text('length',$row['length'],['class' => 'form-control', 'placeholder' => 'Length in MM']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('width', 'Width:') !!}
                                {!! Form::text('width',$row['width'],['class' => 'form-control', 'placeholder' => 'Width in MM']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('height', 'Height:') !!}
                                {!! Form::text('height', $row['height'], ['class' => 'form-control', 'placeholder' => 'Height in MM']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('weight_dist', 'WEIGHT DISTRIBUTION:') !!}
                                {!! Form::text('weight_dist', $row['weight_dist'], ['class' => 'form-control', 'placeholder' => 'WEIGHT DISTRIBUTION']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('trunk', 'Trunk:') !!}
                                {!! Form::text('trunk', $row['trunk'], ['class' => 'form-control', 'placeholder' => 'Trunk in Length']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('WEIGHT', 'WEIGHT:') !!}
                                {!! Form::text('weight', $row['weight'], ['class' => 'form-control', 'placeholder' => 'Weight in KG']) !!}
                            </div>

                           @elseif($key ='Seating_Capacity')
                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Seating Capacity</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('seats', 'MAX.NO OF SEATS:') !!}
                                    {!! Form::text('seats', $row['seats'], ['class' => 'form-control', 'placeholder' => 'MAX.NO OF SEATS']) !!}
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @else
                                    <!-- Edit Limited Field -->

                            <!-- Limited Edition Fields -->
                            <div class="form-group col-sm-12 regions">
                                <h3>Dimensions & Weight</h3>
                                <hr>
                            </div>
                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('length', 'Length:') !!}
                                {!! Form::text('length', null, ['class' => 'form-control', 'placeholder' => 'Length in MM']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('width', 'Width:') !!}
                                {!! Form::text('width', null, ['class' => 'form-control', 'placeholder' => 'Width in MM']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('height', 'Height:') !!}
                                {!! Form::text('height', null, ['class' => 'form-control', 'placeholder' => 'Height in MM']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('weight_dist', 'WEIGHT DISTRIBUTION:') !!}
                                {!! Form::text('weight_dist', null, ['class' => 'form-control', 'placeholder' => 'WEIGHT DISTRIBUTION']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('trunk', 'Trunk:') !!}
                                {!! Form::text('trunk', null, ['class' => 'form-control', 'placeholder' => 'Trunk in Length']) !!}
                            </div>

                            <div class="form-group col-sm-6 regions">
                                {!! Form::label('WEIGHT', 'WEIGHT:') !!}
                                {!! Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'Weight in KG']) !!}
                            </div>
                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Seating Capacity</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('seats', 'MAX.NO OF SEATS:') !!}
                                    {!! Form::text('seats', null, ['class' => 'form-control', 'placeholder' => 'MAX.NO OF SEATS']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Drivetrain</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('DRIVETRAIN', 'DRIVETRAIN:') !!}
                                    {!! Form::select('drivetrain', \App\Models\MyCar::$DRIVETRAIN, null, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Engine</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('DISPLACEMENT', 'DISPLACEMENT:') !!}
                                    {!! Form::text('displacement', null, ['class' => 'form-control', 'placeholder' => 'Displacement is CC']) !!}
                                </div>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('CLYNDERS', 'NO. OF  CLYNDERS:') !!}
                                    {!! Form::text('clynders', null, ['class' => 'form-control', 'placeholder' => 'NO. OF  CLYNDERS']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Performance</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('SPEED', 'MAX SPEED:') !!}
                                    {!! Form::text('max_speed', null, ['class' => 'form-control', 'placeholder' => 'Max speed in KM/H']) !!}
                                </div>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('ACCELERATION', 'ACCELERATION') !!}
                                    {!! Form::text('acceleration', null, ['class' => 'form-control', 'placeholder' => 'ACCELERATION 0-100 Sec']) !!}
                                </div>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('RPM', 'HP / RPM') !!}
                                    {!! Form::text('hp_rpm', null, ['class' => 'form-control', 'placeholder' => 'HP / RPM']) !!}
                                </div>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('TORQUE', 'TORQUE') !!}
                                    {!! Form::text('torque', null, ['class' => 'form-control', 'placeholder' => 'TORQUE']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Transmission</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('GEARBOX', 'GEARBOX:') !!}
                                    {!! Form::text('gearbox', null, ['class' => 'form-control', 'placeholder' => 'GEARBOX']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Brakes</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('Brakes_System', 'Brakes System:') !!}
                                    {!! Form::text('brakes', null, ['class' => 'form-control', 'placeholder' => 'Brakes  System']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Suspension</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('Suspension', 'Suspension:') !!}
                                    {!! Form::text('suspension', null, ['class' => 'form-control', 'placeholder' => 'Suspension']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Wheels & Tyres</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('FRONT_TYRE', 'Front tyre:') !!}
                                    {!! Form::text('front_tyre', null, ['class' => 'form-control', 'placeholder' => 'FRONT TYRE']) !!}
                                </div>

                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('Back_TYRE', 'Back tyre:') !!}
                                    {!! Form::text('back_tyre', null, ['class' => 'form-control', 'placeholder' => 'Back TYRE']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Fuel</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('FUEL_CONSUMBSION', 'FUEL CONSUMBSION:') !!}
                                    {!! Form::text('consumbsion', null, ['class' => 'form-control', 'placeholder' => 'FUEL CONSUMBSION L/100KM']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Emission</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('Emission', 'Emission:') !!}
                                    {!! Form::text('emission', null, ['class' => 'form-control', 'placeholder' => 'Emission in gmCO2/KM
                            ']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Warranty & Maintenace</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('WARRANTY', 'WARRANTY:') !!}
                                    {!! Form::text('warranty', null, ['class' => 'form-control', 'placeholder' => 'YEARS/KM
                            ']) !!}
                                </div>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('MAINTENANCE_PROGRAM ', 'MAINTENANCE PROGRAM :') !!}
                                    {!! Form::text('maintenance', null, ['class' => 'form-control', 'placeholder' => 'YEARS/KM']) !!}
                                </div>
                            </div>


                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Lifecycle</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('Lifecycle', 'Lifecycle:') !!}
                                    {!! Form::text('lifecycle', null, ['class' => 'form-control', 'placeholder' => 'number/YEARS']) !!}
                                </div>
                            </div>
                            <div class="form-group col-sm-12 regions">
                                <hr>
                                <h3>Depreciation Trend</h3>
                                <hr>
                                <div class="form-group col-sm-6 regions">
                                    {!! Form::label('Depreciation_Trend', 'Depreciation Trend:') !!}
                                    {!! Form::text('depreciation_trend', null, ['class' => 'form-control', 'placeholder' => 'Depreciation Trend']) !!}
                                </div>
                            </div>
                            @endif
                                    <!-- End of Limited Editions Field -->

                            <!-- Multiple Regions Selection Field -->

                            @if(isset($myCar))
                                @foreach($myCar->carRegions as $region)
                                    <div class="regions">
                                        <div class="form-group col-sm-3">
                                            {!! Form::label('price','Price in '. $region->region->name) !!}
                                            {!! Form::hidden('regions[]',$region->id, null, ['class' => 'form-control']) !!}
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
                                    </div>

                                    <!-- Year Field -->
                                    <div class="form-group col-sm-12 clearfix">
                                        {!! Form::label('description', 'Description:') !!}
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
                                            if (id == 29) {
                                                $('.regions').show();
                                                $('.region').hide();
                                            } else {
                                                $('.regions').hide();
                                                $('.region').show();
                                            }

                                            $('#category_id').on('change', function () {
                                                var cat_id = $(this).val();

                                                if (cat_id == 29) {
                                                    $('.regions').show();
                                                    $('.region').hide();
                                                } else {
                                                    $('.regions').hide();
                                                    $('.region').show();
                                                }
                                            });
                                        });
                                    </script>
                                    @endpush
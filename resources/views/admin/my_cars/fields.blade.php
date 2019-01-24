@push('css')
<style>
    .regions {
        display: none;
    }
</style>
@endpush

<!-- Name Field -->
<div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Car Title:*') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'maxLength' => 55]) !!}

    @if ($errors->has('name'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>

<!-- Category Field -->
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
    {!! Form::label('model_id', 'Model:*') !!}
    {!! Form::select('model_id', $carModels, null, ['class' => 'form-control select2', 'data-url'=> route('api.carModels.index'), 'data-depends'=> 'brand']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6 years_classic" style="display: none">
    {!! Form::label('year', 'Year:*') !!}
    {!! Form::select('year', $years_classic, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6 years_pre_owned" style="display: none">
    {!! Form::label('year', 'Year:*') !!}
    {!! Form::select('year', $years_pre_owned, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6 years_outlet_mall" style="display: none">
    {!! Form::label('year', 'Year:*') !!}
    {!! Form::select('year', $years_outlet_mall, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6 transmission_type">
    {!! Form::label('transmission_type', 'Transmission Type:') !!}
    {!! Form::select('transmission_type', $transmission_type, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('engine_type_id', 'Engine Type:*') !!}
    {!! Form::select('engine_type_id', $engineType, null, ['class' => 'form-control select2']) !!}
</div>

<div class="col-sm-12 clearfix"></div>

<!-- Car Type Field -->
<div class="form-group col-sm-6 cartype">
    {!! Form::label('type', 'Segments:') !!}
    {!! Form::select('type', $carTypes, isset($myCar)? @$myCar->carType->parent_id:null, ['class' => 'form-control select2']) !!}
</div>

<!-- Car Type Field -->
<div class="form-group col-sm-6 cartype">
    {!! Form::label('type_id', 'Sub Segments:') !!}
    {!! Form::select('type_id', $carTypesChildren, isset($myCar)? @$myCar->type_id:null, ['class' => 'form-control select2', 'data-url' => url('api/v1/carTypes'), 'data-depends'=>'type']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6 chassis {{ $errors->has('chassis') ? ' has-error' : '' }}">
    {!! Form::label('chassis', 'Chassis:') !!}
    {!! Form::text('chassis', null, ['class' => 'form-control', 'placeholder' => 'Enter Car Chassis', 'maxLength' => 17]) !!}
    @if ($errors->has('chassis'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('chassis') }}</strong>
        </span>
    @endif
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6 region {{ $errors->has('region') ? ' has-error' : '' }}">
    {!! Form::label('region', 'Region:') !!}
    {!! Form::select('region', $regions, null, ['class' => 'form-control select2']) !!}
    @if ($errors->has('region'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('region') }}</strong>
        </span>
    @endif
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6 category2528 {{ $errors->has('kilometer') ? ' has-error' : '' }}" {{--id="mileage" style="display:none;"--}}>
    {!! Form::label('kilometers', 'Mileage(km):') !!}
    {!! Form::number('kilometer', null, ['class' => 'form-control', 'placeholder' => 'Enter Car Mileage', 'maxLength' => 6]) !!}
    @if ($errors->has('kilometer'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('kilometer') }}</strong>
        </span>
    @endif
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6 {{ $errors->has('amount') ? ' has-error' : '' }}">
    {!! Form::label('amount', 'Amount('. @\Illuminate\Support\Facades\Auth::user()->details->regionDetail->currency.'):*' ?? 'AED' .'):*') !!}
    {!! Form::number('amount', null, ['class' => 'form-control', 'placeholder' => 'Enter Car Amount', 'pattern'=>"^[1-9]\d*$", "min" => 1, "max"=> 99999999]) !!}

    @if ($errors->has('amount'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('amount') }}</strong>
        </span>
    @endif
</div>

<!-- Average MKP Field -->
<div class="form-group col-sm-6 category2528 {{ $errors->has('average_mkp') ? ' has-error' : '' }}">
    {!! Form::label('avg_mkp', 'Average MKP('. @\Illuminate\Support\Facades\Auth::user()->details->regionDetail->currency.'):*' ?? 'AED' .'):') !!}
    {!! Form::number('average_mkp', null, ['class' => 'form-control', 'placeholder' => 'Enter Average Market Price', 'pattern'=>"^[1-9]\d*$", "min" => 1, "max"=> 99999999]) !!}

    @if ($errors->has('average_mkp'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('average_mkp') }}</strong>
        </span>
    @endif
</div>

{{--@php($user = \Illuminate\Support\Facades\Auth::user())--}}
<!-- Email Field -->
{{--<div class="form-group col-sm-6 region">
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
</div>--}}

<!-- Regional Specification Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regional_specific1ation_id', 'Regional Specification:*') !!}
    {!! Form::select('regional_specification_id', $regional_specs, null, ['class' => 'form-control select2']) !!}
</div>

@if(!isset($myCar))
    <div class="clearfix"></div>
    @foreach($attributes as $attribute)
        @if($attribute->type == 10)
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label('phone', $attribute->name.':*') !!}
                {!! Form::text('attribute['.$attribute->id.']', null, ['class' => 'form-control', 'placeholder' => 'Enter attribute '.$attribute->name, 'maxLength' => 55]) !!}

                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>
        @elseif($attribute->type == 20)
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::number('attribute['.$attribute->id.']', null, ['class' => 'form-control', 'step' =>0.1, 'placeholder' => 'Enter attribute '.$attribute->name]) !!}
                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>
        @elseif($attribute->type == 30 || $attribute->type == 40)
            @foreach($attribute->option_array as $item)
                @php($options[$item['id']] = $item['name'])
            @endforeach
            <!-- Regional Specification Field -->
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::select('attribute['.$attribute->id.']', $options, null, ['class' => 'form-control select2', ($attribute->type == 40)?'multiple':'']) !!}

                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>
            @php($options = [])
        @else
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::file('attribute['.$attribute->id.']', ['class' => 'form-control', ($attribute->type == 60)?
                'multiple':'']) !!}
                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>
        @endif
    @endforeach
@else
    <div class="clearfix"></div>

    @foreach($attributes as $attribute)
        @php($value = (in_array($attribute->id, $myCar->myCarAttributes->pluck('attr_id')->toArray())?($myCar->myCarAttributes[array_search($attribute->id, $myCar->myCarAttributes->pluck('attr_id')->toArray())]->value): null))
        @if($attribute->type == 10)
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::text('attribute['.$attribute->id.']', $value, ['class' => 'form-control', 'placeholder' => 'Enter attribute '.$attribute->name, 'maxLength' => 55]) !!}

                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>
        @elseif($attribute->type == 20)
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::number('attribute['.$attribute->id.']', (int)$value, ['class' => 'form-control', 'step' =>0.1, 'placeholder' => 'Enter attribute '.$attribute->name]) !!}
                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>
        @elseif($attribute->type == 30 || $attribute->type == 40)
            @foreach($attribute->option_array as $item)
                @php($options[$item['id']] = $item['name'])
            @endforeach
            <!-- Regional Specification Field -->
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label($attribute->name, $attribute->name.':') !!}
                {!! Form::select('attribute['.$attribute->id.']', $options, $value, ['class' => 'form-control select2']) !!}
                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>
            @php($options = [])
        @else
            <div class="form-group col-sm-6 non-luxury {{ $attribute->name }} {{ $errors->has('attribute.'.$attribute->id) ? ' has-error' : '' }}">
                {!! Form::label('phone', $attribute->name.':') !!}
                {!! Form::file('attribute['.$attribute->id.']', ['class' => 'form-control', ($attribute->type == 60)?
                'multiple':'']) !!}
                @if ($errors->has('attribute.'.$attribute->id))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong>
                </span>
                @endif
            </div>

        @endif
    @endforeach
@endif
<div>
    <!-- Limited Edition Fields -->
    <div class="form-group col-sm-12 regions">
        <h3>Dimensions & Weight</h3>
        <hr>
    </div>

    <div class="form-group col-sm-4 regions {{ $errors->has('length') ? ' has-error' : '' }}">
        {!! Form::label('length', 'Length:*') !!}
        {!! Form::number('length', isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['LENGTH']:null, ['class' => 'form-control', 'placeholder' => 'Length in MM']) !!}

        @if ($errors->has('length'))
            <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('length') }}</strong>
                </span>
        @endif
    </div>

    <div class="form-group col-sm-4 regions {{ $errors->has('width') ? ' has-error' : '' }}">
        {!! Form::label('width', 'Width:*') !!}
        {!! Form::number('width',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['WIDTH']:null, ['class' => 'form-control', 'placeholder' => 'Width in MM']) !!}
        @if ($errors->has('width'))
            <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('width') }}</strong>
                </span>
        @endif
    </div>

    <div class="form-group col-sm-4 regions {{ $errors->has('height') ? ' has-error' : '' }}">
        {!! Form::label('height', 'Height:*') !!}
        {!! Form::number('height',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['HEIGHT']:null, ['class' => 'form-control', 'placeholder' => 'Height in MM']) !!}
        @if ($errors->has('height'))
            <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('height') }}</strong>
                </span>
        @endif
    </div>

    <div class="form-group col-sm-4 regions {{ $errors->has('weight_dist') ? ' has-error' : '' }}">
        {!! Form::label('weight_dist', 'WEIGHT DISTRIBUTION:*') !!}
        {!! Form::number('weight_dist',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['WEIGHT DISTRIBUTION']:null, ['class' => 'form-control', 'placeholder' => 'WEIGHT DISTRIBUTION']) !!}
        @if ($errors->has('weight_dist'))
            <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('weight_dist') }}</strong>
                </span>
        @endif
    </div>

    <div class="form-group col-sm-4 regions" {{ $errors->has('trunk') ? ' has-error' : '' }}>
        {!! Form::label('trunk', 'Trunk:*') !!}
        {!! Form::number('trunk',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['TRUNK']:null, ['class' => 'form-control', 'placeholder' => 'Trunk in Length']) !!}
        @if ($errors->has('trunk'))
            <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('trunk') }}</strong>
                </span>
        @endif
    </div>

    <div class="form-group col-sm-4 regions {{ $errors->has('weight') ? ' has-error' : '' }}">
        {!! Form::label('WEIGHT', 'WEIGHT:*') !!}
        {!! Form::number('weight',  isset($limited_edition_specs)? $limited_edition_specs['Dimensions_Weight']['WEIGHT']:null, ['class' => 'form-control', 'placeholder' => 'Weight in KG']) !!}
        @if ($errors->has('weight'))
            <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('weight') }}</strong>
                </span>
        @endif
    </div>

    <div class="form-group col-sm-6 regions">
        <hr>
        <h3>Seating Capacity</h3>
        <hr>
        <div class="form-group col-sm-12 regions {{ $errors->has('seats') ? ' has-error' : '' }}">
            {!! Form::label('seats', 'MAX.NO OF SEATS:*') !!}
            {!! Form::number('seats', isset($limited_edition_specs)? $limited_edition_specs['Seating_Capacity']['MAX.NO OF SEATS']:null, ['class' => 'form-control', 'placeholder' => 'MAX.NO OF SEATS']) !!}
            @if ($errors->has('seats'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('seats') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-6 regions">
        <hr>
        <h3>Drive Train</h3>
        <hr>
        <div class="form-group col-sm-12 regions {{ $errors->has('drive_train') ? ' has-error' : '' }}">
            {!! Form::label('drive_train', 'Drive Train:') !!}
            {!! Form::select('drive_train', \App\Models\MyCar::$DRIVE_TRAIN,  isset($limited_edition_specs['DRIVE_TRAIN']['drive_train'])? $limited_edition_specs['DRIVE_TRAIN']['drive_train']:null, ['class' => 'form-control select2']) !!}
            @if ($errors->has('drive_train'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('drive_train') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-12 regions">
        <hr>
        <h3>Engine</h3>
        <hr>
        <div class="form-group col-sm-6 regions {{ $errors->has('displacement') ? ' has-error' : '' }}">
            {!! Form::label('DISPLACEMENT', 'DISPLACEMENT:*') !!}
            {!! Form::number('displacement',  isset($limited_edition_specs)? $limited_edition_specs['Engine']['DISPLACEMENT']:null, ['class' => 'form-control', 'placeholder' => 'Displacement is CC']) !!}
            @if ($errors->has('displacement'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('displacement') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-sm-6 regions {{ $errors->has('cylinders') ? ' has-error' : '' }}">
            {!! Form::label('cylinders', 'NO. OF  cylinders:*') !!}
            {!! Form::number('cylinders',  isset($limited_edition_specs)? $limited_edition_specs['Engine']['NO. OF CYLINDER']:null, ['class' => 'form-control', 'placeholder' => 'NO. OF  cylinders']) !!}
            @if ($errors->has('cylinders'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('cylinders') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-12 regions">
        <hr>
        <h3>Performance</h3>
        <hr>
        <div class="form-group col-sm-6 regions {{ $errors->has('max_speed') ? ' has-error' : '' }}">
            {!! Form::label('SPEED', 'MAX SPEED:*') !!}
            {!! Form::number('max_speed',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['MAX SPEED']:null, ['class' => 'form-control', 'placeholder' => 'Max speed in KM/H']) !!}
            @if ($errors->has('max_speed'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('max_speed') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-sm-6 regions {{ $errors->has('acceleration') ? ' has-error' : '' }}">
            {!! Form::label('ACCELERATION', 'ACCELERATION:*') !!}
            {!! Form::number('acceleration',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['ACCELERATION 0-100']:null, ['class' => 'form-control', 'placeholder' => 'ACCELERATION 0-100 Sec']) !!}
            @if ($errors->has('acceleration'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('acceleration') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-sm-6 regions {{ $errors->has('hp_rpm') ? ' has-error' : '' }}">
            {!! Form::label('RPM', 'HP / RPM:*') !!}
            {!! Form::number('hp_rpm',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['HP / RPM']:null, ['class' => 'form-control', 'placeholder' => 'HP / RPM']) !!}
            @if ($errors->has('hp_rpm'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('hp_rpm') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-sm-6 regions {{ $errors->has('torque') ? ' has-error' : '' }}">
            {!! Form::label('TORQUE', 'TORQUE:*') !!}
            {!! Form::number('torque',  isset($limited_edition_specs)? $limited_edition_specs['Performance']['TORQUE']:null, ['class' => 'form-control', 'placeholder' => 'TORQUE']) !!}
            @if ($errors->has('torque'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('torque') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-12 regions">
        <hr>
        <h3>Transmission</h3>
        <hr>
        <div class="form-group col-sm-6 regions  {{ $errors->has('gearbox') ? ' has-error' : '' }}">
            {!! Form::label('GEARBOX', 'GEARBOX:*') !!}
            {!! Form::number('gearbox',  isset($limited_edition_specs)? $limited_edition_specs['Transmission ']['GEARBOX']:null, ['class' => 'form-control', 'placeholder' => 'GEARBOX']) !!}
            @if ($errors->has('gearbox'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('gearbox') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-6 regions">
        <hr>
        <h3>Brakes</h3>
        <hr>
        <div class="form-group col-sm-12 regions  {{ $errors->has('brakes') ? ' has-error' : '' }}">
            {!! Form::label('Brakes_System', 'Brakes System:*') !!}
            {!! Form::text('brakes',  isset($limited_edition_specs)? $limited_edition_specs['Brakes']['BRAKES SYSTEM']:null, ['class' => 'form-control', 'placeholder' => 'Brakes  System', 'maxLength' => 55]) !!}
            @if ($errors->has('brakes'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('brakes') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-6 regions  {{ $errors->has('email') ? ' has-error' : '' }}">
        <hr>
        <h3>Suspension</h3>
        <hr>
        <div class="form-group col-sm-12 regions  {{ $errors->has('suspension') ? ' has-error' : '' }}">
            {!! Form::label('Suspension', 'Suspension:*') !!}
            {!! Form::text('suspension',  isset($limited_edition_specs)? $limited_edition_specs['Suspension']['SUSPENSION']:null, ['class' => 'form-control', 'placeholder' => 'Suspension', 'maxLength' => 55]) !!}
            @if ($errors->has('suspension'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('suspension') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-12 regions">
        <hr>
        <h3>Wheels & Tyres</h3>
        <hr>
        <div class="form-group col-sm-6 regions  {{ $errors->has('front_tyre') ? ' has-error' : '' }}">
            {!! Form::label('FRONT_TYRE', 'Front tyre:*') !!}
            {!! Form::text('front_tyre',  isset($limited_edition_specs)? $limited_edition_specs['Wheels_Tyres']['FRONT TYRE']:null, ['class' => 'form-control', 'placeholder' => 'FRONT TYRE', 'maxLength' => 55]) !!}

            @if ($errors->has('front_tyre'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('front_tyre') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-sm-6 regions  {{ $errors->has('back_tyre') ? ' has-error' : '' }}">
            {!! Form::label('Back_TYRE', 'Back tyre:*') !!}
            {!! Form::text('back_tyre',  isset($limited_edition_specs)? $limited_edition_specs['Wheels_Tyres']['BACK TYRE']:null, ['class' => 'form-control', 'placeholder' => 'Back TYRE', 'maxLength' => 55]) !!}

            @if ($errors->has('back_tyre'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('back_tyre') }}</strong>
                </span>
            @endif</div>
    </div>

    <div class="form-group col-sm-6 regions">
        <hr>
        <h3>Fuel</h3>
        <hr>
        <div class="form-group col-sm-12 regions  {{ $errors->has('consumption') ? ' has-error' : '' }}">
            {!! Form::label('FUEL_CONSUMPTION', 'FUEL CONSUMPTION:*') !!}
            {!! Form::number('consumption',  isset($limited_edition_specs)? $limited_edition_specs['Fuel']['FUEL CONSUMPTION']:null, ['class' => 'form-control', 'placeholder' => 'FUEL CONSUMPTION L/100KM']) !!}
            @if ($errors->has('consumption'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('consumption') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-6 regions">
        <hr>
        <h3>Emission</h3>
        <hr>
        <div class="form-group col-sm-12 regions  {{ $errors->has('emission') ? ' has-error' : '' }}">
            {!! Form::label('Emission', 'Emission:*') !!}
            {!! Form::text('emission',  isset($limited_edition_specs)? $limited_edition_specs['Emission']['EMISSION']:null, ['class' => 'form-control', 'placeholder' => 'Emission in gmCO2/KM', 'maxLength' => 55]) !!}
            @if ($errors->has('emission'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('emission') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-12 regions">
        <hr>
        <h3>Warranty & Maintenance</h3>
        <hr>
        <div class="form-group col-sm-6 regions  {{ $errors->has('warranty') ? ' has-error' : '' }}">
            {!! Form::label('WARRANTY', 'WARRANTY:*') !!}
            {!! Form::number('warranty',  isset($limited_edition_specs)? $limited_edition_specs['Warranty_Maintenance']['WARRANTY']:null, ['class' => 'form-control', 'placeholder' => 'YEARS/KM']) !!}
            @if ($errors->has('warranty'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('warranty') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-sm-6 regions  {{ $errors->has('maintenance') ? ' has-error' : '' }}">
            {!! Form::label('MAINTENANCE_PROGRAM ', 'MAINTENANCE PROGRAM :*') !!}
            {!! Form::number('maintenance',  isset($limited_edition_specs)? $limited_edition_specs['Warranty_Maintenance']['MAINTENANCE PROGRAM ']:null, ['class' => 'form-control', 'placeholder' => 'YEARS/KM']) !!}
            @if ($errors->has('maintenance'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('maintenance') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group col-sm-12 regions">
        <?php $explodeLifeCycle = explode('-', @$myCar->life_cycle); ?>
        <hr>
        <h3>Production Life Cycle</h3>
        <hr>
        <div class="form-group col-sm-6 regions {{ $errors->has('from') ? ' has-error' : '' }}">
            {!! Form::label('Lifecycle', 'Start Year:*') !!}
            {{--{!! Form::number('from', null, ['class' => 'form-control', 'placeholder' => 'number/YEARS']) !!}--}}
            {!! Form::select('from', $years, @$explodeLifeCycle[0], ['class' => 'form-control select2']) !!}
            @if ($errors->has('from'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('from') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-sm-6 regions {{ $errors->has('to') ? ' has-error' : '' }}">
            {!! Form::label('Lifecycle', 'End Year:*') !!}
            {{--{!! Form::number('to', null, ['class' => 'form-control', 'placeholder' => 'number/YEARS']) !!}--}}
            {!! Form::select('to', $years, @$explodeLifeCycle[1], ['class' => 'form-control select2']) !!}
            @if ($errors->has('to'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('from') }}</strong>
                </span>
            @endif
        </div>
        <hr>
    </div>
{{--<div class="form-group col-sm-12 regions {{ $errors->has('depreciation_trend') ? ' has-error' : '' }}">
<div class="form-group col-sm-6 regions">
{!! Form::label('Depreciation_Trend', 'Depreciation Trend (%):*') !!}
{!! Form::number('depreciation_trend',  null, ['class' => 'form-control', 'placeholder' => 'Depreciation Trend in %', 'min'=>1, 'max'=>99]) !!}
@if ($errors->has('depreciation_trend'))
<span class="help-block" style="color: red;">
<strong>{{ $errors->first('depreciation_trend') }}</strong>
</span>
@endif
</div>
</div>--}}
<!-- End of Limited Editions Field -->
</div>

<!-- Multiple Regions Selection Field -->
@if(isset($myCar))
    @foreach($myCar->carRegions as $region)
        <div class="regions">
            <div class="form-group col-sm-3 regions  {{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price','Price in '. $region->region->name) !!}
                {!! Form::hidden('regions[]',$region->region_id, null, ['class' => 'form-control']) !!}
                {!! Form::number('price[]', $region->price, ['class' => 'form-control', 'placeholder' => 'Enter Region Price']) !!}
                @if ($errors->has('price'))
                    <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
                @endif
            </div>
        </div>
    @endforeach
@else
    @foreach($regions as $key => $region)
        <div class="regions" style="display: none">
            <div class="form-group col-sm-6  {{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('regions','Price in '.$region, null, ['class' => 'form-control']) !!}
                {!! Form::hidden('regions[]',$key, null, ['class' => 'form-control']) !!}
                {!! Form::number('price[]', null, ['class' => 'form-control', 'placeholder' => 'Enter Region Price', 'pattern'=>"^[1-9]\d*$"]) !!}
                @if ($errors->has('price'))
                    <span class="help-block" style="color: red;">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    @endforeach
@endif

<div class="col-sm-12 clearfix"></div>
@foreach($depreciation_trend_years as $key => $depreciation_trend_year)
    <div class="regions" style="display: none">
        <div class="form-group col-sm-2 {{ $errors->has('depreciation_trend['.$key.']') ? 'has-error' : '' }}">
            {!! Form::label('depreciation_trend','Year ('.$key.')', null, ['class' => 'form-control']) !!}
            {!! Form::number('depreciation_trend['.$key.']', isset($myCar)?@$myCar->DepreciationTrend()->where('year', $key)->first()->percentage:'', ['class' => 'form-control', 'placeholder' => 'Depreciation Trend in %', 'min' => 1, 'max' => 99, 'required' => 'required']) !!}
            @if ($errors->has('depreciation_trend['.$key.']'))
                <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('depreciation_trend['.$key.']') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endforeach
<div class="clearfix"></div>
<div class="col-sm-12">
    @if ($errors->has('media'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('media') }}</strong>
        </span>
    @endif
</div>
<div>
    @php($count = 0)
    @foreach($media_types as $key => $media_type)
        @php($count++)
        <div class="form-group col-sm-4 {{ $errors->has('media.'.$key) ? ' has-error' : '' }}">
            {!! Form::label('media', ucwords($key).':') !!}
            {!! Form::file('media['.$key.']', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}
            <br>
            @if(isset($myCar))
                @if($myCar->media()->where('title', $key)->count() > 0)
                    @php($media = $myCar->media()->where('title', $key)->first())
                    <div style="position: relative; display: inline; padding-right: 10px">
                        <a class="showGallery" data-id="{{$media->id}}" data-toggle="modal"
                           data-target="#imageGallery">
                            <img src="{{ $media->file_url }}" width="120">
                        </a>
                        <span class="btn-sm btn-danger delete_media" data-id="{{$media->id}}"
                              style="position: absolute; right: 15px; z-index: 100; cursor: hand">&times;
                        </span>
                    </div>
                @endif
            @endif
            @if ($errors->has('media.'.$key))
                <span class="help-block" style="color: red;">
                        <strong>{{ $errors->first('media.'.$key) }}</strong>
                    </span>
            @endif
        </div>
        @if(($count%3) == 0)
            <div class="col-sm-12 clearfix"><br></div>
        @endif
    @endforeach
</div>

<!-- is_featured Field -->
<div class="form-group col-sm-2  {{ $errors->has('is_featured') ? ' has-error' : '' }}">
    {!! Form::label('is_featured', 'Is Featured:') !!}
    {!! Form::select('is_featured', App\Helper\Utils::$BOOLS, null, ['class' => 'form-control']) !!}
    @if ($errors->has('is_featured'))
        <span class="help-block" style="color: red;">
            <strong>{{ $errors->first('is_featured') }}</strong>
        </span>
    @endif
</div>

@if(isset($myCar))

    <!-- Status Field -->
    <div class="form-group col-sm-2 clearfix">
        {!! Form::label('status', 'Status:') !!}
        {!! Form::select('status', $status, $myCar->status, ['class' => 'form-control', ($myCar->status == 30)? 'disabled' : '']) !!}
    </div>
@endif
<!-- Year Field -->
<div class="form-group col-sm-12 clearfix  {{ $errors->has('notes') ? ' has-error' : '' }}">
    {!! Form::label('notes', 'Description:') !!}
    {!! Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => 'Enter Description']) !!}
    @if ($errors->has('notes'))
        <span class="help-block" style="color: red;">
                    <strong>{{ $errors->first('notes') }}</strong>
                </span>
    @endif
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

        $('.years_pre_owned').hide();
        $('.years_outlet_mall').hide();
        $('.years_classic').hide();
        $('.region').hide();
        $('.category2528').hide();

        if (parseInt(id) == 25) {
            $('.years_outlet_mall').show();
            $('.years_pre_owned').hide();
            $('.years_classic').hide();
        }
        if (parseInt(id) == 26) {
            $('.years_outlet_mall').hide();
            $('.years_pre_owned').show();
            $('.years_classic').hide();
        }
        if (parseInt(id) == 27) {
            $('.years_outlet_mall').hide();
            $('.years_pre_owned').hide();
            $('.years_classic').show();
        }

        if (parseInt(id) == 25 || parseInt(id) == 26 || parseInt(id) == 27) {
            $('.cartype').hide();
            $('.chassis').hide();
            $('.Trim').hide();
            $('.Accident').hide();
            $('.transmission_type').hide();

        } else {
            $('.cartype').show();
            $('.chassis').hide();
            $('.Trim').show();
            $('.Accident').show();
            $('.transmission_type').show();
        }

        if (parseInt(id) == 28) {
            $('.regions').show();
            $('.cartype').show();
//                $('.region').hide();
            $('.non-luxury').hide();
        } else {
            $('.regions').hide();
            $('.cartype').hide();
            //   $('.non-luxury').show();
//                $('.region').show();
        }

        if (parseInt(id) === 25) {
            $('.category2528').hide();
        } else if (parseInt(id) === 26 || parseInt(id) === 27) {
            $('.category2528').show();
        }

        $('#category_id').on('change', function () {
            var cat_id = $(this).val();

            if (id == 25 || id == 26 || id == 27) {
                $('.cartype').hide();
                $('.chassis').hide();
                $('.Trim').hide();
                $('.Accident').hide();
                $('.transmission_type').hide();

            } else {
                $('.cartype').show();
                $('.chassis').show();
                $('.Trim').show();
                $('.Accident').show();
                $('.transmission_type').show();
            }

            if (parseInt(cat_id) == 28) {
                $('.regions').show();
//                    $('.region').hide();
                $('.cartype').show();
                $('.non-luxury').hide();
            } else {
                $('.regions').hide();
                $('.cartype').hide();
//                $('.non-luxury').show();
//                $('.region').show();
            }

            if (parseInt(cat_id) == 25) {
                $('.years_outlet_mall').show();
                $('.years_pre_owned').hide();
                $('.years_classic').hide();
            }
            if (parseInt(cat_id) == 26) {
                $('.years_outlet_mall').hide();
                $('.years_pre_owned').show();
                $('.years_classic').hide();
            }
            if (parseInt(cat_id) == 27) {
                $('.years_outlet_mall').hide();
                $('.years_pre_owned').hide();
                $('.years_classic').show();
            }

            if (parseInt(cat_id) === 25 || parseInt(cat_id) === 28) {
                $('.category2528').hide();
            } else if (parseInt(cat_id) === 26 || parseInt(cat_id) === 27) {
                $('.category2528').show();
            }
        });
    });
</script>
@endpush
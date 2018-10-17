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
    {!! Form::label('model_id', 'Model:') !!}
    {!! Form::select('model_id', $carModels, null, ['class' => 'form-control select2', 'data-url'=> route('api.carModels.index'), 'data-depends'=> 'brand']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year', 'Year:') !!}
    {!! Form::text('year', null, ['class' => 'form-control']) !!}
</div>

<!-- Engine Type Field -->
<div class="form-group col-sm-6">
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

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount(AED):') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Average MKP Field -->
<div class="form-group col-sm-6">
    {!! Form::label('avg_mkp', 'Average MKP(AED):') !!}
    {!! Form::number('average_mkp', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

@php($user = \Illuminate\Support\Facades\Auth::user())
<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
</div>

<!-- Country Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country_code', 'Country Code:') !!}
    {!! Form::text('country_code', $user->details->country_code, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', $user->details->phone, ['class' => 'form-control']) !!}
</div>

<!-- Regional Specification Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regional_specification_id', 'Regional Specification:') !!}
    {!! Form::select('regional_specification_id', $regional_specs, null, ['class' => 'form-control select2']) !!}
</div>

@foreach($attributes as $attribute)
    @if($attribute->type == 10)
        <div class="form-group col-sm-6">
            {!! Form::label('phone', $attribute->name.':') !!}
            {!! Form::text('attribute['.$attribute->id.']', (isset($myCar))? $myCar->carAttributes: null, ['class' => 'form-control']) !!}
        </div>
    @elseif($attribute->type == 20)
        <div class="form-group col-sm-6">
            {!! Form::label('phone', $attribute->name.':') !!}
            {!! Form::number('attribute['.$attribute->id.']', null, ['class' => 'form-control', 'step' =>0.1]) !!}
        </div>
    @elseif($attribute->type == 30 || $attribute->type == 40)
        @foreach($attribute->option_array as $item)
            @php($options[$item['id']] = $item['name'])
        @endforeach
        <!-- Regional Specification Field -->
        <div class="form-group col-sm-6">
            {!! Form::label($attribute->name, $attribute->name.':') !!}
            {!! Form::select('attribute['.$attribute->id.']', $options, null, ['class' => 'form-control select2', ($attribute->type == 40)?
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
@endforeach

<!-- Media Field -->
<div class="form-group col-sm-6">
    {!! Form::label('media', 'Images:') !!}
    {!! Form::file('media[]', ['class' => 'form-control', 'multiple']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.myCars.index') !!}" class="btn btn-default">Cancel</a>
</div>

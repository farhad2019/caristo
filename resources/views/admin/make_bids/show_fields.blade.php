<div class="col-sm-4">
    <!-- Name Field -->
    <dt>{!! Form::label('name', 'Name:') !!}</dt>
    <dd>{!! $car->name !!}</dd>

    <!-- Model Id Field -->
    <dt>{!! Form::label('model', 'Car:') !!}</dt>
    <dd>{!! $car->carModel->brand->name . ' - '.$car->carModel->name !!}</dd>

    <!-- Email Field -->
    <dt>{!! Form::label('email', 'Email:') !!}</dt>
    <dd>{!! $car->email !!}</dd>

    <!-- Phone Field -->
    <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
    <dd>{!! $car->country_code.' '.$car->phone !!}</dd>

@foreach($car->carAttributes as $attribute)
    <!-- Chassis Field -->
        <dt>{!! Form::label('chassis', $attribute->name.':') !!}</dt>
        @if($attribute->type == 30)
            <dd>{!! \App\Models\AttributeOption::find($attribute->pivot->value)->option !!}</dd>
        @endif
    @endforeach

</div>
<div class="col-sm-8">
    <!-- Owner Id Field -->
    <dt>{!! Form::label('owner_id', 'Owner:') !!}</dt>
    <dd>{!! $car->owner->name !!}</dd>

    <!-- Year Field -->
    <dt>{!! Form::label('year', 'Year:') !!}</dt>
    <dd>{!! $car->year !!}</dd>

    <!-- Regional Specification Id Field -->
    <dt>{!! Form::label('regional_specification_id', 'Regional Specification:') !!}</dt>
    <dd>{!! $car->regionalSpecs->name !!}</dd>

    <!-- Chassis Field -->
    <dt>{!! Form::label('chassis', 'Chassis:') !!}</dt>
    <dd>{!! $car->chassis !!}</dd>

    <!-- Notes Field -->
    <dt>{!! Form::label('notes', 'Media:') !!}</dt>
    <dd>
        @foreach($car->media as $media)
            <img src="{!! $media->file_url !!}" width="50">
        @endforeach
    </dd>

    <!-- Created At Field -->
    <dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
    <dd>{!! $car->created_at !!}</dd>
</div>

<!-- Notes Field -->
<dt>{!! Form::label('notes', 'Notes:') !!}</dt>
<dd>{!! $car->notes !!}</dd>


<!-- Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_id', 'Type Id:') !!}
    {!! Form::text('type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Id:') !!}
    {!! Form::text('category_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Model Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model_id', 'Model Id:') !!}
    {!! Form::text('model_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Engine Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('engine_type_id', 'Engine Type Id:') !!}
    {!! Form::text('engine_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Regional Specification Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regional_specification_id', 'Regional Specification Id:') !!}
    {!! Form::text('regional_specification_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_id', 'Owner Id:') !!}
    {!! Form::text('owner_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year', 'Year:') !!}
    {!! Form::text('year', null, ['class' => 'form-control']) !!}
</div>

<!-- Chassis Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chassis', 'Chassis:') !!}
    {!! Form::text('chassis', null, ['class' => 'form-control']) !!}
</div>

<!-- Transmission Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('transmission_type', 'Transmission Type:') !!}
    {!! Form::text('transmission_type', null, ['class' => 'form-control']) !!}
</div>

<!-- kilometer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kilometer', 'kilometer:') !!}
    {!! Form::text('kilometer', null, ['class' => 'form-control']) !!}
</div>

<!-- Average Mkp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('average_mkp', 'Average Mkp:') !!}
    {!! Form::text('average_mkp', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Country Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country_code', 'Country Code:') !!}
    {!! Form::text('country_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_type', 'Owner Type:') !!}
    {!! Form::text('owner_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Notes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.cars.index') !!}" class="btn btn-default">Cancel</a>
</div>

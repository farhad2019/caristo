<!-- Owner Car Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_car_id', 'Owner Car Id:') !!}
    {!! Form::text('owner_car_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Customer Car Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_car_id', 'Customer Car Id:') !!}
    {!! Form::text('customer_car_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Notes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.tradeInCars.index') !!}" class="btn btn-default">Cancel</a>
</div>

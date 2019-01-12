<!-- Car Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('car_id', 'Car Id:') !!}
    {!! Form::text('car_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Average Rating Field -->
<div class="form-group col-sm-6">
    {!! Form::label('average_rating', 'Average Rating:') !!}
    {!! Form::text('average_rating', null, ['class' => 'form-control']) !!}
</div>

<!-- Review Message Field -->
<div class="form-group col-sm-6">
    {!! Form::label('review_message', 'Review Message:') !!}
    {!! Form::text('review_message', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.reviews.index') !!}" class="btn btn-default">Cancel</a>
</div>

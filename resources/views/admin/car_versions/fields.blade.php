<!-- Brand Field -->
<div class="form-group col-sm-6">
    {!! Form::label('brand', 'Brand:') !!}
    {!! Form::select('brand', $brands, (isset($carVersion))? $carVersion->carModel->brand->id: null, ['class' => 'form-control select2']) !!}
</div>

<!-- Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model_id', 'Model:*') !!}
    {!! Form::select('model_id', $carModels, isset($carVersion)? $carVersion->model_id:null, ['class' => 'form-control select2', 'data-url'=> route('api.carModels.index'), 'data-depends'=> 'brand']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.carVersions.index') !!}" class="btn btn-default">Cancel</a>
</div>

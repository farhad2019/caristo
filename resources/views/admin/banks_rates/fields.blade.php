<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','maxlength'=>50]) !!}
</div>

<!-- Phone No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_no', 'Phone No:') !!}
    {!! Form::text('phone_no', null, ['class' => 'form-control','maxlength'=>15]) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control','maxlength'=>50]) !!}
</div>

<!-- Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rate', 'Rate:') !!}
    {!! Form::number('rate', null, ['class' => 'form-control','maxlength'=>3]) !!}
</div>

<!-- Type Field -->

<div class="form-group col-sm-6 regions">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::select('type', \App\Models\BanksRate::$BANK_TYPE_TEXT,  null, ['class' => 'form-control select2']) !!}
</div>


<div class="form-group col-sm-6">
    {!! Form::label('name', 'Media*:') !!}
    {!! Form::file('media', ['class' => 'form-control', 'accept' => 'image/x-png,image/gif,image/jpeg']) !!}

    @if(isset($banksRate) && count($banksRate->media)>0)
        <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;" >
            <a class='showGallery' data-id='{{ $banksRate->media[0]->id }}' data-toggle='modal'>
                <img src="{{$banksRate->media()->orderby('created_at', 'desc')->first()->fileUrl}}" style="width: 125px;">
            </a>
        </div>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.banksRates.index') !!}" class="btn btn-default">Cancel</a>
</div>

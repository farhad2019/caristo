<!-- Title Field -->
<dt>{!! Form::label('title', 'Title:') !!}</dt>
<dd>{!! $banksRate->title !!}</dd>

<!-- Phone No Field -->
<dt>{!! Form::label('phone_no', 'Phone No:') !!}</dt>
<dd>{!! $banksRate->phone_no !!}</dd>

<!-- Address Field -->
<dt>{!! Form::label('address', 'Address:') !!}</dt>
<dd>{!! $banksRate->address !!}</dd>

<!-- Rate Field -->
<dt>{!! Form::label('rate', 'Rate:') !!}</dt>
<dd>{!! $banksRate->rate !!}%</dd>

<dt>{!! Form::label('image', 'Image:') !!}</dt>
<dd>
    <div style="float: left;padding: 8px; border:1px solid #ddd; min-height:75px;margin-top: 8px;" >
        <a class='showGallery' data-id='{{ $banksRate->media[0]->id }}' data-toggle='modal'>
            <img src="{{$banksRate->media()->orderby('created_at', 'desc')->first()->fileUrl}}" style="width: 125px;">
        </a>
    </div>
</dd>


<br>

<!-- Type Field -->
<dt>{!! Form::label('type', 'Type:') !!}</dt>
<dd> @if($banksRate->type == \App\Models\BanksRate::BANK) BANK @else INSURANCE @endif</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $banksRate->created_at->timezone(session('timezone')) !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $banksRate->updated_at->timezone(session('timezone')) !!}</dd>




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



@if($getBankRequest)
    <div class="container" style="width: 100%;">
        <h3>Request(s)</h3>

        <table id="datatable" class="table table-striped table-bordered" data-form="deleteForm">
            <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 20%;">User Name</th>
                <th style="width: 20%;">User Email</th>
                <th style="width: 20%;">User Phone no</th>
                <th style="width: 20%;">Car Name</th>
                <th style="width: 15%;">Created At</th>
            </tr>
            </thead>
            <tbody>



            <?php $i=1;
            foreach ($getBankRequest as $bankRequest){?>
            <tr>
                <td  class="abc">{{ $i}}</td>
                <td  class="abc"><a href="{{URL::to('/')}}/admin/users/{{$bankRequest['user_id']}}">{{ $bankRequest['name']}}</a></td>
                <td  class="abc">{{ $bankRequest['email']}}</td>
                <td  class="abc">{{ $bankRequest['country_code']}} {{ $bankRequest['phone']}}</td>
                {{--<td  class="abc">{!! $bankRequest['userDetail']['details']['first_name'] .' '.$bankRequest['userDetail']['details']['last_name'] !!}</td>--}}
                <td  class="abc"><a href="{{URL::to('/')}}/admin/cars/{{$bankRequest['carDetail']['id']}}">{!! $bankRequest['carDetail']['name'] or "N/A" !!} </a></td>
                <td  class="abc">{!! $bankRequest->created_at->timezone(session('timezone')) !!} </td>
            </tr>
            <?php $i = $i +1;} ?>

            </tbody>
        </table>
    </div>
@endif





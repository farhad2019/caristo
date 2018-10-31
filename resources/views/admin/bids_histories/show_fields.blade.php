<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <!-- Collapse Button -->
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-4">
            <dt>{!! Form::label('name', 'Name:') !!}</dt>
            <dd>{!! $car->name !!}</dd>


            <!-- Phone Field -->
            <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
            <dd>{!! $car->country_code.' '.$car->phone !!}</dd>
        </div>
        <div class="col-md-8">
            <!-- Email Field -->
            <dt>{!! Form::label('email', 'Email:') !!}</dt>
            <dd>{!! $car->email !!}</dd>

            <!-- Created At Field -->
            <dt>{!! Form::label('created_at', 'Bid Close At:') !!}</dt>
            <dd>{!! $car->bid_close_at !!} ( {!! $car->bid_close_at->diffForHumans() !!})</dd>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <!-- Notes Field -->
        <dt>{!! Form::label('notes', 'Amount(AED):') !!}</dt>
        <dd>{!! number_format($car->bids()->where('user_id', \Auth::id())->first()->amount,2) !!}</dd>

        <!-- Notes Field -->
        <dt>{!! Form::label('notes', 'Notes:') !!}</dt>
        <dd>{!! $car->notes !!}</dd>
    </div>
    <!-- box-footer -->
</div>
<!-- /.box -->

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <!-- Collapse Button -->
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- Property Title Field -->
        <dt>{!! Form::label('ownerName', 'Images:') !!}</dt>
        <dd>@foreach($car->media as $media)
                <a class="showGallery" data-id="{{$car->id}}" data-toggle="modal" data-target="#imageGallery">
                    <img src="{{ $media->file_url }}" width="120" style="margin-right: 2%">
                </a>
            @endforeach
        </dd>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

    </div>
    <!-- box-footer -->
</div>
<!-- /.box -->

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <!-- Collapse Button -->
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-6">
            <!-- Model Id Field -->
            <dt>{!! Form::label('model', 'Car:') !!}</dt>
            <dd>{!! $car->carModel->brand->name . ' - '.$car->carModel->name . ' ('.$car->year .')'!!}</dd>

            <!-- Model Id Field -->
            <dt>{!! Form::label('model', 'Kilometers:') !!}</dt>
            <dd>{!! number_format($car->kilometre) !!}</dd>

        </div>
        <div class="col-md-6">
            <!-- Email Field -->
            <dt>{!! Form::label('email', 'Regional Specs:') !!}</dt>
            <dd>{!! $car->regionalSpecs->name !!}</dd>

            <!-- Email Field -->
            <dt>{!! Form::label('email', 'Chassis:') !!}</dt>
            <dd>{!! $car->chassis !!}</dd>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

        <div class="col-sm-6">
            @foreach($car->carAttributes as $attribute)
                <!-- Chassis Field -->
                <dt>{!! Form::label('chassis', $attribute->name.':')  !!}</dt>
                @if($attribute->type == 30)
                    <dd>{!! \App\Models\AttributeOption::find($attribute->pivot->value)->option !!}</dd>
                @elseif($attribute->type == 10 || $attribute->type == 20)
                    <dd>{!! $attribute->pivot->value !!}</dd>
                @endif
            @endforeach
        </div>
        <div class="col-sm-6">
            @foreach($car->carFeatures as $carFeature)
                <!-- Chassis Field -->
                <dt>{!! Form::label('chassis', $carFeature->name.':')  !!}</dt>
                <dd><span class='badge badge-success'> <i class='fa fa-eye'></i> Yes</span></dd>
            @endforeach
        </div>

    </div>

    <!-- box-footer -->
</div>
<!-- /.box -->
{{--

<div class="col-sm-4">
    <!-- Name Field -->


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
</div>--}}
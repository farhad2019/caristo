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
            <!-- Id Field -->
            <dt>{!! Form::label('id', 'Id:') !!}</dt>
            <dd>{!! $car->id !!}</dd>

            <!-- Type Id Field -->
            <dt>{!! Form::label('type_id', 'Type Id:') !!}</dt>
            @if($car->carType)
            <dd>{!! $car->carType->name !!}</dd>
        @endif

            <!-- Category Id Field -->
            <dt>{!! Form::label('category_id', 'Category Id:') !!}</dt>
            @if($car->category)
            <dd>{!! $car->category->name !!}</dd>
        @endif

            <!-- Model Id Field -->
            <dt>{!! Form::label('model_id', 'Model Id:') !!}</dt>
            <dd>{!! $car->carModel->name !!}</dd>


        </div>
        <div class="col-md-8">

            <!-- Engine Type Id Field -->
            <dt>{!! Form::label('engine_type_id', 'Engine Type Id:') !!}</dt>
            @if($car->engineType)
            <dd>{!! $car->engineType->name !!}</dd>
            @endif

            <!-- Regional Specification Id Field -->
            <dt>{!! Form::label('regional_specification_id', 'Regional Specification Id:') !!}</dt>
            <dd>{!! $car->regional_specification_id !!}</dd>

            <!-- Owner Id Field -->
            <dt>{!! Form::label('owner_id', 'Owner Id:') !!}</dt>
            <dd>{!! $car->owner->name !!}</dd>

            <!-- Year Field -->
            <dt>{!! Form::label('year', 'Year:') !!}</dt>
            <dd>{!! $car->year !!}</dd>

        </div>

        <div class="col-md-8">
            <!-- Chassis Field -->
            <dt>{!! Form::label('chassis', 'Chassis:') !!}</dt>
            <dd>{!! $car->chassis !!}</dd>

            <!-- Transmission Type Field -->
            <dt>{!! Form::label('transmission_type', 'Transmission Type:') !!}</dt>
            <dd>{!! $car->transmission_type_text !!}</dd>

            <!-- Kilometre Field -->
            <dt>{!! Form::label('kilometre', 'Kilometre:') !!}</dt>
            <dd>{!! $car->kilometre !!}</dd>

            <!-- Average Mkp Field -->
            <dt>{!! Form::label('average_mkp', 'Average Mkp:') !!}</dt>
            <dd>{!! $car->average_mkp !!}</dd>

            <!-- Amount Field -->
            <dt>{!! Form::label('amount', 'Amount:') !!}</dt>
            <dd>{!! $car->amount !!}</dd>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

    </div>
    <!-- box-footer -->
</div>


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
            <!-- Name Field -->
            <dt>{!! Form::label('name', 'Name:') !!}</dt>
            <dd>{!! $car->name !!}</dd>

            <!-- Email Field -->
            <dt>{!! Form::label('email', 'Email:') !!}</dt>
            <dd>{!! $car->email !!}</dd>

            <!-- Country Code Field -->
            <dt>{!! Form::label('country_code', 'Country Code:') !!}</dt>
            <dd>{!! $car->country_code !!}</dd>

            <!-- Phone Field -->
            <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
            <dd>{!! $car->phone !!}</dd>




        </div>
        <div class="col-md-8">
            <!-- Owner Type Field -->
            <dt>{!! Form::label('owner_type', 'Owner Type:') !!}</dt>
            <dd>{!! $car->owner_type_text !!}</dd>

            <!-- Notes Field -->
            <dt>{!! Form::label('notes', 'Notes:') !!}</dt>
            <dd>{!! $car->notes !!}</dd>

            <!-- Bid Close At Field -->
            <dt>{!! Form::label('bid_close_at', 'Bid Close At:') !!}</dt>
            <dd>{!! $car->bid_close_at !!}</dd>

        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

    </div>
    <!-- box-footer -->
</div>

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




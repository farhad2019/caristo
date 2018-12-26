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
            <!-- Type Id Field -->
            <dt>{!! Form::label('type_id', 'Type :') !!}</dt>
            <dd>{!! isset($myCar->carType->name) ? $myCar->carType->name : '' !!}</dd>

            <!-- Model Id Field -->
            <dt>{!! Form::label('model_id', 'Model :') !!}</dt>
            <dd>{!! isset($myCar->carModel->name) ? $myCar->carModel->name : '' !!}</dd>

        </div>
        <div class="col-md-8">
            <!-- Engine Type Id Field -->
            <dt>{!! Form::label('engine_type_id', 'Engine Type :') !!}</dt>
            <dd>{!! isset($myCar->engineType->name) ? $myCar->engineType->name : '' !!}</dd>

            <!-- Owner Id Field -->
            <dt>{!! Form::label('owner_id', 'Owner :') !!}</dt>
            <dd>{!! isset($myCar->owner->name) ? $myCar->owner->name : '' !!}</dd>
        </div>

        <div class="col-md-8">
            <!-- Year Field -->
            <dt>{!! Form::label('year', 'Year:') !!}</dt>
            <dd>{!! $myCar->year !!}</dd>

            <!-- Transmission Type Field -->
            <dt>{!! Form::label('transmission_type', 'Transmission Type:') !!}</dt>
            <dd>{!! $myCar->transmission_type_text !!}</dd>
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
            <dd>{!! $myCar->name !!}</dd>

            <!-- Email Field -->
            <dt>{!! Form::label('email', 'Email:') !!}</dt>
            <dd>{!! $myCar->email !!}</dd>

            <!-- Country Code Field -->


        </div>
        <div class="col-md-8">
            <dt>{!! Form::label('country_code', 'Country Code:') !!}</dt>
            <dd>{!! $myCar->country_code !!}</dd>

            <!-- Phone Field -->
            <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
            <dd>{!! $myCar->phone !!}</dd>
        </div>

        <div class="col-md-8">
            <!-- Owner Type Field -->
            <dt>{!! Form::label('owner_type', 'Owner Type:') !!}</dt>
            <dd>{!! $myCar->owner_type_text !!}</dd>

            <!-- Owner Type Field -->
            <dt>{!! Form::label('description', 'Description:') !!}</dt>
            <dd>{!! $myCar->description !!}</dd>
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
    <dt>{!! Form::label('owner_type', 'Features:') !!}</dt>
    <dd>
        @foreach($myCar->myCarFeatures as $feature)
            <ul>
                <li>{!!  $feature->carFeature->name !!}</li>
            </ul>
        @endforeach
    </dd>
</div>

<div class="box">
    <div class="box-header with-border col-sm-6">

        <div class="box-tools pull-right">
            <!-- Collapse Button -->
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <dt>{!! Form::label('owner_type', 'Attributes:') !!}</dt>
    <dd>
        @foreach($myCar->myCarAttributes as $attribute)
            <ul>
                <li>{!! $attribute->carAttribute->name !!} : {!! $attribute->value !!}</li>
            </ul>
        @endforeach
    </dd>

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
    <dt>{!! Form::label('owner_type', 'Region:') !!}</dt>
    <dd>
        @foreach($myCar->carRegions as $region)
            <ul>
                <li>{!! $region->region->name !!}
                    {{ (empty($region->price)? '' : ': '.number_format($region->price,2)) }}</li>
            </ul>
        @endforeach
    </dd>
    <!-- /.box-body -->
    <div class="box-footer clearfix">

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
        <dd>@foreach($myCar->media as $media)
                <a class="showGallery" data-id="{{$myCar->id}}" data-toggle="modal" data-target="#imageGallery">
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
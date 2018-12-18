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
            <dt>{!! Form::label('type_id', 'Type Id:') !!}</dt>
            <dd>{!! $myCar->carType->name !!}</dd>

            <!-- Model Id Field -->
            <dt>{!! Form::label('model_id', 'Model Id:') !!}</dt>
            <dd>{!! $myCar->carModel->name !!}</dd>

        </div>
        <div class="col-md-8">
            <!-- Engine Type Id Field -->
            <dt>{!! Form::label('engine_type_id', 'Engine Type Id:') !!}</dt>
            <dd>{!! $myCar->engineType->name !!}</dd>

            <!-- Owner Id Field -->
            <dt>{!! Form::label('owner_id', 'Owner Id:') !!}</dt>
            <dd>{!! $myCar->owner->name !!}</dd>
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
            <dd>{!! $myCar->owner_type !!}</dd>

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
    <div class="box-body">

        <div class="col-md-8">
            <table class="table table-striped table-hover">
                <tr>
                    <th  colspan="2">{!! Form::label('region', 'Region:') !!}</th>
                </tr>
                @foreach($myCar->carRegions as $region)
                    <tr>
                        <td>{!! $region->region->name !!}</td>
                        <td>{!! $region->price !!} AED</td>
                    </tr>
                @endforeach
            </table>
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

{{--<!-- Created At Field -->--}}
{{--<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>--}}
{{--<dd>{!! $myCar->created_at !!}</dd>--}}

{{--<!-- Updated At Field -->--}}
{{--<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>--}}
{{--<dd>{!! $myCar->updated_at !!}</dd>--}}

{{--<!-- Deleted At Field--}}
{{--<dt>{!! Form::label('deleted_at', 'Deleted At:') !!}</dt>--}}
{{--<dd>{!! $myCar->deleted_at !!}</dd>-->--}}


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Basic Information</h3>
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
            <!-- Engine Type Id Field -->
            <dt>{!! Form::label('engine_type_id', 'Engine Type :') !!}</dt>
            <dd>{!! isset($myCar->engineType->name) ? $myCar->engineType->name : 'N/A' !!}</dd>

            <!-- Model Id Field -->
            <dt>{!! Form::label('model_id', 'Model :') !!}</dt>
            <dd>{!! isset($myCar->carModel->name) ? $myCar->carModel->brand->name.' '.$myCar->carModel->name : 'N/A' !!}</dd>

            <!-- Year Field -->
            <dt>{!! Form::label('year', 'Year:') !!}</dt>
            <dd>{!! $myCar->year?? 'N/A' !!}</dd>

            <!-- Year Field -->
            <dt>{!! Form::label('chassis', 'Chassis:') !!}</dt>
            <dd>{!! $myCar->chassis?? 'N/A' !!}</dd>
        </div>
        <div class="col-md-8">
        @if($myCar->name)
            <!-- Name Field -->
                <dt>{!! Form::label('name', 'Name:') !!}</dt>
                <dd>{!! $myCar->name?? 'N/A' !!}</dd>
        @endif
        @if($myCar->category_id)
            <!-- Type Id Field -->
                <dt>{!! Form::label('category_id', 'Category :') !!}</dt>
                <dd>{!! isset($myCar->category_id) ? $myCar->category->name : 'N/A' !!}</dd>

                <!-- Type Id Field -->
                <dt>{!! Form::label('type_id', 'Type :') !!}</dt>
                <dd>{!! isset($myCar->carType->name) ? $myCar->carType->name : 'N/A' !!}</dd>

                <!-- Transmission Type Field -->
                <dt>{!! Form::label('transmission_type', 'Transmission Type:') !!}</dt>
                <dd>{!! $myCar->transmission_type_text?? 'N/A' !!}</dd>
        @endif
        @if($myCar->category_id == \App\Models\MyCar::APPROVED_PRE_OWNED || $myCar->category_id == \App\Models\MyCar::CLASSIC_CARS)
            <!-- Year Field -->
                <dt>{!! Form::label('kilometer', 'Kilometer:') !!}</dt>
                <dd>{!! $myCar->kilometer ? $myCar->kilometer .' Km': 'N/A' !!}</dd>
        @endif
        @if($myCar->amount)
            <!-- Year Field -->
                <dt>{!! Form::label('amount', 'Amount:') !!}</dt>
                <dd>{!! $myCar->amount .' AED' ?? 'N/A' !!}</dd>

            @endif
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <!-- Owner Id Field -->
        <dt>{!! Form::label('owner_id', 'Owner :') !!}</dt>
        <dd>{!! isset($myCar->owner->name) ? $myCar->owner->name : 'N/A' !!}</dd>

        <!-- Description Field -->
        <dt>{!! Form::label('description', 'Description :') !!}</dt>
        <dd>{!! isset($myCar->notes) ? $myCar->notes : 'N/A' !!}</dd>
    </div>
    <!-- box-footer -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Owner information</h3>
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
            <!-- Email Field -->
            <dt>{!! Form::label('email', 'Email:') !!}</dt>
            <dd>{!! $myCar['owner']['email'] ?? 'N/A' !!}</dd>
            <!-- Country Code Field -->

            <!-- Address Field -->
            <dt>{!! Form::label('address', 'Address:') !!}</dt>
            <dd>{!! $myCar['owner']['details']['address'] ?? 'N/A' !!}</dd>
        </div>
        <div class="col-md-8">
        {{--<dt>{!! Form::label('country_code', 'Country Code:') !!}</dt>--}}
        {{--<dd>{!! $myCar->country_code?? 'N/A' !!}</dd>--}}

        <!-- Phone Field -->
            <dt>{!! Form::label('phone', 'Phone:') !!}</dt>
            <dd>{!! $myCar['owner']['details']['country_code'] ?? 'N/A' !!}
                - {!! $myCar['owner']['details']['phone'] ?? 'N/A' !!}</dd>


            <!-- Owner Type Field -->
            <dt>{!! Form::label('owner_type', 'Owner Type:') !!}</dt>
            <dd>{!! $myCar->owner_type_text?? 'N/A' !!}</dd>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <!-- Owner Type Field -->
        <dt>{!! Form::label('description', 'Description:') !!}</dt>
        <dd>{!! $myCar['owner']['details']['about'] ?? 'N/A' !!}</dd>
    </div>
    <!-- box-footer -->
</div>
@if($myCar->category_id != \App\Models\MyCar::LIMITED_EDITION)
    {{--<div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Car Features</h3>
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
            <dt>{!! Form::label('features', 'Features:') !!}</dt>
            <dd>
                @if($myCar->myCarFeatures->count() > 0)
                    @foreach($myCar->myCarFeatures as $feature)
                        <ul>
                            <li>{!!  $feature->carFeature->name !!}</li>
                        </ul>
                    @endforeach
                @else
                    <ul>
                        <li>N/A</li>
                    </ul>
                @endif
            </dd>
        </div>
        <div class="box-footer"></div>
    </div>--}}

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Car Attributes</h3>
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
            <dt>{!! Form::label('owner_type', 'Attributes:') !!}</dt>
            <dd>
                @if($myCar->myCarAttributes->count() > 0)
                    @foreach($myCar->myCarAttributes as $attribute)
                        <ul>
                            @if($attribute->carAttribute->type == \App\Models\CarAttribute::TEXT || $attribute->carAttribute->type == \App\Models\CarAttribute::NUMBER )
                                <li>{!! $attribute->carAttribute->name !!} : {!! $attribute->value !!}</li>
                            @else
                                <li>
                                    {!! $attribute->carAttribute->name !!} :
                                    @php
                                        $options_array = \App\Models\AttributeOption::where('id', $attribute->value)->get();
                                        foreach ($options_array as $opt) {
                                            echo $opt['option_array']['name'];
                                        }
                                    @endphp
                                </li>
                            @endif
                        </ul>
                    @endforeach
                @else
                    <ul>
                        <li>N/A</li>
                    </ul>
                @endif
            </dd>
        </div>
        <div class="box-footer"></div>
    </div>
@else
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Car Detailed Information</h3>
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
            @if(!empty($myCar->limited_edition_specs))
                @foreach(json_decode($myCar->limited_edition_specs, true) as $key => $values)
                    <dt>{!! Form::label('owner_type', $key.':') !!}</dt>
                    <dd>
                        @foreach($values as $label => $value)
                            <ul>
                                <li>{!! $label !!} : {!! $value !!}</li>
                            </ul>
                        @endforeach

                    </dd>
                @endforeach
            @else
                <ul>
                    <li>N/A</li>
                </ul>
            @endif
        </div>
        <div class="box-footer"></div>
    </div>

    {{--<div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Car Attributes</h3>
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
            <dt>{!! Form::label('owner_type', 'Attributes:') !!}</dt>
            <dd>
                @if($myCar->myCarAttributes->count() > 0)
                    @foreach($myCar->myCarAttributes as $attribute)
                        <ul>
                            <li>{!! $attribute->carAttribute->name !!} : {!! $attribute->value !!}</li>
                        </ul>
                    @endforeach
                @else
                    <ul>
                        <li>N/A</li>
                    </ul>
                @endif
            </dd>
        </div>
        <div class="box-footer"></div>
    </div>--}}
@endif
@if($myCar->carRegions->count() > 0)
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Regions</h3>
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
            <dt>{!! Form::label('owner_type', 'Region:') !!}</dt>
            <dd>
                @if($myCar->carRegions->count() > 0)
                    @foreach($myCar->carRegions as $region)
                        <ul>
                            <li>{!! $region->region->name !!}
                                {{ (empty($region->price)? '' : ': '.number_format($region->price,2)) }}</li>
                        </ul>
                    @endforeach
                @else
                    <ul>
                        <li>N/A</li>
                    </ul>
                @endif
            </dd>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix"></div>
        <!-- box-footer -->
    </div>
@endif

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Car Images</h3>
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
        <dd>@if($myCar->media->count() > 0)
                @foreach($myCar->media as $media)
                    <a class="showGallery" data-id="{{$myCar->id}}" data-toggle="modal" data-target="#imageGallery">
                        <img src="{{ $media->file_url }}" width="120" style="margin-right: 2%">
                    </a>
                @endforeach
            @else
                N/A
            @endif
        </dd>
    </div>
    <!-- /.box-body -->
    <div class="box-footer"></div>
    <!-- box-footer -->
</div>
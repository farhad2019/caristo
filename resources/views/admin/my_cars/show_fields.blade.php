<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Meta Information</h3>
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
            <!-- Engine Type Id Field -->
            <dt>{!! Form::label('engine_type_id', 'Meta Title :') !!}</dt>
            <dd>{!! isset($myCar->meta[0]) ? $myCar->meta[0]->title : 'N/A' !!}</dd>
        </div>
        <div class="col-md-6">
            <!-- Engine Type Id Field -->
            <dt>{!! Form::label('engine_type_id', 'Meta Tags :') !!}</dt>
            <dd>{!! isset($myCar->meta[0]) ? $myCar->meta[0]->tags : 'N/A' !!}</dd>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <!-- Engine Type Id Field -->
        <dt>{!! Form::label('engine_type_id', 'Meta Description :') !!}</dt>
        <dd>{!! isset($myCar->meta[0]) ? $myCar->meta[0]->description : 'N/A' !!}</dd>
    </div>
    <!-- box-footer -->
</div>

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
        @if($myCar->category_id == 28)
            <!-- Version Field -->
                <dt>{!! Form::label('version', 'Version:') !!}</dt>
                <dd>{!! (isset($myCar->version_id) && $myCar->version_id != null)? $myCar->version_id : 'N/A' !!}</dd>
        @endif
        @if($myCar->category_id == null)
            <!-- Version Field -->
                <dt>{!! Form::label('version', 'Version:') !!}</dt>
                <dd>{!! (isset($myCar->version_app) && $myCar->version_app != null)? $myCar->version_app : 'N/A' !!}</dd>
        @endif
        <!-- Year Field -->
            <dt>{!! Form::label('year', 'Year:') !!}</dt>
            <dd>{!! $myCar->year?? 'N/A' !!}</dd>

        {{--<!-- Year Field -->
        <dt>{!! Form::label('chassis', 'Chassis:') !!}</dt>
        <dd>{!! $myCar->chassis?? 'N/A' !!}</dd>--}}

        <!-- Status Field -->
            <dt>{!! Form::label('status', 'Status:') !!}</dt>
            @if($myCar->status == 10)
                <dd>{!! '<span class="badge bg-blue" >'. $myCar->status_text .'</span>' !!}</dd>
            @elseif($myCar->status == 20)
                <dd>{!! '<span class="badge bg-red" >'. $myCar->status_text .'</span>' !!}</dd>
            @elseif($myCar->status == 30)
                <dd>{!! '<span class="badge bg-green" >'. $myCar->status_text .'</span>' !!}</dd>
            @else
                <dd>{!! $myCar->status_text !!}</dd>
            @endif
        </div>

        <div class="col-md-8">
        @if($myCar->category_id)
            <!-- Type Id Field -->
                <dt>{!! Form::label('category_id', 'Category :') !!}</dt>
                <dd>{!! isset($myCar->category_id) ? $myCar->category->name : 'N/A' !!}</dd>

            {{--<!-- Type Id Field -->
            <dt>{!! Form::label('type_id', 'Segments:') !!}</dt>
            <dd>{!! isset($myCar->carType->name) ? $myCar->carType->name : 'N/A' !!}</dd>--}}

            <!-- Transmission Type Field -->
                <dt>{!! Form::label('transmission_type', 'Transmission Type:') !!}</dt>
                <dd>{!! $myCar->transmission_type_text?? 'N/A' !!}</dd>
        @endif
        @if($myCar->category_id == \App\Models\MyCar::APPROVED_PRE_OWNED || $myCar->category_id == \App\Models\MyCar::CLASSIC_CARS || $myCar->category_id == Null)
            <!-- Year Field -->
                <dt>{!! Form::label('kilometer', 'Kilometer:') !!}</dt>
                <dd>{!! $myCar->kilometer ? $myCar->kilometer .' Km': 'N/A' !!}</dd>
        @endif
        @if($myCar->amount)
            <!-- Year Field -->
                <dt>{!! Form::label('amount', 'Amount:') !!}</dt>
                <dd>{!! $myCar->amount ? number_format($myCar->amount) : 'N/A' !!} {!! $myCar->currency ?? 'AED' !!}</dd>

        @endif

        <!-- Status Field -->
            <dt>{!! Form::label('status', 'Featured:') !!}</dt>
            <dd>
                <span class='badge bg-{{App\Helper\Utils::getBoolCss($myCar->is_featured, true)}}'>
                    <i class='fa fa-{{ ($myCar->is_featured ? "check" : "times") }}'></i>
                    {{ App\Helper\Utils::getBoolText($myCar->is_featured) }}
                </span>
            </dd>

            <!-- Regional Specification Field -->
            <dt>{!! Form::label('status', 'Regional Specification:') !!}</dt>
            <dd>{!! $myCar->regionalSpecs->name ? $myCar->regionalSpecs->name : 'N/A' !!} </dd>
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
            <dd>{!! $myCar['owner']['showroomDetails']['address'] ?? 'N/A' !!}</dd>
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
                        @if($attribute->carAttribute->name !== 'Trim' && $attribute->carAttribute->name !== 'Accident')
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
                        @endif
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
                                <li>{!! $label !!} : {!! $value['value'] !!} {{ @$value['unit'] }}</li>
                            </ul>
                        @endforeach
                    </dd>
                @endforeach
            @else
                <ul>
                    <li>N/A</li>
                </ul>
            @endif
            <dt>{!! Form::label('depreciation_trend', 'Depreciation Trend:') !!}</dt>
            <dd>
                @foreach($myCar->DepreciationTrend as $label => $value)
                    <ul>
                        <li>{!! $value->year !!} : {!! number_format($value->amount, 2) !!} ({!! $value->percentage !!}
                            %)
                        </li>
                    </ul>
                @endforeach
            </dd>
            @php($life_cycle = explode('-',$myCar->life_cycle))
            <dt>{!! Form::label('life_cycle', 'Life Cycle:') !!}</dt>
            <dd>
                <ul>
                    <li>{!! $life_cycle[0] !!} - {!! $life_cycle[1] !!}</li>
                </ul>
            </dd>
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

@if($myCar->category_id == \App\Models\MyCar::LIMITED_EDITION)
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Official Dealer</h3>
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
            @foreach($myCar->dealers as $dealer)
                <div class="col-sm-4">
                    <dt>{!! Form::label('owner_type', 'Showroom:') !!}</dt>
                    <dd><a href="{{ route('admin.users.show', $dealer->id) }}">
                            {!! $dealer->showroomDetails->name !!}</a></dd>
                </div>
                <div class="col-sm-4">
                    <dt>{!! Form::label('owner_type', 'Address:') !!}</dt>
                    <dd>{!! $dealer->showroomDetails->address !!}</dd>
                </div>
                <div class="col-sm-4">
                    <dt>{!! Form::label('owner_type', 'Contact#:') !!}</dt>
                    <dd>{!! $dealer->showroomDetails->phone !!}</dd>
                </div>
                <div class="col-sm-12 clearfix">
                    <hr>
                </div>
            @endforeach
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
        @if($myCar->media->count() > 0)
            @php($count = 0)
            @foreach($myCar->media as $media)
                @php($count++)
                <div class="col-sm-4">
                    <dt>{!! Form::label('engine_type_id', ucwords($media->title).' :') !!}</dt>
                    <dd>
                        <a class="showGallery" data-id="{{$myCar->id}}" data-source="{{ $count }}" data-toggle="modal"
                           data-target="#imageGallery">
                            <img src="{{ $media->file_url }}" width="120" height="70" style="margin-right: 2%">
                        </a>
                    </dd>
                </div>
                @if(($count%3) == 0)
                    <div class="col-sm-12 clearfix"><br></div>
                @endif
            @endforeach
        @else
            N/A
        @endif
    </div>
    <!-- /.box-body -->
    <div class="box-footer"></div>
    <!-- box-footer -->
</div>
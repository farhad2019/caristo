<div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($carBrand->translations as $key=>$translation)
                <li {{ $key == 0?'class=active':'' }}>
                    <a href="#tab_{{$key+1}}" data-toggle="tab">
                        {{ $translation->locale }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($carBrand->translations as $key => $translation)
                <div class="tab-pane {{$key==0?'active':''}}" id="tab_{{$key+1}}">
                    <div class="box">
                        <div class="box-header with-border">
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <dt>{!! Form::label('name', __('Name').':') !!}</dt>
                            <dd>{!! $translation->name !!}</dd>
                            <dt>{!! Form::label('logo', __('Logo').':') !!}</dt>
                            <dd><a class='showGallery' data-id='{{ $carBrand->media[0]->id }}' data-toggle='modal' data-target='#imageGallery'><img src="{!! $carBrand->media[0]->file_url !!}" width="80"></a></dd>
                        </div>
                        <div class="box-footer">
                            <dt>{!! Form::label('created_at', __('Created At').':') !!}</dt>
                            <dd>{!! $carBrand->created_at->format('d M Y') !!}</dd>
                        </div>
                        <!-- box-footer -->
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
</div>
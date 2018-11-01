<div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($carFeature->translations as $key => $translation)
                <li {{ $key == 0?'class=active':'' }}>
                    <a href="#tab_{{$key+1}}" data-toggle="tab">
                        {{ $translation->locale }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($carFeature->translations as $key => $translation)
                <div class="tab-pane {{$key==0?'active':''}}" id="tab_{{$key+1}}">
                    <div class="box">
                        <div class="box-header with-border">

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <dt>{!! Form::label('name', __('Name').':') !!}</dt>
                            <dd><img src="{{ $carFeature->icon_css }}" width="20"> {!! $translation->name !!}</dd>
                        </div>
                        <div class="box-footer">
                            <dt>{!! Form::label('created_at', __('Created At').':') !!}</dt>
                            <dd>{!! $carFeature->created_at !!}</dd>
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
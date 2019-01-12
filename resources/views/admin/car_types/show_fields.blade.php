<div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($carType->translations as $key => $translation)
                <li {{ $key == 0?'class=active':'' }}>
                    <a href="#tab_{{$key+1}}" data-toggle="tab">
                        {{ $translation->locale }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($carType->translations as $key => $translation)
                <div class="tab-pane {{$key==0?'active':''}}" id="tab_{{$key+1}}">
                    <div class="box">
                        <div class="box-header with-border">

                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <dt>{!! Form::label('name', __('Name').':') !!}</dt>
                            <dd><img src="{{ $carType->un_selected_icon }}" width="35"> {!! $translation->name !!}</dd>

                            <dt>{!! Form::label('name', __('Parent').':') !!}</dt>
                            <dd>{!! ($carType->parentCategory) ? "<span class='label label-success' style='word-break: break-all'>" . $carType->parentCategory->name . "</span>" : "<span class='label label-default' style='word-break: break-all'>None</span>" !!}</dd>
                        </div>

                        <div class="box-footer">
                            <dt>{!! Form::label('created_at', __('Created At').':') !!}</dt>
                            <dd>{!! $carType->created_at->format('d M Y') !!}</dd>
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
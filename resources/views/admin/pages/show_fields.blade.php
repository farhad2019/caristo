<div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($page->translations as $key=>$translation)
                <li {{ $key==0?'class=active':'' }}><a href="#tab_{{$key+1}}"
                                                       data-toggle="tab">{{ $translation->locale }}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($page->translations as $key => $translation)
                <div class="tab-pane {{$key==0?'active':''}}" id="tab_{{$key+1}}">
                    <dt>{!! Form::label('title', __('Title').':') !!}</dt>
                    <dd>{!! $translation->title !!}</dd>

                    <!-- Content Field -->
                    <dt>{!! Form::label('title', __('Content').':') !!}</dt>
                    <dd>{!! $translation->content !!}</dd>
                    <hr>

                    <!-- Status Field -->
                    <dt>{!! Form::label('visible', __('Visible').':') !!}</dt>
                    <dd>{!! ($translation->status==1)?'<span class="label label-success">Yes</span>':'<span class="label label-danger">No</span>' !!}</dd>

                    <!-- Slug Field -->
                    <dt>{!! Form::label('slug', __('Slug').':') !!}</dt>
                    <dd>{!! $page->slug !!}</dd>

                    <!-- Created At Field -->
                    <dt>{!! Form::label('created_at', __('Created At').':') !!}</dt>
                    <dd>{!! $page->created_at !!}</dd>

                    <!-- Updated At Field -->
                    <dt>{!! Form::label('updated_at', __('Updated At').':') !!}</dt>
                    <dd>{!! $page->updated_at !!}</dd>
                </div>
            @endforeach
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
</div>
<!-- /.col -->
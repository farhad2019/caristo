<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:*') !!}
    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder'=>'Unique Slug', 'required']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::hidden('status', 0, false) !!} <br>
    {!! Form::checkbox('status', 1, true, ['class'=> 'form-control', 'data-toggle'=>'toggle']) !!}
</div>

@if(isset($page))
    <div class="">
        <h3 class="box-title">Translations</h3>
    </div>
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @foreach($locales as $key=>$locale)
                    <li {{ $key==0?'class=active':'' }}>
                        <a href="#tab_{{$key+1}}"
                           data-toggle="tab">{{ ($locale->native_name===null)?$locale->title:$locale->native_name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($locales as $key=>$locale)
                    <div class="tab-pane {{$key==0?'active':''}} clearfix" id="tab_{{$key+1}}">
                        <!-- Title Field -->
                        <div class="form-group">
                            {!! Form::label('title', __('Title').':') !!}
                            {!! Form::text('title['.$locale->id.']', isset($page->translations[$key]->title)?$page->translations[$key]->title:null, ['class' => 'form-control', 'autofocus', 'style'=>'direction:'.$locale->direction]) !!}
                        </div>

                        <!-- Content Field -->
                        <div class="form-group">
                            {!! Form::label('content', __('Content').':') !!}
                            {!! Form::textarea('content['.$locale->id.']', isset($page->translations[$key]->content)?$page->translations[$key]->content:null, ['class' => 'textarea form-control', 'style'=>'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;']) !!}
                        </div>

                        <!-- Status Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('status', __('Status').':') !!}
                            {!! Form::checkbox('status['.$locale->id.']', 1, isset($page->translations[$key]->status)?$page->translations[$key]->status:null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.pages.index') !!}" class="btn btn-default">{{ __('Cancel') }}</a>
</div>

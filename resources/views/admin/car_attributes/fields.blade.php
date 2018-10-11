<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::select('type', $types, null, ['class' => 'form-control select2 att_type']) !!}
</div>

<div class="clearfix"></div>
<div id="clone-div" style="display: none">
    <div>
        <!-- Options Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('options', 'Options:') !!}
            {!! Form::text('options[]', null, ['class'=>'form-control']) !!}
        </div>

        <div class="col-sm-2" style="margin-top: 23px;">
            <a href="javascript:void(0)" class="btn btn-info add_row"><i class="fa fa-plus"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger delete_row"><i class="fa fa-trash"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="" id="clone-row-sample" style="display: none;">
        <!-- Options Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('options', 'Options:') !!}
            {!! Form::text('options[]', null, ['class'=>'form-control']) !!}
        </div>

        <div class="col-sm-2" style="margin-top: 23px;">
            <a href="javascript:void(0)" class="btn btn-danger delete_row"><i class="fa fa-trash"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.carAttributes.index') !!}" class="btn btn-default">Cancel</a>
</div>
@push('scripts')
    <script>
        $(function () {

            $('body').on('click', 'a.add_row', function () {
                var clone = $("#clone-row-sample").clone().appendTo("#clone-div");
                clone.removeAttr('id');
                clone.removeAttr('style');
                clone.prev().find('a.add_row').remove();
            });

            $('body').on('click', 'a.delete_row', function () {
                $(this).parent().parent().remove();
            });

            $('.att_type').change(function () {
                var type = $(this).val();
                if (type >= 30 && type < 60) {
                    $('#clone-div').show();
                }
                if (type < 30) {
                    $('#clone-div').hide();
                }

            });
        });
    </script>
@endpush
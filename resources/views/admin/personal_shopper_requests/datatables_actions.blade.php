{!! Form::open(['route' => ['admin.personalShopperRequests.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @endability
    @ability('super-admin' ,'personalShopperRequests.destroy')
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "confirmDelete($(this).parents('form')[0]); return false;"
    ]) !!}
    @endability
</div>
{!! Form::close() !!}

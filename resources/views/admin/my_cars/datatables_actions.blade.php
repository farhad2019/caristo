{!! Form::open(['route' => ['admin.myCars.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @ability('super-admin' ,'myCars.show')
    <a href="{{ route('admin.myCars.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    @endability
    @ability('super-admin' ,'myCars.edit')
    <a href="{{ route('admin.myCars.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    @endability
    @ability('super-admin' ,'myCars.destroy')
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "confirmDelete($(this).parents('form')[0]); return false;"
    ]) !!}
    @endability
</div>
{!! Form::close() !!}

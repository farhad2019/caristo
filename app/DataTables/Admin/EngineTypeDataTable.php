<?php

namespace App\DataTables\Admin;

use App\Models\EngineType;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class EngineTypeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['translations']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('translations.name', function ($model) {
            return '<span style="word-break: break-all">' . $model->name . '</span>';
        });

        $dataTable->rawColumns(['translations.name', 'action']);
        return $dataTable->addColumn('action', 'admin.engine_types.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EngineType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EngineType $model)
    {
        return $model->select('engine_types.*', 'engine_type_translations.name')->join('engine_type_translations', 'engine_type_translations.engine_type_id', '=', 'engine_types.id')->where('engine_type_translations.locale', App::getLocale('en'))->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('engineTypes.create') || \Entrust::hasRole('super-admin')) {
            $buttons = ['create'];
        }

        $buttons = array_merge($buttons, [
//            'export',
            'excel',
            'csv',
            'print',
            'reset',
            'reload',
        ]);

        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false])
            ->parameters([
                'dom'     => 'Bfrtip',
                'order'   => [[0, 'desc']],
                'buttons' => $buttons,
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id'                => [
                'orderable' => false,
            ],
            'translations.name' => [
                'title' => 'Name'
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'engine_typesdatatable_' . time();
    }
}
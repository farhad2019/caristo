<?php

namespace App\DataTables\Admin;

use App\Models\CarType;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarTypeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin.car_types.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CarType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CarType $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('car_types.create') || \Entrust::hasRole('super-admin')) {
            $buttons = ['create'];
        }
        $buttons = array_merge($buttons, [
            'export',
            'print',
            'reset',
            'reload',
        ]);
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px'])
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
            'id'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'car_typesdatatable_' . time();
    }
}
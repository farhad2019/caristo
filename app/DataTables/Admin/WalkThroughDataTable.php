<?php

namespace App\DataTables\Admin;

use App\Models\WalkThrough;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class WalkThroughDataTable extends DataTable
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

        $dataTable->editColumn('translations.title', function (WalkThrough $model) {
            return $model->title;
        });
        
        return $dataTable->addColumn('action', 'admin.walk_throughs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WalkThrough $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WalkThrough $model)
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
        if (\Entrust::can('walk_throughs.create') || \Entrust::hasRole('super-admin')) {
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
            'sort',
            'translations.title' => [
                'title' => 'Title'
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
        return 'walk_throughsdatatable_' . time();
    }
}
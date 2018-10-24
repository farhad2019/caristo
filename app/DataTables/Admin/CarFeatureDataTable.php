<?php

namespace App\DataTables\Admin;

use App\Models\CarFeature;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarFeatureDataTable extends DataTable
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
            return $model->name;
        });

        $dataTable->editColumn('icon', function ($model) {
            return $model->icon ? '<img src="' . $model->icon . '" width="35">' : null;
        });

        $dataTable->rawColumns(['icon', 'action']);
        return $dataTable->addColumn('action', 'admin.car_features.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CarFeature $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CarFeature $model)
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
        if (\Entrust::can('carFeatures.create') || \Entrust::hasRole('super-admin')) {
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
            'id',
            'translations.name' => [
                'title' => 'Name'
            ],
            'icon'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'car_featuresdatatable_' . time();
    }
}
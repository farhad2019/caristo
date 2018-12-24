<?php

namespace App\DataTables\Admin;

use App\Models\CarModel;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarModelDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['translations', 'brand.translations']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('translations.name', function ($model) {
            return '<span style="word-break: break-all">' . $model->name . '</span>';
        });

        $dataTable->addColumn('brand.translations.name', function ($model) {
            return '<span style="word-break: break-all">' . $model->brand->name . '</span>';
        });

        $dataTable->rawColumns(['translations.name', 'brand.translations.name', 'action']);
        return $dataTable->addColumn('action', 'admin.car_models.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CarModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CarModel $model)
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
        if (\Entrust::can('carModels.create') || \Entrust::hasRole('super-admin')) {
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
            'id'                      => [
                'searchable' => false
            ],
            'translations.name'       => [
                'title' => 'Name'
            ],
            'brand.translations.name' => [
                'title' => 'Brand Name'
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
        return 'car_modelsdatatable_' . time();
    }
}
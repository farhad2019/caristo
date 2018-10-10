<?php

namespace App\DataTables\Admin;

use App\Models\CarBrand;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarBrandDataTable extends DataTable
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
        $dataTable->editColumn('logo', function (CarBrand $model) {
            if (count($model->media) > 0)
                return "<img src='" . $model->media()->orderby('created_at', 'desc')->first()->fileUrl . "' width='80'/>";
            else {
                return "<span class='label label-default'>None</span>";
            }
        });
        $dataTable->rawColumns(['logo', 'action']);
        return $dataTable->addColumn('action', 'admin.car_brands.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CarBrand $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CarBrand $model)
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
        if (\Entrust::can('car_brands.create') || \Entrust::hasRole('super-admin')) {
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
            'id',
            'name',
            'logo'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'car_brandsdatatable_' . time();
    }
}
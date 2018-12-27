<?php

namespace App\DataTables\Admin;

use App\Models\CarModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
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

        $dataTable->editColumn('brand.translations.name', function ($model) {
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
        //return $model->newQuery();
        return $model->select('car_models.*', 'car_model_translations.name AS model_name', 'brand_translations.name AS brand_name')
            ->leftJoin('car_model_translations', 'car_model_translations.car_model_id', '=', 'car_models.id')
            ->leftJoin('brand_translations', 'brand_translations.brand_id', '=', 'car_models.brand_id')
            ->where('car_model_translations.locale', App::getLocale('en'))
            ->where('brand_translations.locale', App::getLocale('en'))
            ->newQuery();
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
                //'order'   => [[0, 'desc']],
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
                //'searchable' => false
            ],
            'translations.name'       => [
                'title' => 'Name',
                //'searchable' => true
            ],
            'brand.translations.name' => [
                'title' => 'Brand Name',
                //'searchable' => true
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
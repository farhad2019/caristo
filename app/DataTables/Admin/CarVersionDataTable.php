<?php

namespace App\DataTables\Admin;

use App\Models\CarVersion;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarVersionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['carModel.translations']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('carModel.translations.name', function ($model) {
            return '<span style="word-break: break-all">' . $model->carModel->brand->name . ' ' . $model->carModel->name . '</span>';
        });

        $dataTable->rawColumns(['carModel.translations.name', 'action']);
        return $dataTable->addColumn('action', 'admin.car_versions.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CarVersion $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CarVersion $model)
    {
//        return $model->newQuery();
        return $model->select('car_versions.*', 'car_model_translations.name AS model_name')
            ->leftJoin('car_model_translations', 'car_model_translations.car_model_id', '=', 'car_versions.model_id')
            ->where('car_model_translations.locale', App::getLocale('en'))
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
        if (\Entrust::can('carVersions.create') || \Entrust::hasRole('super-admin')) {
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
//            'id',
            'carModel.translations.name' => [
                'title' => 'Model',
                //'searchable' => true
            ],
            'name'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'car_versionsdatatable_' . time();
    }
}
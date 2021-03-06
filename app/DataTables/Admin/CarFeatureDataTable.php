<?php

namespace App\DataTables\Admin;

use App\Models\CarFeature;
use Illuminate\Support\Facades\App;
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
            return $model->icon ? '<a class="showGallerySingle" data-id="' . $model->id . '" data-toggle="modal" data-target="#imageGallerySingle"><img src="' . $model->icon . '" style="width:75px;"></a>' : null;
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
        return $model->select('features.*', 'feature_translations.name')->join('feature_translations', 'feature_translations.feature_id', '=', 'features.id')->where('feature_translations.locale', App::getLocale('en'))->newQuery();
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
                'searchable' => false
            ],
            'translations.name' => [
                'title' => 'Name'
            ],
            'icon'              => [
                'orderable'  => false,
                'searchable' => false,
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
        return 'car-features-' . date('d-m-Y H:i:s');
    }
}
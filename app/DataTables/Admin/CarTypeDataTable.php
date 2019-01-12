<?php

namespace App\DataTables\Admin;

use App\Models\CarType;
use Illuminate\Support\Facades\App;
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
        $query = $query->with(['translations']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('translations.name', function ($model) {
            return $model->name;
        });

        $dataTable->editColumn('image', function ($model) {
            return $model->image ? '<a class="showGallerySingle" data-id="' . $model->id . '" data-toggle="modal" data-target="#imageGallerySingle"><img src="' . $model->un_selected_icon . '" style="width:75px;"></a>' : "<span class='label label-default' style='word-break: break-all'>No Icon</span>";
        });

        $dataTable->editColumn('type_translations.name', function (CarType $model) {
            return ($model->parentCategory) ? "<span class='label label-success' style='word-break: break-all'>" . $model->parentCategory->name . "</span>" : "<span class='label label-default' style='word-break: break-all'>None</span>";
        });

        $dataTable->rawColumns(['type_translations.name', 'image', 'action']);
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
        return $model->select('car_types.*', 'car_type_translations.name')->join('car_type_translations', 'car_type_translations.car_type_id', '=', 'car_types.id')->where('car_type_translations.locale', App::getLocale('en'))->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('carTypes.create') || \Entrust::hasRole('super-admin')) {
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
                //'orderable' => false,
            ],
            'image'             => [
                'title' => 'Icon',
                'orderable'  => false,
                'searchable' => false,
                'exportable' => false
            ],
            'translations.name' => [
                'title' => 'Name'
            ],
            'type_translations.name' => [
                'title' => 'Parent Name'
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
        return 'car_types-' . date('d-m-Y H:i:s');
    }
}
<?php

namespace App\DataTables\Admin;

use App\Models\CarAttribute;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarAttributeDataTable extends DataTable
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

        $dataTable->editColumn('type', function ($model) {
            return $model->type_text;
        });

        $dataTable->rawColumns(['translations.name', 'action','type']);
        return $dataTable->addColumn('action', 'admin.car_attributes.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CarAttribute $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CarAttribute $model)
    {
        return $model->select('attributes.*', 'attribute_translations.name')->join('attribute_translations', 'attribute_translations.attribute_id', '=', 'attributes.id')->where('attribute_translations.locale', App::getLocale('en'))->newQuery();
        //return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('carAttributes.create') || \Entrust::hasRole('super-admin')) {
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
            'id',
            'translations.name' => [
                'title' => 'Name'
            ],
            'type'              => [
                'searchable' => false
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
        return 'car-attributes-' . date('d-m-Y H:i:s');
    }
}
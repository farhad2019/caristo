<?php

namespace App\DataTables\Admin;

use App\Models\Region;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RegionDataTable extends DataTable
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

        $dataTable->editColumn('flag', function ($model) {
            return '<span style="word-break: break-all">' . $model->name . '</span>';
        });

        $dataTable->editColumn('flag', function ($model) {
            if ($model->flag)
                return "<a class='showGallerySingle' data-id='" . $model->id . "' data-toggle='modal' data-target='#imageGallerySingle'><img src = '" . $model->flag . "' style = 'width:70px;' /></a> ";
            else {
                return "<span class='label label-default' > None</span > ";
            }
        });
        $dataTable->rawColumns(['flag', 'flag', 'action']);
        return $dataTable->addColumn('action', 'admin.regions.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Region $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Region $model)
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
        if (\Entrust::can('regions.create') || \Entrust::hasRole('super-admin')) {
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
            'id'   => [
                'searchable' => false
            ],
            'name',
            'flag' => [
                'searchable' => false,
                'orderable'  => false

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
        return 'regions-' . date('d-m-Y H:i:s');
    }
}
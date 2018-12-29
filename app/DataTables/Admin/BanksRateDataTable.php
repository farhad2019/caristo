<?php

namespace App\DataTables\Admin;

use App\Models\BanksRate;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class BanksRateDataTable extends DataTable
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

        $dataTable->editColumn('type', function (BanksRate $model) {
           if($model->type == '10')
           {
               return 'Bank';
           }else{
               return 'Insurance';
           }
        });

        $dataTable->editColumn('rate', function (BanksRate $model) {
            return $model->rate .'%';
        });

        $dataTable->editColumn('media.logo', function (BanksRate $model) {
            if (count($model->media) > 0)
                return "<a class='showGallerySingle' data-id='" . $model->id . "' data-toggle='modal' data-target='#imageGallerySingle'><img src='" . $model->media()->orderby('created_at', 'desc')->first()->fileUrl . "' width='80'/></a>";
            else {
                return "<span class='label label-default'>None</span>";
            }
        });

        $dataTable->rawColumns(['media.logo', 'action']);
        return $dataTable->addColumn('action', 'admin.banks_rates.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BanksRate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BanksRate $model)
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
        if (\Entrust::can('banksRates.create') || \Entrust::hasRole('super-admin')) {
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
            'title',
            'phone_no',
            'address',
            'rate',
            'type',
            'media.logo'        => [
                'title'      => 'Logo',
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
        return 'banks-rates-' . date('d-m-Y H:i:s');
    }
}
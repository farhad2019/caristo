<?php

namespace App\DataTables\Admin;

use App\Models\MakeBid;
use App\Models\MyCar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class MakeBidDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['carModel']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('carModel.name', function ($model) {
            return $model->name;
        });

        $dataTable->editColumn('status', function ($model) {
            return ($model->bids()->where('user_id', Auth::id())->count() > 0) ? 'Pending' : 'NEW';
        });
        return $dataTable->addColumn('action', 'admin.make_bids.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MyCar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MyCar $model)
    {
        return $model->where('owner_type', User::RANDOM_USER)->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        /*if (\Entrust::can('make_bids.create') || \Entrust::hasRole('super-admin')) {
            $buttons = ['create'];
        }
        $buttons = array_merge($buttons, [
            'export',
            'print',
            'reset',
            'reload',
        ]);*/
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'order'     => [[2, 'desc']],
//                'bFilter'   => false,
//                'paging'    => false,
                'searching' => false,
//                'info'      => false,
                'buttons'   => $buttons,
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
            'name',
            'car_model.name' => [
                'title' => 'Model'
            ],
            'year',
            'status'         => [
                'title' => 'Bid Status'
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
        return 'make_bidsdatatable_' . time();
    }
}
<?php

namespace App\DataTables\Admin;

use App\Models\BidsHistory;
use App\Models\MyCar;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class BidsHistoryDataTable extends DataTable
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

        $dataTable->editColumn('image', function ($model) {
            return isset($model->media[0]) ? '<a class="showGallery" data-id="' . $model->id . '" data-toggle="modal" data-target="#imageGallery"><img src="' . $model->media[0]->file_url . '" width=50></a>' : '-';
        });

        $dataTable->editColumn('Model', function ($model) {
            return $model->carModel->brand->name . ' ' . $model->carModel->name . ' (' . $model->year . ')';
        });

        $dataTable->editColumn('bid_close_at', function ($model) {
            return $model->bid_close_at->diffForHumans();
        });

        $dataTable->editColumn('amount', function ($model) {
            return number_format($model->bids()->where('user_id', Auth::id())->first()->amount, 2);
        });

        $dataTable->rawColumns(['image', 'action']);
        return $dataTable->addColumn('action', 'admin.bids_histories.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MyCar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MyCar $model)
    {
        $car_ids = Auth::user()->bids()->pluck('car_id')->toArray();
        return $model->whereIn('id', $car_ids)->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        /*if (\Entrust::can('bidsHistories.create') || \Entrust::hasRole('super-admin')) {
            $buttons = ['create'];
        }
        $buttons = array_merge($buttons, [
//            'export',
            'excel',
            'csv',
            'print',
            'reset',
            'reload',
        ]); */
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
            'id'     => [
                'visible' => false
            ],
            'image',
            'name',
            'Model',
            'kilometre',
            'bid_close_at',
            'amount' => [
                'title' => 'Amount (AED)'
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'bids_historiesdatatable_' . time();
    }
}
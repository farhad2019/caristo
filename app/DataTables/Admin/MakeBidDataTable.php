<?php

namespace App\DataTables\Admin;

use App\Models\MakeBid;
use App\Models\MyCar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('image', function ($model) {
            return isset($model->media[0]) ? '<a class="showGallery" data-id="' . $model->id . '" data-toggle="modal" data-target="#imageGallery"><img src="' . $model->media[0]->file_url . '" width=50></a>' : '-';
        });

        $dataTable->editColumn('Model', function ($model) {
            return $model->carModel->brand->name . ' ' . $model->carModel->name . ' (' . $model->year . ')';
        });

        $dataTable->editColumn('kilometre', function ($model) {
            return $model->kilometre ?? '-';
        });

        $dataTable->editColumn('bid_close_at', function ($model) {
            return $model->bid_close_at->diffForHumans();
        });

        $dataTable->rawColumns(['image', 'action']);
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
        $car_ids = Auth::user()->bids()->pluck('car_id')->toArray();
        return $model->where('owner_type', User::RANDOM_USER)->whereRaw(DB::raw('(bid_close_at > NOW()) > 0'))->whereNotIn('id', $car_ids)->orderBy('created_at', 'desc')->newQuery();
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
            'id'            => [
                'visible' => false
            ],
            'image',
            'name',
            'Model',
            'kilometre',
            'bid_close_at',
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
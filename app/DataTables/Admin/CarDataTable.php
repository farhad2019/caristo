<?php

namespace App\DataTables\Admin;

use App\Helper\Utils;
use App\Models\Car;
use App\Models\CarInteraction;
use App\Models\MyCar;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['carModel', 'category']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('category.name', function ($model) {
            return $model->category->name ?? '-';
        });

        $dataTable->editColumn('brand', function ($model) {
            return $model->carModel->brand->name;
        });

        $dataTable->editColumn('car_model.name', function ($model) {
            return $model->carModel->name;
        });

        $dataTable->editColumn('amount', function ($model) {
            return $model->amount ? number_format($model->amount, 2) : '-';
        });

        $dataTable->editColumn('image', function ($model) {
            if (count($model->media) > 0) {
                return "<img src='" . $model->media[0]->fileUrl . "' width='80'/>";
            } else {
                return "<span class='label label-default'>None</span>";
            }
        });

        $dataTable->editColumn('views_count', function (MyCar $model) {
            return "<a href='" . route('admin.users.index', ['car_id' => $model->id, 'type' => CarInteraction::TYPE_VIEW]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->views_count . "</span></a>";
        });

        $dataTable->editColumn('favorite_count', function (MyCar $model) {
            return "<a href='" . route('admin.users.index', ['car_id' => $model->id, 'type' => CarInteraction::TYPE_FAVORITE]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->favorite_count . "</span></a>";
        });

        $dataTable->editColumn('like_count', function (MyCar $model) {
            return "<a href='" . route('admin.users.index', ['car_id' => $model->id, 'type' => CarInteraction::TYPE_LIKE]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-thumbs-up'></i> " . $model->liked_count . "</span></a>";
        });

        $dataTable->editColumn('owner_type', function (MyCar $model) {
            $owner_type = $model->owner_type == 10 ? 1 : 0;
            return "<span class='badge bg-" . Utils::getBoolCss($owner_type, true) . "'> <i class='fa fa-" . ($owner_type ? "users" : "user") . "'></i> " . (($model->owner_type == 10) ? 'Vendor' : 'Client') . "</span>";
        });

        $dataTable->rawColumns(['action', 'views_count', 'favorite_count', 'like_count', 'owner_type', 'image']);

        return $dataTable->addColumn('action', 'admin.cars.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Car $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MyCar $model)
    {
        return $model->newQuery();
    }

    public function interactionList($data)
    {
        if (isset($data['owner_id']) && isset($data['type'])) {
            $this->owner_id = $data['owner_id'];
            $this->interaction_type = $data['type'];
        }
        return $this;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('cars.create') || \Entrust::hasRole('super-admin')) {
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
            'category.name'  => [
                'title' => 'Category',
            ],
            'brand',
            'car_model.name' => [
                'title' => 'Model'
            ],
            'amount',
            'image',
            'views_count'    => [
                'title' => 'Views'
            ],
            'favorite_count' => [
                'title' => 'Favorites'
            ],
            'like_count'     => [
                'title' => 'Likes'
            ],
            'owner_type'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'carsdatatable_' . time();
    }
}
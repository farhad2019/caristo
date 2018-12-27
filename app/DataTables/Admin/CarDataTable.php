<?php

namespace App\DataTables\Admin;

use App\Helper\Utils;
use App\Models\Car;
use App\Models\CarInteraction;
use App\Models\MyCar;
use Illuminate\Support\Facades\Auth;
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
        $query = $query->with(['carModel.translations', 'category.translations', 'carModel.brand.translations']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('category.translations.name', function ($model) {
            return $model->category->name ?? '-';
        });

        $dataTable->editColumn('carModel.brand.translations.name', function ($model) {
            return $model->carModel->brand->name;
        });

        $dataTable->editColumn('carModel.translations.name', function ($model) {
            return $model->carModel->name;
        });

        $dataTable->editColumn('amount', function ($model) {
            return $model->amount ? number_format($model->amount, 2) : '-';
        });

        $dataTable->editColumn('image', function ($model) {
            if (count($model->media) > 0) {
                return "<a class='showGallery' data-id='" . $model->id . "' data-toggle='modal' data-target='#imageGallery'><img src='" . $model->media[0]->fileUrl . "' width='80'/></a>";
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

        /*$dataTable->editColumn('like_count', function (MyCar $model) {
            return "<a href='" . route('admin.users.index', ['car_id' => $model->id, 'type' => CarInteraction::TYPE_LIKE]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-thumbs-up'></i> " . $model->liked_count . "</span></a>";
        });*/

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
     * @param \App\Models\MyCar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MyCar $model)
    {
        if ($this->owner_id && $this->interaction_type) {
            if ($this->interaction_type == 'cars') {
                $model = $model->where('owner_id', $this->owner_id);
            } else {
                $owner_id = $this->owner_id;
                $interactionType = $this->interaction_type;
                $model = $model->whereHas('CarInteractions', function ($carInteractions) use ($owner_id, $interactionType) {
                    return $carInteractions->where(['user_id' => $owner_id, 'type' => $interactionType]);
                });
            }
        }
        return $model->select('cars.*')->where('owner_id', '!=', Auth::id())->newQuery();
    }

    /**
     * @param $data
     * @return $this
     */
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
            'category.translations.name'       => [
                'title' => 'Category',
            ],
            'carModel.brand.translations.name' => [
                'title' => 'Brand'
            ],
            'carModel.translations.name'       => [
                'title' => 'Model'
            ],
            'amount',
            'image'                            => [
                'orderable'  => false,
                'searchable' => false,
            ],
            'views_count'                      => [
                'orderable'  => false,
                'searchable' => false,
                'title'      => 'User Views'
            ],
            'favorite_count'                   => [
                'orderable'  => false,
                'searchable' => false,
                'title'      => 'User Favorites'
            ],
            /* 'like_count'                       => [
                 'orderable'  => false,
                 'searchable' => false,
                 'title'      => 'Likes'
             ],*/
            'owner_type'                       => [
                'orderable' => false
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
        return 'cars-' . date('d-m-Y H:i:s');
    }
}
<?php

namespace App\DataTables\Admin;

use App\Models\CarInteraction;
use App\Models\MyCar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends DataTable
{
    protected $car_id;
    protected $interaction_type;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        /**
         * for master detail search uncomment next lines
         */

//        $query = $query->with(['Roles']);
        $dataTable = new EloquentDataTable($query);

//        $dataTable->editColumn('Roles.roles', function (User $model) {
//            return implode(",", $model->Roles->pluck('display_name')->toArray());
//        });


        $dataTable->addColumn('roles', function ($user) {
            return $user->rolesCsv;
        });
        $dataTable->editColumn('cars_count', function (User $model) {
            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->cars_count . "</span></a>";
        });
        $dataTable->editColumn('favorite_count', function (User $model) {
            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id, 'type' => CarInteraction::TYPE_FAVORITE]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->favorite_count . "</span></a>";
        });
        $dataTable->editColumn('like_count', function (User $model) {
            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id, 'type' => CarInteraction::TYPE_LIKE]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->like_count . "</span></a>";
        });
        $dataTable->editColumn('view_count', function (User $model) {
            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id, 'type' => CarInteraction::TYPE_VIEW]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->view_count . "</span></a>";
        });
        $dataTable->rawColumns(['action', 'cars_count','favorite_count','like_count','view_count']);
        return $dataTable->addColumn('action', 'admin.users.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        if ($this->car_id && $this->interaction_type) {
            $car_id = $this->car_id;
            $interactionType = $this->interaction_type;
            $model = $model->whereHas('catInteractions', function ($catInteractions) use ($car_id, $interactionType) {
                return $catInteractions->where(['car_id' => $car_id, 'type' => $interactionType]);
            });
        }
        return $model->newQuery()->whereNotIn('id', [1, Auth::user()->id]);
    }

    public function interactionList($data)
    {
        if (isset($data['car_id']) && isset($data['type'])) {
            $this->car_id = $data['car_id'];
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
        if (\Entrust::can('users.create') || \Entrust::hasRole('super-admin')) {
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
            'name',
            'email',
            'roles',
            'cars_count'    => [
                'title' => 'Cars'
            ],
            'favorite_count'    => [
                'title' => 'Favorite'
            ],
            'like_count'    => [
                'title' => 'Like'
            ],
            'view_count'    => [
                'title' => 'View'
            ],
//            'Roles.roles' => [
//                'searchable' => true,
//                'title'      => 'Roles'
//            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'usersdatatable_' . time();
    }
}
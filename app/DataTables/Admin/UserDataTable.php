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

        $query = $query->with(['Roles']);
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('name', function (User $model) {
            return '<span style="word-break: break-all">' . $model->name . '</span>';
        });

        $dataTable->editColumn('email', function (User $model) {
            return '<span style="word-break: break-all">' . $model->email . '</span>';
        });

        $dataTable->editColumn('Roles.display_name', function (User $model) {
            return '<span style="word-break: break-all">' . implode(",", $model->Roles->pluck('display_name')->toArray()) . '</span>';
        });

        $dataTable->editColumn('cars_count', function (User $model) {
            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id, 'type' => 'cars']) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->cars_count . "</span></a>";
        });

        $dataTable->editColumn('favorite_count', function (User $model) {
            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id, 'type' => CarInteraction::TYPE_FAVORITE]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->favorite_count . "</span></a>";
        });

//        $dataTable->editColumn('like_count', function (User $model) {
//            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id, 'type' => CarInteraction::TYPE_LIKE]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->like_count . "</span></a>";
//        });

        $dataTable->editColumn('view_count', function (User $model) {
            return "<a href='" . route('admin.cars.index', ['owner_id' => $model->id, 'type' => CarInteraction::TYPE_VIEW]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->view_count . "</span></a>";
        });

        $dataTable->rawColumns(['name', 'email', 'action', 'Roles.display_name', 'cars_count', 'favorite_count', 'view_count']);
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
        if ($this->interaction_id && $this->interaction_type) {
            $interaction_id = $this->interaction_id;
            $interactionType = $this->interaction_type;
            $dataType = $this->data_type;

            if ($dataType == 'news') {
                $model = $model->whereHas('newsInteractions', function ($newsInteractions) use ($interaction_id, $interactionType) {
                    return $newsInteractions->where(['news_id' => $interaction_id, 'type' => $interactionType]);
                });
            } else {
                $model = $model->whereHas('catInteractions', function ($catInteractions) use ($interaction_id, $interactionType) {
                    return $catInteractions->where(['car_id' => $interaction_id, 'type' => $interactionType]);
                });
            }
        }
        return $model->newQuery()->select('users.*')->whereNotIn('users.id', [1, Auth::user()->id]);
    }

    public function interactionList($data)
    {
        if (isset($data['car_id']) && isset($data['type'])) {
            $this->interaction_id = $data['car_id'];
            $this->interaction_type = $data['type'];
            $this->data_type = 'cars';
        } elseif (isset($data['news_id']) && isset($data['type'])) {
            $this->interaction_id = $data['news_id'];
            $this->interaction_type = $data['type'];
            $this->data_type = 'news';
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
            'name',
            'email',
            'Roles.display_name' => [
                'searchable' => true,
                'title'      => 'Roles'
            ],
            'cars_count'         => [
                'title'      => 'My Cars',
                'orderable'  => false,
                'searchable' => false
            ],
            'favorite_count'     => [
                'title'      => 'Favorite Cars',
                'orderable'  => false,
                'searchable' => false
            ],
//            'like_count'         => [
//                'title'      => 'Like',
//                'orderable'  => false,
//                'searchable' => false
//            ],
            'view_count'         => [
                'title'      => 'Viewed Cars',
                'orderable'  => false,
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
        return 'users-' . date('d-m-Y H:i:s');
    }
}
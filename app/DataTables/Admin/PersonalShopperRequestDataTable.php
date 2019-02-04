<?php

namespace App\DataTables\Admin;

use App\Models\PersonalShopperRequest;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PersonalShopperRequestDataTable extends DataTable
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
        $dataTable->addColumn('car_name', function (PersonalShopperRequest $model) {
            if ($model->car_id) {
                return "<a href='" . route('admin.cars.show', ['id' => $model->car_id]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->car_name . "</span></a>";
            } else {
                return '-';
            }
        });

        $dataTable->addColumn('phone', function (PersonalShopperRequest $model) {
            return $model->country_code . "-" . $model->phone;
        });

        $dataTable->addColumn('message', function (PersonalShopperRequest $model) {
            return '<span style="word-break: break-all">' . $model->message . '</span>';
        });

        $dataTable->rawColumns(['message', 'car_name', 'phone', 'action']);

        return $dataTable->addColumn('action', 'admin.personal_shopper_requests.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PersonalShopperRequest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PersonalShopperRequest $model)
    {
        return $model->newQuery()->select('admin_queries.*', 'cars.name as car_name')->leftJoin('cars', "admin_queries.car_id", "=", "cars.id")->where(['admin_queries.type' => 20]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('personal_shopper_requests.create') || \Entrust::hasRole('super-admin')) {
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
            'name',
            'email',
            'phone',
            'message',
            'car_name'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'personal_shopper_requestsdatatable_' . time();
    }
}
<?php

namespace App\DataTables\Admin;

use App\Models\Car;
use App\Models\ConsultancyRequest;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ConsultancyRequestDataTable extends DataTable
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

        /*$dataTable->addColumn('car_name', function (ConsultancyRequest $model) {
            return "<a href='" . route('admin.cars.show', ['id' => $model->car_id]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->car_name . "</span></a>";
        });*/

        $dataTable->editColumn('name', function (ConsultancyRequest $model) {
            return $model->name;
        });

        $dataTable->editColumn('email', function (ConsultancyRequest $model) {
            return $model->email;
        });

        $dataTable->addColumn('phone', function (ConsultancyRequest $model) {
            return $model->country_code . "-" . $model->phone;
        });

        $dataTable->addColumn('message', function (ConsultancyRequest $model) {
            return '<span style="word-break: break-all">' . $model->message . '</span>';
        });

        $dataTable->rawColumns(['message', 'action']);
        return $dataTable->addColumn('action', 'admin.consultancy_requests.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ConsultancyRequest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ConsultancyRequest $model)
    {
        return $model->newQuery()->select('admin_queries.*')->where(['admin_queries.type' => 10]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('consultancy_requests.create') || \Entrust::hasRole('super-admin')) {
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
//            'car_name'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'consultancy_requestsdatatable_' . time();
    }
}
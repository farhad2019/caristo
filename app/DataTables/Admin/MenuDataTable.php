<?php

namespace App\DataTables\Admin;

use App\Models\Menu;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class MenuDataTable extends DataTable
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
        $dataTable->editColumn('sort_by', function (Menu $menu) {
            return '<span class="hidden">' . $menu->sort_by . '</span><input type="hidden" data-id="' . $menu->id . '" class="inputSort" value="' . $menu->sort_by . '"><a href="javascript:void(0)" class="btn btn-success btn-up"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0)" class="btn btn-success btn-down"><i class="fa fa-arrow-down"></i></a>';
        });
        $dataTable->addColumn('action', 'admin.menus.datatables_actions');
        $dataTable->rawColumns(['sort_by', 'action']);
        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Menu $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Menu $model)
    {
        return $model->selectRaw('*')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('menus.create') || \Entrust::hasRole('super-admin')) {
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
            'sort_by',
            'name'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'menusdatatable_' . time();
    }
}
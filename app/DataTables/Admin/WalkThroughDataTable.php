<?php

namespace App\DataTables\Admin;

use App\Models\WalkThrough;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class WalkThroughDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['translations']);
        $dataTable = new EloquentDataTable($query);

        /*$dataTable->editColumn('sort_by', function (Menu $menu) {
            return '<span class="hidden">' . $menu->sort_by . '</span><input type="hidden" data-id="' . $menu->id . '" class="inputSort" value="' . $menu->sort_by . '"><a href="javascript:void(0)" class="btn btn-success btn-up"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0)" class="btn btn-success btn-down"><i class="fa fa-arrow-down"></i></a>';
        });*/
        $dataTable->editColumn('sort', function ($query) {
            return '<input type="hidden" data-id="' . $query->id . '" class="inputSort" value="' . $query->sort . '"><a href="javascript:void(0)" class="btn btn-success btn-up"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0)" class="btn btn-success btn-down"><i class="fa fa-arrow-down"></i></a>';
        });

        $dataTable->editColumn('translations.title', function ($query) {
            return $query->title;
        });

        $dataTable->rawColumns(['sort', 'action']);
        return $dataTable->addColumn('action', 'admin.walk_throughs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WalkThrough $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WalkThrough $model)
    {
        return $model->select('walkthrough.*', 'walkthrough_translations.title')->join('walkthrough_translations', 'walkthrough_translations.walk_through_id', '=', 'walkthrough.id')->where('walkthrough_translations.locale', App::getLocale('en'))->newQuery();
        //return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('walkThroughs.create') || \Entrust::hasRole('super-admin')) {
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
            'sort'               => [
                'searchable' => false
            ],
            'translations.title' => [
                'title' => 'Title'
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
        return 'walk_throughsdatatable_' . time();
    }
}
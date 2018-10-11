<?php

namespace App\DataTables\Admin;

use App\Models\Category;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with('translations', 'parentCategory.translations');
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('translations.name', function (Category $model) {
            return $model->name;
        });
        $dataTable->editColumn('parentCategory.translations.name', function (Category $model) {
            return ($model->parentCategory) ? "<span class='label label-success'>" . $model->parentCategory->name . "</span>" : "<span class='label label-default'>None</span>";
        });
        $dataTable->editColumn('image', function (Category $model) {
            if (count($model->media) > 0)
                return "<img src='" . $model->media[0]->fileUrl . "' width='80'/>";
            else {
                return "<span class='label label-default'>None</span>";
            }
        });
        $dataTable->rawColumns(['image', 'parentCategory.translations.name', 'action']);
        return $dataTable->addColumn('action', 'admin.categories.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('categories.create') || \Entrust::hasRole('super-admin')) {
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
//            'slug',
            'translations.name'                => [
                'title' => 'Name'
            ],
            'image'                            => [
                'orderable'  => false,
                'searchable' => false,
            ],
            'parentCategory.translations.name' => [
                'title' => 'Parent Category'
            ]
//            'created_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'categoriesdatatable_' . time();
    }
}
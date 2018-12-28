<?php

namespace App\DataTables\Admin;

use App\Models\CarInteraction;
use App\Models\Category;
use Illuminate\Support\Facades\App;
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
            return '<span style="word-break: break-all">' . $model->name . '</span>';
        });
        $dataTable->editColumn('category_translations.name', function (Category $model) {
            return ($model->parentCategory) ? "<span class='label label-success' style='word-break: break-all'>" . $model->parentCategory->name . "</span>" : "<span class='label label-default' style='word-break: break-all'>None</span>";
        });

        $dataTable->editColumn('image', function (Category $model) {
            if (count($model->media) > 0)
                return "<a class='showGallerySingle' data-id='" . $model->id . "' data-toggle='modal' data-target='#imageGallerySingle'>
                <img src='" . $model->media[0]->fileUrl . "' width='80'/></a>";
            else {
                return "<span class='label label-default'>None</span>";
            }
        });

        $dataTable->editColumn('clicks_count', function (Category $model) {
            return "<a href='" . route('admin.users.index', ['car_id' => $model->id, 'type' => CarInteraction::TYPE_CLICK_CATEGORY]) . "' target='_blank'> <span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->clicks_count . " </span></a>";
        });

        $dataTable->rawColumns(['clicks_count', 'translations.name', 'image', 'category_translations.name', 'action']);
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
        return $model->select('category.*', 'category_translations.name')
            ->leftJoin('category as b', 'category.parent_id', '=', 'b.id')
            ->leftJoin('category_translations', 'category_translations.category_id', '=', 'category.id')
            ->where('category_translations.locale', App::getLocale('en'))
            ->newQuery();
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
//            'slug',
            'translations.name'          => [
                'title' => 'Name'
            ],
            'image'                      => [
                'orderable'  => false,
                'searchable' => false,
            ],
            'category_translations.name' => [
                'title'     => 'Parent Category',
                'orderable' => false,
            ],
            'clicks_count'               => [
                'title'     => 'Clicks Count',
                'orderable' => false,
                'searchable' => false,
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
        return 'categories-' . date('d-m-Y H:i:s');
    }
}
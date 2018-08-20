<?php

namespace App\DataTables\Admin;

use App\Helper\Utils;
use App\Models\News;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class NewsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['translations', 'category.translations']);

        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('translations.headline', function (News $model) {
            return $model->headline;
        });
        $dataTable->editColumn('category.translations.name', function (News $model) {
//            return ($model->category) ? "<span id='category-" . $model->category_id . "' class='label label-success'>" . $model->category->name . "</span>" : "<span class='label label-default'>None</span>";
            return $model->category->name;
        });
        $dataTable->editColumn('image', function (News $model) {
            if (count($model->media) > 0)
                return "<img src='" . $model->media[0]->fileUrl . "' width='80'/>";
            else {
                return "<span class='label label-default'>None</span>";
            }
        });
        $dataTable->editColumn('views_count', function (News $model) {
            return "<span class='badge badge-success'> <i class='fa fa-eye'></i> " . $model->views_count . "</span>";
        });
        $dataTable->editColumn('like_count', function (News $model) {
            return "<span class='badge badge-success'> <i class='fa fa-thumbs-up'></i> " . $model->like_count . "</span>";
        });
        $dataTable->editColumn('comments_count', function (News $model) {
            return "<span class='badge badge-success'> <i class='fa fa-comments'></i> " . $model->comments_count . "</span>";
        });
        $dataTable->editColumn('is_featured', function (News $model) {
            return "<span class='badge bg-" . Utils::getBoolCss($model->is_featured, true) . "'> <i class='fa fa-" . ($model->is_featured ? "check" : "times") . "'></i> " . Utils::getBoolText($model->is_featured) . "</span>";
        });
        $dataTable->rawColumns(['category.name', 'image', 'action', 'views_count', 'like_count', 'comments_count', 'is_featured']);
        return $dataTable->addColumn('action', 'admin.news.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\News $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(News $model)
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
        if (\Entrust::can('news.create') || \Entrust::hasRole('super-admin')) {
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
            ->addAction(['width' => '80px'])
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
            'translations.headline'      => [
                'orderable' => false,
                'title'     => 'Headline'
            ],
            'category.translations.name' => [
                'orderable' => false,
                'title'     => 'Category'
            ],
            'image'                      => [
                'orderable'  => false,
                'searchable' => false
            ],
            'views_count'                => [
                'title' => 'Views'
            ],
//            'favorite_count' => [
//                'title' => 'Views'
//            ],
            'like_count'                 => [
                'title' => 'Likes'
            ],
            'comments_count'             => [
                'title' => 'Comments'
            ],
            'is_featured'
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
        return 'newsdatatable_' . time();
    }
}
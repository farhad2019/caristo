<?php

namespace App\DataTables\Admin;

use App\Models\MyCar;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class MyCarDataTable extends DataTable
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
            return $model->category->name;
        });

        $dataTable->editColumn('carModel.brand.translations.name', function ($model) {
            return $model->carModel->brand->name ?? '-';
        });

        $dataTable->editColumn('carModel.translations.name', function ($model) {
            return $model->carModel->name;
        });

        $dataTable->editColumn('amount', function ($model) {
            return $model->amount .' AED' ?? '-';
        });

        $dataTable->editColumn('image', function ($model) {
            if (count($model->media) > 0) {
                return "<a class='showGallerySingle' data-id='" . $model->id . "' data-toggle='modal' data-target='#imageGallerySingle'><img src='" . @$model->media[0]->fileUrl . "' width='80'/></a>";
            } else {
                return "<span class='label label-default'>None</span>";
            }
        });

        $dataTable->editColumn('brand', function ($model) {
            return @$model->carModel->brand->name;
        });

        $dataTable->rawColumns(['action','image']);

        return $dataTable->addColumn('action', 'admin.my_cars.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MyCar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MyCar $model)
    {
        $id = Auth::id();
        return $model->select('cars.*', 'car_model_translations.name as model_name')
            ->join('car_models', 'car_models.id', '=', 'cars.model_id')
            ->leftJoin('car_model_translations', 'car_models.id', '=', 'car_model_translations.car_model_id')
            ->where(['owner_id' => $id, 'car_model_translations.locale' => 'en'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('myCars.create') || \Entrust::hasRole('super-admin')) {
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
            'image' => [
                'orderable'  => false,
                'searchable' => false,
            ],
            'category.translations.name' => [
                'title' => 'Category',
            ],
            'carModel.brand.translations.name' => [
                'title' => 'Brand'
            ],
            'carModel.translations.name' => [
                'title' => 'Model'
            ],
            'year',
            'amount'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'my_carsdatatable_' . time();
    }
}
<?php

namespace App\DataTables\Admin;

use App\Models\CarBrand;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CarBrandDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->with(['translations', 'media']);

        $dataTable = new EloquentDataTable($query);
        $dataTable->editColumn('translations.name', function (CarBrand $model) {
            return '<span style="word-break: break-all">' . $model->name . '</span>';
        });

        $dataTable->editColumn('media.logo', function (CarBrand $model) {
            if (count($model->media) > 0)
            return "<a class='showGallerySingle' data-id='" . $model->id . "' data-toggle='modal' data-target='#imageGallerySingle'><img src='" . $model->media()->orderby('created_at', 'desc')->first()->fileUrl . "' width='80'/></a>";
        else {
                return "<span class='label label-default'>None</span>";
            }
        });

        $dataTable->rawColumns(['translations.name', 'media.logo', 'action']);
        return $dataTable->addColumn('action', 'admin.car_brands.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CarBrand $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CarBrand $model)
    {
        return $model->newQuery()->select('brands.*')->join('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')->where('locale', App::getLocale('en'));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('carBrands.create') || \Entrust::hasRole('super-admin')) {
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
            'translations.name' => [
                'title' => 'Name'
            ],
            'media.logo'        => [
                'title'      => 'Logo',
                'orderable'  => false,
                'searchable' => false,
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
        return 'car-brands-' . date('d-m-Y H:i:s');
    }
}
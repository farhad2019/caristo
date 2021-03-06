<?php

namespace App\DataTables\Admin;

use App\Models\RegionalSpecification;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RegionalSpecificationDataTable extends DataTable
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

        $dataTable->editColumn('translations.name', function ($model) {
            return $model->name;
        });

        return $dataTable->addColumn('action', 'admin.regional_specifications.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RegionalSpecification $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RegionalSpecification $model)
    {
        return $model->select('regional_specifications.*', 'regional_specification_translations.name')->join('regional_specification_translations', 'regional_specification_translations.regional_specification_id', '=', 'regional_specifications.id')->where('regional_specification_translations.locale', App::getLocale('en'))->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('regionalSpecifications.create') || \Entrust::hasRole('super-admin')) {
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
        return 'regional-specifications-' . date('d-m-Y H:i:s');
    }
}
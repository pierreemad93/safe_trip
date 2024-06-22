<?php

namespace App\DataTables;

use App\Models\Item;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'rent.action')
            ->addIndexColumn()
            ->filterColumn('model', function ($query, $keyword) {
                $query->where('model', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('brand', function ($query, $keyword) {
                $query->where('brand', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('color', function ($query, $keyword) {
                $query->where('color', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('production_date', function ($query, $keyword) {
                $query->where('production_date', 'like', '%' . $keyword . '%');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RentDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RentDataTable $model)
    {
        $model = Item::with('type')->orderBy('id', 'desc');
        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('rentdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->searchable(false)
                ->title(__('message.srno'))
                ->orderable(false)
                ->width(60),
            Column::make('type_id')->title(__('message.type')),
            Column::make('model')->title(__('message.model')),
            Column::make('brand')->title(__('message.brand')),
            Column::make('name')->title(__('message.name')),
            Column::make('color')->title(__('message.color')),
            Column::make('plate_number')->title(__('message.plate_number')),
            Column::make('production_date')->title(__('message.production_date')),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Rent_' . date('YmdHis');
    }
}

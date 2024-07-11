<?php

namespace App\DataTables;

use App\Models\RiderDocument;
use App\Traits\DataTableTrait;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RiderDocumentDataTable extends DataTable
{
    use DataTableTrait;
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
            ->editColumn('is_verified', function ($query) {
                $is_verified = 'warning';
                switch ($query->is_verified) {
                    case 1:
                        $is_verified = 'primary';
                        $is_verified_label =  __('message.approved');
                        break;
                    case 2:
                        $is_verified = 'danger';
                        $is_verified_label =  __('message.rejected');
                        break;
                    default:
                        $is_verified_label = __('message.pending');
                        break;
                }
                return '<span class="text-capitalize badge bg-' . $is_verified . '">' . $is_verified_label . '</span>';
            })
            ->editColumn('rider_id', function ($query) {
                return ($query->rider_id != null && isset($query->rider)) ? $query->rider->display_name : '';
            })
            ->editColumn('document_id', function ($query) {
                return ($query->document_id != null && isset($query->document)) ? $query->document->name : '';
            })
            ->filterColumn('rider_id', function ($query, $keyword) {
                $query->whereHas('rider', function ($q) use ($keyword) {
                    $q->where('display_name', 'like', '%' . $keyword . '%');
                });
            })
            ->addIndexColumn()
            ->addColumn('action', 'rider_document.action')
            ->rawColumns(['action', 'is_verified']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RiderDocument $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = RiderDocument::myDocument()->orderBy('id', 'desc');
        return $this->applyScopes($model);
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
            Column::make('rider_id')->title(__('message.rider')),
            Column::make('document_id')->title(__('message.document')),
            Column::make('is_verified')->title(__('message.is_verify')),
            Column::make('expire_date')->title(__('message.expire_date')),
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
        return 'RiderDocument_' . date('YmdHis');
    }
}

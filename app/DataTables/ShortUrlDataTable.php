<?php

namespace App\DataTables;

use App\Models\ShortUrl;
use Yajra\DataTables\Services\DataTable;

class ShortUrlDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addIndexColumn()
        ->editColumn('created_at', function ($url) {
            $url->orderBy('created_at', 'desc');
        })
        ->editColumn('short_url', function ($url) {
            return "<a href='".url($url->short_url)."' target='_blank' class='url-redirected'>".url($url->short_url)."</a>";
        })
        ->addColumn('action', function ($url) {
            $buttons = "";
            $buttons .='<button type="button" title="Delete" class="btn btn-icon btn-danger btn-sm delete-url" data-id="'.$url->uuid.'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
            return $buttons;
        })->rawColumns(['short_url','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\ShortUrl $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ShortUrl $model)
    {
        $model = $model->query();
        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->processing(true)
        ->language ([
            'searchPlaceholder' => 'Heading/Subject',
            'loadingRecords' => '&nbsp;',
            'processing'=> '<button class="btn btn-primary" type="button" disabled="">
                                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                    Loading...
                            </button>',
        ]) 
        ->columns($this->getColumns())
        ->addAction(['title' => 'Actions'])
        ->parameters($this->getBuilderParameters());
    }
    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $column_specifications = [];
        $column_specifications[] = ['data' => 'updated_at','title' => 'Updated At','orderable'=> true,'searchable'=> false,'visible'=> false];
        $column_specifications[] = ['defaultContent'=> '','data'=> 'DT_RowIndex','name'=> 'DT_RowIndex','title'=> '#','render'=> null,'orderable'=> false,'searchable'=> false,'exportable'=> false,'printable'=> true,'footer'=> ''];
        $column_specifications[] = ['data' => 'short_url','title' => 'Short URL'];
        $column_specifications[] = ['data' => 'url','title' => 'URL'];
        $column_specifications[] = ['data' => 'visitors','title' => 'Visitors'];
        return $column_specifications;
    }
    /**
     * Get columns.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            'dom' => 'Bflrtip',
            'responsive'=>false,
            'drawCallback' => 'function() {$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}',
            'buttons'=> [],
            'order' => [0,'desc'],
            "pageLength" => 20,
            "lengthMenu" => [ 10, 20, 50, 100 ]
        ];
    }
}

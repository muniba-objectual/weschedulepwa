<?php
namespace App\DataTables;

use App\Models\Home;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class HomeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    public $table = "homes";


    public function dataTable($query)
    {
       return datatables()
            ->eloquent($query)
            ->setRowId('id');



       }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Home $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Home $model)
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
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Bfrtip',
                'order' => [1, 'asc'],

                'select' => [
                    'style' => 'os',
                    'selector' => 'td:first-child',
                ],
                'buttons' => [
                    ['extend' => 'create', 'editor' => 'editor'],
                    ['extend' => 'edit', 'editor' => 'editor'],
                    ['extend' => 'remove', 'editor' => 'editor'],
                ]
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
            [
                'data' => null,
                'defaultContent' => '',
                'className' => 'select-checkbox',
                'title' => '',
                'orderable' => false,
                'searchable' => false,

            ],

            'name',
            'address',
            'city',
            'province',
            'notes'



           /*
            'address',
            'city',
            'province',
            'postal',
            'drivers_license',
            'notes',
*/

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Homes_' . date('YmdHis');
    }
}

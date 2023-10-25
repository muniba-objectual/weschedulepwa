<?php
namespace App\DataTables;

use App\Models\Shift;

use App\Models\Shift_Layout_Template;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShiftDataTable extends DataTable
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
            ->setRowId('id');


       }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Shift $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shift $model)
    {
//     $model = Shift::all();

    if ($this->id) {
        $model = Shift::where('id',$this->id)->with('get_user');
    } else {
        $model = Shift::with('get_user');
    }


     //return $model->newQuery();
        //return $model->newQuery()->with('get_user')->select('shifts.*');
        return $model->newQuery()->with('get_user');


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
                'rowGroup' => ['dataSrc' => 'user_type'],

                'select' => [
                    'style' => 'os',
                    'selector' => 'td:first-child',
                ],
                'buttons' => [
                    ['extend' => 'edit', 'editor' => 'editor'],
                    ['text' => 'Validate', 'action' => ""]
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
                'orderable' => true,
                'searchable' => true,
            ],

            [
                'data' => 'title',
                'name' => 'title',
                'title' => 'Child',
            ],

            'start',
            'end',
            'status',

            'actual_shift_start',
            'actual_shift_end',

            [
                'data'  => 'get_user.name',
                //'name' => 'get_user.fullname',
                'name' => 'get_user.name',
                //'id' => 'fk_UserID',
                'title' => 'Staff Assigned',


            ],




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
        return 'Shift_' . date('YmdHis');
    }
}

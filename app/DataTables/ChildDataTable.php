<?php
namespace App\DataTables;

use App\Models\Child;
use App\Models\Home;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class ChildDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    public $table = "children";


    public function dataTable($query)
    {
       return datatables()
            ->eloquent($query)
            ->setRowId('id');



       }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Child $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Child $model)
    {
       // return $model->newQuery()->select('users.*');
        $model = Child::with('get_home')->where('WeSchedule','=','1');
        //->leftJoin( 'homes',   'homes.id',   '=', 'children.fk_HomeID' );

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
                'rowGroup' => ['dataSrc' => 'user_type'],

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
                'orderable' => true,
                'searchable' => false,
            ],
            ['name' => 'initials',
                'title' => 'Name',
                'data' => 'initials'
                ],
            'DOB',
            'notes',
            ['name' => 'SRA',
             'data' => 'displayable_SRA',
             'title' => 'SRA',

            ],

            ['name' => 'assigned_home',
                'data'  => 'get_home.name',

                'id' => 'assigned_home',
                'title' => 'Assigned Home'
            ],
//            ['name' => 'WeSchedule',
//                'data' => 'displayable_WeSchedule',
//                'title' => 'We-Schedule',
//
//            ],

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
        return 'Children_' . date('YmdHis');
    }
}

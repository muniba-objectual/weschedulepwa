<?php
namespace App\DataTables;

use App\Models\Shift_Layout_Template;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;
class ShiftLayoutDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    public $table = "shift__layout__templates";


    public function dataTable($query)
    {

       return datatables()

            ->eloquent($query)
            ->setRowId('id');
            //->editColumn('get_user.first_name', function () {
//                return 'test user';
//    });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Shift_Layout_Template $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

        $model = Shift_Layout_Template::with('get_user','get_child');

        if(isset($_GET['staffID'])) {


         $model = Shift_Layout_Template::with('get_user','get_child')
         ->where ('fk_UserID','=',$_GET['staffID']);

     } else {
         $model = Shift_Layout_Template::with('get_user','get_child');
     }

        return $model->newQuery()->with('get_user','get_child')->select('shift__layout__templates.*');



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
                'order' => [5, 'desc'],
                'orderFixed' => '[get_child.initials, "asc"]',

                'rowGroup' => ['dataSrc' => 'get_child.initials'],
                'select' => [
                    'style' => 'os',
                    'selector' => 'td:first-child',
                ],
                'searching' => true,

                'columnDefs' => [
                    [
                        'targets' => [4],
                        'visible' => true,
                        'searchable' => true,

                    ],
                ],

                'buttons' => [
                    ['extend' => 'create', 'editor' => 'editor'],
                    ['extend' => 'edit', 'editor' => 'editor'],
                    ['extend' => 'remove', 'editor' => 'editor'],
                    ['text' => 'Import', 'action' => "function() {uploadEditor.create({title:'CSV File Import'});}"],
                    ['text' => 'Export'],
                    ['text' => 'Generate Schedule', 'action' => "function(e, dt, node, config){generateSchedule();}"]
                ],
                'initComplete' => "function() {
   this.api().columns([1,4,5]).every( function () {
                var column = this;
                var select = $('<select><option value=". '""' ."></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()

                        );
 //window.alert ($(this).val());
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value=".'"' . "'" . "+d+" . "'" . '"' .">'+d+'</option>' )
                } );
            } );
  }",



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

            'day_of_week',
            'start_time',
            'end_time',

            [
                'data'  => 'get_user.name',
                //'name' => 'get_user.fullname',
                'name' => 'get_user.name',
                //'id' => 'fk_UserID',
                'title' => 'Staff Assigned',


            ],
            //[
                //'data' => 'get_user.fullname',
                //'name' => 'get_user.fullname',
                //'visible' => true,
            //],

            ['name' => 'fk_ChildID',
                'data'  => 'get_child.initials',
                'name' => 'get_child.initials',

                'title' => 'Child Assigned'
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
        return 'Shift_Layout_Template' . date('YmdHis');
    }
}

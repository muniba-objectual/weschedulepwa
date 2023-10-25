<?php
namespace App\DataTables;

use App\Models\Child;
use App\Models\ChildNotification;
use App\Models\Home;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class ChildNotificationsScheduleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    public $table = "child_notifications_schedule";


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
    public function query(ChildNotification $model)
    {
       // return $model->newQuery()->select('users.*');
        $model = ChildNotification::with('get_child');
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
                //'rowGroup' => ['dataSrc' => 'user_type'],

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
            'notification_events',
            'notification_message',
            'notification_schedule',
            'notification_method',
            'notification_addresses',


            ['name' => 'assigned_child',
                'data'  => 'get_child.initials',

                'id' => 'assigned_child',
                'title' => 'Assigned Child'
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
        return 'ChildNotificationsSchedule_' . date('YmdHis');
    }
}

<?php
namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class UsersDataTable extends DataTable
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
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
       // return $model->newQuery()->select('users.*');
        //filter the model based on We-Schedule Users only
        $model = \App\Models\User::with('get_user_type')->with('getAssignedChildren')->where('user_type', '=', '1.0')->OrWhere('user_type', '=', '2.0')->OrWhere('user_type', '=', '10.0');
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
                'order' => [3, 'asc'],
                'orderFixed' => '[get_user_type.name, "asc"]',

                'rowGroup' => ['dataSrc' => 'get_user_type.name'],

                'select' => [
                    'style' => 'os',
                    'selector' => 'td:first-child',
                ],
                'buttons' => [
                    ['extend' => 'create', 'editor' => 'editor'],
                    ['extend' => 'edit', 'editor' => 'editor'],
                    ['extend' => 'remove', 'editor' => 'editor'],
                    ['extend' => 'selectedSingle', 'text' => 'View Profile', 'action' => 'function ( e, dt, node, config ) {
                        //dt.ajax.reload();
                        $record = (this.rows({selected: true}).data()[0]);

                        window.open("/users/" + ($record.id), "_blank");
                    }'],
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
            'name',

            'email',
            ['name' => 'user_type',
                'data'  => 'get_user_type.name',
                'id' => 'get_user_type',
                'title' => 'User Type'
            ],

            ['name' => 'assigned_children',
                'data'  => 'get_assigned_children[].initials',
                'id' => 'get_assigned_children[].id',
                'salary' => 'get_assigned_children[].pivot.salary',

                'title' => 'Assigned Children',
                'render' => '[, ]',

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
        return 'Users_' . date('YmdHis');
    }
}

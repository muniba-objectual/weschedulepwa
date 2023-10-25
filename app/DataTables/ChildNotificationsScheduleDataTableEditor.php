<?php

namespace App\DataTables;

use App\Models\Child;
use App\Models\ChildNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class ChildNotificationsScheduleDataTableEditor extends DataTablesEditor
{
    protected $table = "child_notifications_schedule";


    protected $model = ChildNotification::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'notification_events' => 'required',
            'notification_message' => 'required',
            'notification_schedule' => 'required',
            'notification_method' => 'required',
            'notification_addresses' => 'required',
            'fk_ChildID' => 'required'

        ];
    }

    /**
     * Get edit action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function editRules(Model $model)
    {
        return [
            'notification_events' => 'required',
            'notification_message' => 'required',
            'notification_schedule' => 'required',
            'notification_method' => 'required',
            'notification_addresses' => 'required',
            'fk_ChildID' => 'required'


        ];
    }

    /**
     * Get remove action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function removeRules(Model $model)
    {
        return [];
    }

    public function creating(Model $model, array $data)
    {
        return $data;

    }

    public function updating(Model $model, array $data)
    {


        return $data;
    }

    public function messages()
    {
        return [
            'fk_ChildID.required' => 'Error: You must assign a Child',
        ];
    }
}

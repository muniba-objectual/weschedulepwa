<?php

namespace App\DataTables;

use App\Models\Shift_Layout_Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class ShiftLayoutDataTableEditor extends DataTablesEditor
{
    protected $table = "shift__layout__templates";


    protected $model = Shift_Layout_Template::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'fk_UserID' => 'required',
            'fk_ChildID' => 'required',
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
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'fk_UserID' => 'required',
            'fk_ChildID' => 'required',

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
            ];
    }
}

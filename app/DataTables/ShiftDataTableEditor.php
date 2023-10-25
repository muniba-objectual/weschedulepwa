<?php

namespace App\DataTables;

use App\Models\Shift;
use App\Models\Shift_Entries;
use App\Models\Shift_Layout_Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class ShiftDataTableEditor extends DataTablesEditor
{


    protected $model = Shift::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'title' => 'required',

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
            'title' => 'required',


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

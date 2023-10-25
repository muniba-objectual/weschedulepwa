<?php

namespace App\DataTables;

use App\Models\Child;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class ChildDataTableEditor extends DataTablesEditor
{
    protected $table = "children";


    protected $model = Child::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'initials' => 'required|unique:children',
            'fk_HomeID' => 'required'
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
            'initials' => 'sometimes|required|' . Rule::unique($model->getTable())->ignore($model->getKey()),
            'fk_HomeID' => 'required'


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
            'fk_HomeID.required' => 'Error: You must assign a default Home',
        ];
    }
}

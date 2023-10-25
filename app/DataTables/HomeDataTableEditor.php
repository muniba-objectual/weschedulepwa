<?php

namespace App\DataTables;

use App\Models\Home;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class HomeDataTableEditor extends DataTablesEditor
{
    protected $table = "homes";


    protected $model = Home::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'name' => 'required|unique:homes',
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
            'name' => 'sometimes|required|' . Rule::unique($model->getTable())->ignore($model->getKey()),


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

<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class UsersDataTableEditor extends DataTablesEditor
{
    protected $model = User::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'email' => 'required|email|unique:users',
            'name'  => 'required',

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
            'email' => 'sometimes|required|email|' . Rule::unique($model->getTable())->ignore($model->getKey()),
            'name'  => 'sometimes|required',



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
        $data['password'] = bcrypt($data['password']);

        return $data;
    }

    public function updating(Model $model, array $data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }

    public function saved(Model $model, array $data)
    {

      if (isset($data['get_assigned_children'])) { //if children have been assigned, update the pivot table


       // $model->load('getAssignedChildren');
        $model->getAssignedChildren()->detach();
        $childrenIDs = array();
        foreach ($data['get_assigned_children'] as $children) {
            $childrenIDs[] = $children['id'];
        }
        $model->getAssignedChildren()->sync($childrenIDs);
        //$model->setAttribute('users_id', $model->user->id);
        //$model->setAttribute('children_id', $model->child->id);

      }
        return $model;
    }
}

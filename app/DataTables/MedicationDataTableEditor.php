<?php

namespace App\DataTables;

use App\Models\Medication_Entry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class MedicationDataTableEditor extends DataTablesEditor
{
    protected $table = "medication_entries";


    protected $model = Medication_Entry::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'medication_type' => 'required',
            //'fk_HomeID' => 'required'
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
            'medication_type' => 'required',
//            'fk_HomeID' => 'required'


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
           // 'fk_HomeID.required' => 'Error: You must assign a default Home',
        ];
    }
}

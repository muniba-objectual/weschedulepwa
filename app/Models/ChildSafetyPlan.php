<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildSafetyPlan extends Model
{
    use HasFactory;

    public $table = "child_safety_plan";

    protected $fillable = [
        'id',
        'fk_ChildID',

        //Emergency Contacts
        'Foster_Parent_Name',
        'Foster_Parent_Address',
        'Foster_Parent_Phone',
        'Case_Manager',

        //Identifying Information

        'Name',
        'DOB',
        'DOA',
        'Status',
        'CSW',
        'Branch',

        //Medical Information
        'Health_Card',
        'Physician',
        'Allergies',
        'Food_Restrictions',
        'Medical_Condition',
        'Medication',
        'PRNs',
        'Diagnosed_With',
        'Risk_of_Injury_Behaviour',
        'Description_of_Specific_Behaviours',
        'Triggers',
        'Indicators',
        'Non-Physical_Responses',
        'Physical_Responses',
        'Additional_Information'

    ];
}

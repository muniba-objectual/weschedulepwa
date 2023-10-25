<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission_Preliminary_Assessment extends Model

{
    protected $table = "admission_preliminary_assessment";

    protected $fillable = [
        'id',
        'fk_UserID',

        'date_of_placement_call',
        'child_name',
        'preferred_pronoun',
        'DOB',
        'fk_CASAgencyID',
        'fk_CASAgencyWorkerID',
        'immediate_needs_of_child',
        'is_child_expected_to_return_home',
        'orientation_to_foster_parent',
        'CSW', //json
        'FSW', //json
        'health_card_number',
        'green_shield_number',
        'wardship_status',
        'gender',
        'ethnicity',
        'reason_in_care',
        'bio_family_information',
        'family_access_visits', //json
        'carpe_diem_foster_home', //FosterHome_fk_UserID?
        'POC_dates',
        'school_information',
        'therapy',
        'medical_concerns',
        'admission_medical',
        'allergies',
        'approval_for_extra_funding_or_clothing_upon_admission',
        'transportation',
        'resource_person',
        'notes',
        'medical_appointments', //json?

        'contract_attachment',
        'active'

    ];
    use HasFactory;
}

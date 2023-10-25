<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission_Form extends Model

{
    protected $table = "admission_form";

    protected $fillable = [
        'id',
        'fk_UserID',
        'date',

        //Identifying Information
        'name_of_child',
        'aliases',
        'preferred_pronoun',
        'DOB',
        'gender',
        'health_card_number',
        'green_shield_number',
        'language',
        'cultural_racial_identity',
        'citizenship_status', //enum('Canadian', 'Landed Immigrant', 'Minister's Permit')
        'religious_affiliation',
        'religious_attends', //enum('Reguarly','Occasionally','Never')
        'indian_status_eligibility', //enum('Yes','No','Unknown')
        'band_name',
        'band_number',

        //PHYSICAL DESCRIPTION OF CHILD
        'color_of_eyes',
        'frame', //enum ('small, medium, large')
        'color_of_hair',
        'current_hairstyle',
        'complexion',
        'weight',
        'height',
        'identifying_characteristics',

        'family_members', //json Name, Address, Phone Number [Mother, Father, Other]
        'siblings', //json - Name, Gender, Age, Whereabouts

        //ADMISSION INFORMATION
        'date_of_admission',
        'admission_type', //enum (New Admission, Re-Admission)
        'is_the_child_youth_expected_to_return_home', //enum (yes/no)
        'circumstances_necessitating_out_of_home_care',
        'child_and_family_reaction_to_admission_plan',
        'current_legal_status', //json (checkbox: Temporary Care Agreement, Interim Care, Society Ward, Crown Ward, Expiry Dates for All)
        'risk_to_foster_parent_safety', //yes/no
        'risk_to_foster_parent_safety_severity', //low/moderate/high
        'risk_to_foster_parent_safety_reason',
        'safety_plan',

        //ADMISSION NEEDS
        'immediate_objectives_of_foster_care',
        'clothing', //enum (adequate, not adequate, to be collected, to be purchased)
        'admission_medical_exam', //json [enum, textbox, date] (to be arranged, by social worker, by foster parent, not required) & reason & date_completed
        'admission_dental_exam', //json [enum, textbox, date] (to be arranged, by social worker, by foster parent, not required) & date_completed
        'school_enrollment', //json [name, type of class, grade], to_continune_in_present_placement / to_enroll_in_area_school / responsibility_for_enrollment (worker, foster parent)

        'immediate_plans_for_family_contact',
        'any_other_immediate_pending_appointments',

        'family_doctor_pediatrician',
        'last_seen',

        'current_medical_problems', //json (textbox + enum (on_medication, pyshotropic drug, needs glasses, communicable disease contact in last six month, other, family_drug_coverage_available, family_dentist, last_seen, current_dental_problems_treatment_issues, family_dental_plan_available)

        'childs_behaviour_for_school_aged_children', //json (behaviour, past, present, comments)
        'childs_behaviour_for_preschoolers', //json (toilet_trained, mobile, ...)
        'childs_behaviour_for_adolescents', //json (YOA involvement, mobile, ...)
        'additional_comments_regarding_behaviour',
        'behaviour_information_provided_by', //enum (Parent/Guardian, Child, CAS)


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

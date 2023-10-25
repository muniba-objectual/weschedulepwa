<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Spatie\Comments\Models\Concerns\HasComments;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use \App\CustomClasses\FosterParentApplicationFormCustomPathGenerator;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class FosterParentApplicationForm extends Model implements HasMedia
{
    use HasFactory, HasComments, InteractsWithMedia;


    public $table = "foster_parent_application_form";

    protected $casts = [
        'family_members' => 'array',
        'family_pets' => 'array',
        'additional_telephone_numbers' => 'array'
    ];


    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    /*
* This string will be used in notifications on what a new comment
* was made.
*/
    public function commentableName(): string
    {
        return auth()->user()->name;
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {
        return "";
        // return 'myUrl';
    }

    public function getFamilyMembersAttribute($details)
    {
       // return $details;
        return json_decode($details, true);
    }

    public function getFamilyPetsAttribute($details)
    {
        // return $details;
        return json_decode($details, true);
    }

    public function getAdditionalTelephoneNumbersAttribute($details)
    {
        // return $details;
        return json_decode($details, true);
    }
    /*
    public function setFamilyMembersAttribute($value)
    {
        $family_members = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['surname_given_name'])) {
                $family_members = $array_item;
            }
        }

        $this->attributes['family_members'] = json_encode($family_members);
    }

    */

    protected $fillable = [
        'fk_UserID',
        'primary_caregiver_fullname',
        'partner_fullname',
        'mailing_address',
        'city',
        'province',
        'postal_code',
        'telephone',
        'email',
        'type_of_family',
        'country_of_birth',
        'city_of_birth',
        'relationship',

        'family_pets',
        'describe_physical_personality_applicants',
        'personal_history_applicants',
        'describe_parents',
        'describe_parents_secondary',

        'describe_home',
        'describe_partner',
        'personal_history_primary_caregiver',
        'personal_history_secondary',

        'primary_caregiver_education',
        'secondary_caregiver_education',
        'primary_caregiver_employment',
        'secondary_caregiver_employment',

        'partner_education',
        'partner_employment',

        'partner_describe_relationship',
        'partner_length_of_relationship',

        'describe_previous_marriage',
        'secondary_describe_previous_marriage',
        'describe_previous_partner_contact',
        'secondary_describe_previous_partner_contact',

        'describe_discipline',
        'describe_communication',

        'describe_problem_solving',
        'problem_solving_example',

        'pattern_daily_living',
        'describe_experience_cultures',

        'open_willing_other_backgrounds',

        'primary_religious_affiliation',
        'primary_spiritual_practices',

        'secondary_religious_affiliation',
        'secondary_spiritual_practices',

        'special_skills',
        'describe_pursuing_fostering',

        'primary_income_source',
        'secondary_income_source',

        'primary_debt_management',
        'secondary_debt_management',

        'primary_bill_management',
        'secondary_bill_management',



        'fulltime_parttime',
        'list_strengths',
        'record_check_CAS',
        'record_check_VSP',

        'basement_apartment',
        'has_drivers_license',

        'date',

        'additional_telephone_numbers'


    ];


}

<?php

namespace App\Http\Livewire\Forms\CaseManage\Mobile;

use Livewire\Component;
use App\Models\User;
use App\Models\FosterParentApplicationForm;
use Carbon\Carbon;
use Livewire\Request;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use App\Http\Controllers\FosterParentApplicationFormFileUploaderController;
class lvMobileFosterParentApplicationForm extends Component
{
  use WithMedia;
    use WithFileUploads;

    public $mediaComponentNames = ['images'];

    public $myUpload;


    public FosterParentApplicationForm $FPAForm;
   public User $user;
    public $userID;

    public $box;

    public $primary_caregiver_fullname;
    public $partner_fullname;
    public $mailing_address;
    public $city;
    public $postal_code;
    public $telephone;
    public $email;

    public $family_members = array();

    public $additional_telephone_numbers = array();

    public $family_pets;
    public $describe_physical_personality_applicants;
    public $personal_history_applicants;
    public $describe_parents;

    public $describe_home;
    public $describe_backyard;
    public $describe_schools;

    public $describe_partner;
    public $personal_history_primary_caregiver;
    public $personal_history_partner;

    public $primary_caregiver_education;
    public $primary_caregiver_employment;

    public $partner_education;
    public $partner_employment;

    public $partner_describe_relationship;
    public $partner_length_of_relationship;

    public $describe_previous_marriage;
    public $describe_previous_partner_contact;

    public $describe_discipline;
    public $describe_communication;

    public $describe_problem_solving;
    public $problem_solving_example;

    public $pattern_daily_living;
    public $describe_experience_cultures;

    public $open_willing_other_backgrounds;

    public $primary_religious_affiliation;
    public $primary_spiritual_practices;

    public $partner_religious_affiliation;
    public $partner_spiritual_practices;

    public $special_skills;
    public $describe_pursuing_fostering;

    public $primary_income_source;
    public $primary_debt_management;
    public $primary_bill_management;

    public $partner_income_source;
    public $partner_debt_management;
    public $partner_bill_management;

    public $fulltime_parttime;
    public $list_strengths;
    public $record_check_CAS;
    public $record_check_VSP;

    public $basement_apartment;
    public $has_drivers_license;

    public $date;

    public $completion_PersonalInformation;

    public $DOB_ageCalc = array();


    public $inputs = [];
    public $images;
    public $tmp_1 = [];
    public $tmp_2 = [];

    protected $listeners = [
        'updateDOB' => 'updateDOB',
        'updateEmail' => 'updateEmail',
        'updateSecondaryEmail' => 'updateSecondaryEmail',
        'updateTelephone' => 'updateTelephone',
        'updateSecondaryTelephone' => 'updateSecondaryTelephone',
        'updatePostal' => 'updatePostal',
        'updateAdditionalTelephone' => 'updateAdditionalTelephone',

    ];


    public function updateEmail($value) {
        if ($value) {
            $this->inputs = $this->FPAForm->family_members;

            $this->FPAForm->email = $value;
            $this->validate();
            $this->FPAForm->save();
        }
        $this->dispatchBrowserEvent('refreshPB');
    }

    public function updatePostal($value) {
        if ($value) {
            $this->inputs = $this->FPAForm->family_members;

            $this->FPAForm->postal_code = $value;
            $this->validate();
            $this->FPAForm->save();
        }

        $this->dispatchBrowserEvent('refreshPB');
    }

    public function updateSecondaryEmail($key, $value) {
        if ($value) {
            $this->inputs = $this->FPAForm->family_members;

            data_set($this->inputs,$key . ".secondary_email", $value);

            $this->inputs = array_values($this->inputs);
            $this->FPAForm->family_members = $this->inputs;

            $this->validate();

            $this->FPAForm->save();

        }
        $this->dispatchBrowserEvent('refreshPB');
    }

    public function updateTelephone($value) {
        $this->inputs = $this->FPAForm->family_members;

        if ($value) {

            $this->FPAForm->telephone = $value;
            $this->validate();
            $this->FPAForm->save();
        }

        $this->dispatchBrowserEvent('refreshPB');
    }

    public function updateSecondaryTelephone($key, $value) {
        $this->inputs = $this->FPAForm->family_members;

        if ($value) {

            data_set($this->inputs,$key . ".secondary_telephone", $value);

            $this->inputs = array_values($this->inputs);
            $this->FPAForm->family_members = $this->inputs;

            $this->validate();

            $this->FPAForm->save();

            $this->dispatchBrowserEvent('refreshPB');
        }
    }

    public function addAdditionalTelephoneNumber()
    {

        $i = count($this->FPAForm->additional_telephone_numbers) + 1;
        $this->i = $i;
        $this->additional_telephone_numbers = $this->FPAForm->additional_telephone_numbers;
        $tmpArray = [
            'telephone' => '',
            'type' => ''

        ];
        array_push($this->additional_telephone_numbers ,$tmpArray);


        $this->additional_telephone_numbers = array_values($this->additional_telephone_numbers);
        $this->FPAForm->additional_telephone_numbers = $this->additional_telephone_numbers;

        $this->validate();

        $this->FPAForm->save();
        $this->dispatchBrowserEvent('refreshPB');
        $this->dispatchBrowserEvent('personal_information_change');


    }

    public function removeAdditionalTelephoneNumber($i) {

        $this->additional_telephone_numbers = array_values($this->additional_telephone_numbers);

        $this->FPAForm->additional_telephone_numbers = $this->additional_telephone_numbers;
        unset($this->additional_telephone_numbers[$i]);

        $this->additional_telephone_numbers = array_values($this->additional_telephone_numbers);
        $this->FPAForm->additional_telephone_numbers = $this->additional_telephone_numbers;


        $this->validate();
        $this->FPAForm->save();
        $this->dispatchBrowserEvent('refreshPB');
        $this->dispatchBrowserEvent('personal_information_change');
    }

    public function updateAdditionalTelephone($key, $value) {
        $this->additional_telephone_numbers = $this->FPAForm->additional_telephone_numbers;

        if ($value) {

            data_set($this->additional_telephone_numbers,$key . ".telephone", $value);

            $this->additional_telephone_numbers = array_values($this->additional_telephone_numbers);
            $this->FPAForm->additional_telephone_numbers = $this->additional_telephone_numbers;

            $this->validate();

            $this->FPAForm->save();

            $this->dispatchBrowserEvent('refreshPB');
        }
    }
    public function updateDOB($elementKey, $value) {
        //dd ($this->inputs[$elementKey]->age_DOB);
        $this->inputs = $this->FPAForm->family_members;
        data_set($this->inputs,$elementKey . ".age_DOB", $value);
      //  $this->FPAForm->family_members = $this->inputs;


        $DOB = Carbon::createFromFormat("d/m/Y",$value);
        $now = Carbon::now();


        if ($DOB->diffInYears($now) == 0) {
            $this->DOB_ageCalc[$elementKey] = "";
        } else {
            $this->DOB_ageCalc[$elementKey] = $DOB->diffInYears($now);
        }

        $this->inputs = array_values($this->inputs);
        $this->FPAForm->family_members = $this->inputs;


        $this->validate();
        $this->FPAForm->save();
        $this->dispatchBrowserEvent('refreshPB');
    }

    public function changeToSecondary($i) {

        $this->inputs = $this->FPAForm->family_members;

        data_set($this->inputs,$i . ".role", "secondary");
        $this->inputs = array_values($this->inputs);
        $this->FPAForm->family_members = $this->inputs;

        $this->validate();
        $this->dispatchBrowserEvent('enableDOBMasks');

        $this->FPAForm->save();
        $this->dispatchBrowserEvent('refreshPB');
        $this->dispatchBrowserEvent('family_composition_change');

    }

    public function removeFromSecondary($i) {

        $this->inputs = $this->FPAForm->family_members;

        data_set($this->inputs,$i . ".role", "other");
        $this->inputs = array_values($this->inputs);
        $this->FPAForm->family_members = $this->inputs;

        $this->validate();
        $this->dispatchBrowserEvent('enableDOBMasks');

        $this->FPAForm->save();
        $this->dispatchBrowserEvent('refreshPB');
        $this->dispatchBrowserEvent('family_composition_change');

    }
    public function addSecondary()
    {

        $i = count($this->FPAForm->family_members) + 1;
        $this->i = $i;
        $this->inputs = $this->FPAForm->family_members;
        $tmpID = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        $this->DOB_ageCalc[$i-1] = '';
        $tmpArray = [
            'id' => $tmpID,
            'age_DOB'=>'01/01/1900',
            'surname_given_name' => '',
            'role' => 'secondary'
            ];
        array_push($this->inputs ,$tmpArray);

       // data_set($this->inputs,$this->i++ . ".age_DOB", "");
      //  data_set($this->inputs,$this->i++ . ".surname_given_name", "");


        $this->inputs = array_values($this->inputs);
        $this->FPAForm->family_members = $this->inputs;

        $this->validate();
        $this->dispatchBrowserEvent('enableDOBMasks');

        $this->FPAForm->save();

        //update rows for the respective notes section
       // $this->emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $height );

        $this->dispatchBrowserEvent('refreshPB');
        $this->dispatchBrowserEvent('family_composition_change');

    }

    public function addOther()
    {

        $i = count($this->FPAForm->family_members) + 1;
        $this->i = $i;
        $this->inputs = $this->FPAForm->family_members;
        $tmpID = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        $this->DOB_ageCalc[$i-1] = '';
        $tmpArray = [
            'id' => $tmpID,
            'age_DOB'=>'01/01/2022',
            'surname_given_name' => '',
            'role' => 'other'
        ];
        array_push($this->inputs ,$tmpArray);

        // data_set($this->inputs,$this->i++ . ".age_DOB", "");
        //  data_set($this->inputs,$this->i++ . ".surname_given_name", "");


        $this->inputs = array_values($this->inputs);
        $this->FPAForm->family_members = $this->inputs;

        $this->validate();
        $this->dispatchBrowserEvent('enableDOBMasks');

        $this->FPAForm->save();

        //update rows for the respective notes section
        // $this->emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $height );

        $this->dispatchBrowserEvent('refreshPB');
        $this->dispatchBrowserEvent('family_composition_change');

    }

    public function remove($i)
    {

        $this->inputs = array_values($this->inputs);
       $this->FPAForm->family_members = $this->inputs;
        unset($this->inputs[$i]);
        $this->dispatchBrowserEvent('family_composition_change');

        $this->inputs = array_values($this->inputs);
        $this->FPAForm->family_members = $this->inputs;


        $this->validate();
        $this->FPAForm->save();

        $this->dispatchBrowserEvent('refreshPB');
        //update rows for the respective notes section
       // $this->emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $height );

    }



    public function render()
    {


         $FPAFormID = $this->FPAForm->id;
         $userID = $this->user->id;
         $FPAForm = $this->FPAForm;
        $this->dispatchBrowserEvent('refreshPB');


//        $this->dispatchBrowserEvent('personal_information_change');
//       $this->dispatchBrowserEvent('family_composition_change');



        return view('livewire.mobile.mobileFosterParentApplicationForm', compact('FPAFormID', 'userID', 'FPAForm'));

    }


    protected $rules = [
        'FPAForm.primary_caregiver_fullname' => 'required',
        'FPAForm.partner_fullname' => 'nullable',
        'FPAForm.mailing_address' => 'nullable',
        'FPAForm.city' => 'nullable',
        'FPAForm.province' => 'nullable',
        'FPAForm.postal_code' => 'nullable',
        'FPAForm.telephone' => 'nullable',
        'FPAForm.additional_telephone_numbers' => 'nullable',
        'FPAForm.additional_telephone_numbers.*.telephone' => 'nullable',
        'FPAForm.additional_telephone_numbers.*.type' => 'nullable',

        'FPAForm.email' => 'nullable',
        'FPAForm.type_of_family' => 'nullable',
        'FPAForm.country_of_birth' => 'nullable',
        'FPAForm.city_of_birth' => 'nullable',
        'FPAForm.relationship' => 'nullable',

      //  'FPAForm.family_members[0][surname_given_name]' => 'nullable',
      //  'FPAForm.family_members[0][age_DOB]' => 'nullable',
        'FPAForm.family_members.*.surname_given_name' => 'nullable',
        'FPAForm.family_members.*.id' => 'nullable',

        'FPAForm.family_members.*.age_DOB' => 'nullable',
        'FPAForm.family_members.*.role' => 'nullable',
        'FPAForm.family_members.*.secondary_email' => 'nullable',
        'FPAForm.family_members.*.secondary_telephone' => 'nullable',
        'FPAForm.family_members.*.secondary_child_welfare_check' => 'nullable',
        'FPAForm.family_members.*.secondary_criminal_reference_check' => 'nullable',
        'FPAForm.family_members.*.secondary_medical' => 'nullable',


        'FPAForm.family_pets' => 'nullable',
        'FPAForm.family_pets.*.name' => 'nullable',
        'FPAForm.family_pets.*.type' => 'nullable',
        'FPAForm.family_pets.*.picture' => 'nullable',
        'FPAForm.family_pets.*.vaccination_certificate' => 'nullable',

        'FPAForm.describe_physical_personality_applicants' => 'nullable',
        'FPAForm.personal_history_applicants' => 'nullable',
        'FPAForm.personal_history_secondary' => 'nullable',

        'FPAForm.describe_parents' => 'nullable',
        'FPAForm.describe_parents_secondary' => 'nullable',

        'FPAForm.describe_home' => 'nullable',
        'FPAForm.describe_backyard' => 'nullable',

        'FPAForm.describe_partner' => 'nullable',
        'FPAForm.personal_history_primary_caregiver' => 'nullable',

        'FPAForm.primary_caregiver_education' => 'nullable',
        'FPAForm.secondary_caregiver_education' => 'nullable',

        'FPAForm.primary_caregiver_employment' => 'nullable',
        'FPAForm.secondary_caregiver_employment' => 'nullable',

        'FPAForm.partner_education' => 'nullable',
        'FPAForm.partner_employment' => 'nullable',

        'FPAForm.partner_describe_relationship' => 'nullable',
        'FPAForm.partner_length_of_relationship' => 'nullable',

        'FPAForm.describe_previous_marriage' => 'nullable',
        'FPAForm.secondary_describe_previous_marriage' => 'nullable',

        'FPAForm.describe_previous_partner_contact' => 'nullable',
        'FPAForm.secondary_describe_previous_partner_contact' => 'nullable',

        'FPAForm.describe_discipline' => 'nullable',
        'FPAForm.describe_communication' => 'nullable',

        'FPAForm.describe_problem_solving' => 'nullable',
        'FPAForm.problem_solving_example' => 'nullable',

        'FPAForm.pattern_daily_living' => 'nullable',
        'FPAForm.describe_experience_cultures' => 'nullable',

        'FPAForm.open_willing_other_backgrounds' => 'nullable',

        'FPAForm.primary_religious_affiliation' => 'nullable',
        'FPAForm.secondary_religious_affiliation' => 'nullable',

        'FPAForm.primary_spiritual_practices' => 'nullable',
        'FPAForm.secondary_spiritual_practices' => 'nullable',


        'FPAForm.special_skills' => 'nullable',
        'FPAForm.describe_pursuing_fostering' => 'nullable',

        'FPAForm.primary_income_source' => 'nullable',
        'FPAForm.primary_debt_management' => 'nullable',
        'FPAForm.primary_bill_management' => 'nullable',

        'FPAForm.secondary_income_source' => 'nullable',
        'FPAForm.secondary_debt_management' => 'nullable',
        'FPAForm.secondary_bill_management' => 'nullable',


        'FPAForm.fulltime_parttime' => 'nullable',
        'FPAForm.list_strengths' => 'nullable',
        'FPAForm.record_check_CAS' => 'nullable',
        'FPAForm.record_check_VSP' => 'nullable',

        'FPAForm.basement_apartment' => 'nullable',
        'FPAForm.has_drivers_license' => 'nullable',

        'FPAForm.date' => 'nullable',
        'FPAForm.describe_schools' => 'nullable',

        'DOB_ageCalc.*' => 'nullable',

    ];

    public function updating () {
      //  $this->dispatchBrowserEvent('refreshPB', []);


    }


//        public function updated($name, $value) {
//            if ($name == "telephone") {
//                $this->telephone = Manny::stripper($this->telephone, ['num']);
//            }
//        }
    public function updated($name, $value)
    {



        /*   if ($name == "FPAForm2.family_members.0.age_DOB") {
               $DOB = Carbon::createFromDate($value);
               $now = Carbon::now();
               if ($DOB->diffInYears($now) == 0) {
                   $this->DOB_ageCalc_0 = "Age: N/A";
               } else {
                   $this->DOB_ageCalc_0 = "Age: " . $DOB->diffInYears($now);
               }
           }*/



        $this->FPAForm->fk_UserID = $this->user->id;

        //$this->FPAForm->family_members = json_encode ($this->family_members);

        //NEED THIS?
       // $this->FPAForm->family_members = $this->inputs;
        //END NEED THIS


        /*
        $this->FPAForm->primary_caregiver_fullname = $this->primary_caregiver_fullname;
        $this->FPAForm->partner_fullname = $this->partner_fullname;
        $this->FPAForm->mailing_address = $this->mailing_address;
        $this->FPAForm->city = $this->city;
        $this->FPAForm->postal_code = $this->postal_code;
        $this->FPAForm->telephone = $this->telephone;
        $this->FPAForm->email = $this->email;
        $this->FPAForm->family_members = $this->family_members;

        $this->FPAForm->family_pets = $this->family_pets;
        $this->FPAForm->describe_physical_personality_applicants = $this->describe_physical_personality_applicants;
        $this->FPAForm->personal_history_applicants = $this->personal_history_applicants;
        $this->FPAForm->describe_parents = $this->describe_parents;

        $this->FPAForm->describe_home = $this->describe_home;
        $this->FPAForm->describe_partner = $this->describe_partner;
        $this->FPAForm->personal_history_primary_caregiver = $this->personal_history_primary_caregiver;
        $this->FPAForm->personal_history_partner = $this->personal_history_partner;

        $this->FPAForm->primary_caregiver_education = $this->primary_caregiver_education;
        $this->FPAForm->primary_caregiver_employment = $this->primary_caregiver_employment;

        $this->FPAForm->partner_education = $this->partner_education;
        $this->FPAForm->partner_employment  = $this->partner_employment;

        $this->FPAForm->partner_describe_relationship = $this->partner_describe_relationship;
        $this->FPAForm->partner_length_of_relationship = $this->partner_length_of_relationship;

        $this->FPAForm->describe_previous_marriage = $this->describe_previous_marriage;
        $this->FPAForm->describe_previous_partner_contact = $this->describe_previous_partner_contact;

        $this->FPAForm->describe_discipline = $this->describe_discipline;
        $this->FPAForm->describe_communication = $this->describe_communication;

        $this->FPAForm->describe_problem_solving = $this->describe_problem_solving;
        $this->FPAForm->problem_solving_example = $this->problem_solving_example;

        $this->FPAForm->pattern_daily_living = $this->pattern_daily_living;
        $this->FPAForm->describe_experience_cultures = $this->describe_experience_cultures;

        $this->FPAForm->open_willing_other_backgrounds = $this->open_willing_other_backgrounds;

        $this->FPAForm->primary_religious_affiliation = $this->primary_religious_affiliation;
        $this->FPAForm->primary_spiritual_practices = $this->primary_spiritual_practices;

        $this->FPAForm->partner_religious_affiliation = $this->partner_religious_affiliation;
        $this->FPAForm->partner_spiritual_practices = $this->partner_spiritual_practices;

        $this->FPAForm->special_skills = $this->special_skills;
        $this->FPAForm->describe_pursuing_fostering = $this->describe_pursuing_fostering;

        $this->FPAForm->primary_income_source = $this->primary_income_source;
        $this->FPAForm->primary_debt_management = $this->primary_debt_management;
        $this->FPAForm->primary_bill_management = $this->primary_bill_management;

        $this->FPAForm->partner_income_source = $this->partner_income_source;
        $this->FPAForm->partner_debt_management = $this->partner_debt_management;
        $this->FPAForm->partner_bill_management = $this->partner_bill_management;

        $this->FPAForm->fulltime_parttime = $this->fulltime_parttime;
        $this->FPAForm->list_strengths = $this->list_strengths;
        //$this->FPAForm->record_check_CAS;
        //$this->FPAForm->record_check_VSP;

        $this->FPAForm->basement_apartment = $this->basement_apartment;
        $this->FPAForm->describe_schools = $this->describe_schools;
*/

        if ($name == "FPAForm.primary_caregiver_fullname") {
            $tmpArray = [
                'age_DOB'=>'',
                'surname_given_name' => $this->FPAForm->primary_caregiver_fullname,
                'role' => 'primary'

            ];
            $this->inputs[0] = $tmpArray;


            $this->inputs = array_values($this->inputs);
            $this->FPAForm->family_members = $this->inputs;
        }
        $this->FPAForm->date = Carbon::now()->toDateTimeString();

        $this->validate();
        $this->FPAForm->save();

//        $this->dispatchBrowserEvent('refreshPB');

    }

    public function mount($userID) {
       //$this->completion_PersonalInformation = 0;
        $this->user = User::where('id','=',$userID)->firstOrFail();
        $this->FPAForm = FosterParentApplicationForm::where('fk_UserID','=',$this->user->id)->firstOrNew([
            'fk_UserID' => $this->user->id,


        ]);

        $this->FPAForm->date = now();

        if(!$this->FPAForm->exists) {
            $this->FPAForm->primary_caregiver_fullname = $this->user->name;
            $this->FPAForm->mailing_address = $this->user->address;
            $this->FPAForm->province = $this->user->province;
            $this->FPAForm->city = $this->user->city;
            $this->FPAForm->postal_code = $this->user->postal;
            $this->FPAForm->email = $this->user->email;

        }

       // $this->images = $this->FPAForm->getMedia('images');
        //dd ($this->images);
        /*'primary_caregiver_fullname' => $this->user->name,
            'mailing_address' => $this->user->address,
            'city' => $this->user->city,
            'postal_code' => $this->user->postal*/

      /*  if ($this->FPAForm->family_members) {

            if (isset($this->FPAForm->family_members[0])) {
                $this->family_members[0] = $this->FPAForm->family_members[0];
                $DOB = Carbon::createFromDate($this->FPAForm->family_members[0]['age_DOB']);
                $now = Carbon::now();

                if ($DOB->diffInYears($now) == 0) {
                    $this->DOB_ageCalc_0 = "Age: N/A";
                } else {
                    $this->DOB_ageCalc_0 = "Age: " . $DOB->diffInYears($now);
                }
            }

            if (isset($this->FPAForm->family_members[1])) {
                $this->family_members[1] = $this->FPAForm->family_members[1];
                $DOB = Carbon::createFromDate($this->FPAForm->family_members[1]['age_DOB']);
                $now = Carbon::now();
                if ($DOB->diffInYears($now) == 0) {
                    $this->DOB_ageCalc_1 = "Age: N/A";
                } else {
                    $this->DOB_ageCalc_1 = "Age: " . $DOB->diffInYears($now);
                }            }

            if (isset($this->FPAForm->family_members[2])) {
                $this->family_members[2] = $this->FPAForm->family_members[2];
                $DOB = Carbon::createFromDate($this->FPAForm->family_members[2]['age_DOB']);
                $now = Carbon::now();
                if ($DOB->diffInYears($now) == 0) {
                    $this->DOB_ageCalc_2 = "Age: N/A";
                } else {
                    $this->DOB_ageCalc_2 = "Age: " . $DOB->diffInYears($now);
                }            }

            if (isset($this->FPAForm->family_members[3])) {
                $this->family_members[3] = $this->FPAForm->family_members[3];
                $DOB = Carbon::createFromDate($this->FPAForm->family_members[3]['age_DOB']);
                $now = Carbon::now();
                if ($DOB->diffInYears($now) == 0) {
                    $this->DOB_ageCalc_3 = "Age: N/A";
                } else {
                    $this->DOB_ageCalc_3 = "Age: " . $DOB->diffInYears($now);
                }            }

            if (isset($this->FPAForm->family_members[4])) {
                $this->family_members[4] = $this->FPAForm->family_members[4];
                $DOB = Carbon::createFromDate($this->FPAForm->family_members[4]['age_DOB']);
                $now = Carbon::now();
                if ($DOB->diffInYears($now) == 0) {
                    $this->DOB_ageCalc_4 = "Age: N/A";
                } else {
                    $this->DOB_ageCalc_4 = "Age: " . $DOB->diffInYears($now);
                }
            }




        }*/


        //$this->i =  count($this->FPAForm->family_members);
        $this->inputs = $this->FPAForm->family_members;

        if ($this->inputs) {
            foreach ($this->inputs as $key=>$input) {

                //dd($input);


                $DOB = Carbon::createFromFormat("d/m/Y", data_get($input,"age_DOB"));


                $now = Carbon::now();


                if ($DOB->diffInYears($now) == 0) {
                    $this->DOB_ageCalc[$key] ="";


                } else {
                    $this->DOB_ageCalc[$key] =  $DOB->diffInYears($now);

                    //$this->inputs[$key]= "Age: " . $DOB->diffInYears($now);
                }

            }
        } else {
            //brand new form, set primary

            if ($this->FPAForm->primary_caregiver_fullname) {
                $tmpArray = [
                    'age_DOB' => '',
                    'surname_given_name' => $this->FPAForm->primary_caregiver_fullname,
                    'role' => 'primary'

                ];
            } else {
                $tmpArray = [
                    'age_DOB' => '',
                    'surname_given_name' => '',
                    'role' => 'primary'

                ];
            }
            $this->inputs[0] = $tmpArray;


            $this->inputs = array_values($this->inputs);
            $this->FPAForm->family_members = $this->inputs;
            $this->dispatchBrowserEvent('family_composition_change');


        }

        $this->email = $this->FPAForm->email;
        $this->telephone = $this->FPAForm->telephone;
        if ($this->FPAForm->family_pets) {
            $this->family_pets = $this->FPAForm->family_pets;
        }

        if ($this->FPAForm->additional_telephone_numbers) {
            $this->additional_telephone_numbers = $this->FPAForm->additional_telephone_numbers;
            $this->dispatchBrowserEvent('personal_information_change');

        }

    }

    public function save() {


    }

    public function updatedImages(){
        dd($this->images);
    }
    public function submitImages() {
       // dd($this->myUpload);
        $this->FPAForm
            ->addFromMediaLibraryRequest($this->myUpload)
            ->toMediaCollection('images');
        $this->save();
    }

    public function submitImages2() {
        //$test = $this->{$key};
        $this->FPAForm
            ->addFromMediaLibraryRequest($this->myUpload)
            ->toMediaCollection('test');

    }

}

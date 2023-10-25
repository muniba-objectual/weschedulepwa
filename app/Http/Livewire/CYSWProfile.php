<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CYSW_Profile;
use App\Models\User;

use App\Models\CYSW_Profile_Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CYSWProfile extends Component
{
    use WithFileUploads;

    public $MyCYSW_Profile;
    public $MyCYSW_Profile_LoadedID = "";

    public User $user;

    public $title;
    public $legal_name;
    public $preferred_name;
    public $SIN;

    public $address;
    public $cellular;
    public $monday = array();
    public $tuesday = array();
    public $wednesday = array();
    public $thursday = array();
    public $friday = array();
    public $saturday = array();
    public $sunday = array();

    public $resume_attachment;

    public $diploma_certificate_1_attachment;
    public $diploma_certificate_2_attachment;
    public $diploma_certificate_3_attachment;
    public $diploma_certificate_4_attachment;
    public $diploma_certificate_5_attachment;

    public $criminal_reference_1_attachment;
    public $criminal_reference_2_attachment;

    public $carpe_diem_confidentiality_attachment;
    public $carpe_diem_release_information_attachment;
    public $child_welfare_check_attachment;

    public $drivers_license_front_attachment;
    public $drivers_license_back_attachment;

    public $auto_insurance_front_attachment;
    public $auto_insurance_back_attachment;

    public $auto_year;
    public $auto_make;
    public $auto_model;
    public $auto_liability;

    public $reference_1_name;
    public $reference_1_phone;
    public $reference_1_email;
    public $reference_1_attachment;

    public $reference_2_name;
    public $reference_2_phone;
    public $reference_2_email;
    public $reference_2_attachment;

    public $reference_3_name;
    public $reference_3_phone;
    public $reference_3_email;
    public $reference_3_attachment;

    public $photo_id_2_front_attachment;
    public $photo_id_2_back_attachment;
    public $covid19_proof_of_vaccination;
    public $bank_name;
    public $transit;
    public $institution;
    public $account_number;
    public $banking_attachment;

    public $vaccination_status;



    protected $listeners = [
        'refreshme' => '$refresh',
    ];
    public function render()
    {

        return view('livewire.cyswprofile');
    }

    protected $rules = [
        //'name' => 'required',
    ];

    public function updated($propertyName)
    {
       // $this->validateOnly($propertyName);
    }


    public function save()   {
      //  $this->validate();

        // Execution doesn't reach here if validation fails.

        if ($this->MyCYSW_Profile_LoadedID) {
        //    $this->MyCYSW_Profile->name = $this->name;
          //  $this->MyCYSW_Profile->address = $this->address;
            $this->MyCYSW_Profile->title = $this->title;
            $this->MyCYSW_Profile->legal_name = $this->legal_name;
            $this->MyCYSW_Profile->preferred_name = $this->preferred_name;
            $this->MyCYSW_Profile->SIN = $this->SIN;

            $this->MyCYSW_Profile->cellular = $this->cellular;
            $this->MyCYSW_Profile->monday = implode(";",$this->monday);
            $this->MyCYSW_Profile->tuesday = implode(";",$this->tuesday);
            $this->MyCYSW_Profile->wednesday = implode(";",$this->wednesday);
            $this->MyCYSW_Profile->thursday = implode(";",$this->thursday);
            $this->MyCYSW_Profile->friday = implode(";",$this->friday);
            $this->MyCYSW_Profile->saturday = implode(";",$this->saturday);
            $this->MyCYSW_Profile->sunday = implode(";",$this->sunday);

            $this->MyCYSW_Profile->reference_1_name = $this->reference_1_name;
            $this->MyCYSW_Profile->reference_2_name = $this->reference_2_name;
            $this->MyCYSW_Profile->reference_3_name = $this->reference_3_name;

            $this->MyCYSW_Profile->reference_1_phone = $this->reference_1_phone;
            $this->MyCYSW_Profile->reference_2_phone = $this->reference_2_phone;
            $this->MyCYSW_Profile->reference_3_phone = $this->reference_3_phone;

            $this->MyCYSW_Profile->reference_1_email = $this->reference_1_email;
            $this->MyCYSW_Profile->reference_2_email = $this->reference_2_email;
            $this->MyCYSW_Profile->reference_3_email = $this->reference_3_email;

            $this->MyCYSW_Profile->auto_year = $this->auto_year;
            $this->MyCYSW_Profile->auto_make = $this->auto_make;
            $this->MyCYSW_Profile->auto_model = $this->auto_model;
            $this->MyCYSW_Profile->auto_liability = $this->auto_liability;

            $this->MyCYSW_Profile->bank_name = $this->bank_name;
            $this->MyCYSW_Profile->transit = $this->transit;
            $this->MyCYSW_Profile->institution = $this->institution;
            $this->MyCYSW_Profile->account_number = $this->account_number;
            $this->MyCYSW_Profile->banking_attachment = $this->banking_attachment;

            $this->MyCYSW_Profile->vaccination_status = $this->vaccination_status;



            if (is_object($this->reference_1_attachment)) {
                $tmpStore = $this->reference_1_attachment->store('/public/CYSW_Profiles/References');
                $this->MyCYSW_Profile->reference_1_attachment = $tmpStore;
            }

            if (is_object($this->reference_2_attachment)) {
                $tmpStore = $this->reference_2_attachment->store('/public/CYSW_Profiles/References');
                $this->MyCYSW_Profile->reference_2_attachment = $tmpStore;
            }

            if (is_object($this->reference_3_attachment)) {
                $tmpStore = $this->reference_3_attachment->store('/public/CYSW_Profiles/References');
                $this->MyCYSW_Profile->reference_3_attachment = $tmpStore;
            }


            if (is_object($this->diploma_certificate_1_attachment)) {
                $tmpStore = $this->diploma_certificate_1_attachment->store('/public/CYSW_Profiles/Diploma_Certificate');
                $this->MyCYSW_Profile->diploma_certificate_1_attachment = $tmpStore;
            }

            if (is_object($this->diploma_certificate_2_attachment)) {
                $tmpStore = $this->diploma_certificate_2_attachment->store('/public/CYSW_Profiles/Diploma_Certificate');
                $this->MyCYSW_Profile->diploma_certificate_2_attachment = $tmpStore;
            }

            if (is_object($this->diploma_certificate_3_attachment)) {
                $tmpStore = $this->diploma_certificate_3_attachment->store('/public/CYSW_Profiles/Diploma_Certificate');
                $this->MyCYSW_Profile->diploma_certificate_3_attachment = $tmpStore;
            }

            if (is_object($this->diploma_certificate_4_attachment)) {
                $tmpStore = $this->diploma_certificate_4_attachment->store('/public/CYSW_Profiles/Diploma_Certificate');
                $this->MyCYSW_Profile->diploma_certificate_4_attachment = $tmpStore;
            }

            if (is_object($this->diploma_certificate_5_attachment)) {
                $tmpStore = $this->diploma_certificate_5_attachment->store('/public/CYSW_Profiles/Diploma_Certificate');
                $this->MyCYSW_Profile->diploma_certificate_5_attachment = $tmpStore;
            }

            if (is_object($this->resume_attachment)) {
                $tmpStore = $this->resume_attachment->store('/public/CYSW_Profiles/Resume');
                $this->MyCYSW_Profile->resume_attachment = $tmpStore;
            }

            if (is_object($this->carpe_diem_release_information_attachment)) {
                $tmpStore = $this->carpe_diem_release_information_attachment->store('/public/CYSW_Profiles/Carpe_Diem');
                $this->MyCYSW_Profile->carpe_diem_release_information_attachment = $tmpStore;
            }

            if (is_object($this->carpe_diem_confidentiality_attachment)) {
                $tmpStore = $this->carpe_diem_confidentiality_attachment->store('/public/CYSW_Profiles/Carpe_Diem');
                $this->MyCYSW_Profile->carpe_diem_confidentiality_attachment = $tmpStore;
            }

            if (is_object($this->child_welfare_check_attachment)) {
                $tmpStore = $this->child_welfare_check_attachment->store('/public/CYSW_Profiles/Carpe_Diem');
                $this->MyCYSW_Profile->child_welfare_check_attachment = $tmpStore;
            }

            if (is_object($this->drivers_license_front_attachment)) {
                $tmpStore = $this->drivers_license_front_attachment->store('/public/CYSW_Profiles/Drivers_License');
                $this->MyCYSW_Profile->drivers_license_front_attachment = $tmpStore;
            }

            if (is_object($this->drivers_license_back_attachment)) {
                $tmpStore = $this->drivers_license_back_attachment->store('/public/CYSW_Profiles/Drivers_License');
                $this->MyCYSW_Profile->drivers_license_back_attachment = $tmpStore;
            }

            if (is_object($this->auto_insurance_front_attachment)) {
                $tmpStore = $this->auto_insurance_front_attachment->store('/public/CYSW_Profiles/Insurance');
                $this->MyCYSW_Profile->auto_insurance_front_attachment = $tmpStore;
            }

            if (is_object($this->auto_insurance_back_attachment)) {
                $tmpStore = $this->auto_insurance_back_attachment->store('/public/CYSW_Profiles/Insurance');
                $this->MyCYSW_Profile->auto_insurance_back_attachment = $tmpStore;
            }


            if (is_object($this->criminal_reference_1_attachment)) {
                $tmpStore = $this->criminal_reference_1_attachment->store('/public/CYSW_Profiles/Criminal_Reference_Check');
                $this->MyCYSW_Profile->criminal_reference_1_attachment = $tmpStore;
            }

            if (is_object($this->criminal_reference_2_attachment)) {
                $tmpStore = $this->criminal_reference_2_attachment->store('/public/CYSW_Profiles/Criminal_Reference_Check');
                $this->MyCYSW_Profile->criminal_reference_2_attachment = $tmpStore;
            }

            if (is_object($this->photo_id_2_front_attachment)) {
                $tmpStore = $this->photo_id_2_front_attachment->store('/public/CYSW_Profiles/Carpe_Diem');
                $this->MyCYSW_Profile->photo_id_2_front_attachment = $tmpStore;
            }

            if (is_object($this->photo_id_2_back_attachment)) {
                $tmpStore = $this->photo_id_2_back_attachment->store('/public/CYSW_Profiles/Carpe_Diem');
                $this->MyCYSW_Profile->photo_id_2_back_attachment = $tmpStore;
            }

            if (is_object($this->covid19_proof_of_vaccination)) {
                $tmpStore = $this->covid19_proof_of_vaccination->store('/public/CYSW_Profiles/Carpe_Diem');
                $this->MyCYSW_Profile->covid19_proof_of_vaccination = $tmpStore;
            }

            if (is_object($this->banking_attachment)) {
                $tmpStore = $this->banking_attachment->store('/public/CYSW_Profiles/Banking');
                $this->MyCYSW_Profile->banking_attachment = $tmpStore;
            }





            $this->MyCYSW_Profile->save();
            return redirect()->back()->with('message', 'CYSW Profile has been updated successfully.');

            //  redirect()->to('/mobile/MyProfile/' . $this->user->id);

        } else {
           //should never execute as we are always updating the record as per firstOrCreate
            /*
            $tmpStore = $this->reference_1_attachment->store('/public/CYSW_Profiles/References');

            $this->MyCYSW_Profile_LoadedID = CYSW_Profile_Model::create([
                'fk_UserID' => Auth::user()->id,
                'name' => $this->name,
                'address' => $this->address,
                'cellular' => $this->cellular,
                'monday' => implode(";",$this->monday),
                'tuesday' => implode(";",$this->tuesday),
                'wednesday' => implode(";",$this->wednesday),
                'thursday' => implode(";",$this->thursday),
                'friday' => implode(";",$this->friday),
                'saturday' => implode(";",$this->saturday),
                'sunday' => implode(";",$this->sunday),
                'reference_1_attachment' => $tmpStore,
            ]);
            */
            $this->loadRecord();
        }

       // $this->emit('refreshme');

       //$this->MyCYSW_Profile->refresh();

        //$this->emit('$refresh');
    }

    public function loadRecord() {
        //$this->MyCYSW_Profile = CYSW_Profile_Model::firstOrCreate(['fk_UserID'=>Auth::id()]);
        $this->MyCYSW_Profile = CYSW_Profile_Model::firstOrCreate(['fk_UserID'=>$this->user->id]);
        //$this->MyCYSW_Profile = CYSW_Profile_Model::where('fk_UserID',Auth::id())->first();
        if ($this->MyCYSW_Profile) {
            $this->MyCYSW_Profile_LoadedID = $this->MyCYSW_Profile->id;
            //$this->name = $this->MyCYSW_Profile->name;
            //$this->address = $this->MyCYSW_Profile->address;
            $this->title = $this->MyCYSW_Profile->title;
            $this->legal_name = $this->MyCYSW_Profile->legal_name;
            $this->preferred_name = $this->MyCYSW_Profile->preferred_name;
            $this->SIN = $this->MyCYSW_Profile->SIN;

            $this->cellular = $this->MyCYSW_Profile->cellular;

            $this->resume_attachment = $this->MyCYSW_Profile->resume_attachment;

            $this->reference_1_name = $this->MyCYSW_Profile->reference_1_name;
            $this->reference_1_phone = $this->MyCYSW_Profile->reference_1_phone;
            $this->reference_1_email = $this->MyCYSW_Profile->reference_1_email;
            $this->reference_1_attachment = $this->MyCYSW_Profile->reference_1_attachment;

            $this->reference_2_name = $this->MyCYSW_Profile->reference_2_name;
            $this->reference_2_phone = $this->MyCYSW_Profile->reference_2_phone;
            $this->reference_2_email = $this->MyCYSW_Profile->reference_2_email;
            $this->reference_2_attachment = $this->MyCYSW_Profile->reference_2_attachment;

            $this->reference_3_name = $this->MyCYSW_Profile->reference_3_name;
            $this->reference_3_phone = $this->MyCYSW_Profile->reference_3_phone;
            $this->reference_3_email = $this->MyCYSW_Profile->reference_3_email;
            $this->reference_3_attachment = $this->MyCYSW_Profile->reference_3_attachment;

            $this->diploma_certificate_1_attachment = $this->MyCYSW_Profile->diploma_certificate_1_attachment;
            $this->diploma_certificate_2_attachment = $this->MyCYSW_Profile->diploma_certificate_2_attachment;
            $this->diploma_certificate_3_attachment = $this->MyCYSW_Profile->diploma_certificate_3_attachment;
            $this->diploma_certificate_4_attachment = $this->MyCYSW_Profile->diploma_certificate_4_attachment;
            $this->diploma_certificate_5_attachment = $this->MyCYSW_Profile->diploma_certificate_5_attachment;

            $this->criminal_reference_1_attachment = $this->MyCYSW_Profile->criminal_reference_1_attachment;
            $this->criminal_reference_2_attachment = $this->MyCYSW_Profile->criminal_reference_2_attachment;

            $this->carpe_diem_confidentiality_attachment = $this->MyCYSW_Profile->carpe_diem_confidentiality_attachment;
            $this->carpe_diem_release_information_attachment = $this->MyCYSW_Profile->carpe_diem_release_information_attachment;
            $this->child_welfare_check_attachment = $this->MyCYSW_Profile->child_welfare_check_attachment;


            $this->drivers_license_front_attachment = $this->MyCYSW_Profile->drivers_license_front_attachment;
            $this->drivers_license_back_attachment = $this->MyCYSW_Profile->drivers_license_back_attachment;

            $this->auto_insurance_front_attachment = $this->MyCYSW_Profile->auto_insurance_front_attachment;
            $this->auto_insurance_back_attachment = $this->MyCYSW_Profile->auto_insurance_back_attachment;

            $this->photo_id_2_front_attachment = $this->MyCYSW_Profile->photo_id_2_front_attachment;
            $this->photo_id_2_back_attachment = $this->MyCYSW_Profile->photo_id_2_back_attachment;

            $this->covid19_proof_of_vaccination = $this->MyCYSW_Profile->covid19_proof_of_vaccination;

            $this->auto_year = $this->MyCYSW_Profile->auto_year;
            $this->auto_make = $this->MyCYSW_Profile->auto_make;
            $this->auto_model = $this->MyCYSW_Profile->auto_model;
            $this->auto_liability = $this->MyCYSW_Profile->auto_liability;


            $this->bank_name = $this->MyCYSW_Profile->bank_name;
            $this->transit = $this->MyCYSW_Profile->transit;
            $this->institution = $this->MyCYSW_Profile->institution;
            $this->account_number = $this->MyCYSW_Profile->account_number;
            $this->banking_attachment = $this->MyCYSW_Profile->banking_attachment;

            $this->vaccination_status = $this->MyCYSW_Profile->vaccination_status;


            $this->monday = $this->MyCYSW_Profile->monday;
                // get an array of ids
                $setOfIds = explode(";",$this->monday);
                $this->monday = $setOfIds;

            $this->tuesday = $this->MyCYSW_Profile->tuesday;
            // get an array of ids
            $setOfIds = explode(";",$this->tuesday);
            $this->tuesday = $setOfIds;

            $this->wednesday = $this->MyCYSW_Profile->wednesday;
            // get an array of ids
            $setOfIds = explode(";",$this->wednesday);
            $this->wednesday = $setOfIds;

            $this->thursday = $this->MyCYSW_Profile->thursday;
            // get an array of ids
            $setOfIds = explode(";",$this->thursday);
            $this->thursday = $setOfIds;

            $this->friday = $this->MyCYSW_Profile->friday;
            // get an array of ids
            $setOfIds = explode(";",$this->friday);
            $this->friday = $setOfIds;

            $this->saturday = $this->MyCYSW_Profile->saturday;
            // get an array of ids
            $setOfIds = explode(";",$this->saturday);
            $this->saturday = $setOfIds;

            $this->sunday = $this->MyCYSW_Profile->sunday;
            // get an array of ids
            $setOfIds = explode(";",$this->sunday);
            $this->sunday = $setOfIds;


        } else {
            $this->MyCYSW_Profile_LoadedID = "";
        }

    }
    public function mount(CYSW_Profile_Model $MyCYSW_Profile) {

      //  $this->user = Auth::user();

        $this->loadRecord();




    }
}

<?php

namespace App\Http\Livewire\Forms\CaseManage\Temp;

use App\CustomClasses\UserFormComponent;
use App\Models\Child;
use App\Models\DocumentFile;
use App\Models\DocumentShare;
use App\Models\PlacingAgencyWorkers;
use App\Models\TempFormData;
use DOMDocument;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class PreAdmissions extends Component
{
    use UserFormComponent;

    protected $listeners    = [
        'writeEmailBody',
    ];

    public function render()
    {
        if($this->printMode){
            return view('livewire.forms.case-manage.temp.carpe-diem.pre-admissions-pdf');
        }
        return view('livewire.forms.case-manage.temp.pre-admissions2');
    }


    public function onEmail(): void
    {
        /**
         * @var TempFormData $form
         * @var Child $child
         * @var PlacingAgencyWorkers $worker
         */

        //The Json Form
        $form = TempFormData::find($this->formDataId);
        $formType = TempFormData::translateTypeToIndex(TempFormData::PRE_ADMISSIONS);

        if( ($this->formData['is_child_appropriate_for_placement']??0) == 1 ){

            //find or new Child
            $child = Child::query()->where('pre_admissions_form_id', $this->formDataId)->first();

            if(is_null($child)){
                $child = new Child();
                $child->pre_admissions_form_id = $form->id; //attach new form to new child

                $CmCHildProfile = new \App\Models\CM_Child_Profile(); //cerate new profile
            }else{
                $CmCHildProfile = \App\Models\CM_Child_Profile::query()
                    ->where('fk_ChildID', $child->id)
                    ->firstOrNew(); //there may or may not be a profile, create if does not exists
            }

            //fill in child model data
            $child->status = "Pending";

            //fill child model
            $this->mapFillByForm($child,[
                'fk_CASAgencyID'        => 'placing_agency_id',
                'FosterHome_fk_UserID'  => 'foster_parent_id',
                'fk_CASAgencyWorkerID'  => 'placement_worker_id',
                'DOB'                   => 'child_dob',
                'initials'              => 'child_name',
            ]);

            //fill profile model
            $this->mapFillByForm($CmCHildProfile, [
                'pronoun'               => 'child_identity_or_pro_nouns',
                'legal_status'          => 'care_status',
                'date_of_birth'         => 'child_dob',

                //MISSING ON THE PRE-ADMISSION FORM
//            'preferred_name'        => '',
//            'legal_name'            => '',
//            'gender'                => '',
//            'health_card_number'    => '',
//            'green_shield_number'   => '',
            ]);


            //Fields to check
//            cultural_religious_background_custom_value
//            hair_colour_custom_value
//            eye_colour_custom_custom_valuealue
//            ethic_background_custom_value
//            care_status_custom_value
//            languages_custom_value

            Schema::disableForeignKeyConstraints();
            $child->save();
            $CmCHildProfile->fk_ChildID = $child->id;
            $CmCHildProfile->save();
            Schema::enableForeignKeyConstraints();
        }



        //call Email popup on if logic is met
        if( isset($this->formData['placement_worker_id']) && isset($this->formData['child_name']) ){

            //derive the email of the placement-worker
            $worker = \App\Models\PlacingAgencyWorkers::find($this->formData['placement_worker_id']);
            $email = $worker->email;

            //register document as a separate frozen version
            $document = \App\Models\DocumentFile::query()->create([
                'file_name'         => "{$this->formData['child_name']} Pre-Admission-Form ".now(),
                'file_meta_info'    => ['data' => $this->formData, 'form_type' => $formType, 'form_id' => $form->id],
                'directory_path'    => null,
                'file_category'     => DocumentFile::CATEGORY_DYNAMIC_FORM,
            ]);

            //generate a share logic for the document
            $share = \App\Models\DocumentShare::CreateFileLink(document: $document, email: $email, expiresInHours: (7*24), recipientName: $worker->name);

            //build email body (auto saved)
            $this->writeEmailBody($share)
                ->save();

            $this->emit('setSubject', "Carpe Diem - Pre-Admission Request");
            $this->emit('initEmailConf',  $share->id, $this->formDataId, self::class);
            $this->dispatchBrowserEvent('open-email-prompt');
        }
    }


    public static function afterEmailSent(\App\Models\DocumentShare $share, TempFormData $form): void
    {
        //$form = TempFormData::find( $share->document->file_meta_info['form_id'] );

        activity('PreAdmissionEmailed')
            ->causedBy(auth()->user())
            ->performedOn($share)
            ->event("PreAdmissionEmailed")
            ->withProperties([
                'form-data'     => $form->toArray(),
                'documentShare' => $share->toArray()
            ])
            ->log("Email the Pre-Admission Form");


        /**
         * @var \App\Models\PlacingAgency $placementAgency
         * @var \App\Models\PlacingAgencyWorkers $worker
         */
        $placementAgency = \App\Models\PlacingAgency::find($form->getVal('placing_agency_id'));
        $worker = \App\Models\PlacingAgencyWorkers::find($form->getVal('placement_worker_id'));

        activity('AssignedChildToPlacementWorker')
            ->causedBy(auth()->user())
            ->performedOn($placementAgency)
            ->event("AssignedChildToPlacementWorker")
            ->withProperties([
                'worker'    => $worker->toArray(),
                'agency'    => $placementAgency->toArray(),
                'form-data'     => $form->toArray(),
            ])
            ->log("Pre-admission assigned to placement-worker, {$worker->name}");
    }

    public static function writeEmailBody(DocumentShare &$share): DocumentShare
    {
        $hidePassword = true;

        if(is_null($share->download_html)){
            $share->download_html = Blade::render(<<<'blade'
               Hi {{$share->recipient_name}},
               <br/>
               <br/>You have a new Pre-Admission document to review!
               <br/>
               <br/>Please click on the <a id="document-link" href="{{$share->getUrl()}}" target="_blank">following link</a> to download your secure document.
                <!--               <br/><a id="document-link" href="{{$share->getUrl()}}" target="_blank">{{$share->getUrl()}}</a>-->
               @unless($hidePassword)
               <br/>
               <br/>Document Password: <span id="doc_password">{{$share->password}}</span>
               <br/>*Document password is only shown for testing purposes and will not be included in the email.
               @endunless
               <br/>
               <br/>This link will expire on <span id="doc_link_expire_at">{{$share->link_expire_at}}</span>
               <br/>
               <br/>Thank You,
               <br/>{{Auth::user()->name}}
               <br/>Carpe Diem Residential Therapeutic Treatment Homes for Children
            blade, compact('share', 'hidePassword'));

        }else{
            $func = (function(&$html, $elementId, string $innerHtml = null, $attributes =[ ]) {

                // Create a DOMDocument object and load the HTML
                $dom = new DOMDocument();
                $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                // Find the element by its ID
                $element = $dom->getElementById($elementId);

                // Check if the element exists
                if ($element) {
                    foreach ($attributes as $key => $value){
                        // Modify the element attributes
                        $element->setAttribute($key, $value);
                    }
                    if(!is_null($innerHtml)){
                        $element->nodeValue = $innerHtml;
                    }

                }

                // Get the modified HTML
                $html = $dom->saveHTML();
                return $html;
            });


            //modify the properties
            $html = $share->download_html; //assigning to variable since it passed by reference

            if(!$hidePassword){
                //update password in the email body if changed
                $func($html, elementId: 'doc_password', innerHtml: $share->password);
            }

            //update expire_at in the email body if changed
            $func($html, elementId: 'doc_link_expire_at', innerHtml: $share->link_expire_at);

            //update url in the email body if expire_at changed
            $url = $share->getUrl();
            $func($html, elementId: 'document-link', attributes: ['href' => $url]);

            $share->download_html = $html;
        }
        return $share;
    }

    protected function afterMount(){
        if( !isset($this->formData['created_by']['id']) ){
            $user = auth()->user();
            $this->formData['created_by']['id']     = $user->id;
            $this->formData['created_by']['name']   = $user->name;
            $this->submit();
        }
    }
}


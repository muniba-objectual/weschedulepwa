<?php

namespace App\Http\Livewire;

use App\Models\Child;
use App\Models\ChildSafetyForm;
use App\Models\ChildSafetyPlanVersion;
use App\Models\DocumentFile;
use App\Models\DocumentShare;
use App\Models\PlacingAgencyWorkers;
use App\Models\TempFormData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use DOMDocument;
class SafetyPlanTable extends Component
{

    public $saftyPlanChildId;
    public $childName;

    protected $listeners = [
        'createSafetyAssessment'
    ];

    public function createSafetyAssessment(){

        //TODO::ashain,optimize this!
        /** @var Child $child */
        $child = Child::find($this->saftyPlanChildId);
        $safetyPlans = $child->allSafetyPlans;

        foreach ($safetyPlans as $safetyPlan) {
            if ($safetyPlan->pivot->deactivated_at == null) {
                $safetyPlan->pivot->deactivated_at = Carbon::now();
                $safetyPlan->pivot->save();
            }
        }

        //create the safety plan
        $form = ChildSafetyForm::create([
            'form' => ChildSafetyForm::SAFETY_PLAN,
            'raw_data' => json_encode([
                "aad" => $child->DOB,
                "aac" => $child->initials, //$child->getCMProfile->legal_name
                "aai" => $child->getCMProfile->legal_status,
                "aap" => $child->getCMProfile->health_card_number,
            ]),
        ]);


        $child->safetyPlan()->attach($form->id, [
            'child_id'      => $child->id,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);
    }

    public function createACloneForReviewPurpose($versionId)
    {
        $v2 = ChildSafetyPlanVersion::findOrFail($versionId)->createACloneForReviewPurpose();
        return Redirect::to("/TestFormBuilder/2/{$v2->form_id}/?back-text=Child {$this->childName} Review&back-url=/children/{$this->saftyPlanChildId}#safety_forms");
    }

    public function deleteForm($versionId)
    {
        $version = ChildSafetyPlanVersion::findOrFail($versionId);
        $version->form->delete();
        $version->delete();
    }


    public function createACloneForAnotherReviewPurpose($versionId){
        $v2 = ChildSafetyPlanVersion::findOrFail($versionId)->createACloneForAnotherReviewPurpose();
        return Redirect::to("/TestFormBuilder/2/{$v2->form_id}/?back-text=Child {$this->childName} Review&back-url=/children/{$this->saftyPlanChildId}#safety_forms");
    }

    public function createACloneForNewAssessmentPurpose($versionId){
        ChildSafetyPlanVersion::findOrFail($versionId)->createACloneForNewAssessmentPurpose();

        // Refresh the component to reflect the changes
        $this->render();
    }

    public function mount(Child $child){
        $this->saftyPlanChildId = $child->id;
        $this->childName = $child->initials;
    }

    public function render()
    {
        $versions = ChildSafetyPlanVersion::query()
            ->where('child_id', $this->saftyPlanChildId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.safety-plan-table', ['versions' => $versions]);
    }

    public  function onEmail($id): void
    {
        /**
         * @var TempFormData $form
         * @var Child $child
         * @var PlacingAgencyWorkers $worker
         */

        //The Json Form
        $form = TempFormData::find($id);
        $formType = TempFormData::translateTypeToIndex(TempFormData::SAFETY_PLAN);

        $mapping = \App\Models\ChildSafetyPlanVersion::query()->where('form_id', $id)->firstOrFail();
        $this->formStageIndex   = $mapping->form_stage;
        $this->readOnlyForm     = $mapping->form_stage == 2;
        $this->mapId            = $mapping->id;

        //call Email popup on if logic is met

        //derive the email of the placement-worker
//            $worker = \App\Models\PlacingAgencyWorkers::first();

        $child = Child::find($this->saftyPlanChildId);
        $workerName = "";
        $email = "";
        if ($child->getCASAgencyWorker) {
            $workerEmail = $child->getCASAgencyWorker->email;
            $workerName = $child->getCASAgencyWorker->name;
        }

//            $email = $email ? $workerEmail : "[Email address not found for Placement Worker]";

        //register document as a separate frozen version
        $document = \App\Models\DocumentFile::query()->create([
            'file_name'         => "Safety Assessment - Safety Form ".now(),
            'file_meta_info'    => ['data' => '', 'form_type' => $formType, 'form_id' => $form->id],
            'directory_path'    => null,
            'file_category'     => DocumentFile::CATEGORY_DYNAMIC_FORM,
        ]);

        //generate a share logic for the document
        $share = \App\Models\DocumentShare::CreateFileLink(document: $document, email: $workerEmail  ?? "" ?:  "[Email address not found for Placement Worker]", expiresInHours: (7*24), recipientName: $workerName ?? "" ?: "[Name not found for Placement Worker");

        //build email body (auto saved)
        $this->writeEmailBody($share)
            ->save();

        $this->emit('setSubject', "Carpe Diem - Safety Assessment/Safety Plan Request");
        $this->emit('initEmailConf',  $share->id, $form->id, self::class);
        $this->dispatchBrowserEvent('open-email-prompt');
    }



    public static function afterEmailSent(\App\Models\DocumentShare $share, TempFormData $form): void
    {
        //$form = TempFormData::find( $share->document->file_meta_info['form_id'] );

        activity('SafetyPlanEmailed')
            ->causedBy(auth()->user())
            ->performedOn($share)
            ->event("SafetyPlanEmailed")
            ->withProperties([
                'form-data' => $form->toArray(),
                'documentShare' => $share->toArray()
            ])
            ->log("Emailed the Safety Plan/Assessment Form");


    }

    public static function writeEmailBody(DocumentShare &$share): DocumentShare
    {
        $hidePassword = true;

        if(is_null($share->download_html)){

            $share->download_html = Blade::render(<<<'blade'
               Hi {{$share->recipient_name}},
               <br/>
               <br/>You have a new Safety Assessment/Plan document to review!
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

}

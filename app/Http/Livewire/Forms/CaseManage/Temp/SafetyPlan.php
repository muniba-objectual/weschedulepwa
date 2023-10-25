<?php

namespace App\Http\Livewire\Forms\CaseManage\Temp;

use App\CustomClasses\UserFormComponent;
use App\Models\Child;
use App\Models\DocumentFile;
use App\Models\DocumentShare;
use App\Models\PlacingAgencyWorkers;
use App\Models\TempFormData;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use DOMDocument;

class SafetyPlan extends Component
{
    use UserFormComponent;
    use LivewireAlert;
    public $makePDF;

    public $canSubmitAssessment = false;

    public $needsASafetyPlan = false;

    public $formStageIndex;
    public $mapId;
    public $redirectBackTo;


    protected $listeners    = [
        'writeEmailBody', 'onEmail'
    ];

    public function render()
    {
        if ($this->makePDF) {
            $this->printMode = true;

        }
        return view('livewire.forms.case-manage.temp.safety-plan2');
    }


    private function evaluateSafetyPlaneNecessity(): void
    {
        //Based on the results of the safety assessment, does the child engage in behaviours that may pose a risk to the safety of themselves or others or are there other risks to the safety of the child? == NO;
        $logic1 = $this->formData['is_child_behavior_and_safety_risky']??null;

        //Is it the view of the person who is placing or who placed the child or the placing agency, as the case may be, that a safety plan is needed? == NO;
        $logic2 = $this->formData['placer_recommends_safety_plan']??null;

        /**
        | logic1| logic2| Safety |
        |-------|-------|--------|
        |   0   |   0   |   0    |
        |   0   |   1   |   1    |
        |   1   |   0   |   1    |
        |   1   |   1   |   1    |
        */

        $this->needsASafetyPlan = !(!$logic1 && !$logic2);
    }


    public function submitAssessment()
    {
        if( $this->canSubmitAssessment() ){
            /** @var \App\Models\ChildSafetyPlanVersion $mapping */
            $mapping = \App\Models\ChildSafetyPlanVersion::query()->findOrFail( $this->mapId);
            $mapping->form_stage = 1; //mark as submitted on the mapping
            $mapping->deactivated_at = now();
            $mapping->save();
            $this->submit();

            //redirect to previous location if set.
            if($this->redirectBackTo){
                return redirect($this->redirectBackTo)->with('message', 'Submitted successfully.');
            }
        }
    }


    public function submitReview()
    {
        /** @var \App\Models\ChildSafetyPlanVersion $mapping */
        $mapping = \App\Models\ChildSafetyPlanVersion::query()->findOrFail( $this->mapId);
        $mapping->form_stage = 2; //mark as reviewed on the mapping
        $mapping->save();
        $this->submit();

        //redirect to previous location if set.
        if($this->redirectBackTo){
            return redirect($this->redirectBackTo)->with('message', 'Submitted successfully.');
        }
    }


    private function canSubmitAssessment(): bool
    {
        return
            //safety plan questions has to be answered, before submitting
            isset($this->formData['is_child_behavior_and_safety_risky']) &&
            isset($this->formData['placer_recommends_safety_plan']);
    }


    protected function afterMount(): void
    {
        //store previous location, (depends on the URL params)
        $this->redirectBackTo = request()->query('back-url');
        $this->bootup();
    }

    protected function afterSubmit(): void
    {
        $this->bootup();
    }

    protected function bootup(): void
    {
        /** @var \App\Models\ChildSafetyPlanVersion $mapping */
        $mapping = \App\Models\ChildSafetyPlanVersion::query()->where('form_id', $this->formDataId)->firstOrFail();
        $this->formStageIndex   = $mapping->form_stage;
        $this->readOnlyForm     = $mapping->form_stage == 2;
        $this->mapId            = $mapping->id;
        $this->evaluateSafetyPlaneNecessity();                                              //toggle safety plan evaluation (setting: $this->needsASafetyPlan)

        if($this->formStageIndex == 0){
            $this->canSubmitAssessment = $this->canSubmitAssessment();                      //submit assessment lock evaluation
        }
    }


}

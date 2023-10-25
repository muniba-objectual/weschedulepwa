<?php

namespace App\Http\Livewire\Forms\CaseManage\Temp;

use App\CustomClasses\UserFormComponent;
use App\Models\FosterParentForm;
use Livewire\Component;
use PDF;
class FosterParentLearning extends Component
{
    use UserFormComponent;

    public $redirectBackTo;
    public $isAHistoryRecord;
    public $makePDF;
    public function render()
    {
       if ($this->makePDF) {
           $this->printMode = true;
       }
        return view('livewire.forms.case-manage.temp.foster-parent-learning');
    }

    public function saveVersion()
    {

        /**
         * @var FosterParentForm $existingFormMap
         * Locate the mapping.
         * Create the new version and map it to the current component.
         */
        $existingFormMap = FosterParentForm::query()
            ->where('form_id', $this->formDataId)
            ->orWhere('secondary_form_id', $this->formDataId)
            ->first();

        //on every submit the current form converts to a draft
        if ($existingFormMap->secondary_form_id == $this->formDataId) {
            $existingFormMap->is_secondary_draft = true; //as draft
        } else {
            $existingFormMap->is_draft = true; //as draft
        }
        $existingFormMap->save();

        //the component now should repoint to this new form
        $this->formDataId = $existingFormMap
            ->createAVersion(forSecondary: $existingFormMap->secondary_form_id == $this->formDataId)
            ->id;

        //redirect to previous location if set.
        if ($this->redirectBackTo) {
            return redirect($this->redirectBackTo)->with('message', 'Submitted successfully.');
        }
    }

    public function afterMount()
    {
        //store previous location, (depends on the URL params)
        $this->redirectBackTo = request()->query('back-url');
        $this->isAHistoryRecord = FosterParentForm::query()
            ->where('form_id', $this->formDataId)
            ->orWhere('secondary_form_id', $this->formDataId)
            ->doesntExist();
    }

    public function afterSubmit()
    {
        if (!$this->isAHistoryRecord) { //handle draft flag only in non history records

            $existingFormMap = FosterParentForm::query()
                ->where('form_id', $this->formDataId)
                ->orWhere('secondary_form_id', $this->formDataId)
                ->first();

            // on update mark as saved

            if($existingFormMap->secondary_form_id == $this->formDataId){
                $existingFormMap->is_secondary_draft = false; //saved
            }else{
                $existingFormMap->is_draft = false; //saved
            }
            $existingFormMap->save();

        }

    }
}

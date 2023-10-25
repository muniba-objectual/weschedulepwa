<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Models\HomeVisit;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AdmissionPreliminaryAssessmentDesktop extends Component
{
    use LivewireAlert;
    public $show;
    public $size;


    public $user;

    public $date;


    protected $rules = [
        'selectedHome' => 'required',
        'notes' => 'required',
        'selectedChildren' => 'nullable',
        'privacy' => 'required'
    ];

    protected $listeners = ['AddToSelectedChildren', 'RemoveFromSelectedChildren'];






    public function submit() {



        if ($this->selectedHome && ($this->notes)) {

            $hv = new HomeVisit();

            $hv->fk_UserID = $this->user->id;
            $hv->fk_HomeID = $this->selectedHome;
            if (count($this->selectedChildren) > 0) {
                $data = [];
                foreach ($this->selectedChildren as $child)
                {
                    $data[] = [
                        'id' => (int)$child,

                    ];
                }
                $hv->fk_ChildID = json_encode($data);
            }
            $hv->notes = $this->notes;

            if ($this->privacy) {
                $hv->privacy = true;
            } else {
                $hv->privacy = false;
            }

            if ($this->date) {
                $hv->setUpdatedAt($this->date);
                $hv->setCreatedAt($this->date);
            }
            $hv->save();
            $this->alert('success', 'Home Visit Saved');

            $tmpHome = \App\Models\User::where('id','=',$this->selectedHome)->first();

            if (!$this->privacy) {

                activity('HomeVisit')
                    ->causedBy($this->user)
                    ->performedOn($tmpHome)
                    ->event("HomeVisit")
                    ->withProperties($tmpHome)
                    ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                    ->log($this->notes);

                activity('HomeVisit')
                    ->causedBy($this->user)
                    ->performedOn($this->user)
                    ->event("HomeVisit")
                    ->withProperties($tmpHome)
                    ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                    ->log($this->notes);

                if (count($this->selectedChildren)>0) {
                    foreach ($this->selectedChildren as $childID) {
                        $tmpChild = \App\Models\Child::where('id','=',$childID)->first();
                        activity('HomeVisit')
                            ->causedBy($this->user)
                            ->performedOn($tmpChild)
                            ->event("HomeVisit")
                            ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                            ->withProperties($tmpHome)

                            ->log($this->notes);
                    }
                }
            } else {
                if (count($this->selectedChildren)>0) {
                    foreach ($this->selectedChildren as $childID) {
                        $tmpChild = \App\Models\Child::where('id','=',$childID)->first();
                        activity('PrivacyVisit')
                            ->causedBy($this->user)
                            ->performedOn($tmpChild)
                            ->event("PrivacyVisit")
                            ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                            ->withProperties($tmpChild)

                            ->log($this->notes);

                    }
                }
            }
            }else {
            $this->alert('warning', 'Please select a home and fill out the note section before submitting.');


        }



    }

    public function mount() {
        $this->user = Auth::user();

    }

//    public function updated($field, $value) {
//        if ($field == "privacy") {
//            $this->privacy = true;
//        }
//    }
    public function render()
    {
        return <<<'blade'


            <div wire:ignore>

         <form>
              <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Example select</label>
                <select class="form-control" id="exampleFormControlSelect1">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect2">Example multiple select</label>
                <select multiple class="form-control" id="exampleFormControlSelect2">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Example textarea</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
            </form>




            </div>
        blade;
    }
}

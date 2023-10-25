<?php

namespace App\Http\Livewire\Mobile;

use App\Models\Shift_Form;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\User;
use App\Models\Shift;
use Auth;
use App\Models\Child;


class SigninComponent extends Component
{
    use LivewireAlert;

    public $user;
public $child;
 public Shift $myshift;
 public $signed_in;
    public $SRA_enabled = false;


    protected $rules = [
        'myshift.signed_in' => 'nullable',
      ];

    public function signOut() {
        $date = date('Y-m-d H:i:s');

        $this->myshift->actual_shift_end = $date;
        $this->myshift->status = "Ended - Pending Verification";
        $this->myshift->signed_in = "0";
        $this->myshift->update();
        $this->dispatchBrowserEvent('viewEndOfShiftModal', ['shiftID'=>$this->myshift->id]);


        $this->child = Child::where('id','=',$this->myshift->fk_ChildID)->first();
        activity('ShiftSignOut')
            ->causedBy(Auth::user())
            ->performedOn($this->child)
            ->event("ShiftSignOut")
            //->withProperties($this->myshift->id)
            ->log("Signed Out");



    }

    public function signIn()
    {
        $date = date('Y-m-d H:i:s');

        $this->myshift->signed_in = true;


        $this->myshift->actual_shift_start = $date;
        $this->myshift->status = "Started";
        $this->myshift->update();

        $this->child = Child::where('id','=',$this->myshift->fk_ChildID)->first();

        if ($this->child->SRA) {
            $this->SRA_enabled = true;
        }
        activity('ShiftSignIn')
            ->causedBy(Auth::user())
            ->performedOn($this->child)
            ->event("ShiftSignIn")
            //->withProperties($this->myshift->id)
            ->log("Signed In");

//        $this->alert('warning','URGENT MESSAGE ', [
//            'position' => 'center',
//            'timer' => '',
//            'toast' => false,
//            'html' => '<p>Shane Saunders will be your support contact from: <u>March 4th - March 17th</u> <br /><br />24 hour direct line <a href="tel:416-919-1581">416-919-1581</a>',
//            'showConfirmButton' => true,
//            'onConfirmed' => '',
//            'customClass' =>[
//                'container' => 'alertContainer',
//                'popup' => 'alertPopup',
//                'title' => 'alertTitle',
//
//            ]
//        ]);


//    Submit End Of Shift Form
        $this->myshift_form = New Shift_Form;
        $this->myshift_form->datetime = date('Y-m-d H:i');

        if  ($this->SRA_enabled)  {
            $this->myshift_form->SRA_Enabled = "1";
        }


            //create a new shift_form for this shift
            $newShiftFormCreated = $this->myshift_form->save();
            //CYSW has created a new Shift Form
            //Add it to the Activity Log (only once instead of every update)
           sleep(1);
            activity('EndOfShiftForm')
                ->causedBy(Auth::user())
                ->performedOn($this->child)
                ->event("EndOfShiftForm")
                ->withProperties($this->myshift->id)
                ->log($this->myshift_form);

        $this->myshift->fk_ShiftFormID = $this->myshift_form->id;

        $this->myshift->save();
    }

    public function render()
    {

        return <<<'blade'

                                                         <div>
                                                               <h5 class="card-title text-primary">{{$myshift->title}}                                                    </h5>

                                                <h6 class="card-subtitle">{{$myshift->status}}</h6>
                                                <p class="card-text">
                                                    <span class="text-uppercase font-weight-bold" style="color:green;">{{\Carbon\Carbon::parse($myshift->start)->format('M d Y')}} @ {{\Carbon\Carbon::parse($myshift->start)->format('g:i A')}} - {{\Carbon\Carbon::parse($myshift->end)->format('g:i A')}}
                                                </p>
                                                <ul class="listview image-listview">
                                                  @if  ($myshift->status == "Pending" || $myshift->status == "Started")
                                                    <li>
                                                        <div class="item">
                                                            <div wire:ignore class="icon-box bg-primary">
                                                                <ion-icon name="alarm"></ion-icon>
                                                            </div>
                                                                 <div wire:poll.visible class="in">
                                                                <div>
                                                                    @if ($myshift->signed_in)

                                                                        Signed In

                                                                    @else
                                                                        Not Signed In
                                                                @endif
                                                                <!-- <div class="text-muted">05:20 AM</div> -->
                                                                </div>
                                                                     <div  class="form-check form-switch">
                                                                    @if ($myshift->signed_in)
                                                                        <input wire:click="signOut()" class="form-check-input" type="checkbox" id="ShiftSignedIn" checked />
                                                                        <label class="form-check-label" for="ShiftSignedIn"></label>

                                                                    @else
                                                                        <input wire:click="signIn()"  class="form-check-input" type="checkbox" id="ShiftSignedOut"  />
                                                                        <label class="form-check-label" for="ShiftSignedOut"></label>

                                                                    @endif
                                                                        </div>

                                                            </div>
                                                                         </li>



                                                @endif
                                                  @if (($myshift->status == "Started") || ($myshift->status == "Pending") || ($myshift->status == "Ended - Incomplete") || ($myshift->status == "Ended - Pending Verification") || ($myshift->status == "Complete") )
                                                            <li>
                                                        <div class="item">
                                                            <div wire:ignore class="icon-box bg-primary">
                                                                <ion-icon name="clipboard-outline"></ion-icon>
                                                            </div>
                                                            <div wire:poll.visible class="in">
                                                                <div>
                                                                        @if ($myshift->signed_in)
                                                                        <a href="javascript:Load_End_of_Shift_Report('{{$myshift->id}}')">End of Shift Report</a>
                                                                        @else
                                                                        End of Shift Report
                                                                        @endif
                                                                <!-- <div class="text-muted">05:20 AM</div> -->
                                                                </div>
                                                                     <div  wire:poll.visible>
                                                                    @if ($myshift->fk_ShiftFormID && $myshift->status == "Ended - Pending Verification")
                                                                        <span style="color: green;">Submitted</span>

                                                                    @else

                                                                        <span style="color:red;">Pending</span>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                            </div>
                                                            </li>

                                                            @endif
                                                </ul>

        blade;
    }

public function mount($myshift) {
    $this->myshift = New Shift;

    $this->myshift = $myshift;
       //$this->myshift->signed_in = $this->signed_in;
$this->child = New Child;
}
}

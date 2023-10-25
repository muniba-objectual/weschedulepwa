<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage;

use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\Child;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class ChildProfiles extends Component
{
    use LivewireAlert;
    public $users;
    public $children;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount() {

        $this->users = User::all()->where('fk_CaseManagerID','=',Auth::user()->id)->sortBy('name');
        //$this->children = Child::all()->where('WeSchedule','=','0')->where('CaseManager_fk_UserID','=',Auth::user()->id)->sortBy('initials');
        $this->children = Child::all()->where('WeSchedule','=','0')->sortBy('initials');

        $collectionOfChildren = new Collection();
        foreach ($this->users as $user) {
            foreach ($this->children as $child) {
                if ($child->FosterHome_fk_UserID == $user->id) {
                    //Child belongs to Foster Home (User's 2.0, 2.1, 2.2, 2.3...etc.)
                    $collectionOfChildren->push($child);
                }


            }

        }

        //dd ($collectionOfChildren);
        $this->children = $collectionOfChildren;


   }



    public function render()
    {
        return <<<'blade'
            <div>


             <!-- Child Profiles -->
             @if ($children->count() > 0)
                    <div class="container-fluid mt-3 mb-3">
                        CHILD PROFILES


                        <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 mt-2 justify-content-center">
                            @foreach ($children as $child)
                                <div class="col-xl-2 col-md-2 mb-4">
                                    <div class="card border-0 shadow">

                                          <img src="https://images.unsplash.com/photo-1516240562813-7d658edb7239?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" class="card-img-top" alt="...">
                                          @if($child->hasPrivacyNoteForThisMonth())
                                            <span class="badge bg-gradient-green mt-0">Privacy Note Complete</span>
                                          @endif
                                          <div class="card-body text-center">
                                            <h6 class="mb-0 text-center child-small">
                                            <br />{{$child->initials}}</h6>
                                            <div class="card-text text-black-50">
                                                <div class="button mt-2 d-flex flex-row align-items-center">
                                                    <a href="/children/{{$child->id}}/" class="btn btn-sm btn-primary w-100">Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    @endif
                    <!-- *Child Profiles -->


            </div>

        blade;
    }
}

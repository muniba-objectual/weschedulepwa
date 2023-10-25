<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage;

use App\Models\User;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FosterParentProfiles extends Component
{
    use LivewireAlert;
    public $users;
   protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount() {
        $this->users = User::all()
            ->where('fk_CaseManagerID','=',Auth::user()->id)
            ->sortBy('name');

    }

    public function render()
    {
        return <<<'blade'
            <div>


             <!-- Foster Parent Profiles -->
             @if ($users->count() > 0)
                    <div class="container-fluid mt-3 mb-3">
                    FOSTER PARENT PROFILES

                        @if(!$users->isEmpty())
                        <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 mt-2 justify-content-center">
                                @foreach ($users as $user)
                                    <div class="col-xl-2 col-md-2 mb-4">
                                        <div class="card border-0 shadow">
                                            @if (!$user->profile_pic)


                                                <img height="150px" src="/img/CM-default-avatar.png" alt="avatar" class="card-img-top" />
                                            @else
                                                @php
                                                    // @ray ($user->name);
                                                     //@ray (storage_path('app/public/profile_pic/') . substr($user->profile_pic,20));
                                                     //$img = Image::make(storage_path('app/public/profile_pic/') . substr($user->profile_pic,20))->orientate()->fit(142, 116, function ($constraint) {
                                                    //$constraint->upsize();
                                                    //});


                                                    //$img->save(storage_path('app/public/profile_pic/') . substr($user->profile_pic,20));
                                               // echo $img->response('jpg');

                                                @endphp

                                                <img height="150px" src="/storage/profile_pic/{{substr($user->profile_pic,20)}}" alt="avatar" class="card-img-top imaged rounded mr-2">
                                            @endif

                                            @if($user->hasCompletedPrivacyNoteForThisMonth() == -1)
                                                <span class="badge bg-gradient-yellow mt-0">Privacy Notes N/A (No Children Assigned)</span>
                                            @elseif($user->hasCompletedPrivacyNoteForThisMonth())
                                                <span class="badge bg-gradient-green mt-0">Privacy Notes For All Children Complete</span>
                                            @endif

                                            @if($user->hasSupportNoteForThisMonth() == -1)
                                                <span class="badge bg-gradient-yellow mt-0">Support Notes N/A (No Children Assigned)</span>
                                            @elseif($user->hasSupportNoteForThisMonth())
                                                <span class="badge bg-gradient-green mt-0">Has Support Notes</span>
                                            @endif

                                            <div class="card-body text-center">
                                                <h6 class="mb-0 text-center child-small">
                                                <br />{{$user->name}}</h6>
                                                <div class="card-text text-black-50">
                                                    <div class="button mt-2 d-flex flex-row align-items-center"> <a href="/users/{{$user->id}}" class="btn btn-sm btn-primary w-100">Profile</a> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                        </div>
                        @else
                            <div class="row">
                                <div class=" col-md-12 text-center">
                                    <h5> No Foster Parent Profiles Assigned </h5>
                                </div>
                            </div>
                            @endif
                    </div>
                    @endif
                    <!-- *FOSTER PARENT Profiles -->


            </div>

        blade;
        //return view('livewire.c-y-s-w-dashboard-profiles');
    }
}

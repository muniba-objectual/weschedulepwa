<?php

namespace App\Http\Livewire\Modals\CaseManage;


use App\Models\User;
use WireElements\Pro\Components\SlideOver\SlideOver;
use Auth;
class ViewMentorHomeVisitSeenUnseenModal extends SlideOver
{

    public $show;
    public $user;
    public $userID;
    public $AuthUserID;

    public $size;

    public $staff;
    public $mentorHomeVisitID;



    protected $listeners = ['showModal' => 'showModal'];

    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
            'size' => '7xl',

        ];
    }

    public function mount() {
        $this->staff = User::where('user_type','>=','3')
            ->where('user_type','<','6')
            ->orWhere('user_type','=','10')
            ->orderBy('name','ASC')
            ->get();

    }




    public function render()
    {
        return view('livewire.modals.case-manage.view-mentor-home-visit-seen-unseen-modal');
    }
}

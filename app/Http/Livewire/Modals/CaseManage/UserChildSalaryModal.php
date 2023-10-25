<?php

namespace App\Http\Livewire\Modals\CaseManage;

use App\Models\Child;
use App\Models\UserChildrenHistory;
use Illuminate\Support\Collection;
use WireElements\Pro\Components\Modal\Modal;

class UserChildSalaryModal extends Modal
{
    public Collection $salaries;
    public string $childInitials;


    public function mount(int $userId, int $childId) {

        //expired salaries only
        $this->salaries = UserChildrenHistory::query()
            ->select('*')
            ->orderByExpiration()
            ->where([
                'child_id'  => $childId,
                'user_id'   => $userId,
            ])
            ->get();

        $this->childInitials = Child::find($childId)->initials; //child name
    }

    public function render()
    {
        return view('livewire.modals.case-manage.user-child-salary-modal');
    }

    public static function behavior(): array
    {
        return [
            // Close the modal if the escape key is pressed
            'close-on-escape' => false,
            // Close the modal if someone clicks outside the modal
            'close-on-backdrop-click' => false,
            // Trap the users focus inside the modal (e.g. input autofocus and going back and forth between input fields)
            'trap-focus' => true,
            // Remove all unsaved changes once someone closes the modal
            'remove-state-on-close' => true,
        ];
    }

    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
            'size' => '6xl',
        ];
    }
}

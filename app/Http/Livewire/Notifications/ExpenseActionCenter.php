<?php

namespace App\Http\Livewire\Notifications;

use App\Http\Livewire\ExpensesReport\DynamicExpenseReportComponent;
use App\Models\Expenses;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use WireElements\Pro\Components\SlideOver\SlideOver;

class ExpenseActionCenter extends SlideOver
{
    public bool $embeddedSlider;

    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
            'size' => '4xl',

        ];
    }

    public function mount(bool $embeddedSlider=false){
        $this->embeddedSlider = $embeddedSlider;
    }

    protected $listeners = [
        'dismiss' => 'dismiss',
    ];

    public function dismiss($expenseId){
        Notifications::query()
            ->where('fk_UserID','=',Auth::id())
            ->where('model','Expenses')
            ->where('fk_ModelID', $expenseId)
            ->update(['active' =>0]);
    }

    public function render()
    {
        $user = Auth::user();

        $expenseComponent = new DynamicExpenseReportComponent();
        $expenseComponent->loadConfigurationForLoginLevel();

        //get notifications for this user;
        $activeExpenseIds = Notifications::query()
            ->where([
                'fk_UserID' => $user->id,
                'model' => 'Expenses',
                'active' => 1,
            ])
            ->pluck('fk_ModelID');

        $collection = Expenses::query()
            ->find($activeExpenseIds)
            ->map(function (Expenses $model) use (&$expenseComponent){
                $model->expense_tab = $expenseComponent->findTabForExpense($model->id); //attach  the expense tab it is in available
                return $model;
            });

        return view('livewire.notifications.expense-action-center', [
            'collection' => $collection,
        ]);
    }
}

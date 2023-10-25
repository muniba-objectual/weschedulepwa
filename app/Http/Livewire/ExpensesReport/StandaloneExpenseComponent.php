<?php

namespace App\Http\Livewire\ExpensesReport;

use App\Models\ExpenseCategory;
use App\Models\Expenses;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
//use WireElements\Pro\Components\Modal\Modal;
use Livewire\Component;

class StandaloneExpenseComponent extends component
{
    public $detail;
    public $tagged;

    protected $listeners = [
        'updateLineItems' => 'updateLineItems',
        'dismissNotifications' => 'dismissNotifications',
    ];

    public function mount($expenseId){
        $this->detail = \App\Models\Expenses::find($expenseId);
    }

    public function updateLineItems($expenseId, $content){
        /** @var Expenses $expense */
        $expense = Expenses::find($expenseId);
        $expense->updateLineItems(json_decode($content));
    }

    public function dismissNotifications($expenseId): void
    {
        Notifications::query()
            ->where('fk_UserID','=',Auth::id())
            ->where('model','Expenses')
            ->where('fk_ModelID', $expenseId)
            ->update(['active' =>0]);
    }

    public function render()
    {

        $user = auth()->user();

        $this->tagged = Notifications::query()
            ->where([
                'fk_UserID' => $user->id,
                'model' => 'Expenses',
                'active' => 1,
                'fk_ModelID' => $this->detail->id
            ])->exists();

        $expensesCategories = json_encode(ExpenseCategory::all()->toArray()); //used in frontend

        return view('livewire.expenses-report.standalone-expense-component', compact('user', 'expensesCategories'));
    }

//    public static function behavior(): array
//    {
//        return [
//            // Close the modal if the escape key is pressed
//            'close-on-escape' => true,
//            // Close the modal if someone clicks outside the modal
//            'close-on-backdrop-click' => true,
//            // Trap the users focus inside the modal (e.g. input autofocus and going back and forth between input fields)
//            'trap-focus' => true,
//            // Remove all unsaved changes once someone closes the modal
//            'remove-state-on-close' => false,
//        ];
//    }
//
//    public static function attributes(): array
//    {
//        return [
//            // Set the modal size to 2xl, you can choose between:
//            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
//            'size' => '7xl',
//        ];
//    }

}

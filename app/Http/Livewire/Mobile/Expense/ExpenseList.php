<?php

namespace App\Http\Livewire\Mobile\Expense;

use App\Models\Child;
use App\Models\ExpenseCategory;
use App\Models\Expenses;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class ExpenseList extends Component
{
    public User $user;
    public Collection $expenses;
    public Collection $expenseCategories;

    protected $listeners = ['deleteExpense'];



    public function render()
    {
        //expenses created by user
        $this->expenses = Expenses::query()
            ->where('fk_UserID', $this->user->id)
            ->limitToThisMonth()
            ->get();

        $this->expenseCategories = ExpenseCategory::pluck('name', 'id');

        return view('livewire.mobile.expense.list-items');
    }

    public function deleteExpense(int $expenseId){
        Expenses::query()
            ->where([
                'fk_UserID' => $this->user->id, //for better security
                'id' => $expenseId,
            ])
            ->where('datetime', '>=', Carbon::now()->startOfMonth())
            ->delete();
    }

    public function mount(){
        $this->user = auth()->user();
    }
}

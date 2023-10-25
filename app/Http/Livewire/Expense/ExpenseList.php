<?php

namespace App\Http\Livewire\Expense;

use App\Models\ExpenseCategory;
use App\Models\ExpensePayout;
use App\Models\Expenses;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class ExpenseList extends Component
{
    public User $user;
    public Collection $expenseCategories;
    public $expanded = [];
    protected $listeners = ['deleteExpense'];
    public string $latestKey;


    public function toggleExpand($key){
        if( isset($this->expanded[$key]) ){
            unset( $this->expanded[$key] );
        }else{
            $this->expanded[$key]=true;
        }
    }


    public function render()
    {
        $summaryData = [];

        //expenses created by user
        $timeline_data = Expenses::query()
            ->with('expensePayout')
            ->where('fk_UserID', $this->user->id)
            ->whereNotNUll('verified_at')
            ->get()
            ->groupBy('monthyear')

            ->transform(function (Collection $expenses, string $key) use (&$summaryData){
                /** @var Collection|Expenses[] $expenses */

                //for older months, only show expenses that are being paid.
                if($key != $this->latestKey){
                    $expenses = $expenses->where('expensePayout.status', ExpensePayout::STATUS__PAID);
                }

                //use this block if you want to hide empty months.
                if($expenses->isEmpty()){
                    return null;
                }

                //build summaries
                $summaryData[$key]['Total'] = $expenses->sum('total');
                $summaryData[$key]['HST'] = $expenses->sum('HST');
                $summaryData[$key]['Receipts'] = $expenses->count();

                //build category Summary
                $categorySubTotals=[];
                foreach($expenses as $expense){
                    foreach(json_decode($expense->line_items) as $lineItem) {
                        //calculate totals category wise, if category is null, assume index as `0`.
                        if (isset( $categorySubTotals[$this->expenseCategories[$lineItem->category] ?? 'Other'] )) {
                            $categorySubTotals[$this->expenseCategories[$lineItem->category] ?? 'Other'] += (float)$lineItem->total;
                        } else {
                            $categorySubTotals[$this->expenseCategories[$lineItem->category] ?? 'Other'] = (float)$lineItem->total;
                        }
                    }
                }
                $summaryData[$key]['CategorySummary'] = $categorySubTotals;

                return $expenses;
            });

        //if not records, show a empty placeholder for this month
        if($timeline_data->isEmpty()){
            $timeline_data->put($this->latestKey, null);
        }

        return view('livewire.expense.expense-list', compact('timeline_data', 'summaryData'));
    }


    public function deleteExpense(Expenses $expense){
        if($expense->fk_UserID == $this->user->id && $expense->datetime >= Carbon::now()->startOfMonth()){
            $expense->delete();
        }
    }


    public function mount(){
        $this->user = auth()->user();
        $this->expenseCategories = ExpenseCategory::pluck('name', 'id');
        $this->latestKey = \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('M-Y');
        $this->expanded[$this->latestKey]=true;
    }
}

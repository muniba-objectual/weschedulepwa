<?php

namespace App\Http\Livewire\BankDeposits;

use Livewire\Component;
use App\Models\BankDeposit;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\Debugbar;

use Livewire\WithPagination;


class BankDeposits extends Component

{
    use WithPagination;

    public $user;
    public $viewed;

    protected $timeline_data;

    protected $listeners = ['delete' => 'delete'];

    public function toggle($id) {

        $tmpBankDeposit = BankDeposit::where('id','=',$id)->firstOrFail();
        if ($tmpBankDeposit) {
            if ($tmpBankDeposit->viewed) {
                $tmpBankDeposit->viewed = false;
            }    else {
                $tmpBankDeposit->viewed = true;
            }
        }

        $tmpBankDeposit->save();
    }
    public function mount() {

        $this->user = Auth::user();

    }



    public function render()
    {
        $array = BankDeposit::with('getUser')->orderBy('date','DESC')->get();
        $array = $array->groupBy(function($date) {            return \Carbon\Carbon::parse($date->date)->format('d-M-y');});
        $per_page = 9999; //1 day per page; 62?

//        $data   =   $this->request->all();

        $current_page = $data['page'] ?? 1;

        // $array = $array->slice(($current_page - 1) * $per_page, $per_page);
        $pagination = new LengthAwarePaginator(
            $array->slice(($current_page - 1) * $per_page, $per_page),
            $array->count(),
            $per_page,
            $current_page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );


       $this->timeline_data = $pagination;

       $timeline_data = $this->timeline_data;
        return view('livewire.bankdeposits', compact('timeline_data'));

    }

    public function delete($id) {
        if ($id) {
            $bankDeposit = BankDeposit::find($id);

            $bankDeposit->delete();
        }

    }
}

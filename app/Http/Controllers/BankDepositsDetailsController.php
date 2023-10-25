<?php

namespace App\Http\Controllers;



use App\Models\BankDeposit;
use App\Models\BankDepositDetails;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\Debugbar;

class BankDepositsDetailsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getBankDepositDetails(Request $request) {
        if ($request->id) {
            $details = BankDepositDetails::where('fk_bankDepositID','=',$request->id)->first();
            if ($details) {
                return $details->details;
            } else {
                return 0;
            }

        }


//        return $request;
    }

    public function updateBankDepositDetails(Request $request){
        if ($request->id) {
            $details = BankDepositDetails::where('fk_BankDepositID','=',$request->id)->firstOrCreate();
            if ($details) {
                $details->fk_BankDepositID = $request->id;
                $details->details = $request->data;
                $details->fk_UserID = auth()->user()->id;
                $details->save();
                return "success";
            } else {
                return "error";
            }

        }
    }

    public function show(Request $request) {
//        $OnCalls = OnCall::all();
        $array = BankDeposit::with('getUser')->orderBy('updated_at','DESC')->get();
        $array = $array->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});
        $per_page = 62; //1 day per page

        $data   =   $request->all();

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

        $timeline_data = $pagination;

        $user = Auth::user();
        return view('CaseManage.Modules.BankDeposits', compact('timeline_data', 'user'));
    }


}

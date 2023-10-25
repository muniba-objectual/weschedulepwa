<?php

namespace App\Http\Controllers;



use App\Models\BankDeposit;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\Debugbar;

class BankDepositsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request) {


        $user = Auth::user();
        return view('CaseManage.Modules.BankDeposits', compact( 'user', 'request'));
    }


}

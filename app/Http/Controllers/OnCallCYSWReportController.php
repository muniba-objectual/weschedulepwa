<?php

namespace App\Http\Controllers;


use App\Models\Child;

use App\Models\OnCall;
use App\Models\User;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;

class OnCallCYSWReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function show(Request $request) {
//        $OnCalls = OnCall::all();
        $user = Auth::user();

        return view('CaseManage.Modules.OnCallCYSWReport', compact('user','request'));
    }


}

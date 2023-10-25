<?php

namespace App\Http\Controllers;



use App\Models\Child;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\Debugbar;

class NewChildAdmissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request) {


        $children = Child::where('WeSchedule','=','0');
        return view('CaseManage.Modules.NewChildReport', compact( 'children', 'request'));
    }


}

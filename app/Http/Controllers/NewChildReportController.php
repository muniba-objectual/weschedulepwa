<?php

namespace App\Http\Controllers;


use App\Models\Child;

use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;

class NewChildReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateSeenStatus(Request $request) {
        if ($request->OnCallID) {

            $onCall = OnCall::with('users')->where('id','=',$request->OnCallID)->first();
            if ($onCall) {
                if (count($onCall->users) >0) {
                    foreach ($onCall->users as $user) {
                            if ($user->id == Auth::user()->id) {
//                                $onCall->users()->detach(Auth::user()->id);
//                                $onCall->users()->attach(Auth::user())->id;

                            } else {
                                $onCall->users()->detach(Auth::user()->id);
                                $onCall->users()->attach(Auth::user())->id;
                            }
                    }
                } else {
                    $onCall->users()->attach(Auth::user()->id);

                }
//                $onCall->users()->attach(Auth::user()->id);
            }
            return ($request->data);
        }
    }
    public function show(Request $request) {
//        $OnCalls = OnCall::all();
        $user = Auth::user();

        return view('CaseManage.Modules.NewChildReport', compact('user','request'));
    }


}

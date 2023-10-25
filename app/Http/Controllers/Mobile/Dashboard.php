<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\Child;
use Auth;

class Dashboard extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index() {

        //return "Updates in progress; Mobile site is down for scheduled maintenance.";

        $user = Auth::user();
        if($user->inactive == "1") {
            exit('User does not have access.');
        }

        $shifts = Shift::where('fk_UserID','=',$user->id)->where('published_status','=','Published')->orderBy('start','desc')->get();
        $children = Child::all()->sortBy('initials')->where('inactive','=',0)->where('WeSchedule','=','1');
        return view('mobile.index', compact('user', 'shifts', 'children'));

    }


}

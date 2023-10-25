<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Child;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    if(Auth::user()->inactive == "1") {
        exit ('User has been deactivated.');
    }


        $id = Auth::id();
        $user = User::where('id', $id)->firstOrFail();


        $users = User::where('user_type', '=', '1')->orderBy('name', 'ASC')->get();
        return view('home', compact( 'user', 'users'));
    }

    public function encrypt()
    {
        $users = User::where('id','=','1')->first();

        dd (encrypt("Michello"));
        dd(Crypt::decrypt($users->name));
        $users->name = Crypt::decryptString($users->name);
        $users->save();
//        foreach ($users as $user) {
//            $user->salary = encrypt($user->salary);
//            $user->save();
//}
    }

}

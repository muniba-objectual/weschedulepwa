<?php

namespace App\Http\Controllers;

use App\Models\Activity_Entry;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CYSW;

use Illuminate\Support\Facades\Auth;
use Log;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Laravelista\Comments\Commenter;


/*
// Get the currently authenticated user...
$user = Auth::user();

// Get the currently authenticated user's ID...
$id = Auth::id();
*/
class CYSW_Profile extends Controller
{

  Use Commenter;



    public function MyCYSW_Profile() {
        $id = auth::user()->id;
        $user = User::where('id',$id)->firstOrFail();
        return view ('users.myprofile', compact ('user'));
    }



    public function MyCYSW_Profile_edit(Request $request)
    {
        if ($request->type == "update") {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required',
                'password' => 'confirmed'
            ]);

           // return $validated;

            $user = User::find(auth()->user()->id);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->address = $request->address;
            $user->city = $request->city;
            $user->province = $request->province;
            $user->postal = $request->postal;

            if ($validated['password']) {
                $user->password = bcrypt($validated['password']);
            }
            $updateValue = $user->update();
            return view('users.MyProfile', compact('user', 'updateValue'));
        }

        if ($request->type == "AddDriversLicense") {

            $photo = $request->drivers_license;
                $filename = $photo->store('/public/drivers_license/');

                $user = User::find(auth()->user()->id);

                $user->drivers_license = $filename;
                $user->update();
            return response()->json(array('files' => $photo), 200);

            }



            //  return response()->json(['success' => true, 'message' => 'Created Activity Photo ID: ' . $activity_photo->id]);
        }


    public function ajaxRequest()
    {
        return view('staff');
    }

    public function ajaxRequestPost(Request $request)
    {
        $input_id = $request->input('id');

        //error_log("caught ajax request: id: " . $input_id);

        $user = User::where('id',$input_id)->firstOrFail();

        //error_log("got user data: " . $user);

return $user;

        //return response()->json(['success'=>'Got Simple Ajax Request.']);
    }


    public function cysw_profile_edit(Request $request)
    {
        if ($request->type == "update") {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required',
                'password' => 'confirmed'
            ]);

            // return $validated;

            $user = User::find(auth()->user()->id);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->address = $request->address;
            $user->city = $request->city;
            $user->province = $request->province;
            $user->postal = $request->postal;

            if ($validated['password']) {
                $user->password = bcrypt($validated['password']);
            }
            $updateValue = $user->update();
            return view('users.MyProfile', compact('user', 'updateValue'));
        }

        if ($request->type == "AddDriversLicense") {

            $photo = $request->drivers_license;
            $filename = $photo->store('/public/drivers_license/');

            $user = User::find(auth()->user()->id);

            $user->drivers_license = $filename;
            $user->update();
            return response()->json(array('files' => $photo), 200);

        }



        //  return response()->json(['success' => true, 'message' => 'Created Activity Photo ID: ' . $activity_photo->id]);
    }
}

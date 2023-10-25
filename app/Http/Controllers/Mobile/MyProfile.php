<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Livewire\WithPagination;


class MyProfile extends Controller

{

    use WithPagination;
    public $user;

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function edit(Request $request) {

    }

    public function show($id) {
        $user = Auth::user();
        return view ('mobile.MyProfile', compact('user'));
    }

    public function mobile_myprofile_edit(Request $request)
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

            $user->signature = $request->signature;

            if ($validated['password']) {
                $user->password = bcrypt($validated['password']);
            }
            $updateValue = $user->update();


           // return redirect()->back()->with('message', 'User Profile has been updated successfully.');
            $request->session()->flash('message', 'User Profile has been updated successfully.');
           return view('mobile.MyProfile', compact('user', 'updateValue'));
        }

        if ($request->type == "AddDriversLicense") {

            $photo = $request->drivers_license;
            $filename = $photo->store('/public/drivers_license/');

            $user = User::find(auth()->user()->id);

            $user->drivers_license = $filename;
            $user->update();
            return response()->json(array('files' => $photo), 200);

        }

        if ($request->type == "AddProfilePic") {

            $photo = $request->file_profile_pic;
            $filename = $photo->store('/public/profile_pic/');

            $user = User::find(auth()->user()->id);

            $user->profile_pic = $filename;
            $user->update();
            return response()->json(array('files' => $photo), 200);

        }


        //  return response()->json(['success' => true, 'message' => 'Created Activity Photo ID: ' . $activity_photo->id]);
    }

    public function mobile_cysw_profile_edit(Request $request)
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

            $user->signature = $request->signature;

            if ($validated['password']) {
                $user->password = bcrypt($validated['password']);
            }
            $updateValue = $user->update();
            return view('mobile.MyProfile', compact('user', 'updateValue'));
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

<?php

namespace App\Http\Controllers;

use App\DataTables\HomeDataTable;
use App\DataTables\HomeDataTableEditor;
use Illuminate\Http\Request;
use App\Models\Home;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Routing\Controller;

use DataTables;
/*
// Get the currently authenticated user...
$user = Auth::user();

// Get the currently authenticated user's ID...
$id = Auth::id();
*/
class Homes extends Controller
{

    public function edit($id) {
        $home = Home::where('id',$id)->firstOrFail();
        return view ('staff_edit', compact ('home'));
    }

    public function editModal($id) {
        $home = Home::where('id',$id)->firstOrFail();
        return $home;
    }

    public function ajaxRequest()
    {
        return view('homes');
    }

    public function ajaxRequestPost(Request $request)
    {
        $input_id = $request->input('id');

        //error_log("caught ajax request: id: " . $input_id);

        $home = Home::where('id',$input_id)->firstOrFail();

        //error_log("got user data: " . $user);

return $home;

        //return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    public function listAll() {
        $homes = Home::all();
        return response()->json(($homes));
}

    public function index(HomeDataTable $dataTable)
    {
        return $dataTable->render('homes.index');
    }

    public function store(HomeDataTableEditor $editor)
    {
        return $editor->process(request());
    }
}

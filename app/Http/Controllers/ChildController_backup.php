<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{

    public function index2() {
        $homes = Home::all();

        return view('child')->with('homes',$homes);
}
    public function ajaxRequest()
    {


        return view('child');
    }

    public function ajaxRequestPost(Request $request)
    {
        $input_id = $request->input('id');

        //error_log("caught ajax request: id: " . $input_id);

        $child = Child::where('id',$input_id)->firstOrFail();

        //error_log("got user data: " . $user);


        return $child;

        //return response()->json(['success'=>'Got Simple Ajax Request.']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function show(Child $child)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function edit(Child $child)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Child $child)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function destroy(Child $child)
    {
        //
    }
}

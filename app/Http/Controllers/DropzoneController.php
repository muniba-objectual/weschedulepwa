<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropzoneController extends Controller
{
    /**
     * Generate Image upload View
     *
     * @return void
     */
    public function index()
    {
        return view('dropzone');
    }

    /**
     * Image Upload Code
     *
     * @return void
     */
    public function store(Request $request)
    {
        $image = $request->file('file');

        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'),$imageName);

        return response()->json(['success'=>$imageName]);
    }
}

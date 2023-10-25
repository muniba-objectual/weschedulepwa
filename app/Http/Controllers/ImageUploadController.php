<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class ImageUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUpload()
    {
        return view('imageUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUploadPost(Request $request)
    {
       if ($request->type == "Activities") {
           //Uploading Photo to be linked to Activities

           $photos = [];
           foreach ($request->photos as $photo) {
               $filename = $photo->store('activities_photos');
               //   $product_photo = ProductPhoto::create([
               //       'filename' => $filename
               //    ]);

               $myPhoto =
               $photo_object = new \stdClass();
               $photo_object->name = str_replace('photos/', '', $photo->getClientOriginalName());
               $photo_object->size = round(Storage::size($filename) / 1024, 2);
               //   $photo_object->fileID = $product_photo->id;
               $photos[] = $photo_object;
           }

           return response()->json(array('files' => $photos), 200);
       }


    }
    }

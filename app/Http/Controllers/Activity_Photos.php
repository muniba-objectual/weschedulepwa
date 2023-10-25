<?php

namespace App\Http\Controllers;

use App\Models\Activity_Entry;
use App\Models\Activity_Photo;
use Illuminate\Http\Request;
use Storage;

class Activity_Photos extends Controller
{
    public function edit(Request $request)
    {
        if ($request->type == "AddPhoto") {

        $photos = [];
        foreach ($request->photos as $photo) {
            $filename = $photo->store('/public/activities_photos');
            //   $product_photo = ProductPhoto::create([
            //       'filename' => $filename
            //    ]);

            $activity = Activity_Entry::create(
                [
                    'message' => '[!photo!]:' . $filename,
                    'fk_UserID' => $request->UserID,
                    'fk_ChildID' => $request->ChildID
                ]
            );


        /*    $activity_photo = Activity_Photo::create(

                [

                    'photo' => $filename,
                    'fk_UserID' => $request->UserID,
                    'fk_ChildID' => $request->ChildID


                ]
            );
*/

               $photo_object = new \stdClass();
               $photo_object->name = str_replace('photos/', '', $photo->getClientOriginalName());
               $photo_object->size = round(Storage::size($filename) / 1024, 2);
               //   $photo_object->fileID = $product_photo->id;
               $photos[] = $photo_object;
           }

        return response()->json(array('files' => $photos), 200);


              //  return response()->json(['success' => true, 'message' => 'Created Activity Photo ID: ' . $activity_photo->id]);
            }
        }
    }


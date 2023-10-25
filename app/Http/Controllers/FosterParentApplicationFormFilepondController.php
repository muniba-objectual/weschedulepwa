<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use RahulHaque\Filepond\Facades\Filepond;
use App\Models\FosterParentApplicationForm;

class FosterParentApplicationFormFilepondController extends Controller
{
    public function store(Request $request)
    {

        $FPAForm = "";

        if ($request->FPAFormID) {
            $FPAForm = FosterParentApplicationForm::where('id', '=', $request->FPAFormID)->firstOrFail();

            if ($request->familyMemberID) {


                //clear out existing files in this collection
                $FPAForm->clearMediaCollection($request->section . "_" . $request->familyMemberID);

                $filesInfo = Filepond::field($request->uploadedFiles)->getFile();
                //if a new upload is detected, process it

                foreach ($filesInfo as $files) {
                    $FPAForm->addMedia($files->getPathname())
                        ->usingFileName($files->getClientOriginalName())
                        ->toMediaCollection($request->section . "_" . $request->familyMemberID);

                }

//                foreach ($request->uploadedFiles as $files) {
//                    $FPAForm->addMedia($files)
//                        ->toMediaCollection($request->section . "_" . $request->familyMemberID);
//
//                }

            } else {

                //clear out existing files in this collection
                $FPAForm->clearMediaCollection($request->section . "_" . "primary");

                $filesInfo = Filepond::field($request->uploadedFiles)->getFile();
                //if a new upload is detected, process it

                foreach ($filesInfo as $files) {
                    $FPAForm->addMedia($files->getPathname())
                        ->usingFileName($files->getClientOriginalName())
                        ->toMediaCollection($request->section . "_" . "primary");

                }
//                foreach ($request->uploadedFiles as $files) {
//                    $FPAForm->addMedia($files)
//                        ->toMediaCollection($request->section . "_" . "primary");
//
//                }

            }


//            // Set filename
//            $avatarName = 'avatar-' . auth()->id();
//
//            // Move the file to permanent storage
//            // Automatic file extension set
//            $fileInfo = Filepond::field($request->uploadedFiles)
//                ->moveTo('avatars/' . $avatarName);

//        session()->flash('message', 'File uploaded successfully');
            return response()->json(true);
        }
        }
}

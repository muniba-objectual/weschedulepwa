<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use RahulHaque\Filepond\Facades\Filepond;
use App\Models\FosterParentApplicationForm;

class ExpensesFilepondController extends Controller
{
    public function store(Request $request)
    {

        $Expense = "";

        if ($request->ExpenseID) {
            $Expense = Expenses::where('id', '=', $request->ExpenseID)->firstOrFail();



                //clear out existing files in this collection
                $Expense->clearMediaCollection("Expenses");

                $filesInfo = Filepond::field($request->uploadedFiles)->getFile();
                //if a new upload is detected, process it

                foreach ($filesInfo as $files) {
                    $Expense->addMedia($files->getPathname())
                        ->usingFileName($files->getClientOriginalName())
                        ->toMediaCollection("Expenses");

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

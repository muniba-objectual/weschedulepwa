<?php

namespace App\Http\Controllers;

use App\Models\Medication_Profile;
use Illuminate\Http\Request;

class MedicationProfileController extends Controller
{
   public function AddMedicationProfile(Request $request) {

       if ($request->AddMedType) {




           $newMedProfile = Medication_Profile::create([
               'type' => $request->get('AddMedType'),
               'dosage' => $request->get('AddMedDosage'),
               'fk_ChildID' => $request->get('childID')
           ]);
           return response()->json([
               'status' => 'success',
               'message' => 'Medication Profile ' . $request->get('AddMedType') . ' created successfully'
           ]);



       }





   }
}

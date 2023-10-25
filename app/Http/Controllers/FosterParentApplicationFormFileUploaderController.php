<?php

namespace App\Http\Controllers;


use App\Models\FosterParentApplicationForm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;


class FosterParentApplicationFormFileUploaderController extends Controller
{

    public $FPAForm;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        if ($request->FPAFormID) {

            $FPAForm = FosterParentApplicationForm::where('id','=',$request->FPAFormID)->firstOrFail();
        }


        $FPAForm
            ->addFromMediaLibraryRequest($request->avatar)
            ->toMediaCollection('avatar');
    }
}

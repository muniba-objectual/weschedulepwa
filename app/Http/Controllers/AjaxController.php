<?php

namespace App\Http\Controllers;

use App\Models\Shift_Form;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\User;
use App\Models\Child;


class AjaxController extends Controller
{

    public function getChildren() {
        $children = Child::select("id","initials")->get();
        return response()->json($children);
    }
}
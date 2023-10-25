<?php

namespace App\Http\Controllers;

use App\DataTables\ShiftDataTable;
use App\DataTables\ShiftDataTableEditor;
use App\Models\Shift;
use App\Models\User;
Use DB;
use View;
use Yajra\DataTables\Services\DataTable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Shifts extends Controller
{

    public function index(ShiftDataTable $dataTable)
    {


        $shift = Shift::all();
        $staff = User::all();
        return $dataTable->render('shifts.index', compact('staff'));
    }

    public function store(ShiftDataTableEditor $editor)
    {
        return $editor->process(request());
    }

    public function show(ShiftDataTable $dataTable, $id) {
        return $dataTable->with('id',$id)->render('shifts.show');


        //return view('shifts.show');
    }


}

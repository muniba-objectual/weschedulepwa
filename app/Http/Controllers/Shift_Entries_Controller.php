<?php

namespace App\Http\Controllers;

use App\DataTables\ChildDataTable;
use App\DataTables\ChildDataTableEditor;
use App\DataTables\ShiftEntriesDataTable;
use App\DataTables\ShiftEntriesDataTableEditor;
use App\Models\Child;
use App\Models\Home;
use App\Models\Shift_Entries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Shift_Entries_Controller extends Controller
{

    public function index(ShiftEntriesDataTable $dataTable)
    {
        $shift_entries = Shift_Entries::all();

        return $dataTable->render('shift_entries.index');
    }

    public function store(ShiftEntriesDataTableEditor $editor)
    {
        return $editor->process(request());
    }
}

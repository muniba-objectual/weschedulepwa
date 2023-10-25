<?php

namespace App\Http\Controllers;

use App\DataTables\MedicationDataTable;
use App\DataTables\MedicationDataTableEditor;
use Illuminate\Http\Request;

class Medication_Entries extends Controller
{
    public function index(MedicationDataTable $dataTable)
    {
        return $dataTable->render(',medication.index');
    }

    public function store(MedicationDataTableEditor $editor)
    {
        return $editor->process(request());
    }
}

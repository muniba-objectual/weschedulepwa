<?php

namespace App\Http\Controllers;

use App\DataTables\ChildNotificationsScheduleDataTableEditor;
use App\DataTables\ChildNotificationsScheduleDataTable;
use App\Models\Child;
use App\Models\Home;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ChildNotificationsScheduleController extends Controller
{

    public function index(ChildNotificationsScheduleDataTable $dataTable)
    {
        $children = Child::all();
        return $dataTable->render('children.notifications_schedule', compact('children'));
    }



    public function store(ChildNotificationsScheduleDataTableEditor $editor)
    {
        return $editor->process(request());
    }

    public function show(Child $child)
    {

    }
}

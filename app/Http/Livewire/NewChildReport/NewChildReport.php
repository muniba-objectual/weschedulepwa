<?php

namespace App\Http\Livewire\NewChildReport;

use App\Models\User;
use Livewire\Component;
use App\Models\Child;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\Debugbar;

use Livewire\WithPagination;


class NewChildReport extends Component

{
    use WithPagination;

    public $children;

    protected $timeline_data;

    protected $listeners = [
        'deleteChildInWaitingRoom' => 'deleteChildInWaitingRoom'
    ];
    public function mount() {}

    public function render()
    {
        $array = Child::query()
            ->where('WeSchedule','=','0')
            ->where('status','=','Pending')
            ->orderBy('created_at', 'DESC')
            ->get();

        $array = $array->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('d-M-y');
        });

        $per_page = 62; //1 day per page
        $current_page = $data['page'] ?? 1;

        // $array = $array->slice(($current_page - 1) * $per_page, $per_page);
        $pagination = new LengthAwarePaginator(
            $array->slice(($current_page - 1) * $per_page, $per_page),
            $array->count(),
            $per_page,
            $current_page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        $timeline_data = $pagination;
        $this->timeline_data = $pagination;
        $timeline_data = $this->timeline_data;


        return view('livewire.newchildreport', compact('timeline_data'));
    }

    public function approveChild($childId)
    {
        $child = Child::findOrFail($childId);
        $child->status = 'active';
        $child->save();
        $this->render();

        // You can add additional logic or flash messages here if needed
    }

    public function deleteChildInWaitingRoom($childId)
    {
        $child = Child::findOrFail($childId);
        //TODO::ashain, delete form
        $child->delete();
        $this->render();
    }

}

<?php

namespace App\Http\Livewire\OnCall;

use App\Models\Child;
use Livewire\Component;
use App\Models\OnCall;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\Debugbar;

use Livewire\WithPagination;


class OnCallReport extends Component

{
    use WithPagination;

    public $user;

    protected $timeline_data;

    protected $listeners = ['delete' => 'delete'];
    public function mount() {

        $this->user = Auth::user();

    }

    public function render()
    {
        $array = OnCall::with('getUser','getHome','getChild')->orderBy('updated_at','DESC')->get();
        $array = $array->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});
        $per_page = 62; //1 day per page

//        $data   =   $request->all();

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


        return view('livewire.oncallreport', compact('timeline_data'));

    }


}

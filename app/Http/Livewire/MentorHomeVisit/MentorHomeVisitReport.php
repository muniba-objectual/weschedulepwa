<?php

namespace App\Http\Livewire\MentorHomeVisit;

use Livewire\Component;
use App\Models\MentorHomeVisit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

use Livewire\WithPagination;


class MentorHomeVisitReport extends Component
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
        $array = MentorHomeVisit::query()
            ->with('getUser','getHome')
            ->orderBy('updated_at','DESC')
            ->get();
        $array = $array->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');
        });
        $per_page = 62; //1 day per page

        $current_page = $data['page'] ?? 1;

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

        $this->timeline_data = $pagination;

        $timeline_data = $this->timeline_data;

        return view('livewire.mentor-home-visit-report', compact('timeline_data'));

    }


}

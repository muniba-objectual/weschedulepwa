<?php

namespace App\Http\Livewire;

use App\Models\PlacingAgency;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class AgencyTimeline extends Component
{
    public $placingAgencyId;

    public function mount(int $placingAgencyID){
        $this->placingAgencyId = $placingAgencyID;
    }

    public function render(){
        $array = Activity::query()
            ->where('subject_type', PlacingAgency::class)
            ->Where('subject_id', $this->placingAgencyId)
            ->WhereNotIn('log_name', ['Wall', 'default'])
            ->latest('created_at')
            ->get();

        $array = $array->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('d-M-y');
        });

        $per_page = 7; //1 day per page

        $data   =   request()->all();

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


        return view('livewire.agency-timeline', compact('timeline_data'));
    }
}

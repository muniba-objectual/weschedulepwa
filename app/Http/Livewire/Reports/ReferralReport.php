<?php

namespace App\Http\Livewire\Reports;

use App\Models\TempFormData;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class ReferralReport extends Component
{
    use WithPagination;

    public $children;

    protected $timeline_data;


    public function render()
    {
        $array = TempFormData::query()
            ->where('form', TempFormData::PRE_ADMISSIONS)
            ->orderBy('temp_form_data.created_at', 'DESC')
            ->with('childAsAPreAdmission')
            ->get();

        $array = $array->groupBy(function($date) {
            return $date->created_at->format('d-M-y');
        });

        $per_page = 62;
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

        $this->timeline_data = $pagination;
        $timeline_data = $this->timeline_data;

        $allPlacingAgencyWorkers = \App\Models\PlacingAgencyWorkers::get(['id', 'name'])->keyBy('id');
        $allDocumentShares = \App\Models\DocumentShare::get(['id', 'email_sent_at'])->keyBy('id');

        return view('livewire.reports.referral-report', compact('timeline_data', 'allPlacingAgencyWorkers', 'allDocumentShares'));
    }

    public function deletePreAdmissionForm(int $formId): void
    {
        TempFormData::query()->findOrFail($formId)->delete();
    }
}

<?php

namespace App\Http\Livewire\SupportNotesReport;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseConfig;
use App\Models\Child;
use App\Models\HomeVisit;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Livewire\WithPagination;
use Ramsey\Collection\Collection;


class SupportNotesReport extends Component

{
    use WithPagination;

    public $user;

    protected $timeline_data;

    protected $listeners = ['delete' => 'delete'];
    public function mount() {

        $this->user = Auth::user();

    }

    public function renderOld()
    {
        //show 1 year back.
        $endOfThisMonth = Carbon::now()->endOfMonth();
        $yearBackDate = $endOfThisMonth->copy()->subYear()->startOfMonth();

        /**
         * @var Collection|HomeVisit[] $visitsFor1YearBack
         * Home visits only to the given time range.
         */
        $visitsFor1YearBack = HomeVisit::query()
            ->where('created_at', '<=', $endOfThisMonth)
            ->orderBy('created_at', 'DESC')

            ->where("privacy","=",false) //where support notes
            ->where('created_at', '>=', $yearBackDate) //limit to 1 year back

            ->get();


        //all case-manage children
        $caseManageChildren = Child::query()
            ->where("WeSchedule",0)
            ->where('created_at', '<=', $endOfThisMonth)
            ->get();


        //all foster parents on the system
        $allFosterParents = User::query()
            ->with('getCaseManager')
            ->whereIn('user_type', ExpenseConfig::roleMapping()['foster-homes']) //foster homes only
            ->get();

        $grouped = [];
        //loop through every month between the given dates
        foreach (CarbonPeriod::create($yearBackDate, '1 month', $endOfThisMonth) as $period)  {

            //filter foster visits for the Nth month from the given children
            $childrenInPeriod = $caseManageChildren
                // move the end-date as per the year-month pointer
                ->where('created_at', '<=', $period->endOfMonth())
                ->pluck('FosterHome_fk_UserID', 'id'); //foster-parent keyed by childId


            //filter foster visits for the Nth month
            // and then drain out the system children, based on the child-IDs in each visit
            //  Thus the remain children has not got any visit yet.
            $visitsFor1YearBack
                ->where('created_at', '<=', $period->endOfMonth())
                ->where('created_at', '>=', $period->startOfMonth())
                ->map(function (HomeVisit $visit) use (&$childrenInPeriod){
                    //for each visit get all childIds in that visit
                    // and drop them from the foster child collection
                    foreach ($visit->getChildIds() as $childId){
                        $childrenInPeriod->has($childId)?$childrenInPeriod->forget($childId):null;
                    }
                });


            $grouped[ $period->format('M Y') ] = $allFosterParents
                ->whereIn('id', $childrenInPeriod->values())
                ->groupBy('getCaseManager');

        }

        //reverse the array to bring the latest month on top
        $grouped = array_reverse($grouped);

        return view('livewire.supportnotesreport', compact('grouped'));
    }


    public function render()
    {
        //show 1 year back.
        $endOfThisMonth = Carbon::now()->endOfMonth();
        $yearBackDate = $endOfThisMonth->copy()->subYear()->startOfMonth();

        /**
         * @var Collection|HomeVisit[] $visitsFor1YearBack
         * Home visits only to the given time range.
         */
        $visitsFor1YearBack = HomeVisit::query()
            ->where('created_at', '<=', $endOfThisMonth)
            ->orderBy('created_at', 'DESC')

            ->where("privacy","=",false) //where support notes
            ->where('created_at', '>=', $yearBackDate) //limit to 1 year back

            ->get();


        //all foster parents on the system
        $allFosterParents = User::query()
            ->with('getCaseManager')
            ->whereIn('user_type', ExpenseConfig::roleMapping()['foster-homes']) //foster homes only
            ->get();


        $grouped = [];
        //loop through every month between the given dates
        foreach (CarbonPeriod::create($yearBackDate, '1 month', $endOfThisMonth) as $period)  {

            $visitsForThisMonth = $visitsFor1YearBack
                ->where('created_at', '<=', $period->endOfMonth())
                ->where('created_at', '>=', $period->startOfMonth())
                ->pluck('fk_HomeID');


            $grouped[ $period->format('M Y') ] = $allFosterParents
                ->where('created_at', '<=', $period->endOfMonth()) //omit users registered in future
                ->reject(function (User $fosterUser) use($visitsForThisMonth){
                    return $visitsForThisMonth->contains($fosterUser->id);
                })
                ->groupBy('getCaseManager');

        }

        //reverse the array to bring the latest month on top
        $grouped = array_reverse($grouped);

        return view('livewire.supportnotesreport', compact('grouped'));
    }


}

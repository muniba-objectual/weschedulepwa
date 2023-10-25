<?php

namespace App\Http\Livewire\PrivacyNotesReport;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseConfig;
use App\Models\HomeVisit;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Child;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

use Livewire\WithPagination;


class PrivacyNotesReport extends Component

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
        //show 1 year back.
        $endOfQuarter = Carbon::now()->endOfQuarter();
        $yearBackDate = $endOfQuarter->copy()->subYear()->startOfMonth();

        /**
         * @var Collection|HomeVisit[] $visitsFor1YearBack
         * Home visits only to the given time range.
         */
        $visitsFor1YearBack = HomeVisit::query()
            ->where('created_at', '<=', $endOfQuarter)
            ->orderBy('created_at', 'DESC')

            ->where("privacy","=",true) //where privacy notes
            ->where('created_at', '>=', $yearBackDate) //limit to 1 year back

            ->get();


        //all case-manage children
        $caseManageChildren = Child::query()
            ->where("WeSchedule",0)
            ->where('created_at', '<=', $endOfQuarter)
            ->get();


        //all foster parents on the system
        $allFosterParents = User::query()
            ->with('getCaseManager')
            ->whereIn('user_type', ExpenseConfig::roleMapping()['foster-homes']) //foster homes only
            ->get();


        //prepare date ranges
        /** @var \DateTime[][] $dateRanges */
        $dateRanges = [];
        $end = $endOfQuarter->copy();
        for($x=1; $x<=4; $x++)  { //4 quarters back == 1 year
            $dateRanges[]=[
                'end' => $end->toDate(),
                'start' =>  $end->subMonth(2)->startOfMonth()->toDate()
            ];
            $end = $end->subSecond();
        }

        $grouped = [];
        //loop through every month between the given dates
        foreach ($dateRanges as $period)  {

            //filter foster visits for the Nth month from the given children
            $childrenInPeriod = $caseManageChildren
                // move the end-date as per the year-month pointer
                ->where('created_at', '<=', $period['end'])
                ->pluck('FosterHome_fk_UserID', 'id'); //foster-parent keyed by childId


            //filter foster visits for the Nth month
            // and then drain out the system children, based on the child-IDs in each visit
            //  Thus the remain children has not got any visit yet.
            $visitsFor1YearBack
                ->where('created_at', '<=', $period['end'])
                ->where('created_at', '>=', $period['start'])
                ->map(function (HomeVisit $visit) use (&$childrenInPeriod){
                    //for each visit get all childIds in that visit
                    // and drop them from the foster child collection
                    foreach ($visit->getChildIds() as $childId){
                        $childrenInPeriod->has($childId)?$childrenInPeriod->forget($childId):null;
                    }
                });


            $grouped[  $period['start']->format('M Y')  .' - '.$period['end']->format('M Y') ] = $caseManageChildren
                ->whereIn('id', $childrenInPeriod->keys())
                ->groupBy(function (Child $child) use ($allFosterParents){
                    return
                        $allFosterParents->where('id', $child->FosterHome_fk_UserID) //find foster-parent from collection
                            ->first() //foster-parent object
                            ->getCaseManager;
                });

        }

        return view('livewire.privacynotesreport', compact( 'grouped'));
    }


}

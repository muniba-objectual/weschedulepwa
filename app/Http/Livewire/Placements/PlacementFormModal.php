<?php

namespace App\Http\Livewire\Placements;

use App\Models\Child;
use App\Models\Placements;
use App\Models\User;
use Carbon\Carbon;
use WireElements\Pro\Components\Modal\Modal;

class PlacementFormModal extends Modal
{
    public $childId;
    public $placementType;

    public $editingPlacementId = null;

    public array $fosterPlacement = [];

    public function validationAttributes(): array
    {
        return [
            'fosterPlacement.fk_FosterUserID' => 'foster parent',
            'fosterPlacement.from_date' => 'start date',
            'fosterPlacement.to_date' => 'end date',
        ];
    }

    public function rules(): array
    {
        $maturityAge = 21; //TODO::ashain, confirm from michello
        $probableDOB =
            Child::find($this->childId)->DOB ??
            Carbon::today()->subYears($maturityAge);// assume worse case, a child about to reach end of maturity as of today

        return [
            'fosterPlacement.fk_FosterUserID' => 'required',
            'fosterPlacement.from_date' => [
                'required',
                'date',
                "after_or_equal:$probableDOB", // Placement can't start before the child's birthday

                // Custom rule to prevent overlapping placements
                function ($attribute, $fromDate, $fail) {
                    if ($fromDate) {

                        //check if fromDate goes between a existing range, if so not valid since it overlaps
                        $overlap = Placements::where('fk_ChildID', $this->childId)
                            ->where('type', $this->placementType)
                            ->where('id', '!=', $this->editingPlacementId)
                            ->whereNotNull('to_date')
                            ->where('to_date', '>=', $fromDate)
                            ->where('from_date', '<=', $fromDate)
                            ->first();

                        if($overlap){
                            $fail("The `from date` overlaps with placement ({$overlap->from_date} -to- {$overlap->to_date}).");
                        }

                        //Ref:xx1 (validation when placing a new placement without end date)
                        if(!isset($this->fosterPlacement['to_date']) || !$this->fosterPlacement['to_date']){ //not-set || null
                            // a $toDate can only be empty if it set as the last placement record,
                            // therefore make sure the $fromDate of the new entry is set after the existing placement's->from_date

                            //find the last placement, assuming the to_date is null in the latest placement
                            $lastPlacement = Placements::query()
                                ->where('fk_ChildID', $this->childId)
                                ->where('type', $this->placementType)
                                ->where('id', '!=', $this->editingPlacementId)
                                ->whereNull('to_date')
                                ->first();

                            //sometimes the last placement may have a pre-scheduled end date, so look for the latest to_date
                            if(!$lastPlacement){
                                $lastPlacement = Placements::query()
                                    ->where('fk_ChildID', $this->childId)
                                    ->where('type', $this->placementType)
                                    ->where('id', '!=', $this->editingPlacementId)
                                    ->orderByDesc('to_date')
                                    ->first();
                            }

                            //check if the last_placement->from_date < new_placement->from_date, if not throw validation
                            if(
                                $lastPlacement && //given that there is a existing (last) placement
                                (new Carbon($lastPlacement->from_date))->gte(
                                    (new Carbon($this->fosterPlacement['from_date']))
                                )
                            ){
                                $fail("Since the `end date` is not set, this is considered as the latest placement, therefor the `from date` cannot be behind a existing placement ({$lastPlacement->from_date} -to- ".($lastPlacement->to_date??'Now').").");
                            }
                        }
                    }
                },
            ],
            'fosterPlacement.to_date' => [
                'nullable',
                'date',
                'after_or_equal:fosterPlacement.from_date',

                // Custom rule to prevent overlapping placements
                function ($attribute, $toDate, $fail) {
                    if ($toDate) {

                        //check if toDate goes between a existing range, if so not valid since it overlaps
                        $overlap = Placements::query()
                            ->where('fk_ChildID', $this->childId)
                            ->where('type', $this->placementType)
                            ->where('id', '!=', $this->editingPlacementId)
                            ->whereNotNull('to_date')
                            ->where('to_date', '>=', $toDate)
                            ->where('from_date', '<=', $toDate)
                            ->first();

                        if($overlap){
                            $fail("The `end date` overlaps with placement ({$overlap->from_date} -to- {$overlap->to_date}).");
                        }

                        if($this->fosterPlacement['from_date']??false) { //evaluate this logic only, when the frm_date is available

                            if($this->placementType == Placements::TYPE__PERMANENT){

                                // Ensure the gap between the from_date & to_date is having at least 1 day gap.
                                // Calculate the minimum allowed "to_date" with a 1-day gap
                                $minToDate = ( new Carbon($this->fosterPlacement['from_date']))->copy()->addDay();

                                if ((new Carbon($toDate))->lt($minToDate)) {
                                    $fail("The minimum gap between 'from date' and 'end date' should be 1 day.");
                                }

                            }


                            // Even though the from_date does not overlap individually (whitelisted the "upper" bound)
                            // and the to_date does not overlap individually,  (whitelisted the "lower" bound)
                            // still there could have the possibility of placements being existing between the new placements time range.
                            // So check for existing placements "Between" the new placement's bounds.

                            //check if any DB records where the from_date falls between the new placement's time range
                            $overlap = Placements::query()
                                ->where('fk_ChildID', $this->childId)
                                ->where('type', $this->placementType)
                                ->where('id', '!=', $this->editingPlacementId)
                                ->where('from_date', '>=', $this->fosterPlacement['from_date'])
                                ->where('from_date', '<=', $toDate)
                                ->first();

                            if($overlap){
                                $fail("The existing placement ({$overlap->from_date} -to- ".($overlap->to_date??'Now').") overlaps with the new given time range.");
                            }

                            //if the `from_date` check up is looking good then extend the validation checkup to the `to_date` field.
                            if(!$overlap){

                                //check if any DB records where the to_date falls between the new placement's time range
                                $overlap = Placements::query()
                                    ->where('fk_ChildID', $this->childId)
                                    ->where('type', $this->placementType)
                                    ->where('id', '!=', $this->editingPlacementId)
                                    ->whereNotNull('to_date')
                                    ->where('to_date', '>=', $this->fosterPlacement['from_date'])
                                    ->where('to_date', '<=', $toDate)
                                    ->first();

                                if($overlap){
                                    $fail("The `end date` overlaps with placement ({$overlap->from_date} -to- {$overlap->to_date}).");
                                }
                            }

                        }

                    }else{
                        //handle from date, this should not be behind the existing placement's from_date,
                        //*** this validation is already implemented in the `from_date` field. (Ref:xx1)
                    }
                },
            ],
        ];
    }

    public static function attributes(): array
    {
        return [
            // Set the modal size to 7xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
            'size' => '7xl',

        ];
    }

    /**
     * @throws \Throwable
     */
    public function mount(int $childId = null, string $placementType = null, int $placementId = null): void
    {
        if($placementId !== null){
            //working in **editing** mode
            $placement = Placements::query()->find($placementId);
            $this->editingPlacementId = $placement->id;
            $this->childId = $placement->fk_ChildID;
            $this->placementType = $placement->type;

            $this->fosterPlacement = $placement->toArray(); //load current data

        }else{
            //working in **addition** mode

            //validate {$placementType} options
            throw_unless($placementType == Placements::TYPE__PERMANENT | $placementType == Placements::TYPE__RELIEF, "Invalid `placement type` argument.");

            $this->childId = $childId;
            $this->placementType = $placementType;
        }
    }

    public function add(): void
    {
        $this->validate();

        // The lookup should be performed prior to the new placement saving!!
        $previousPlacement = Placements::query()
            ->where('fk_ChildID', $this->childId)
            ->where('type', $this->placementType)
            ->whereNull('to_date')
            ->where('from_date', '<=',$this->fosterPlacement['from_date']) //this constraint is important when in edit mode, to avoid false positives.
            ->orderByDesc('from_date')
            ->first();


        $savingPlacement = $this->editingPlacementId ?
            Placements::find($this->editingPlacementId)
            :new Placements();

        $savingPlacement->fk_ChildID = $this->childId;
        $savingPlacement->fk_FosterUserID = $this->fosterPlacement['fk_FosterUserID'];
        $savingPlacement->type = $this->placementType;
        $savingPlacement->from_date = $this->fosterPlacement['from_date'];
        $savingPlacement->to_date = $this->fosterPlacement['to_date']??null;
        $savingPlacement->save();

        // Update the end date of the previous placement (if any)
        if ($previousPlacement) {
            $previousPlacement->to_date = (new  Carbon($this->fosterPlacement['from_date']))->subDay();
            $previousPlacement->save();
        }



        // Check if today's date falls between from_date and to_date of **ANY** of the modified placements.
        // If found, then set the child->FosterHome_fk_UserID to the placement->fk_FosterUserID
        $child = $savingPlacement->child;

        //evaluate the modal's placement record.
        if (
            ($savingPlacement->from_date <= now())
            && (!$savingPlacement->to_date || $savingPlacement->to_date >= now()) //to_date can be null
        ) {
            $child->FosterHome_fk_UserID = $savingPlacement->fk_FosterUserID;
        }

        // else if the today is not found in the modal's placement,
        // then there could be a possibility of having today's date falling between the previous (to_date adjusted) placement.
        elseif (
            $previousPlacement //if there is a previous placement
            && ($previousPlacement->from_date <= now())
            && ($previousPlacement->to_date >= now())  //`to_date` won't be null, since if, $previousPlacement was found then it's 'to_date' is already assigned by now.
        ) {
            $child->FosterHome_fk_UserID = $previousPlacement->fk_FosterUserID;
        }

        //save the updated child if `FosterHome_fk_UserID` was modified.
        if( $child->isDirty('FosterHome_fk_UserID') ){
            $child->save();
        }

        $this->close();
    }


    public function render()
    {
        $fosterFamilies = User::where('user_type','>','2.0')
            ->where('user_type','<','3.0')
            ->orderBy('name','ASC')
            ->get();

        $child = \App\Models\Child::find($this->childId);

        return view('livewire.placements.placement-form-modal', compact('fosterFamilies', 'child'));
    }
}

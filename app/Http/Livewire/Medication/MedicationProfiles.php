<?php

namespace App\Http\Livewire\Medication;

use App\Models\Medication_Profile;
use App\Models\Child;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;


class MedicationProfiles extends LivewireDatatable
{


    public $hideable = "select";
    public Child $child;

    protected $listeners = ['refreshDataTable' => 'refreshTable'];

    public function builder()
    {
        return Medication_Profile::where('fk_ChildID','=',$this->child->id);
    }

    public function columns()
    {
        return [

            /*
            NumberColumn::name('id')
                ->label('ID')
                ->linkTo('Medication_Profile'),
            */

            Column::name('type')
                ->label('Type')
                ->searchable()
                ->editable(),


                //->filterable(),

            Column::name('dosage')
                ->label('Dosage')
                //->searchable()
                ->editable(),


            Column::delete()
                ->label('Actions')


        ];
    }


    public function refreshTable()
    {
        $this->refreshLivewireDatatable();
    }
}

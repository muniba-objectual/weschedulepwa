<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SRA_Contracts;
use Livewire\WithFileUploads;

class SRAContracts extends Component
{

    use WithFileUploads;
    public $contract_attachment;

    public $user;
    public $child;
    public $SRA_Contracts;



    protected $listeners = [
        'addContract' => 'addContract'
    ];

    public function saveDateOfApprovedSRA() {

    }

    public function save()
    {
//       $this->validate([
//       'photo' => 'image|max:1024', // 1MB Max
//      ]);
        if (is_object($this->contract_attachment)) {
            $tmpStore = $this->contract_attachment->store('public/SRA_Contracts');

            $tmpContract = new SRA_Contracts();

            $tmpContract->fk_UserID = $this->user->id;
            $tmpContract->fk_ChildID = $this->child->id;
            $tmpContract->contract_attachment = $tmpStore;

            $tmpContract->save();

        }


    }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible class="form-group mt-5">
            <script>

            </script>




            <label for="SRA_Contract">Contract Attachment(s)</label>
            @php
                $SRA_Contracts = \App\Models\SRA_Contracts::where('fk_ChildID','=',$child->id)->get();
            @endphp
            @if (count($SRA_Contracts) >= 1)
                <ul>
            @endif
            @foreach ($SRA_Contracts as $entries)
                @php
                    $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name;
                    $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('M d, Y @h:i A');
                @endphp
                    <li><a href="/storage/SRA_Contracts/{{substr($entries->contract_attachment,21)}}">Attachment #{{$entries->id}}</a> uploaded by {{$tmpUser}} at {{$tmpDate}}</li><br />

            @endforeach

            <form wire:submit.prevent="save">
                <input type="file" class="SRA_Contract" wire:model="contract_attachment">

                    @error('contract_attachment') <span class="error">{{ $message }}</span> @enderror

                    <button class="float-right mt-2 mb-2" type="submit">Add Contract Entry</button>
            </form>
             @if (count($SRA_Contracts) >= 1)
                </ul>
            @endif

        </div>

        blade;
    }
}

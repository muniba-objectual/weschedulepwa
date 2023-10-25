<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class CalendarColorPicker extends Component
{
   public $userID;
   public $user;

    protected $listeners = ['updatedColor' => 'updatedColor'];



    protected $rules = [
        'user.calendarColor' => 'nullable',


    ];
    public function mount() {
       $this->user = User::where('id','=',$this->userID)->first();

   }

   public function updatedColor($newColor) {
    if ($newColor) {
        $this->user->calendarColor = $newColor;
    }

                $this->user->save();
   }

    public function render()
    {
        return <<<'blade'
            <div>

                 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
                                    <input wire:model="user.calendarColor" id="colorPick" type="text" class="colorpicker" />
                                    <button wire:click="$emit('updatedColor', $('#colorPick').val())">Update Color</button>
                                    <script>
                                        $('.colorpicker').colorpicker();

                                        // $('#colorPick').on('change', function(event) {
                                        //        Livewire.emit('updatedColor')
                                        //
                                        //
                                        // });
                                    </script>
            </div>
        blade;
    }
}

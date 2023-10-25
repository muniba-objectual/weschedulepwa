<?php

namespace App\Http\Livewire;

use Livewire\Component;
class ChildAdmin extends Component
{
   public $child;
    protected $guard_name = 'web';

   public $toggleVisible_Profile;

   public function updated($field, $value) {
       if ($field == "toggleVisible_Profile") {
           if ($value) {
               $this->toggleVisible_Profile = true;
               $this->child->givePermissionTo('child_profile_view_Activity');
               $this->dispatchBrowserEvent('toggleVisible_Profile', ['inactive' => $value]);

           } else {
               $this->toggleVisible_Profile = false;
           }
       }
   }

   public function mount() {
       $this->toggleVisible_Profile = true;
   }
    public function render()
    {
        return <<<'blade'
            <div>
            {{-- Setup data for datatables --}}
            @php
            $heads = [

                'Tab',
                ['label' => 'Status', 'width' => 40],
            ];


            $config = [
                'data' => [
                    ['Profile', $child->can('child_profile_view_Activity')],
                    ['Activity', ''],
                    ['Timeline', ''],
                    ['Medication', ''],
                    ['Safety Plan', ''],
                ],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
            ];
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table999" :heads="$heads">
                @foreach($config['data'] as $row)
                    <tr>
                       <td>{!! $row[0] !!}</td>
                       <td>
                        <div wire:poll.active class="custom-control custom-switch custom-switch-md custom-switch-off-danger custom-switch-on-success">

                            @if ($row[1] != 1)
                                <input wire:model="toggleVisible_{!! $row[0] !!}"  type="checkbox" class="custom-control-input" id="toggleVisible_{!! $row[0] !!}" >
                                <label class="custom-control-label" for="toggleVisible_{!! $row[0] !!}">Disabled</label>
                                <script>
                                    $('#toggleVisible_{!! $row[0] !!}').prop('checked', false);

                                </script>
                            @else
                                <input wire:model="toggleVisible_{!! $row[0] !!}"  type="checkbox" class="custom-control-input" id="toggleVisible_{!! $row[0] !!}" checked>
                                <label class="custom-control-label" for="toggleVisible_{!! $row[0] !!}">Enabled</label>
                                <script>
                                    $('#toggleVisible_{!! $row[0] !!}').prop('checked', true);

                                </script>
                            @endif

                            <script>

                            window.addEventListener('2toggleVisible_{!! $row[0] !!}', data => {
                                            if (data) {
                                                console.log ('set to checked');
                                                $('#toggleVisible_{!! $row[0] !!}').prop('checked', true)
                                            } else {
                                                console.log ('set to unchecked');
                                                $('#toggleVisible_{!! $row[0] !!}').prop('checked', false)

                                            }
                             });



                          $('#toggleVisible_{!! $row[0] !!}').change(function() {
                                    if (!$(this).is(':checked')) {
                                        @this.set('toggleVisible_{!! $row[0] !!}',false)
                                        $('#toggleVisible_{!! $row[0] !!}').prop('checked', false);
                                        console.log ('set to unchecked (change)');


                                    } else {
                                        @this.set('toggleVisible_{!! $row[0] !!}',true)
                                        $('#toggleVisible_{!! $row[0] !!}').prop('checked', true);
                                        console.log ('set to checked (change)');



                                    }

                            });
                            </script>

                        </div>

                       </td>

                    </tr>
                @endforeach


            </x-adminlte-datatable>

                <script>
                  $(function()  {
                                @if ($toggleVisible_Profile)
                                    //alert ('visible');
                                    $('#toggleVisible_Profile').prop('checked', true);
                                @else
                                    // alert ('not visible');
                                    $('#toggleVisible_Profile').prop('checked', false);
                                @endif
                            });
                  </script>
            </div>
        blade;
    }
}

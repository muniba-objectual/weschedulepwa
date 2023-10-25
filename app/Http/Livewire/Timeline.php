<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Model\Child;
use App\Models\User;
use App\Models\Shift;
use App\Models\Shift_Form;
use Livewire\WithPagination;


class Timeline extends Component
{
    use WithPagination;

    public $timeline_data;
    public $timeline_data_EOD_forms_unique;
    public  $child;
    public  $user;

   public function mount() {

       //$timeline_data = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $child->id)->where('event','=','IR')->orWhere('event','=','Medication')->orWhere('event','=','EndOfShiftForm')->orWhere('event','=','ShiftSignIn')->orWhere('event','=','ShiftSignOut')->orderBy('updated_at', 'DESC')->paginate(50)->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});

       $this->timeline_data = Activity::where('subject_type','=','App\Models\Child')->Where('subject_id','=', $this->child->id)->Where('log_name','!=','Wall')->orderBy('updated_at', 'DESC')->paginate(9999)->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});
       $this->timeline_data_EOD_forms_unique = Activity::where('subject_type','=','App\Models\Child')->Where('subject_id','=', $this->child->id)->Where('log_name','=','EndOfShiftForm')->orderBy('updated_at', 'DESC')->paginate(9999)->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});

       $this->user = User::where('id','=',Auth::id());

   }

    public function render()
    {
        return <<<'blade'
                                <div class="timeline timeline-inverse ">


                        @if ($this->timeline_data->count() > 0)
                            {{--$myshift_timeline--}}
                            @foreach ($this->$timeline_data as $key=>$timeline)

                                <div class="time-label">
        <span class="bg-success">
          {{$key}}

        </span>
                                </div>


                                @foreach ($timeline as $details)

                                    <div>

                                        @if ($details->event == "IR")
                                            <i class="fas fa-exclamation bg-red"></i>
                                        @endif

                                        @if ($details->event == "Medication")

                                            <i class="fas fa-prescription-bottle bg-green"></i>
                                        @endif
                                        @if ($details->event == "EndOfShiftForm")

                                            <i class="fas fa-business-time bg-blue"></i>
                                        @endif

                                        @if ($details->event == "ShiftSignIn")

                                            <i class="fas fa-hourglass-start bg-gradient-green"></i>
                                        @endif

                                        @if ($details->event == "ShiftSignOut")

                                            <i class="fas fa-hourglass-end bg-gradient-red"></i>
                                        @endif

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($details->updated_at)->format('D M d @h:i A') }}</span>


                                            @if ($details->event == "IR")

                                                <h3 class="timeline-header">{{App\Models\User::getUser($details->causer_id)->name}}
                                                    submitted an <span class="font-weight-bold"><a
                                                            href="javascript:viewIR({{$details->properties}});">Incident Report</a></span>
                                                </h3>
                                            @endif

                                            @if ($details->event == "Medication")

                                                <h3 class="timeline-header">{{App\Models\User::getUser($details->causer_id)->name}}
                                                    submitted a <span class="font-weight-bold">Medication Entry</span>
                                                </h3>
                                            @endif

                                            @if ($details->event == "EndOfShiftForm")


                                                <h3 class="timeline-header panel-heading"
                                                    data-toggle="collapse" role="button"
                                                    aria-expanded="true"
                                                    aria-controls="#collapseddiv_{{$details->id}}"
                                                    data-target="#collapseddiv_{{$details->id}}">{{App\Models\User::getUser($details->causer_id)->name}}
                                                    submitted an <span class="font-weight-bold">End of Shift Report</span>
                                                </h3>

                                            @endif

                                            @if ($details->event == "ShiftSignIn")

                                                <h3 class="timeline-header">{{App\Models\User::getUser($details->causer_id)->name}}
                                                    <span class="font-weight-bold">Signed In</span></h3>
                                            @endif

                                            @if ($details->event == "ShiftSignOut")

                                                <h3 class="timeline-header">{{App\Models\User::getUser($details->causer_id)->name}}
                                                    <span class="font-weight-bold">Signed Out</span>
                                                </h3>
                                            @endif

                                            @if ($details->event == "IR" || $details->event == "Medication" || $details->event == "EndOfShiftForm")
                                                <div @if ($details->event == "EndOfShiftForm") class="collapse" @endif
                                                     id="collapseddiv_{{$details->id}}">
                                                    <div class="timeline-body" class="panel-heading">
                                                        @if ($details->event == "EndOfShiftForm")

                                                            @if ($shiftDetails = \App\Models\Shift::find($details->properties->first())) @endif
                                                            @if ($shiftDetails)
                                                                @if ($shiftForm = \App\Models\Shift_Form::findOrFail($shiftDetails->fk_ShiftFormID)) @endif
                                                            @else
                                                                @php
                                                                    $shiftForm = NULL
                                                                @endphp
                                                            @endif



                                                            @if ($shiftForm)

                                                                Date/Time: {{ $shiftForm['datetime'] }}
                                                                <br/>
                                                                Mood Upon
                                                                Arrival: {{ $shiftForm['mood_upon_arrival'] }}
                                                                <br/>
                                                                Interaction with
                                                                Staff: {{ $shiftForm['interaction_with_staff'] }}
                                                                <br/>
                                                                General
                                                                Observations: {{ $shiftForm['general_observations'] }}
                                                                <br/>Dietary
                                                                Notes: {{ $shiftForm['dietary_notes'] }}
                                                                <br/>
                                                                <br/>
                                                                *Last
                                                                Updated: {{$shiftForm['updated_at']}}

                                                            @endif

                                                            {{-- var_dump(json_decode($details->description, true)) --}}
                                                        @else
                                                            {{$details->description}}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif


                                            <div class="timeline-footer">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->


                                    @endforeach
                                    </ul>
                                    {{--$timeline--}}
                                @endforeach
                                @endif
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                    </div>

        blade;
    }
}

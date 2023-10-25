<style>
    .timeline_pagination .pagination {
        margin-left: 58px !important;
    }
</style>
<script>
    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                getTimelineData(page);
            }
        }
    });
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(e) {
            $stripPath = $(this).attr('href').split('page=')[1].split('&')[0]
            getTimelineData($stripPath);
            e.preventDefault();
        });
    });

    function getTimelineData(page) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: "{{ route('child.getTimelineData') }}",
            type: 'GET',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                page: page,
                childID: {{ $childID }}
            },
            //dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function(data) {
                console.log(data);
                $('#timeline').html(data);
            }
        });
    }
</script>
<!-- The timeline -->
<div id="timelineData" class="timeline timeline-inverse ">
    @if ($timeline_data->count() > 0)

        {{-- $myshift_timeline --}}
        @foreach ($timeline_data as $key => $timeline)
            <div class="time-label">
                <span class="bg-success">
                    {{ $key }}

                </span>
            </div>


            @foreach ($timeline as $details)
                <div>
                    @if ($details->event == 'IR')
                        <i class="fas fa-exclamation bg-red"></i>
                    @endif

                    @if ($details->event == 'Medication')
                        <i class="fas fa-prescription-bottle bg-green"></i>
                    @endif
                    @if ($details->event == 'EndOfShiftForm')
                        <i class="fas fa-business-time bg-blue"></i>
                    @endif

                    @if ($details->event == 'ShiftSignIn')
                        <i class="fas fa-hourglass-start bg-gradient-green"></i>
                    @endif

                    @if ($details->event == 'ShiftSignOut')
                        <i class="fas fa-hourglass-end bg-gradient-red"></i>
                    @endif

                    @if ($details->event == 'HomeVisit')
                        <i class="fas fa-hourglass-end bg-gradient-yellow"></i>
                    @endif

                    @if ($details->event == 'PrivacyVisit')
                        <i class="fas fa-hourglass-end bg-gradient-red"></i>
                    @endif

                    @if ($details->event == 'OnCall')
                        <i class="fas fa-clipboard bg-gradient-orange"></i>
                    @endif


                    <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i>
                            {{ $diff = Carbon\Carbon::parse($details->created_at)->format('D M d @h:i A') }}</span>


                        @if ($details->event == 'IR')
                            <h3 class="timeline-header">{{ $details->causer->name }}
                                submitted an <span class="font-weight-bold"><a
                                        href="javascript:viewIR({{ $details->properties }});">Incident Report</a></span>
                            </h3>
                        @endif

                        @if ($details->event == 'Medication')
                            <h3 class="timeline-header">{{ $details->causer->name }}
                                submitted a <span class="font-weight-bold">Medication Entry</span>
                            </h3>
                        @endif

                        @if ($details->event == 'EndOfShiftForm')

                            <h3 class="timeline-header panel-heading" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="#collapseddiv_{{ $details->id }}"
                                data-target="#collapseddiv_{{ $details->id }}">@if ($details->causer){{ $details->causer->name }}@else N/A - {{$details->id}} @endif
                                submitted an <span class="font-weight-bold">End of Shift Report</span>
                            </h3>
                        @endif

                        @if ($details->event == 'ShiftSignIn')
                            <h3 class="timeline-header">@if ($details->causer){{ $details->causer->name }}@else N/A @endif
                                <span class="font-weight-bold">Signed In</span>
                            </h3>
                        @endif

                        @if ($details->event == 'ShiftSignOut')
                            <h3 class="timeline-header">@if ($details->causer){{ $details->causer->name }} @else N/A @endif
                                <span class="font-weight-bold">Signed Out</span>
                            </h3>
                        @endif

                        @if ($details->event == 'HomeVisit')
                            <h3 class="timeline-header">{{ App\Models\User::getUser($details->causer_id)->name }}
                                submitted a <span class="font-weight-bold">Home Site Visit Entry</span>
                                @if ($details->properties->first())
                                    at <span
                                        class="font-weight-bold">{{ App\Models\User::getUser($details->properties->first())->name }}
                                        [{{ App\Models\User::getUser($details->properties->first())->address }}]</span>
                                @endif
                            </h3>
                        @endif

                        @if ($details->event == 'PrivacyVisit')
                            <h3 class="timeline-header">{{ App\Models\User::getUser($details->causer_id)->name }}
                                submitted a <span class="font-weight-bold">Privacy Visit Entry</span>
                                @if ($details->properties->first())
                                    with <span
                                        class="font-weight-bold">{{ App\Models\Child::getChild($details->properties->first())->initials }}
                                    </span>
                                @endif
                            </h3>
                        @endif

                        @if ($details->event == 'OnCall')
                            <h3 class="timeline-header">{{ App\Models\User::getUser($details->causer_id)->name }}
                                submitted an <span class="font-weight-bold">On-Call Entry</span>
                                @if ($details->properties->first())
                                    at <span
                                        class="font-weight-bold">{{ App\Models\User::getUser($details->properties->first())->name }}
                                        [{{ App\Models\User::getUser($details->properties->first())->address }}]</span>
                                @endif
                            </h3>
                        @endif

                        @if (
                            $details->event == 'IR' ||
                                $details->event == 'Medication' ||
                                $details->event == 'EndOfShiftForm' ||
                                $details->event == 'HomeVisit' ||
                                $details->event == 'PrivacyVisit' ||
                                $details->event == 'OnCall')
                            <div @if ($details->event == 'EndOfShiftForm') class="collapse" @endif
                                id="collapseddiv_{{ $details->id }}">
                                <div class="timeline-body" class="panel-heading">
                                    @if ($details->event == 'EndOfShiftForm')
                                        @if ($shiftDetails = \App\Models\Shift::find($details->properties->first()))
                                        @endif
                                        @if ($shiftDetails)
                                            @if ($shiftForm = \App\Models\Shift_Form::findOrFail($shiftDetails->fk_ShiftFormID))
                                            @endif
                                        @else
                                            @php
                                                $shiftForm = null;
                                            @endphp
                                        @endif



                                        @if ($shiftForm)
                                            Date/Time: {{ $shiftForm['datetime'] }}
                                            <br />
                                            Mood Upon
                                            Arrival: {{ $shiftForm['mood_upon_arrival'] }}
                                            <br />
                                            Interaction with
                                            Staff: {{ $shiftForm['interaction_with_staff'] }}
                                            <br />
                                            General
                                            Observations: {{ $shiftForm['general_observations'] }}
                                            <br />
                                            Dietary
                                            Notes: {{ $shiftForm['dietary_notes'] }}
                                            <br />
                                            <br />
                                            *Last
                                            Updated: {{ $shiftForm['updated_at'] }}
                                        @endif
                                    @else
                                        {{ $details->description }}
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
            {{-- $timeline --}}
        @endforeach

    @endif

    <div>
        <i class="far fa-clock bg-gray"></i>
    </div>
    <div class="timeline_pagination"> {{ $timeline_data->links() }}</div>


</div>

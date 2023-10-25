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
            getTimelineData($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });
    });

    function getTimelineData(page) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: "{{ route('user.getTimelineData') }}",
            type: 'GET',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                page: page,
                UserID: {{ $UserID }}
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

                    @elseif ($details->event == 'Medication')
                        <i class="fas fa-prescription-bottle bg-green"></i>

                    @elseif ($details->event == 'EndOfShiftForm')
                        <i class="fas fa-business-time bg-blue"></i>

                    @elseif ($details->event == 'ShiftSignIn')
                        <i class="fas fa-hourglass-start bg-gradient-green"></i>

                    @elseif ($details->event == 'ShiftSignOut')
                        <i class="fas fa-hourglass-end bg-gradient-red"></i>


                    @elseif ($details->event == 'HomeVisit')
                        <i class="fas fa-hourglass-end bg-gradient-yellow"></i>

                    @elseif ($details->event == 'OnCallCYSW')
                        <i class="fas fa-clipboard bg-gradient-orange"></i>

                    @elseif ($details->event == 'PrivacyVisit')
                        <i class="fas fa-hourglass-end bg-gradient-red"></i>

                    @elseif ($details->event == 'LogCall')
                        <i class="fas fa-phone bg-gradient-purple"></i>

                    @elseif ($details->event == 'LogMeeting')
                        <i class="fas fa-calendar bg-gradient-lightblue"></i>

                    @elseif ($details->event == 'PreAdmissionEmailed')
                        <i class="fa fa-solid fa-child bg-gradient-yellow"></i>
                    @endif

                    <div class="timeline-item">
                        <span class="time">
                            <i class="far fa-clock"></i>
                            {{ $diff = Carbon\Carbon::parse($details->created_at)->format('D M d @h:i A') }}
                        </span>

                        @if ($details->event == 'IR')
                            <h3 class="timeline-header">{{ $details->causer->name }}
                                submitted an <span class="font-weight-bold"><a
                                        href="javascript:viewIR({{ $details->properties }});">Incident Report</a></span>
                                for <a
                                    href="/children/{{ $details->subject->id }}">{{ $details->subject->initials }}</a>
                            </h3>

                        @elseif ($details->event == 'Medication')
                            <h3 class="timeline-header">{{ $details->causer->name }}
                                submitted a <span class="font-weight-bold">Medication Entry</span> for <a
                                    href="/children/{{ $details->subject->id }}">{{ $details->subject->initials }}</a>
                            </h3>

                        @elseif ($details->event == 'EndOfShiftForm')
                            <h3 class="timeline-header panel-heading" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="#collapseddiv_{{ $details->id }}"
                                data-target="#collapseddiv_{{ $details->id }}">{{ $details->causer->name }}
                                submitted an <span class="font-weight-bold">End of Shift Report</span> for <a
                                    href="/children/{{ $details->subject->id }}">{{ $details->subject->initials }}</a>
                            </h3>

                        @elseif ($details->event == 'ShiftSignIn')
                            <h3 class="timeline-header">{{ $details->causer->name }}
                                <span class="font-weight-bold">Signed In</span> to a Shift for <a
                                    href="/children/{{ $details->subject->id }}">{{ $details->subject->initials }}</a>
                            </h3>

                        @elseif ($details->event == 'ShiftSignOut')
                            <h3 class="timeline-header">{{ $details->causer->name }}
                                <span class="font-weight-bold">Signed Out</span> from a Shift for <a
                                    href="/children/{{ $details->subject->id }}">{{ $details->subject->initials }}</a>
                            </h3>

                        @elseif ($details->event == 'HomeVisit')
                            <h3 class="timeline-header">{{ App\Models\User::getUser($details->causer_id)->name }}
                                submitted a <span class="font-weight-bold">Home Site Visit Entry</span>
                            </h3>

                        @elseif ($details->event == 'OnCallCYSW')
                            <h3 class="timeline-header">
                                @if ($details->properties->first())
                                    <a
                                        href="/users/{{ App\Models\User::getUser($details->subject_id)->id }}">{{ App\Models\User::getUser($details->subject_id)->name }}</a>
                                    submitted an <span class="font-weight-bold">On-Call CYSW Entry</span> for
                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                @else
                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                    submitted an <span class="font-weight-bold">On-Call CYSW Entry</span> for <a
                                        href="/users/{{ App\Models\User::getUser($details->subject_id)->id }}">{{ App\Models\User::getUser($details->subject_id)->name }}</a>
                                @endif
                            </h3>

                        @elseif ($details->event == 'PrivacyVisit')
                            <h3 class="timeline-header">{{ App\Models\User::getUser($details->causer_id)->name }}
                                submitted a <span class="font-weight-bold">Privacy Visit Entry</span>
                                @if ($details->properties->first())
                                    with <span
                                        class="font-weight-bold">{{ App\Models\Child::getChild($details->properties->first())->initials }}
                                    </span>
                                @endif
                            </h3>

                        @elseif ($details->event == 'LogCall')
                            <h3 class="timeline-header">{{ App\Models\User::getUser($details->subject_id)->name }}
                                submitted a <span class="font-weight-bold">Log Call Entry for
                                    {{ App\Models\User::getUser($details->causer_id)->name }}</span>
                            </h3>

                        @elseif ($details->event == 'LogMeeting')
                            <h3 class="timeline-header">{{ App\Models\User::getUser($details->subject_id)->name }}
                                submitted a <span class="font-weight-bold">In-Person Meeting Entry for
                                    {{ App\Models\User::getUser($details->causer_id)->name }}</span>
                            </h3>

                        @elseif ($details->event == 'PreAdmissionEmailed')
                            <?php
                                /** @var \App\Models\DocumentShare $documentShare */
                                $documentShare = \App\Models\DocumentShare::find($details->subject_id);
                            ?>
                            <h3 class="timeline-header">
                                {{ App\Models\User::getUser($details->causer_id)->name }} emailed a
                                <span class="font-weight-bold">`Pre-Admission Form`</span> to
                                <span class="font-weight-bold">`{{implode('`, `', $documentShare->email)}}`</span> on
                                <span class="font-weight-bold">`{{$documentShare->email_sent_at}}`</span>
                            </h3>
                        @endif


                        @if (
                            $details->event == 'IR' ||
                            $details->event == 'Medication' ||
                            $details->event == 'EndOfShiftForm' ||
                            $details->event == 'HomeVisit' ||
                            $details->event == 'OnCallCYSW' ||
                            $details->event == 'PrivacyVisit' ||
                            $details->event == 'LogCall' ||
                            $details->event == 'LogMeeting' ||
                            $details->event == 'PreAdmissionEmailed'
                        )
                            <div @if ($details->event == 'EndOfShiftForm') class="collapse" @endif id="collapseddiv_{{ $details->id }}">
                                <div class="timeline-body" class="panel-heading">
                                    <p class="ml-2">
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
                                        @elseif($details->event == 'PreAdmissionEmailed')
                                            <?php
                                                $form = new \App\Models\TempFormData();
                                                $form->forceFill($details->properties['form-data']);
                                            ?>
                                            <br/>
                                            <span><i class="fas fa-file-alt"></i></span>
                                            <a href="/TestFormBuilder/3/{{$form->id}}?back-text=Timeline">
                                                {{$form->getVal('child_name', 'Un-named Child')}}'s pre-admission form
                                            </a>
                                        @else
                                            {{ $details->description }}
                                        @endif
                                    </p>
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

<div>

    <style>
        .timeline_pagination .pagination {
            margin-left: 58px !important;
        }
    </style>
    <script>
        {{--$(window).on('hashchange', function() {--}}
        {{--    if (window.location.hash) {--}}
        {{--        var page = window.location.hash.replace('#', '');--}}
        {{--        if (page == Number.NaN || page <= 0) {--}}
        {{--            return false;--}}
        {{--        } else {--}}
        {{--            getTimelineData(page);--}}
        {{--        }--}}
        {{--    }--}}
        {{--});--}}
        {{--$(document).ready(function() {--}}
        {{--    $(document).on('click', '.pagination a', function(e) {--}}
        {{--        getTimelineData($(this).attr('href').split('page=')[1]);--}}
        {{--        e.preventDefault();--}}
        {{--    });--}}
        {{--});--}}

        {{--function getTimelineData(page) {--}}
        {{--    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');--}}
        {{--    $.ajax({--}}
        {{--        /* the route pointing to the post function */--}}
        {{--        url: "{{ route('user.getTimelineData') }}",--}}
        {{--        type: 'GET',--}}
        {{--        /* send the csrf-token and the input to the controller */--}}
        {{--        data: {--}}
        {{--            _token: CSRF_TOKEN,--}}
        {{--            page: page,--}}
        {{--            UserID: {{ $UserID }}--}}
        {{--        },--}}
        {{--        //dataType: 'JSON',--}}
        {{--        /* remind that 'data' is the response of the AjaxController */--}}
        {{--        success: function(data) {--}}
        {{--            console.log(data);--}}
        {{--            $('#timeline').html(data);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
    </script>

    <!-- The timeline -->
    <div id="timelineData" class="timeline timeline-inverse ">

        @if ($timeline_data->count() > 0)

            {{-- $timeline_data --}}
            @foreach ($timeline_data as $key => $timeline)

                <div class="time-label"><span class="bg-success">{{ $key }}</span></div>

                @foreach ($timeline as $details)
                    <div>
                        @if ($details->event == 'AssignedChildToPlacementWorker')
                            <i class="fas fa-exclamation bg-yellow"></i>
                        @endif

                        <div class="timeline-item">

                            <span class="time"><i class="far fa-clock"></i>{{ $diff = Carbon\Carbon::parse($details->created_at)->format('D M d @h:i A') }}</span>

                            @if ($details->event == 'AssignedChildToPlacementWorker')
                                    <?php
                                    /** @var \App\Models\PlacingAgency $placingAgency */
                                    $placingAgency = \App\Models\PlacingAgency::find($details->subject_id);
                                    $form   = (new \App\Models\TempFormData())->forceFill($details->properties['form-data']);
                                    $worker = (new \App\Models\PlacingAgencyWorkers())->forceFill($details->properties['worker']);
                                    ?>
                                <h3 class="timeline-header">
                                    `<span class="font-weight-bold">{{ App\Models\User::getUser($details->causer_id)->name }}</span>` assigned child
                                    `<span class="font-weight-bold">{{$form->getVal('child_name', 'Un-named Child')}}</span>` to placement worker
                                    `<span class="font-weight-bold">{{$worker->name}}</span>` ({{$worker->email}})
                                </h3>
                            @endif


                            @if (
                                $details->event == 'AssignedChildToPlacementWorker'
                            )
                                <div id="collapseddiv_{{ $details->id }}">
                                    <div class="timeline-body" class="panel-heading">
                                        <p class="ml-2">
                                            @if($details->event == 'AssignedChildToPlacementWorker')
                                                <br/>
                                                <span><i class="fas fa-file-alt"></i></span>
                                                <a href="/TestFormBuilder/3/{{$form->id}}?back-text=Timeline">
                                                    {{$form->getVal('child_name', 'Un-named Child')}}'s pre-admission
                                                    form
                                                </a>
                                            @else
                                                {{ $details->description }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="timeline-footer"></div>
                        </div>
                    </div>
                    <!-- END timeline item -->

                @endforeach
                {{-- $timeline --}}

            @endforeach

        @endif

        <div>
            <i class="far fa-clock bg-gray"></i>
        </div>

        <div class="timeline_pagination"> {{ $timeline_data->links() }}</div>

    </div>
</div>

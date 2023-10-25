<div id="timelineData" class="timeline timeline-inverse ">
    @if ($timeline_data->count() > 0)

        {{--$myshift_timeline--}}
        @foreach ($timeline_data as $key=>$timeline)

            <div class="time-label">
                <span class="bg-success">
                  {{$key}}
                </span>
            </div>

            <?php
                $isAdmin = Auth::User()->get_user_type->type == '10.0';
                /** @var \App\Models\TempFormData $details */
            ?>
            @foreach ($timeline as $details)
                <div>
                    <i class="fas fa-child bg-gradient-blue"></i>
                    <div class="timeline-item">


                        <span class="time">

                             @if($isAdmin && !$details->childAsAPreAdmission)
                                <span style="cursor: pointer;" wire:click="deletePreAdmissionForm( {{$details->id}} )" class="text-danger" title="Delete Pre-Admission Form">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </span>
                                &nbsp;|&nbsp;
                            @endif

                            @if($details->childAsAPreAdmission)
                                <a href="/children/{{$details->childAsAPreAdmission->id}}">Child Created</a>
                                 &nbsp;|&nbsp;
                            @endif


                            <?php
                                 $mailShares = $details->getVal('document_share_ids', []);
                                 if(count($mailShares)){
                                     $documentShare = $allDocumentShares[ max($details->getVal('document_share_ids',[])) ];
                                 }
                            ?>
                             @if( count($mailShares) )
                                     <span class="text-success" title="Email sent at {{$documentShare->email_sent_at}}">
                                    <i class="fa fa-lg fa-fw fa-envelope"></i> {{ $documentShare->email_sent_at }}
                                </span>
                                 &nbsp;|&nbsp;
                             @endif

                            <i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($details->created_at)->format('D M d @h:i A') }}
                        </span>

                        <h3 class="timeline-header panel-heading"
                            id="timeline_header_{{$details->id}}"
                            data-toggle="" role="button"
                            aria-expanded="true"
                            aria-controls="#collapseddiv_{{$details->id}}"
                            data-target="#collapseddiv_{{$details->id}}"
                        >
                            <a href="/TestFormBuilder/3/{{$details->id}}?PDF=true&back-text=Child Referral Report">
                                <i class="fas fa-eye"></i> Child: {{$details->getVal('child_name', 'Un-named Child')}}
                            </a>


                            <br/><br/>
                            <div class="container-fluid">
                                <div class="row">
                                    <ul>
                                        <li>Created by: {{$details->getVal('created_by.name', 'N/A')}}</li>
                                        <li>Updated by: {{$details->getVal('edited_by.name', 'N/A')}}</li>
                                        <li>Placement Worker: {!! $allPlacingAgencyWorkers[$details->getVal('placement_worker_id')]->name??"<em>-Not Selected-</em>" !!}</li>
                                    </ul>
                                </div>
                            </div>

                        </h3>


                        <div  wire:ignore class="" id="collapseddiv_{{$details->id}}"></div>
                    </div>
                </div>
                <!-- END timeline item -->

            @endforeach
            {{--$timeline--}}

        @endforeach

    @endif

    <div><i class="far fa-clock bg-gray"></i></div>
    <div class="timeline_pagination"> {{ $timeline_data->links() }}</div>
</div>

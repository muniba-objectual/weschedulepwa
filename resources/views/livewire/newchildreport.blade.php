<div id="timelineData" class="timeline timeline-inverse ">
    @if ($timeline_data->count() > 0)

        {{--$myshift_timeline--}}
        @foreach ($timeline_data as $key=>$timeline)
            <div class="time-label">
                <span class="bg-success">
                  {{$key}}

                </span>
            </div>


            @foreach ($timeline as $details)
                <div>
                    <i class="fas fa-child bg-gradient-blue"></i>

                    <div class="timeline-item">

                        <span class="time">
                            <i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($details->created_at)->format('D M d @h:i A') }}
                        </span>

                        <h3 class="timeline-header panel-heading"
                            id="timeline_header_{{$details->id}}"
                            data-toggle="" role="button"
                            aria-expanded="true"
                            aria-controls="#collapseddiv_{{$details->id}}"


                            data-target="#collapseddiv_{{$details->id}}">
                                New Child Created: <a href="/children/{{$details->id}}">{{$details->initials}}</a> ({{$details->status}})
                                {{-- With custom text using data-* config --}}
                                <button wire:click="admitChild({{$details->id}})" class="btn btn-success btn-sm ml-2">Admit</button>
                                <button wire:click="approveChild({{$details->id}})" class="btn btn-success btn-sm ml-2">Approve</button>
                                <button wire:click="deleteChildInWaitingRoom({{$details->id}})" class="btn btn-danger btn-sm ml-2">Delete</button>

                                <br><br>

                                <div class="container-fluid">
                                <!-- Small boxes (Stat box) -->
                                <div class="row">

                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-gradient-olive">
                                            <div class="inner">
                                                <span class="small">AGREEMENT AND AUTHORIZATION TO PROVIDE SERVICES TO A CHILD IN A CHILDREN’S RESIDENCE</span>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-door-open"></i>
                                            </div><br/>
                                            <a href="/TestFormBuilder/5/{{ $details->getOrCreateFormId('agreement_and_authorization_form_id') }}/?back-text=Child {{$details->initials}}" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-gradient-olive">
                                            <div class="inner">
                                                <span class="small">APPROVAL TO ADMINISTER ALL MEDICATION INCLUDING PSYCHOTROPIC, PRESCRIPTION AND OVER THE COUNTER MEDICATION</span>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-door-open"></i>
                                            </div><br/>
                                            <a href="/TestFormBuilder/7/{{ $details->getOrCreateFormId('approval_to_administer_all_medication_form_id') }}/?back-text=Child {{$details->initials}}" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-gradient-olive">
                                            <div class="inner">
                                                <span class="small">AUTHORIZATION FOR SUPERVISED ACTIVITIES</span>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-door-open"></i>
                                            </div><br/>
                                            <a href="/TestFormBuilder/6/{{ $details->getOrCreateFormId('authorization_for_supervised_activities_form_id') }}/?back-text=Child {{$details->initials}}" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                        </div>
                                    </div>
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

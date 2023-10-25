<div wire:poll.active id="timelineData" class="timeline timeline-inverse " style="width:100%; height:85%; overflow-y:auto;">
    @if ($timeline_data->count() > 0)

        {{--$myshift_timeline--}}
        @foreach ($timeline_data as $key=>$timeline)
            <div class="time-label">
                        <span class="bg-success">
                          {{$key}}

                        </span>
            </div>


            @foreach ($timeline as $details)
                {{--                                    {{Debugbar::info($details)}}--}}
                <div>

                    <i class="fas fa-clipboard bg-gradient-orange"></i>



                    <div class="timeline-item">

                                            <span class="time"><a href="javascript:window.livewire.emit('slide-over.open', 'modals.case-manage.view-on-call-seen-unseen-modal', {'onCallID':'{{$details->id}}'}, {'size':'lg'})">
                                                    @php
                                                        $onCall = App\Models\OnCall::with('users')->where('id','=',$details->id)->first();
                                                    @endphp
                                                    @if ($onCall->users->contains('id',Auth::user()->id))
                                                        <i class="fa-solid fa-eye mr-0.5 text-green" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-green" style="font-size:14px"></i></a>
                                                        @else
                                                    <i class="fa-solid fa-eye mr-0.5 text-primary" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-primary" style="font-size:14px"></i></a>
                                                @endif
                                                <i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($details->updated_at)->format('D M d @h:i A') }}</span>

                        <h3 class="timeline-header panel-heading"
                            id="timeline_header_{{$details->id}}"
                            data-toggle="collapse" role="button"
                            aria-expanded="true"
                            aria-controls="#collapseddiv_{{$details->id}}"


                            data-target="#collapseddiv_{{$details->id}}">Entry created by <a href="/users/{{$details->getUser->id}}">{{$details->getUser->name}}</a>
                            at <span class="font-weight-bold"><a href="/users/{{$details->getHome->id}}">{{$details->getHome->name}}</a> [{{$details->getHome->address}}]</span>
                            @if ($details->fk_ChildID) with: <span class="font-weight-bold">

                            @php
                                $children = collect(json_decode($details->fk_ChildID,true));

                            @endphp
                            @foreach ($children as $child)
                                @php

                                    $tmpChild = App\Models\Child::where('id','=',$child)->first();
                                @endphp
                                @if ($tmpChild)

                                        <a href="/children/{{$tmpChild->id}}">{{$tmpChild->initials}}</a>@if (!$loop->last),@endif
                                @endif
                            @endforeach

                        @endif
                          </span>
                        </h3>
                        <script>
                            window.addEventListener('ScrollMessageBoardToBottom', event=>  {
                                // alert ('got dispatch');
                                //Scroll to the bottom of specific message_board
                                console.log (event.detail.MessageBoardID);
                                //alert ($("#"+ event));
                                $("#message_board_" + event.detail.MessageBoardID).animate({
                                    scrollTop:$("#message_board_" + event.detail.MessageBoardID)[0].scrollHeight - $("#message_board_" + event.detail.MessageBoardID).height()
                                },1000,function(){
                                    console.log("done " + event.detail.MessageBoardID);
                                })

                            });



                            $('#timeline_header_{{$details->id}}').on('click', function() {
                                {{--console.log($('#message_board_{{$details->id}}'));--}}
                                $('#message_board_{{$details->id}}').animate({
                                    scrollTop:$('#message_board_{{$details->id}}').height()
                                },1000,function(){
                                    console.log("done ");
                                    $onCallID = "{{$details->id}}";

                                    // Only send update for the first time it is viewed
                                    @if (!$onCall->users->contains('id',Auth::user()->id))

                                    if ($('#timeline_header_{{$details->id}}').attr('aria-expanded') === "true") {
                                        // alert ('open');
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: "POST",
                                            url: "{{route('updateOnCallSeenStatus')}}",
                                            data: {
                                                OnCallID : "{{$details->id}}"
                                            },
                                            dataType: 'json',
                                            success: function (data) {

                                            },
                                            error: function (data) {
                                                console.log(data);
                                            }
                                        });
                                    }
                                    @endif
                                })



                            });


                        </script>





                        <div  wire:ignore class="collapse"
                              id="collapseddiv_{{$details->id}}">
                            <div wire:ignore class="timeline-body" class="panel-heading">
{{--                                <span class="ml-2">@if ($details->fk_ChildID)--}}
{{--                                Children Present: <br />--}}
{{--                                        <ul>--}}
{{--                                            @php--}}
{{--                                                $children = collect(json_decode($details->fk_ChildID,true));--}}

{{--                                            @endphp--}}
{{--                                        @foreach ($children as $child)--}}
{{--                                                       @php--}}

{{--                                                           $tmpChild = App\Models\Child::where('id','=',$child)->first();--}}
{{--                                                       @endphp--}}
{{--                                                       @if ($tmpChild)--}}

{{--                                                    <li><a href="/children/{{$tmpChild->id}}">{{$tmpChild->initials}}</a></li>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                    @endif--}}

{{--                                </span>--}}
                                <span class="ml-2">{{$details->notes}}</span>
                                <hr>

                                {{--                                                        @livewire('on-call.comments-component', ['model' => $details, 'newestFirst' => true])--}}
                                @livewire('forms.case-manage.module-chat',['user' => Auth::user(), 'model' => 'on_call', 'fk_ModelID' => $details->id, 'rows' => 400])

                                {{--                                                        <x-adminlte-card title="Comments" theme="success" theme-mode="" icon="fas fa-lg fa-thumbs-up"--}}
                                {{--                                                                         collapsible="collapsed">--}}
                                {{--                                                            @livewire('on-call.comments-component', ['model' => $details, 'newestFirst' => true])--}}
                                {{--                                                        </x-adminlte-card>--}}



                            </div>

                        </div>


                        <div class="timeline-footer">
                        </div>
                    </div>
                </div>
                <!-- END timeline item -->


                @endforeach

                {{--$timeline--}}


            @endforeach

            @endif

            <div>
                <i class="far fa-clock bg-gray"></i>
            </div>
            <div class="timeline_pagination"> {{ $timeline_data->links() }}</div>


</div>

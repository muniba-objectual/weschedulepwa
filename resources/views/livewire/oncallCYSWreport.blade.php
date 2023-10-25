<div wire:poll.active id="timelineData" class="timeline timeline-inverse ">
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

                                            <span class="time">
                                                    @php
                                                        $onCall = App\Models\OnCallCYSW::with('getUser')->where('id','=',$details->id)->first();
                                                    @endphp

                                                <i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($details->updated_at)->format('D M d @h:i A') }}</span>

                        <h3 class="timeline-header panel-heading"
                            id="timeline_header_{{$details->id}}"
                            data-toggle="collapse" role="button"
                            aria-expanded="true"
                            aria-controls="#collapseddiv_{{$details->id}}"


                            data-target="#collapseddiv_{{$details->id}}">Entry created by <a href="/users/{{$details->getUser->id}}">{{$details->getUser->name}}</a>
                            for <span class="font-weight-bold"><a href="/users/{{$details->getCYSW->id}}">{{$details->getCYSW->name}}</a>


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


                                })



                            });


                        </script>





                        <div  wire:ignore class="collapse"
                              id="collapseddiv_{{$details->id}}">
                            <div wire:ignore class="timeline-body" class="panel-heading">
                                <span class="ml-2">{{$details->notes}}</span>
                                <hr>
{{--                                @livewire('forms.case-manage.module-chat',['user' => Auth::user(), 'model' => 'on_call', 'fk_ModelID' => $details->id, 'rows' => 400])--}}

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

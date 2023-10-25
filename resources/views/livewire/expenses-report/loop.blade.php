@php($groupLevel++)

@foreach($details as $groupByKey => $detail)
    @if($detail instanceof \Illuminate\Database\Eloquent\Collection)

        <br>
        <!-- Grouped Panel -->
        <div style="{{($expandedExpenses[$parentKey] ?? false) || ($propertyDetails["$parentKey"]['force-expand']??false) ?'':'display:none;'}}">
            <div class="timeline-item" wire:click="toggleExpand('{{$parentKey}}.{{$groupByKey}}')"
                 style="margin-left: {{60+$groupLevel*10}}px; margin-bottom: 0px; margin-top: 0px; top:-10px; cursor: pointer;"
            >
                <h3 class="timeline-header {{($propertyDetails["$parentKey.$groupByKey"]['im-tagged']??false)? 'im-tagged' : ''}}">
                    <!-- Link To Resource -->
                    @if(empty($groupByKey))
                        {{--pick the second level group/user level--}}
                        @if(!empty($summaryDetails["root.$key.$byUser"]['type']))
                            <b>{{ucfirst($summaryDetails["root.$key.$byUser"]['type'])}}:</b>
                        @endif
                        <a href="{{$summaryDetails["root.$key.$byUser"]['url']??'#'}}">{{$byUser}}</a>
                    @else
                        @if( !empty($summaryDetails["$parentKey.$groupByKey"]['type']) )
                            <b>{{ucfirst($summaryDetails["$parentKey.$groupByKey"]['type'])}}:</b>
                        @endif
                        <a href="{{$summaryDetails["$parentKey.$groupByKey"]['url']}}">{{$groupByKey}}</a>
                    @endif



                    <!-- Summaries -->
                    <br>
                    @foreach($summaryDetails["$parentKey.$groupByKey"]['summary']??[] as $propertyName => $propertyValue)
                        @if(is_iterable($propertyValue))
                            <br><b>{{$propertyName}}</b>:
                            @foreach($propertyValue as $key => $value)
                                <br>&nbsp;&nbsp;{{$key}}: {!! $value !!}
                            @endforeach
                        @else
                            <br>
                            @if(!empty($propertyName))
                                <b>{{ucfirst($propertyName)}}:</b>
                            @endif
                            {!! $propertyValue !!}
                        @endif
                    @endforeach
                </h3>
            </div>
        </div>

        @include('livewire.expenses-report.loop', ['details'=>$detail, 'groupLevel' => $groupLevel, 'parentKey'=>"$parentKey.$groupByKey"])
    @else

        @include('livewire.expenses-report.timeline-item', ['detail'=>$detail, 'groupLevel' => $groupLevel, 'parentKey'=>$parentKey])
    @endif
@endforeach


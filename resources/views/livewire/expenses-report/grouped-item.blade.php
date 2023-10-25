@foreach ($timeline as $byUser => $details)

    {{ clock()->info("By user: " . $byUser . $details) }}

    <div style="{{($expandedExpenses[$key] ?? $this->optimizedMode) || ($key == $thisMonthKey)  || ($propertyDetails["root.$key"]['force-expand']??false) ? '' : 'display: none;'}}">

        @php
            //TODO::ashain, switch to a better key identifier, name can be duplicated
            $tmpUser = $tmpUsers[$byUser];
        @endphp

            <!--Profile-Image-->
        @if ($tmpUser && $tmpUser->profile_pic)
            <img style="margin-left:10px; top:40px; position:relative;" height="40px" width="40px"
                 src="/storage/profile_pic/{{ substr($tmpUser->profile_pic, 20) }}" alt="avatar"
                 class="rounded-circle ">
        @else
            <i class="fas fa-user-circle bg-primary"></i>
        @endif

        <div class="timeline-item" wire:click="toggleExpand('root.{{$key}}.{{$byUser}}')" style="margin-left: 60px; margin-bottom: 0px; margin-top: 0px; top:-10px; cursor: pointer;">

            <h3 class="timeline-header {{($propertyDetails["root.$key.$byUser"]['im-tagged']??false)? 'im-tagged' : ''}}">
                <!-- Link To Resource -->
                @if(empty($byUser))
                @else
                    @if( !empty($summaryDetails["root.$key.$byUser"]['type']) )
                        <b>{{ucfirst($summaryDetails["root.$key.$byUser"]['type'])}}:</b>
                    @endif

                    <a href="{{$summaryDetails["root.$key.$byUser"]['url']}}">{{$byUser}}</a>
                    <br/><br/>
                @endif

                <span class="ml-3"><b><u>Verified Expenses:</u></b></span>
                <br/><br/>

                <div class="row">
                    @foreach($summaryDetails["root.$key.$byUser"]['summary'] as $title => $data)
                        {{--TODO::ashain, add a proper fix to this--}}
                        @if( $title == 'Company Credit Card' && !isset($companyCreditCards[$tmpUser->id]) && $data['Total'] == 0)
                            <div class="col-md-5"></div>
                            @continue
                        @endif

                        <div class="col-md-5">
                            <span class="ml-3"><b><u>{{$title}}:</u></b></span>
                            <br>

                            @if ( isset($data['Total']) )
                                <br />
                                <span class="ml-3"><b>Total:</b> ${{$data['Total']}},</span>
                            @endif

                            @if ( isset($data['HST']) )
                                <br />
                                <span class="ml-3"><b>HST:</b> ${{$data['HST']}}</span>,
                            @endif

                            @if ( isset($data['Receipts']) )
                                <br/>
                                <span class="ml-3"><b>Receipts:</b> {!! $data['Receipts'] !!}</span>
                            @endif

                            @if( isset($data['CategorySummary']) )
                                <br/>
                                <span class="ml-3"><b>Categories:</b></span>
                                @forelse($data['CategorySummary'] as $category => $categoryTotal)
                                    <br><span class="ml-3">&nbsp;&nbsp;{{$category}}: ${{($categoryTotal)}}</span>
                                @empty
                                    -<i>none</i>-
                                @endforelse
                            @endif

                            {{--TODO::ashain, remove error-marker in final release--}}
                            @if ( isset($data['Total']) && isset($data['CategorySummary']) && isset($data['HST']) )
                                @php
                                    $categorySum = array_sum($data['CategorySummary'], )
                                @endphp
                                @if( ($data['Total']) != (string)($categorySum + $data['HST']) )
                                    <br><br>
                                    <span class="text-danger" style="font-weight: normal;">
                                                    MISMATCH CALC: &nbsp;
                                                    Shown Total: {{$data['Total']}}, &nbsp;
                                                    Calculated Total: {{ ( ($categorySum) + ($data['HST']) )}}, &nbsp;
                                                    Category Total: {{$categorySum}}
                                                </span>
                                @endif
                            @endif
                            {{--TODO::ashain, End: remove error-marker in final release--}}

                        </div>
                    @endforeach





                    {{--Payout Configurations--}}
                    @if( auth()->user()->user_type == 10.0 ) {{--only super admin--}}

                    <div class="col-md-2">

                        @if(($propertyDetails["root.$key.$byUser"]['verified-expenses-count'] > 0) ){{--at lease has a single verified expense--}}

                            <?php
                            //Get the properties
                            $totalExpensesInGroup = $propertyDetails["root.$key.$byUser"]['expense-count'];
                            $paidExpensesCount = $propertyDetails["root.$key.$byUser"]['paid-payout-count'];
                            $payoutId = $propertyDetails["root.$key.$byUser"]['payout-id'];


                            //Additional Details
                            if($payoutId){
                                //payout model
                                $payoutModelAsArray = $propertyDetails["root.$key.$byUser"]['payout-details'];
                            }

                            //Build flags
                            $neverPaid = $paidExpensesCount == 0;
                            $isFullyPaid = $totalExpensesInGroup == $paidExpensesCount;
                            $partiallyPaid = !$isFullyPaid;
                            ?>


                        {{--Payout Details--}}
                        @if($neverPaid)
                            <i class="fa fa-battery-empty text-danger mb-2" aria-hidden="true"></i> Has Pending Payments

                        @else
                            @if($partiallyPaid)
                                <i class="fa fa-battery-half text-warning mb-2" aria-hidden="true"></i> Partially Paid
                            @elseif($isFullyPaid)
                                <i class="fa fa-battery-full text-success mb-2" aria-hidden="true"></i> Fully Paid
                            @endif

                            {{--Payout Model Data | TODO::michello, edit the UI design.--}}
                            <ul>
                                @foreach($payoutModelAsArray as $modelAttributeName => $propertyValue)
                                    <li>
                                        {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $modelAttributeName)) }}:
                                        {{$propertyValue}}
                                    </li>
                                @endforeach
                            </ul>
                            {{--End Payout Model Data--}}

                        @endif
                        {{--End Payout Details--}}


                        {{--Payout Button--}}
                        {{--you can pay only once, if there is at least a single payment, you cant pay again--}}
                        @if( $paidExpensesCount==0 )
                            <a wire:click="makePayout( '{{"$key.$byUser"}}' )"
                               wire:click.prevent="toggleExpand('{{$key}}')" href="#"
                               style="height: 3.5em;" class="btn btn-outline-success">
                                <i class="fa-brands fa-amazon-pay fa-2xl"
                                   style="padding-top: 0.75em; color: #208852;"></i>
                            </a>
                        @endif
                        {{--End Payout Button--}}

                        @else
                            <span class="text-warning">No verified expense yet to make a payout!</span>
                        @endif

                    </div>
                    @endif
                    {{--End Payout Configurations--}}




                </div>
            </h3>

        </div>
    </div>

    <!--Timeline Details-->
    @include('livewire.expenses-report.loop', [
        'details'=>$details,
        'groupLevel'=>0,
        'summaries'=>$summaryDetails,
        'parentKey'=>"root.$key.$byUser"
    ])
    <!--End Timeline Details-->

    <br>

@endforeach
{{--$timeline--}}

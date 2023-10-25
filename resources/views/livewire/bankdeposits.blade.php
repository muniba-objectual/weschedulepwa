<div wire:poll.active id="timelineData" class="timeline timeline-inverse ">
@if ($this->timeline_data->count() > 0)

    {{--$myshift_timeline--}}
    @foreach ($this->timeline_data as $key=>$timeline)
        <div class="time-label">
                        <span class="bg-success">
                          {{$key}}

                        </span>
        </div>


        @foreach ($timeline as $details)
            {{Debugbar::info($details)}}

            <div>

                <i class="fas fa-dollar-sign bg-primary"></i>



                <div x-data="{}"  class="timeline-item" wire:key="item-{{$details->id}}">
                    <span  class="time"><input x-on:click="$wire.toggle({{$details->id}})" class="form-check-input" style="margin-top:2px !important;" type="checkbox" value="" id="chkViewed_{{$details->id}}" @if ($details->viewed) checked @endif> <i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($details->date)->format('D M d') }} @if ($user->user_type == 10.0)<i x-on:click=" confirm('Are you sure you want to delete this Bank Deposit?') ? window.livewire.emitTo('bank-deposits.bank-deposits', 'delete', '{{$details->id}}') : false" class="fa-solid fa-trash text-red"></i>@endif</span>


                    <h3 class="timeline-header panel-heading"
                        data-toggle="collapse" role="button"
                        aria-expanded="true"
                        aria-controls="#collapseddiv_{{$details->id}}"
                        data-target="#collapseddiv_{{$details->id}}">{{$details->getUser->name}}
                        submitted a new <span class="font-weight-bold">Bank Deposit Entry:</span> {{$details->description}} - ${{number_format($details->amount, 2)}}

                    </h3>







                    <div  wire:ignore class="collapse"
                          id="collapseddiv_{{$details->id}}">
                        <div wire:ignore class="timeline-body" class="panel-heading">

                                {{--                            <span class="ml-2">Description: {{$details->description}}</span><br />--}}
                                {{--                            <span class="ml-2">Amount: ${{$details->amount}}</span>--}}
                                {{--                            <hr>--}}

                            <div wire:ignore class="row ml-1" id="spreadsheet_{{$details->id}}"></div>

                            <script>

                                jSuites.ajax({
                                    url: "{{route('getBankDepositDetails')}}",
                                    beforeSend: function(xhr) {
                                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                                    },
                                    method: 'POST',
                                    // dataType: 'json',
                                    data: { id: {{$details->id}} },

                                    success: function(result) {
                                        // Result
                                        // jSuites.notification(result);
                                        if (result != 0) {
                                            data_{{$details->id}} = result;

                                            var SUMCOL = function(instance, columnId) {
                                                var total = 0;
                                                var newTotal = new currency();
                                                for (var j = 0; j < instance.options.data.length; j++) {
                                                    str = (instance.records[j][columnId].innerHTML);
                                                    var onlyNumbers = currency(str).value;
                                                     // console.log (onlyNumbers);

                                                    newTotal = currency(newTotal).add(onlyNumbers);
                                                     // console.log (newTotal);
                                                    // total += Number(instance.records[j][columnId].innerHTML);

                                                }
                                                // alert (total);
                                                return newTotal.format();
                                            }

                                            var changed_{{$details->id}} = function(instance, cell, x, y, value) {
                                                // var cellName = jexcel.getColumnNameFromId([x,y]);
                                                // $('#log').append('New change on cell ' + cellName + ' to: ' + value + '');
                                                {{--console.log (table_{{$details->id}}.getJson(false));--}}
                                                jSuites.ajax({
                                                    url: "{{route('updateBankDepositDetails')}}",
                                                    beforeSend: function (xhr) {
                                                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                                                    },
                                                    method: 'POST',
                                                    // dataType: 'json',
                                                    data: {
                                                        id: {{$details->id}},
                                                        data: table_{{$details->id}}.getJson(false)
                                                    },
                                                    success: function(result) {
                                                        // alert (result);
                                                        if (result == "success") {
                                                            // alert('updated successful');
                                                        } else {
                                                            // alert ('update error');
                                                        }
                                                    },
                                                    error: function(result) {
                                                        // alert (result);
                                                        // alert ('update error');
                                                    }

                                                });

                                            }

                                            // Send the method to the correct scope
                                            formula.setFormula({ SUMCOL });

                                            var table_{{$details->id}} =  jspreadsheet(document.getElementById('spreadsheet_{{$details->id}}'), {
                                                data:data_{{$details->id}},
                                                onchange: changed_{{$details->id}},
                                                // Allow new rows
                                                allowInsertRow:true,
                                                // Allow new rows
                                                allowManualInsertRow:true,
                                                // Allow new columns
                                                allowInsertColumn:false,
                                                // Allow new rows
                                                allowManualInsertColumn:false,
                                                // Allow row delete
                                                allowDeleteRow:true,
                                                // Allow column delete
                                                allowDeleteColumn:false,
                                                allowRenameColumn: false,
                                                columns: [
                                                    { type: 'text', title:'Cheque Date', width:'150' },
                                                    { type: 'text', title:'Deposit Date', width:'150' },
                                                    { type: 'text', title:'(D) or Direct (DD)', width:'150'},
                                                    { type: 'text', title:'Agency', width:'200' },
                                                    { type: 'text', title:'Reference #', width:'100' },
                                                    { type: 'text', title:'Cheque #', width:'100' },
                                                    { type: 'text', title:'Invoice # (s)', width:'100' },
                                                    { type: 'numeric', title:'Invoice Amount', width:'150',mask: '$#,##0,00', decimal:'.', reverse:true }

                                                ],
                                                updateTable:function(instance, cell, col, row, val, label, cellName) {
                                                    if (cell.innerHTML == 'Total') {
                                                        cell.parentNode.style.backgroundColor = '#fffaa3';
                                                    }

                                                    // if (col == 3) {
                                                    //     if (parseFloat(label) > 10) {
                                                    //         cell.style.color = 'red';
                                                    //     }  else {
                                                    //         cell.style.color = 'green';
                                                    //     }
                                                    // }
                                                },
                                                columnSorting:false,
                                                footers: [['Total',,,,,,,'=SUMCOL(TABLE(), 7)']],

                                            });
                                        }
                                        else {
                                            data_{{$details->id}} = " ";

                                            var SUMCOL = function(instance, columnId) {
                                                var total = 0;
                                                var newTotal = new currency();
                                                for (var j = 0; j < instance.options.data.length; j++) {
                                                    str = (instance.records[j][columnId].innerHTML);
                                                    var onlyNumbers = currency(str).value;
                                                    // console.log (onlyNumbers);

                                                    newTotal = currency(newTotal).add(onlyNumbers);
                                                    // console.log (newTotal);
                                                    // total += Number(instance.records[j][columnId].innerHTML);

                                                }
                                                // alert (total);
                                                return newTotal.format();
                                            }

                                            var changed_{{$details->id}} = function(instance, cell, x, y, value) {
                                                // var cellName = jexcel.getColumnNameFromId([x,y]);
                                                // $('#log').append('New change on cell ' + cellName + ' to: ' + value + '');
                                                {{--console.log (table_{{$details->id}}.getJson(false));--}}
                                                jSuites.ajax({
                                                    url: "{{route('updateBankDepositDetails')}}",
                                                    beforeSend: function (xhr) {
                                                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                                                    },
                                                    method: 'POST',
                                                    // dataType: 'json',
                                                    data: {
                                                        id: {{$details->id}},
                                                        data: table_{{$details->id}}.getJson(false)
                                                    },
                                                    success: function(result) {
                                                        // alert (result);
                                                        if (result == "success") {
                                                            // alert('updated successful');
                                                        } else {
                                                            // alert ('update error');
                                                        }
                                                    },
                                                    error: function(result) {
                                                        // alert ('update error');
                                                    }

                                                });
                                            }

                                            // Send the method to the correct scope
                                            formula.setFormula({ SUMCOL });

                                            var table_{{$details->id}} =  jspreadsheet(document.getElementById('spreadsheet_{{$details->id}}'), {
                                                data:data_{{$details->id}},
                                                onchange: changed_{{$details->id}},
                                                // Allow new rows
                                                allowInsertRow:true,
                                                // Allow new rows
                                                allowManualInsertRow:true,
                                                // Allow new columns
                                                allowInsertColumn:false,
                                                // Allow new rows
                                                allowManualInsertColumn:false,
                                                // Allow row delete
                                                allowDeleteRow:true,
                                                // Allow column delete
                                                allowDeleteColumn:false,
                                                allowRenameColumn: false,
                                                columns: [
                                                    { type: 'text', title:'Cheque Date', width:'150' },
                                                    { type: 'text', title:'Deposit Date', width:'150' },
                                                    { type: 'text', title:'(D) or Direct (DD)', width:'150'},
                                                    { type: 'text', title:'Agency', width:'200' },
                                                    { type: 'text', title:'Reference #', width:'100' },
                                                    { type: 'text', title:'Cheque #', width:'100' },
                                                    { type: 'text', title:'Invoice # (s)', width:'100' },
                                                    { type: 'numeric', title:'Invoice Amount', width:'150',mask: '$#,##0,00', decimal:'.', reverse:true }
                                                ],
                                                updateTable:function(instance, cell, col, row, val, label, cellName) {
                                                    if (cell.innerHTML == 'Total') {
                                                        cell.parentNode.style.backgroundColor = '#fffaa3';
                                                    }

                                                    // if (col == 3) {
                                                    //     if (parseFloat(label) > 10) {
                                                    //         cell.style.color = 'red';
                                                    //     }  else {
                                                    //         cell.style.color = 'green';
                                                    //     }
                                                    // }
                                                },
                                                columnSorting:false,
                                                footers: [['Total',,,,,,,'=SUMCOL(TABLE(), 7)']],

                                            });
                                        }
                                    },
                                    error: function() {
                                        // alert ('error');
                                    }
                                });

                                function initTable() {

                                }
                                {{--var data_{{$details->id}} = [--}}
                                {{--    [ 'Crayons Crayola only (No Rose Art)', 2, 5.01, '=B1*C1',,,,5.00 ],--}}
                                {{--    [ 'Colored Pencils Crayola only', 2, 4.41, '=B2*C2' ],--}}
                                {{--    [ 'Expo Dry-erase Markers Wide', 4, 3.00, '=B3*C3' ],--}}
                                {{--    [ 'Index Cards Unlined', 3, 6.00, '=B4*C4' ],--}}
                                {{--    [ 'Tissues', 10, '1.90', '=B5*C5' ],--}}
                                {{--    [ 'Ziploc Sandwich-size Bags', 5, 1.00, '=B6*C6' ],--}}
                                {{--    [ 'Thin Markers Crayola only', 2, 3.00, '=B7*C7' ],--}}
                                {{--    [ 'Highlighter', 4, 1.20, '=B8*C8' ],--}}
                                {{--];--}}

                                window.addEventListener('ScrollMessageBoardToBottom', event=>  {
                                    // alert ('got dispatch');
                                    //Scroll to the bottom of specific message_board
                                    // console.log (event.detail.MessageBoardID);
                                    //alert ($("#"+ event));
                                    $("#message_board_" + event.detail.MessageBoardID).animate({
                                        scrollTop:$("#message_board_" + event.detail.MessageBoardID)[0].scrollHeight - $("#message_board_" + event.detail.MessageBoardID).height()
                                    },1000,function(){
                                        // console.log("done " + event.detail.MessageBoardID);
                                    })

                                });
                                $('.timeline-header').on('click', function() {
                                    {{--console.log($('#message_board_{{$details->id}}'));--}}
                                    $('#message_board_{{$details->id}}').animate({
                                        scrollTop:$('#message_board_{{$details->id}}').height()
                                    },1000,function(){
                                        // console.log("done ");
                                    })

                                });



                            </script>
{{--                            @livewire('bank-deposits.comments-component', ['model' => $details, 'newestFirst' => true])--}}

                            @livewire('forms.case-manage.module-chat',['user' => Auth::user(), 'model' => 'bank_deposits', 'fk_ModelID' => $details->id, 'rows' => 400])


                        </div>

                    </div>


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
        <div class="timeline_pagination"> {{ $this->timeline_data->links() }}</div>


    <script>
        function deleteBankDeposit($id) {
            alert ($id);
        }
    </script>
        </div>

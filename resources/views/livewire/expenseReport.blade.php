<?php /** @var \App\Models\Expenses $detail  */?>
<div wire:poll.active id="timelineData" class="timeline timeline-inverse ">
    @if ($this->timeline_data->count() > 0)

        {{--$myshift_timeline--}}
        @foreach ($this->timeline_data as $key=>$timeline)

            <div class="time-label">
                <span class="bg-success">
                  {{$key}}
                </span>
            </div>

            @foreach ($timeline as $byUser => $details)
                {{ clock()->info("By user: " . $byUser . $details) }}

                <div>
                    @php
                        $tmpUser = App\Models\User::where('name','=',$byUser)->first();
                    @endphp

                    @if ($tmpUser->profile_pic)
                        <img style="margin-left:10px; top:40px; position:relative;" height="40px" width="40px"
                             src="/storage/profile_pic/{{ substr($tmpUser->profile_pic, 20) }}" alt="avatar"
                             class="rounded-circle ">
                    @else
                        <i class="fas fa-user-circle bg-primary"></i>
                    @endif

                    <div class="timeline-item" wire:click="toggleExpand('{{$byUser}}')" style="margin-left: 60px; margin-bottom: 0px; margin-top: 0px; top:-10px; cursor: pointer;">
                        @if($administrativeUserMode)
                            <span style="cursor: pointer; float:right;"
                                  title="Manage Verifiers"
                                  onclick="Livewire.emit('slide-over.open', 'modals.case-manage.expense-report-verifier-allocation-modal', {'userId': {{$tmpUser->id}} },{'size':'lg'})"
                            >
                                <i class="fa-solid fa-eye mr-0.5 text-danger" style="font-size:14px"></i>
                                <i class="fa-solid fa-eye mr-2 text-danger" style="font-size:14px"></i>
                            </span>
                        @endif

                        <h3 class="timeline-header">User: <a href="/users/{{$tmpUser->id}}">{{$byUser}}</a> <br />
                            Total:
                            @foreach ($groupedTotals as $tmpKey=>$totals)
                                @if ($key == $tmpKey)
                                    {{--                                            date is found within groupedTotals--}}
                                    @if (isset($totals[$byUser]['total_amount']))
                                        ${{$totals[$byUser]['total_amount']}},
                                    @endif
                                    @if (isset($totals[$byUser]['total_count']))
                                        Receipts: {{$totals[$byUser]['total_count']}}
                                    @endif

                                @endif
                            @endforeach
                            <br/><b>Categories:</b>
                                @foreach($totals[$byUser]['category_summary'] as $categorySummary)
                                    <br>&nbsp;&nbsp;{{$categorySummary->name}}: ${{number_format($categorySummary->totals, 2)}}
                                @endforeach
                        </h3>

                    </div>
                </div>

                <!--Timeline Details-->
                @foreach ($details as $detail)
                    <div style="{{($expandedExpenses[$byUser] ?? false)?'':'display:none;'}}">

                        <i class="fas fa-dollar-sign bg-primary"></i>

                        <div x-data="{}" class="timeline-item" wire:key="item-{{$detail->id}}">
                            <span  class="time">
                                <input x-on:click="$wire.toggle({{$detail->id}})" class="form-check-input" style="margin-top:2px !important;" type="checkbox" value="" id="chkViewed_{{$detail->id}}" @if ($detail->viewed) checked @endif>
                                <i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($detail->date)->format('D M d') }} @if ($user->user_type == 10.0)<i x-on:click=" confirm('Are you sure you want to delete this Expense?') ? window.livewire.emitTo('expenses-report.expenses-report', 'delete', '{{$detail->id}}') : false" class="fa-solid fa-trash text-red"></i>@endif

                                <!-- Verification Controls -->
                                @if($detail->is_verified)
                                    |
                                    <span title="Verified at {{$detail->verified_at}}">
                                        Verified by {{$detail->verified_by == auth()->id()?'you':$detail->verifiedBy->name}}
                                        <i class="fa fa-md fa-fw text-success fa-check-circle"></i>
                                    </span>

                                    @if(
                                        $administrativeUserMode ||
                                        $detail->verified_by == auth()->id()
                                    )
                                        |
                                        <a href="#" title="Verified at {{$detail->verified_at}}" x-on:click="$wire.toggleVerified({{$detail->id}})">
                                            <i class="fa fa-md fa-fw text-danger fa-times"></i>
                                            Reject
                                        </a>
                                    @endif
                                @else
                                    @if($totals[$byUser]['can_manage_expenses'] || $administrativeUserMode)
                                        |
                                        <a href="#" title="Verify the expense" x-on:click="$wire.toggleVerified({{$detail->id}})">
                                            Verify
                                        </a>
                                    @endif
                                @endif
                                <!-- End Verification Controls -->

                            </span>

                            <h3 class="timeline-header panel-heading"
                                data-toggle="collapse" role="button"
                                aria-expanded="true"
                                aria-controls="#collapseddiv_{{$detail->id}}"
                                data-target="#collapseddiv_{{$detail->id}}"><span class="font-weight-bold">{{$detail->description}}</span>  - ${{number_format($detail->total, 2)}}
                            </h3>


                            <div wire:ignore class="collapse" id="collapseddiv_{{$detail->id}}">
                                <div wire:ignore class="timeline-body" class="panel-heading">

                                        {{--                            <span class="ml-2">Description: {{$details->description}}</span><br />--}}
                                        {{--                            <span class="ml-2">Amount: ${{$details->amount}}</span>--}}
                                        {{--                            <hr>--}}

                                    <div class="container">
                                       <div class="row">
                                           <div class="col-2">
                                                <div class="ml-1"><b><u>Receipt Details:</u></b>
                                                    <br/>
                                                    <ul>
                                                        <li class="item">Subtotal: $<span class="expense-summary-sub-total">{{number_format($detail->subtotal, 2)}}</span></li>
                                                        <li>HST: ${{$detail->HST}}</li>
                                                        <li>Total: $<span class="expense-summary-total">{{number_format($detail->total, 2)}}</span></li>
                                                    </ul>

                                                    @php
                                                        $media = $detail->getFirstMediaUrl("Expenses","thumb");
                                                    @endphp
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{$media}}" target="_blank"><img src="/img/receipt_thumb_icon.png" height="100px" /></a>
                                                    </div>
                                                </div>
                                            </div>

                                           <div class="col-6">
                                               <div wire:ignore class="row ml-1" id="spreadsheet_{{$detail->id}}">
                                               </div>
                                           </div>
                                       </div>
                                   </div>

                                    <script>

                                        data_{{$detail->id}} = {!! $detail->line_items !!};

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
                                            if (columnId == "1") {
                                                return newTotal;
                                            }

                                            if (columnId == "2") {
                                                return newTotal.format();
                                            }

                                            if (columnId == "3") {
                                                return newTotal.format();
                                            }
                                            // return newTotal.format();
                                        }

                                        var RECURSIVE_EXEC = true;

                                        var changed_{{$detail->id}} = function(instance, cell, col, row, value) {
                                            if(RECURSIVE_EXEC){

                                                if (col==1 || col==2) {//qty || price
                                                    //write
                                                    RECURSIVE_EXEC = false;

                                                    //get data
                                                    $qty = parseFloat(instance.jspreadsheet.getRowData(row)[1]);
                                                    $price = parseFloat(instance.jspreadsheet.getRowData(row)[2]);

                                                    //find row
                                                    var rowData = instance.jspreadsheet.getRowData(row);
                                                    var oldSubTotal = rowData[3];
                                                    var newSubTotal = 0; //emancipate for qty or price to be empty

                                                    //if both are valid numbers
                                                    if( !isNaN($qty) && !isNaN($price) ) {
                                                        newSubTotal = ($qty * $price).toFixed(2);
                                                    }

                                                    rowData[3] = newSubTotal; //update row->itmQty

                                                    instance.jspreadsheet.setReadOnly([3, row], false); //make itemTotal cell editable
                                                    instance.jspreadsheet.setRowData(row, rowData);     //update the entire row
                                                    instance.jspreadsheet.setReadOnly([3, row], true);  //make itemTotal cell readonly

                                                    //update new sub-totals
                                                    var itemSubTotal = $('#collapseddiv_{{$detail->id}}').find('.expense-summary-sub-total');
                                                    var itemTotal = $('#collapseddiv_{{$detail->id}}').find('.expense-summary-total');
                                                    itemSubTotal.html( (parseFloat( itemSubTotal.html().replace(',', '') )+(newSubTotal-oldSubTotal)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
                                                    itemTotal.html( (parseFloat( itemTotal.html().replace(',', '') )+(newSubTotal-oldSubTotal)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
                                                    RECURSIVE_EXEC = true;
                                                }

                                                //pass the dataset to backend if any changes occur, jsonify content
                                                window.livewire.emitTo( 'expenses-report.expenses-report', 'updateLineItems', '{{$detail->id}}', JSON.stringify(instance.jspreadsheet.getJson()) );

                                            }//end of recursive antiknock
                                        }

                                        // Send the method to the correct scope
                                        formula.setFormula({ SUMCOL });

                                        var dropdownOptions = {!! $expensesCategories !!};;
                                                    var table_{{$detail->id}} =  jspreadsheet(document.getElementById('spreadsheet_{{$detail->id}}'), {
                                                        data:data_{{$detail->id}},
                                                        onchange: changed_{{$detail->id}},
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
                                                            { type: 'text', title:'Qty', width:'75px' },
                                                            { type: 'text', title:'Item', width:'185px' },
                                                            { type: 'numeric', title:'Price', width:'100px', decimal:'.', reverse:true},
                                                            { type: 'numeric', readOnly:true, title:'Total', width:'100px', decimal:'.', reverse:true },
                                                            { type: 'dropdown', title:'Category', width:'250px', source:dropdownOptions, autocomplete: true, multiple:false },
                                                        ],
                                                        updateTable:function(instance, cell, col, row, val, label, cellName) {
                                                            if (cell.innerHTML == 'TOTAL') {
                                                                cell.parentNode.style.backgroundColor = '#fffaa3';
                                                            }

                                                            // if (col == 3) { //if itemTotal
                                                            //     $qty = parseFloat(instance.jspreadsheet.getRowData(row)[0])
                                                            //     $price = parseFloat(instance.jspreadsheet.getRowData(row)[2])
                                                            //     if(!isNaN($qty) && !isNaN($price)) {
                                                            //         cell.innerHTML = ($qty * $price).toFixed(2);
                                                            //     }
                                                            // }

                                                            // if (col == 3) {
                                                            //     if (parseFloat(label) > 10) {
                                                            //         cell.style.color = 'red';
                                                            //     }  else {
                                                            //         cell.style.color = 'green';
                                                            //     }
                                                            // }
                                                        },
                                                        columnSorting:false,
                                                        footers: [['=SUMCOL(TABLE(), 1)','TOTAL','=SUMCOL(TABLE(), 2)','=SUMCOL(TABLE(), 3)',]],

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
                                            $('#message_board_{{$detail->id}}').animate({
                                                scrollTop:$('#message_board_{{$detail->id}}').height()
                                            },1000,function(){
                                                // console.log("done ");
                                            })

                                        });

                                        //move columns
                                        {{--table_{{$details->id}}.moveColumn(4,1);--}}
                                        {{--table_{{$details->id}}.moveColumn(1,0);--}}
                                        table_{{$detail->id}}.moveColumn(0,1);
                                        {{--const properties_{{$detail->id}} = {--}}
                                        {{--    type: "=B*C"--}}
                                        {{--}--}}
                                        {{--table_{{$detail->id}}.setProperties(3,properties_{{$detail->id}});--}}
                                    </script>

        {{--                            @livewire('bank-deposits.comments-component', ['model' => $details, 'newestFirst' => true])--}}
                                    @livewire('forms.case-manage.module-chat',['user' => Auth::user(), 'model' => 'expenses', 'fk_ModelID' => $detail->id, 'rows' => 400])
                                </div>
                            </div>

                            <div class="timeline-footer"></div>

                        </div>
                    </div>
                    <!-- END timeline item -->
                @endforeach
                <!--End Timeline Details-->

            @endforeach
            {{--$timeline--}}

        @endforeach

    @endif

    <div>
        <i class="far fa-clock bg-gray"></i>
    </div>

    <div class="timeline_pagination"> {{ $this->timeline_data->links() }}</div>

    <script>
        function deleteExpense($id) {
            alert ($id);
        }
    </script>
</div>

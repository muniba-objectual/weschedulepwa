
    <div class="">
        <div x-data="{}" class="timeline-item wire:key="item-{{$detail->id}}" id="expense-bill-{{$detail->id}}">
        <span  class="time" style="float:right;">
            @if($tagged)
                <a href="#" title="Dismiss Notification (Expense:{{$detail->id}})" x-on:click="$wire.dismissNotifications({{$detail->id}})">
                    <i class="fa fa-md fa-fw text-success fa-ticket"></i>
                    Dismiss Notification
                </a>
                |
            @endif

                <i class="far fa-clock"></i> {{ Carbon\Carbon::parse($detail->datetime)->format('D M d') }}
        </span>

        <h3 class="timeline-header panel-heading"
            data-toggle="collapse" role="button"
            aria-expanded="true"
            aria-controls="#collapseddiv_{{$detail->id}}"
            data-target="#collapseddiv_{{$detail->id}}"><span class="font-weight-bold">{{$detail->description}}</span>  - ${{number_format($detail->total, 2)}}
        </h3>

        <div wire:ignore class="collapse show" id="collapseddiv_{{$detail->id}}" >
            <div wire:ignore class="timeline-body" class="panel-heading">

                {{--                            <span class="ml-2">Description: {{$details->description}}</span><br />--}}
                {{--                            <span class="ml-2">Amount: ${{$details->amount}}</span>--}}
                {{--                            <hr>--}}

                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <div style="font-size:14px;" class="ml-1"><b><u>Receipt Details:</u></b>
                                <br/>
                                <ul>
                                    <li class="item">Subtotal: $<span class="expense-summary-sub-total">{{number_format($detail->subtotal, 2)}}</span></li>
                                    <li>HST: ${{$detail->HST}}</li>
                                    <li>Total: $<span class="expense-summary-total">{{number_format($detail->total, 2)}}</span></li>
                                </ul>

                                @php
                                    $media = $detail->getFirstMediaUrl("Expenses");

                                    //TODO::ashain, remove dummy image after QA
                                    $dummyImage = 'data:image/png;base64,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';
                                    $media = !empty($media)?$media:$dummyImage
                                @endphp
                                <div class="d-flex justify-content-center">
                                    <a href="{{$media}}" target="_blank"><img src="{{$media}}" height="200px" /></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div wire:ignore class="row ml-1" id="spreadsheet_{{$detail->id}}">
                            </div>
                            <br>
                            <div class="row ml-1" style="font-size:14px;">
                                <b><u>Notes: </u>&nbsp;
                                </b><p>{{$detail->notes}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
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
                            window.livewire.emit('updateLineItems', '{{$detail->id}}', JSON.stringify(instance.jspreadsheet.getJson()) );

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
                        },
                        columnSorting:false,
                        footers: [['=SUMCOL(TABLE(), 1)','TOTAL','=SUMCOL(TABLE(), 2)','=SUMCOL(TABLE(), 3)',]],

                    });


                    function initTable() {}

                    window.addEventListener('ScrollMessageBoardToBottom', event=>  {
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
                    table_{{$detail->id}}.moveColumn(0,1);
                </script>

                {{--@livewire('bank-deposits.comments-component', ['model' => $details, 'newestFirst' => true])--}}
                @livewire('forms.case-manage.module-chat',['user' => Auth::user(), 'model' => 'expenses', 'fk_ModelID' => $detail->id, 'rows' => 400])
            </div>
        </div>

        <div class="timeline-footer"></div>

    </div>

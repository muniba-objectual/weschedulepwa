<div style="{{($expandedExpenses[$parentKey] ?? false) || ($propertyDetails["$parentKey"]['force-expand']??false) ?'':'display:none;'}}">
    <?php
    /** @var \App\Models\Expenses $detail */
    $expenseIsEditable = !$detail->isReadyOnly();
//        $requireVendorSelection = !$detail->resolveVendorAccount(true, $resolveMode);
    if ($detail->vendor_id) {
        $expenseVendorIds[$detail->id] = $detail->vendor_id;
    }
    $debug = '';
    //    $debug = json_encode(json_decode($detail->line_items)[0]->category) ?? 'emty'; //TODO::remove this
    ?>


    <i class="fas fa-dollar-sign bg-primary"></i>

    <div x-data="{}" style="margin-left: {{60+($groupLevel+1)*10}}px;"
         class="timeline-item {{($propertyDetails["$parentKey.$detail->id"]['im-tagged']??false)? 'im-tagged' : ''}} {{($propertyDetails["$parentKey.$detail->id"]['force-expand']??false)? 'focused-expense' : ''}}"
         wire:key="item-{{$detail->id}}" id="expense-bill-{{$detail->id}}">
        <span class="time">

            <input x-on:click="$wire.toggle({{$detail->id}})" class="form-check-input"
                   style="margin-top:2px !important;" type="checkbox" value="" id="chkViewed_{{$detail->id}}"
                   @if ($detail->viewed) checked @endif>
            <b>&nbsp;|&nbsp;</b>

            <!-- Card Info -->
            @if($detail->payment_type == \App\Models\Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD)
                <span>
                    <i class="fa fa-md fa-fw text-info fa-credit-card"></i>
                    <!-- Only for Admins & Owner -->
                    @if ($user->user_type == 10.0 || $user->id == $detail->fk_UserID)
                        ***{{$detail->last_four_digits}}
                    @endif
                </span>
                <b>&nbsp;|&nbsp;</b>
            @endif
            <!-- End Card Info Controls -->

            <!-- Notification Dismiss Controls -->
            @if($propertyDetails["$parentKey.$detail->id"]['im-tagged']??false)
                <a href="#" title="Dismiss Notification (Expense:{{$detail->id}})"
                   x-on:click="$wire.dismissNotifications({{$detail->id}})">
                    <i class="fa fa-md fa-fw text-success fa-ticket"></i>
                    Dismiss Notification
                </a>
                <b>&nbsp;|&nbsp;</b>
            @endif
            <!-- End Notification Dismiss Controls -->


            <span title="Created on {{ $detail->datetime->format('M d Y h:i A') }}"><i class="far fa-clock"></i> {{ $detail->datetime->format('D M d') }}</span>


            <!-- Delete Expense Controls -->
            @if (($user->user_type == 10.0 || $user->id == $detail->fk_UserID) && !$detail->is_verified)
                <b>&nbsp;|&nbsp;</b>
                <i style="cursor: pointer;" title="Delete Expense"
                   x-on:click=" confirm('Are you sure you want to delete this Expense?') ? window.livewire.emit('delete', '{{$detail->id}}') : false"
                   class="fa-solid fa-trash text-red"></i>
            @endif
            <!-- End Delete Expense Controls -->


            <!-- Paid Status Indicator -->
            @if($detail->isPaid())
                <b>&nbsp;|&nbsp;</b>
                <span title="Paid at {{$detail->expensePayout->paid_at}}">
                    Payout by {{$detail->expensePayout->paid_by == auth()->id()?'you':$detail->expensePayout->paidByUser->name}}
                    <i class="fa-brands fa-amazon-pay fa-md fa-fw text-success"></i>
                </span>
            @endif
            <!-- End Paid Status Indicator -->

            <!-- QB Account Indicator -->
            @if($detail->getQuickBooksLink())
                <b>&nbsp;|&nbsp;</b>
                <span title="QB Purchase Link">
                    <a href="{{$detail->getQuickBooksLink()}}" title="QB Purchase Link" target="_blank">
                        <i class="fas fa-md fa-cloud-upload-alt"></i>
                    </a>
                </span>
            @endif
            <!-- End QB Account Indicator -->

            <!-- Verification Controls -->
            @if($detail->is_verified)
                <b>&nbsp;|&nbsp;</b>
                <span title="Verified at {{$detail->verified_at}}">
                    Verified by {{$detail->verified_by == auth()->id()?'you':$detail->verifiedBy->name}}
                    <i class="fa fa-md fa-fw text-success fa-check-circle"></i>
                </span>

                @if($expensesCanVerify[$detail->fk_UserID] && !$detail->isPaid())
                    <b>&nbsp;|&nbsp;</b>
                    <a href="#" title="Verified at {{$detail->verified_at}}"
                       x-on:click="$wire.toggleVerified({{$detail->id}}); toggleColumnsReadOnly{{$detail->id}}(false);">
                        <i class="fa fa-md fa-fw text-danger fa-times"></i>
                        Reject
                    </a>
                @endif
            @else
                @if($expensesCanVerify[$detail->fk_UserID] && !$detail->isPaid() && $detail->category_id && $detail->vendor_id)
                    <b>&nbsp;|&nbsp;</b>
                    <a href="#" title="Verify the expense"
                       x-on:click="$wire.toggleVerified({{$detail->id}}); toggleColumnsReadOnly{{$detail->id}}(true);">
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
            data-target="#collapseddiv_{{$detail->id}}">
            <span class="font-weight-bold"
                  @if ($user->user_type == 10.0 || $user->id == $detail->fk_UserID) title="Expense: {{$detail->id}}, QB Account No: {{$detail->vendor_name}}" @endif>
                {{$detail->description}}
            </span> - ${{number_format($detail->total, 2)}}


            {{--Vendor Controls--}}
            &nbsp; &nbsp;
            <br /><br /><b title="debug: {{$debug}}">Vendor:&nbsp;</b>
            @if($expenseIsEditable && !$detail->is_verified)
                <select class="select2" wire:change="updateVendorSelection({{$detail->id}})"
                        wire:model="expenseVendorIds.{{$detail->id}}"
                        data-x="{{$expenseVendorIds[$detail->id]??''}}">
                    <option value="">Select Vendor</option>
                    @foreach($allVendorsAccounts as $vendorId => $vendorName)
                        <option value="{{$vendorId}}">{{$vendorName}}</option>
                    @endforeach
                </select>

{{--                &nbsp;current Vendor: {{$detail->vendor_name??'N/A'}}--}}

            @else
                <span>
                    @if($detail->vendor_id)
                        {{$detail->vendor_name}}
                    @else
                        N/A
                    @endif
                </span>
            @endif
            {{--End Vendor Controls--}}

            &nbsp;|&nbsp;
            <b>Category:</b>
            <span>
                <select class="select2" wire:change="updateExpenseCategorySelection({{$detail->id}})" wire:model="expenseCategoryIds.{{$detail->id}}">

                    <option value="">Select Category</option>

                    <?php $previousSelection = $previousVendorCategories->get($detail->vendor_id,[]); ?>
                    @if(count($previousSelection))<optgroup label="Previous Selections">@endif
                        @foreach ($previousSelection as $categoryId)
                            <option value="{{$categoryId}}">{{"{$allExpensesCategories[$categoryId]} ({$categoryId})"}}</option>
                        @endforeach
                    @if(count($previousSelection))</optgroup>@endif

                    @if(count($previousSelection))<optgroup label="Other Categories">@endif
                        @foreach ($allExpensesCategories as $categoryId => $categoryName)
                            @unless(in_array($categoryId, $previousSelection))
                                <option value="{{$categoryId}}">{{"{$categoryName} ({$categoryId})"}}</option>
                            @endunless
                        @endforeach
                    @if(count($previousSelection))</optgroup>@endif
                </select>
            </span>

            &nbsp;|&nbsp;
            <b>Children:</b>
            <select class="select2" wire:change="updateExpenseChildrenSelection({{$detail->id}})" wire:model="expenseChildrenIds.{{$detail->id}}">
                <option>None</option>
                @foreach($this->allChildren as $child)
                    <option value="{{$child['id']}}">{{$child['initials']}}</option>
                @endforeach
            </select>
        </h3>


        <div wire:ignore.self
             class="collapse {{($propertyDetails["$parentKey.$detail->id"]['force-expand']??false) ?'show':''}}"
             id="collapseddiv_{{$detail->id}}">
            <div class="timeline-body" class="panel-heading">

                {{--                            <span class="ml-2">Description: {{$details->description}}</span><br />--}}
                {{--                            <span class="ml-2">Amount: ${{$details->amount}}</span>--}}
                {{--                            <hr>--}}

                <div class="container">
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <div class="ml-1"><b><u>Receipt Details:</u></b>

                                @if($expenseIsEditable)
                                    @if($editingExpenseId != $detail->id)
                                        &nbsp; &nbsp;
                                        <span>
                                            <a href="#" class="btn btn-xs btn-outline-danger"
                                               title="Override Totals & HST">
                                                <i wire:click="editTotals( {{$detail->id}} )" style="cursor: pointer;"
                                                   class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                    @else
                                        &nbsp; &nbsp;
                                        <span>
                                            <a href="#" class="btn btn-xs btn-outline-success" title="Save override changes">
                                                <i wire:click="overrideTotals( {{$detail->id}} )" style="cursor: pointer;" class="fa fa-check" aria-hidden="true"></i>
                                            </a>
                                        </span>

                                        &nbsp; &nbsp;
                                        <span>
                                            <a href="#" class="btn btn-xs btn-outline-danger"
                                               title="Reset and go to auto calculation mode.">
                                                <i wire:click="resetTotals( {{$detail->id}} )" style="cursor: pointer;"
                                                   class="fa fa-undo" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                    @endif
                                @endif

                                @if($detail->is_override_totals)
                                    &nbsp;(<i>Manual Calc</i>)
                                @endif

                                <br/><br/>

                                @if($editingExpenseId == $detail->id && $expenseIsEditable)
                                    <table>
                                        <tr>
                                            <td>
                                                <li>Sub Total:&nbsp;</li>
                                            </td>
                                            <td><input name="subTotal" type="text" wire:model="editingExpenseSubTotal"></td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <li>HST:&nbsp;</li>
                                            </td>
                                            <td><input name="HST" type="text" wire:model="editingExpenseHst"></td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <li>Total:&nbsp;</li>
                                            </td>
                                            <td><input name="total" type="text" wire:model="editingExpenseTotal"></td>
                                        </tr>
                                    </table>
                                    <br>
                                @else
                                    <ul>
                                        <li class="item">Subtotal: $<span class="expense-summary-sub-total">{{number_format($detail->subtotal, 2)}}</span></li>
                                        <li>HST: ${{$detail->HST}}</li>
                                        <li>Total: $<span class="expense-summary-total">{{number_format($detail->total, 2)}}</span></li>
                                    </ul>
                                @endif

                                <br>


                                @php
                                    $media = $detail->getFirstMediaUrl("Expenses","thumb");

                                    $media = !empty($media)?$media:'/img/receipt_thumb_icon.png';
                                @endphp
                                <div class="d-flex">
                                    <a href="{{$media}}" target="_blank"><img src="/img/receipt_thumb_icon.png" height="100px"/></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="row ml-1">
                                <b><u>Notes: </u>&nbsp;</b>
                                <p>
                                    @if($detail->notes)
                                        <b>{{$detail->notes}}</b>
                                    @else
                                        -<i>none</i>-
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">

                    window.addEventListener('ScrollMessageBoardToBottom', event => {
                        // alert ('got dispatch');
                        //Scroll to the bottom of specific message_board
                        // console.log (event.detail.MessageBoardID);
                        //alert ($("#"+ event));
                        $("#message_board_" + event.detail.MessageBoardID).animate({
                            scrollTop: $("#message_board_" + event.detail.MessageBoardID)[0].scrollHeight - $("#message_board_" + event.detail.MessageBoardID).height()
                        }, 1000, function () {
                            // console.log("done " + event.detail.MessageBoardID);
                        })

                    });
                    $('.timeline-header').on('click', function () {
                        {{--console.log($('#message_board_{{$details->id}}'));--}}
                        $('#message_board_{{$detail->id}}').animate({
                            scrollTop: $('#message_board_{{$detail->id}}').height()
                        }, 1000, function () {
                            // console.log("done ");
                        })

                    });
                </script>

                <div wire:ignore>
                    {{--@livewire('bank-deposits.comments-component', ['model' => $details, 'newestFirst' => true])--}}
                    @livewire('forms.case-manage.module-chat',['user' => Auth::user(), 'model' => 'expenses', 'fk_ModelID' => $detail->id, 'rows' => 400], key("chats-for".$detail->id))
                </div>

            </div>
        </div>

        <div class="timeline-footer"></div>
    </div>

</div>
<!-- END timeline item -->

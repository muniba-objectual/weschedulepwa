<style>
    /*  Helper Styles */
    body .card-body {
        font-family: Varela Round !important;
        background: #f1f1f1;
    }

    a {
        text-decoration: none;
    }

    /* Card Styles */

    .card-sl {
        border-radius: 8px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .card-image img {
        max-height: 100%;
        max-width: 100%;
        border-radius: 8px 8px 0px 0;
    }

    .card-action {
        position: relative;
        float: right;
        margin-top: -25px;
        margin-right: 20px;
        z-index: 2;
        color: #E26D5C;
        background: #fff;
        border-radius: 100%;
        padding: 15px;
        font-size: 15px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 1px 2px 0 rgba(0, 0, 0, 0.19);
    }

    .card-action:hover {
        color: #fff;
        background: #E26D5C;
        -webkit-animation: pulse 1.5s infinite;
    }

    .card-heading {
        font-size: 18px;
        font-weight: bold;
        background: #fff;
        padding: 10px 15px;
    }

    .card-text {
        padding: 10px 15px;
        background: #fff;
        font-size: 14px;
        color: #636262;
    }

    .card-button {
        display: flex;
        justify-content: center;
        padding: 10px 0;
        width: 100%;
        background-color: #1F487E;
        color: #fff;
        border-radius: 0 0 8px 8px;
    }

    .card-button:hover {
        text-decoration: none;
        background-color: #1D3461;
        color: #fff;

    }


    @-webkit-keyframes pulse {
        0% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        70% {
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -webkit-transform: scale(1);
            transform: scale(1);
            box-shadow: 0 0 0 50px rgba(90, 153, 212, 0);
        }

        100% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(90, 153, 212, 0);
        }
    }
</style>

<?php
    /** @var \App\Models\Expenses $detail  */
    $endOfMonth = \Carbon\Carbon::now()->startOfMonth();
?>

<div id="expense-brakdown-container">

    <div id="timelineData" class="timeline timeline-inverse ">

        @foreach ($timeline_data as $key => $expenses)

            <div class="time-label">
                <span class="bg-success" style="cursor: pointer;" wire:click="toggleExpand('{{$key}}')">
                  {{$key}}
                </span>
            </div>

            @if( $this->expanded[$this->latestKey]??false )

                {{--Summary Panel--}}
                <div class="timeline-item" style="margin-left: 60px; margin-bottom: 0px; margin-top: 0px; top:-10px;">

                    @if(!is_null($expenses))
                        <h5 class="timeline-header">

                            <span class="ml-3"><b>Expenses Summary:</b></span>
                            <br/>

                            <br /><span class="ml-3"><b>Total:</b> ${{$summaryData[$key]['Total']}}</span>

                            <br /><span class="ml-3"><b>HST:</b> ${{$summaryData[$key]['HST']}}</span>

                            <br/><span class="ml-3"><b>Receipts:</b> {!! $summaryData[$key]['Receipts'] !!}</span>

                            <br/><span class="ml-3"><b>Categories:</b></span>
                            @forelse($summaryData[$key]['CategorySummary'] as $category => $categoryTotal)
                                <br><span class="ml-3">&nbsp;&nbsp;{{$category}}: ${{number_format($categoryTotal, 2)}}</span>
                            @empty
                                -<i>none</i>-
                            @endforelse
                        </h5>

                    @else
                        No expenses have been submitted for this month
                    @endif

                </div>
                {{--End Summary Panel--}}


                {{--Expense Grid--}}
                @if(!is_null($expenses))
                    <br>
                    <div class="container-fluid" style="margin-top:5px; margin-left:60px;">
                    <div class="row">
                        @foreach($expenses as $expense)

                            @php
                                $media = $expense->getFirstMediaUrl("Expenses");
                                $lineItems = json_decode($expense->line_items);
                            @endphp

                            <div class="col-3 mb-5">
                                <div class="card-sl">
                                    <div class="card-image">
    {{--                                        <img src="https://images.pexels.com/photos/1149831/pexels-photo-1149831.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" />--}}
                                        @if ($media)
                                            <a href="{{$media}}"><img src="{{$media}}" height="200px" width="300px" /></a>
                                        @else
                                            <img height="200px" width="300px" src="https://images.pexels.com/photos/12920742/pexels-photo-12920742.jpeg?auto=compress&cs=tinysrgb&w=800" />
                                        @endif
                                    </div>

                                    @if($expense->is_verified)
                                        <i class="card-action text-success fa fa-check"></i>
    {{--                                        <span class="badge rounded-pill badge-success">Verified</span>--}}

                                    @elseif($expense->datetime >= $endOfMonth)
                                        <i class="card-action text-critcal fa fa-trash"  onclick="confirm('Are you sure you want to delete this bill?') ? window.livewire.emit('deleteExpense', '{{$expense->id}}') : false"></i>
    {{--                                        <span class="btn btn-danger" onclick="confirm('Are you sure you want to delete this bill?') ? window.livewire.emitTo('mobile.expenses', 'deleteExpense', '{{$expense->id}}') : false">--}}
    {{--                                            Delete Bill--}}
    {{--                                        </span>--}}
                                    @endif

                                    <div class="card-heading">
                                        {{strtoupper($expense->description)}}
                                    </div>
                                    <div class="card-text">
                                        <p class="text-muted">DATE: {{$expense->created_at->format('m/d/Y h:i A')}}</p>
                                        <p class="text-muted">SUBTOTAL: ${{number_format($expense->subtotal, 2)}}</p>
                                        <p class="text-muted">HST: ${{$expense->HST}}</p>
                                        <p class="fw-bold mb-1">TOTAL: ${{number_format($expense->total, 2)}}</p>
                                        <hr>
                                        <p class="text-muted">NOTES: {{$expense->notes}}</p>
                                    </div>

                                    <a href="#"  onclick="$('#details_{{$expense->id}}').CardWidget('toggle')" class="card-button">View Details</a>
                                    <div id="details_{{$expense->id}}" data-card-widget="collapse" class="card collapsed-card details">
                                        <div class="card-body card-text">
                                            <p>LINE ITEMS:</p>
                                            <ul class="list-group list-group-light">
                                                @foreach($lineItems as $lineItem)
                                                    <li class="ml-3 mb-2">

                                                        <p class="fw-bold mb-1">{{$lineItem->item}}</p>
                                                        <p class="text-muted mb-0"><b>Category:</b> {{$expenseCategories[$lineItem->category] ?? "None"}}</p>
                                                        <p class="text-muted mb-0">
                                                            <b>Price:</b> ${{number_format((float) $lineItem->price, 2)}}  x
                                                            {{number_format((int) $lineItem->qty, 0)}} <em>(qty)</em>
                                                        </p>
                                                        <p class="text-muted mb-0">
                                                            <b>Total:</b>
                                                            <span class="rounded-pill">${{number_format((float) $lineItem->total, 2)}}</span>
                                                        </p>


                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                {{--End Expense Grid--}}

            @endif

        @endforeach

        <div>
            <i class="far fa-clock bg-gray"></i>
        </div>

    </div>

</div>

{{--                <div class="card collapsed-card">--}}
{{--                <div class="card-header" style="cursor: pointer;" data-card-widget="collapse">--}}
{{--                    <ul class="list-group list-group-light">--}}
{{--                        <li class="list-group-item d-flex justify-content-between align-items-center">--}}
{{--                            <div class="d-flex align-items-center">--}}

{{--                                @if($media)--}}
{{--                                    <a href="{{$media}}"><img src="{{$media}}" alt="image" style="width: 45px; height: 45px; margin-right:10px;"--}}
{{--                                         class="rounded-circle" /></a>--}}
{{--                                @else--}}
{{--                                    <div class="icon-box bg-primary">--}}
{{--                                        <ion-icon name="image-outline"></ion-icon>--}}
{{--                                    </div>--}}
{{--                                @endif--}}


{{--                                <div class="ms-3">--}}
{{--                                    <p class="fw-bold mb-1">Store: {{$expense->description}}</p>--}}
{{--                                    <p class="text-muted">Date: {{$expense->created_at->format('m/d/Y h:i A')}}</p>--}}
{{--                                    <p class="text-muted">Subtotal: ${{number_format($expense->subtotal, 2)}}</p>--}}
{{--                                    <p class="text-muted">HST: ${{$expense->HST}}</p>--}}
{{--                                    <p class="fw-bold mb-1">Total: ${{number_format($expense->total, 2)}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            @if($expense->is_verified)--}}
{{--                                <span class="badge rounded-pill badge-success">Verified</span>--}}


{{--                            @elseif($expense->datetime >= $endOfMonth)--}}
{{--                                <span class="btn btn-danger" onclick="confirm('Are you sure you want to delete this bill?') ? window.livewire.emitTo('mobile.expenses', 'deleteExpense', '{{$expense->id}}') : false">--}}
{{--                                    Delete Bill--}}
{{--                                </span>--}}
{{--                            @endif--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <blockquote>--}}
{{--                        <ul class="list-group list-group-light">--}}
{{--                            @foreach($lineItems as $lineItem)--}}
{{--                                <li class="list-group-item d-flex justify-content-between align-items-center">--}}
{{--                                <div class="d-flex align-items-center">--}}
{{--                                    <div class="ms-3">--}}
{{--                                        <p class="fw-bold mb-1"><b>Item:</b> {{$lineItem->item}}</p>--}}
{{--                                        <p class="text-muted mb-0"><b>Category:</b> {{$expenseCategories[$lineItem->category] ?? "None"}}</p>--}}
{{--                                        <p class="text-muted mb-0">--}}
{{--                                            ${{number_format((float) $lineItem->price, 2)}} <em>(price)</em> X--}}
{{--                                            {{number_format((float) $lineItem->qty, 2)}} <em>(qty)</em>--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <span class="badge rounded-pill badge-primary">${{number_format((float) $lineItem->total, 2)}}</span>--}}
{{--                            </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </blockquote>--}}
{{--                </div>--}}
{{--                <!-- /.card-body -->--}}
{{--            </div>--}}

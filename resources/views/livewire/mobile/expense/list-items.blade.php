<div id="expense-brakdown-container">
    <!-- Media Multi Listview -->
    <ul class="listview image-listview media mb-2">

        @php
            $endOfMonth = \Carbon\Carbon::now()->startOfMonth();
        @endphp

        @foreach($expenses as $expense)
            <li class="multi-level">
                <a href="#" class="item">
                    <div class="imageWrapper">
                        @php
                            $media = $expense->getFirstMediaUrl("Expenses");
                            $lineItems = json_decode($expense->line_items);
                        @endphp

                        @if($media)
                            <img src="{{$media}}" alt="image" class="imaged w64">
                        @else
                            <div class="icon-box bg-primary">
                                <ion-icon name="image-outline"></ion-icon>
                            </div>
                        @endif
                    </div>
                    <div class="in">

                        <div>
                            <header>Shop: {{$expense->description}}</header>
                            <div class="text-muted">Created On: {{$expense->created_at->format('m/d/Y h:i A')}}</div>
                            <div class="text-muted">Subtotal: ${{number_format($expense->subtotal, 2)}}</div>
                            <div class="text-muted">HST: ${{$expense->HST}}</div>
                            <footer>Total: ${{number_format($expense->total, 2)}}</footer>
                        </div>

                        @if($expense->is_verified)
                            <span href="#" class="badge alert-outline-success">
                                Verified
                            </span>

                        @elseif($expense->datetime >= $endOfMonth)
                            <span href="#" onclick="confirm('Are you sure you want to delete this bill?') ? window.livewire.emitTo('mobile.expenses', 'deleteExpense', '{{$expense->id}}') : false" class="badge badge-danger btn btn-danger btn-sm">
                                Delete Bill
                            </span>
                        @endif
                        {{--                        <span class="badge badge-danger">{{count($lineItems)}} Items</span>--}}
                        {{--                        <span class="text-muted">view</span>--}}

                    </div>
                </a>

                <!-- sub menu | line items -->
                <ul class="listview simple-listview media" style="padding-left: 0px !important;">
                    @foreach($lineItems as $lineItem)
                        <li>
                            <a href="#" class="item" style="padding-left: 0px !important; padding-right: 0 !important;">
                                {{--                            <div class="imageWrapper">--}}
                                {{--                                <img src="assets/img/sample/photo/1.jpg" alt="image" class="imaged w64">--}}
                                {{--                            </div>--}}
                                <div class="in">
                                    <div>
                                        <header><b>Item:</b> {{$lineItem->item}}</header>
                                        <div class="text-muted"><b>Category:</b> {{$expenseCategories[$lineItem->category] ?? "None"}}</div>
                                        <footer>
                                            ${{number_format((float) $lineItem->price, 2)}} <em>(price)</em> X
                                            {{number_format((float) $lineItem->qty, 2)}} <em>(qty)</em>
                                        </footer>
                                    </div>
                                    <span class="badge badge-primary">
                                        ${{number_format((float) $lineItem->total, 2)}}
                                    </span>
                                    {{--                                    <span class="text-muted">Edit</span>--}}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <!-- * sub menu -->

            </li>
        @endforeach

    </ul>
    <!-- * Media Multi Listview -->
</div>

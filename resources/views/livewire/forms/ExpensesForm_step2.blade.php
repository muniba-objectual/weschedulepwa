<div>

    <script>

        $(document).ready(function () {

            var darkModeInputs = document.querySelectorAll("input.lineItems"); // returns NodeList
            var div_array = [...darkModeInputs]; // converts NodeList to Array
            div_array.forEach(div => {

                // do something awesome with each div
                if (checkDarkModeStatus) {
                    //dark mode is enabled
                    // alert ("dark mode is active");
                    div.style.color = "white";
                    div.style.backgroundColor = "transparent";
                } else {
                    // alert ("dark mode is not active");
                    div.style.color = "black";
                    div.style.backgroundColor = "transparent";
                }

            });

            // if (!checkDarkModeStatus) {
            //     darkModeInputs.style.backgroundColor = "transparent";
            //     darkModeInputs.style.color = "white";
            //
            //     // darkModeInputs.classList.add("lineItemsDarkMode");
            //     // darkModeInputs.classList.remove("lineItemsLightMode");
            // } else {
            //     darkModeInputs.classList.add("lineItemsLightMode");
            //     darkModeInputs.classList.remove("lineItemsDarkMode");
            //
            //
            // }
        });

    </script>


    <!-- Extra Header -->
    <div class="extraHeader p-0">
        <div class="form-wizard-section">
            @foreach($steps as $key=>$step)

                <a wire:key="item_{{$key}}" @if ($step->isPrevious())
                    wire:click="previousStep"
                   @endif class="button-item {{ $step->isCurrent() ? 'active' : '' }}">
                    @if ($step->label == "Submit")
                        <strong>
                            <ion-icon name="checkmark-outline"></ion-icon>
                        </strong>
                    @else
                        <strong>{{$key+1}}</strong>
                    @endif
                    <p>{{$step->label}}</p>
                </a>
            @endforeach
        </div>


    </div>
    <!-- * Extra Header -->

    <h3 class="mt-3 m-1 p-1 d-flex justify-content-center">MERCHANT</h3>
    <div class="wide-block pt-2 pb-2">
        <div class="exampleBox">NAME</div>
        <div>
            <input wire:model="expenses.description" style="width:100% !important;">
        </div>
    </div>

    <input type="hidden" wire:model="expenses.payment_source" value="{{ array_key_first($paymentSources) }}" />
    @if(count($paymentSources)>1)
        <div class="wide-block pt-2 pb-2">
            <div class="exampleBox">Payment Method</div>

            <div>
                @if(count($paymentSources)>2)

                    {{-- When more than 1 credit card is attached --}}
                    <select wire:ignore wire:model="expenses.payment_source" style="width:100% !important;">
                        @foreach($paymentSources as $paymentSourceId => $paymentSourceName)
                            <option value="{{$paymentSourceId}}">{{$paymentSourceName}}</option>
                        @endforeach
                    </select>
                @else

                    {{-- When 1 credit card is ony attached --}}
                    <label>
                        <input type="checkbox" wire:model="expenses.payment_source" value="{{ array_key_last($paymentSources) }}" />
                        &nbsp; I have used {{strtolower(end($paymentSources))}}
                    </label>

                @endif
            </div>
        </div>
    @endif

    <h3 class="mt-3 m-1 p-1 d-flex justify-content-center">TOTALS</h3>
    <div class="wide-block pt-2 pb-2">
        <div class="row">

            <div class="col">
                <div class="exampleBox">SUB-TOTAL</div>
                <div>
                    <input wire:model="expenses.subtotal" style="width:100% !important;" data-type="currency">
                </div>
            </div>


            <div class="col">
                <div class="exampleBox">HST (13%)</div>
                <div>
                    <input wire:model="expenses.HST" style="width:100% !important;" data-type="currency">
                </div>
            </div>


            <div class="col">
                <div class="exampleBox">TOTAL</div>
                <div>
                    <input wire:model="expenses.total" style="width:100% !important;" data-type="currency">
                </div>
            </div>

        </div>
    </div>

    @if($manualDataEntryMode)

    @endif
    <div class="mb-3"></div>

    <div class="accordion" id="accordionExample">
        {{--        <ul class="listview image-listview" >--}}
{{--        @if ($expenses->line_items)--}}
{{--            @foreach ($expenses->line_items as $key=>$items)--}}

{{--                <div class="accordion-item">--}}

{{--                    <h2 class="accordion-header" id="headingOne">--}}
{{--                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"--}}
{{--                                data-bs-target="#collapse_{{$key}}" aria-expanded="true"--}}
{{--                                aria-controls="collapse_{{$key}}">--}}
{{--                            <i class="fa-solid fa-cart-shopping text-primary"></i>&nbsp;--}}
{{--                            <input wire:model="expenses.line_items.{{$key}}.item" type="text"--}}
{{--                                   class="lineItems form-control" style="border:none; font-size:14px;"--}}
{{--                                   id="itemDesc_{{$key}}" autocomplete="off">--}}
{{--                        </button>--}}
{{--                    </h2>--}}

{{--                    <div wire:ignore.self id="collapse_{{$key}}" class="accordion-collapse collapse hidden"--}}
{{--                         aria-labelledby="headingOne" data-bs-parent="#accordionExample">--}}
{{--                        <div class="accordion-body">--}}

{{--                            <div class="mb-2">--}}
{{--                                <header>Expense Category</header>--}}
{{--                                <div class="text-muted">--}}
{{--                                    <select wire:ignore wire:model="expenses.line_items.{{$key}}.category"--}}
{{--                                            style="width:100% !important;"--}}
{{--                                            class="d-flex justify-content-center col-3 selCategory" data-key="{{$key}}"--}}
{{--                                            id="itemCat_{{$key}}">--}}
{{--                                        <option value="" selected>Please Select...</option>--}}

{{--                                        @foreach($expenseCategories as $expenseCatId => $expenseCategoryName)--}}
{{--                                            <option value="{{$expenseCatId}}">{{$expenseCategoryName}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                --}}{{--                            <footer>California</footer>--}}
{{--                            </div>--}}

{{--                            <div class="mb-2">--}}
{{--                                <header>Quantity</header>--}}
{{--                                <div class="text-muted"><input wire:model="expenses.line_items.{{$key}}.qty" type="text"--}}
{{--                                                               class="form-control"--}}
{{--                                                               style=" border:none; font-size:14px; "--}}
{{--                                                               id="itemQty_{{$key}}" autocomplete="off">--}}
{{--                                </div>--}}
{{--                                --}}{{--                            <footer>California</footer>--}}
{{--                            </div>--}}

{{--                            <div class="mb-2">--}}
{{--                                <header>Price</header>--}}
{{--                                <input wire:model="expenses.line_items.{{$key}}.price" type="text" class="form-control"--}}
{{--                                       style="border:none;  font-size:14px;" id="itemPrice_{{$key}}" autocomplete="off">--}}
{{--                                --}}{{--                            <footer>California</footer>--}}
{{--                            </div>--}}

{{--                            <div class="mb-2">--}}
{{--                                <header>Total</header>--}}
{{--                                <input wire:model="expenses.line_items.{{$key}}.total" type="text" class="form-control"--}}
{{--                                       style=" border:none;  font-size:14px;" id="itemTotal_{{$key}}"--}}
{{--                                       autocomplete="off">--}}
{{--                                --}}{{--                            <footer>California</footer>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{--                    <span class="text-muted">Edit</span>--}}

{{--            @endforeach--}}
{{--        @endif--}}
        {{--        </ul>--}}
    </div>

    <div class="mt-2" >
        <span wire:click="nextStep()" style="cursor:pointer;" class="float-end">Next Step <i class="fas fa-chevron-right" style="color:blue;"></i></span>
        <span wire:click="previousStep()" style="cursor:pointer;" class="float-start"><i class="fas fa-chevron-left" style="color:blue;"></i> Previous Step</span>
    </div>

</div>




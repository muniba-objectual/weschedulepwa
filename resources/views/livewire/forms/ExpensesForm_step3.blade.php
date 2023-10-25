<div wire:poll>


    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
            integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
          integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <style>
        .exampleBox {
            size:34px !important;
        }
    </style>
    <script>

        //Currency Format for Input - https://codepen.io/akalkhair/pen/dyPaozZ



        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "$" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "$" + input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            // var updated_len = input_val.length;
            // caret_pos = updated_len - original_len + caret_pos;
            // input[0].setSelectionRange(caret_pos, caret_pos);
        }



        $(document).ready(function () {

            $("input[data-type='currency']").on({
                keyup: function () {
                    formatCurrency($(this));
                },
                blur: function () {
                    formatCurrency($(this), "blur");
                }
            });

            $.datetimepicker.setDateFormatter('moment');

            $('#datetime').datetimepicker()


            //Initialize Select2 Elements
            $('#selCategory').select2({
                theme: 'classic',

            });

            $('#selLinkTo').select2({
                theme: 'classic',

            });

            $('#selLinkToID').select2({
                theme: 'classic',

            });

      showUpload();
        });


    </script>

    <!-- Extra Header -->
    <div class="extraHeader p-0">
        <div class="form-wizard-section">
            @foreach($steps as $key => $step)

                <a  wire:key="item_{{$key}}" @if ($step->isPrevious())
                    {{--                    wire:click="{{ $step->show() }}"--}}
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



    <div id="divLinking">
            <h3 class="mt-3 m-1 p-1 d-flex justify-content-center">CATEGORY & LINKING</h3>
            <div class="wide-block pt-2 pb-2">

                <div class="row">

                    <div class="col">
                        <div class="exampleBox">LINK TO</div>
                        <div>
                            <select wire:ignore wire:model="expenses.linkTo" style="width:100% !important;"
                                    class="select2-blue d-flex justify-content-center col-3"
                                    data-dropdown-css-class="select2-blue" id="selLinkTo" name="selLinkTo">
                                <option value="" selected>Please Select...</option>
                                @foreach ($mainOptions as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        @if($subOptions)
                            <div class="exampleBox">Link To User</div>
                            <div>
                                <select wire:model="expenses.linkToID" style="width:100% !important;"
                                        class="select2-blue d-flex justify-content-center col-3" id="selLinkToID" name="selLinkToID"
                                        data-dropdown-css-class="select2-blue">
                                    <option value="" selected>Please Select...</option>
                                    @foreach ($subOptions as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
    </div>

    <div class="mt-2" >
        <span wire:click="nextStep()" style="cursor:pointer;" class="float-end">Next Step <i class="fas fa-chevron-right" style="color:blue;"></i></span>
        <span wire:click="previousStep()" style="cursor:pointer;" class="float-start"><i class="fas fa-chevron-left" style="color:blue;"></i> Previous Step</span>
    </div>

</div>

<div wire:ignore>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/sweetalert2/theme-dark/dark.css">

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
            integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
          integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <script>

      window.addEventListener('OCR_Complete', event => {
          $("#showNextStep").show();
          });


        $(document).ready(function () {

            $("#showNextStep").hide();
            $.datetimepicker.setDateFormatter('moment');

            $('#datetime').datetimepicker()



        });


    </script>

    <!-- Extra Header -->
    <div class="extraHeader p-0">
        <div class="form-wizard-section">
            @foreach($steps as $key=>$step)

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

        <h3 class="m-1 p-1 d-flex justify-content-center">DATE/TIME</h3>
        <input wire:model="expenses.datetime" class="select2-blue d-flex justify-content-center col-12" id="datetime"
               type="text">


        <!--<h6 class="card-title">CHILD PROFILES</h6>-->
        <h3 class="mt-3 m-1 p-1 d-flex justify-content-center">UPLOAD RECEIPT</h3>
    {{--    @livewire('forms.case-manage.file-uploader-expenses', ['model' => $Expenses])--}}

        <form>
            <div class="custom-file-upload" id="fileUpload1">

                <input type="file"  wire:model="upload" id="fileuploadInput">
                <label for="fileuploadInput">
                                        <span>
                                            <strong>
                                                <ion-icon name="cloud-upload-outline"></ion-icon>
                                                <i>Tap to Upload</i>
                                            </strong>
                                        </span>
                </label>
            </div>
        </form>


    <div class="mt-2" >
        <span id="showNextStep" style="cursor:pointer;" wire:click="nextStep()" class="float-end">Next Step <i class="fas fa-chevron-right" style="color:blue;"></i></span>
    </div>


</div>

{{--<div wire:click="nextStep()">--}}
{{--    Go to the next step--}}
{{--</div>--}}

{{--<div wire:click="showStep('Review')">--}}
{{--    Go to the Review step (works outside of main div???)--}}
{{--</div>--}}

{{--<button wire:click.prevent="saveUpload">Save & Process Upload</button>--}}

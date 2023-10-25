@extends('adminlte::page')


@section('title', 'Case Manage')

@livewireStyles

{{--<x-comments::styles />--}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Include the overlay-component.css stylesheet -->
<link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

<!-- Include the overlay-component.js script -->
<script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>

<!-- Alpine Plugins -->
<script  src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>



@section('content_header')
    <style>
        .content-wrapper {
            background-color: white; !important;
        }

        @if (isset($makePDF))
            @if ($makePDF)
            select {
            /* for Firefox */
            -moz-appearance: none;
            /* for Chrome */
            -webkit-appearance: none;
            background-color: white;
            color:black;

        }

        /* For IE10 */
        select::-ms-expand {
            display: none;
            background-color: white;
            color:black;
        }
        @endif
        @endif
    </style>

    <h1 class="m-0 text-dark">Forms</h1>
@stop



@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (!$makePDF)
                        <a href="{{$linkBackUrl}}"><i class="fas fa-arrow-circle-left" ></i> {{$linkBackText??'Go Back'}}</a>
                        @endif
                        <div id='print_node'>
                            @switch($formType)
                                @case(1) @livewire('forms.case-manage.temp.foster-parent-learning', [$formId, 'makePDF' => $makePDF]) @break
                                @case(2) @livewire('forms.case-manage.temp.safety-plan', [$formId, 'makePDF' => $makePDF, 'sendMailEnabled' => true]) @break
                                @case(3) @livewire('forms.case-manage.temp.pre-admissions', [$formId]) @break
                                @case(4) @livewire('forms.case-manage.temp.carpe-diem.preliminary-assessment', [$formId]) @break
                                @case(5) @livewire('forms.case-manage.temp.carpe-diem.agreement-and-authorization-to-provide-services-to-a-child-in-a-children-residence', [$formId]) @break
                                @case(6) @livewire('forms.case-manage.temp.carpe-diem.authorization-for-supervised-activities', [$formId]) @break
                                @case(7) @livewire('forms.case-manage.temp.carpe-diem.approval-to-administer-all-medication', [$formId]) @break
                            @endswitch
                        </div>

                        @yield('form-controls')

{{--                        <script>--}}
{{--                            function printForm(){--}}
{{--                                $.ajax({--}}
{{--                                    url: '{{route('MakeFromHTML')}}',--}}
{{--                                    data: {--}}
{{--                                        html: $('#print_node').html(),--}}
{{--                                        _token: '{{ csrf_token() }}',--}}
{{--                                    },--}}
{{--                                    type:'post',--}}
{{--                                    success: function (data) {--}}

{{--                                        var blob = new Blob([data], {type: 'application/pdf'});--}}
{{--                                        var link = document.createElement('a');--}}
{{--                                        link.href = window.URL.createObjectURL(blob);--}}
{{--                                        link.download = "test.pdf";--}}
{{--                                        link.click();--}}
{{--                                    }--}}
{{--                                });--}}
{{--                            }--}}
{{--                        </script>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('modal-pro')

    @livewireScripts

    <x-comments::scripts />

    @php($showMarkers = false)

    @if($showMarkers)
        <style type="text/css">
            input.marker, /*.marker::placeholder,*/
            textarea.marker,
            .marker-flag,
            .marker.data-picker input::placeholder
            {
                color: #b70000 !important;
                font-style: italic;
                vertical-align: super;
                font-size: smaller;
            }
        </style>

        <script type="text/javascript">
            $(document).ready(function() {

                function setFieldMarkers(){
                    var currentPrefix = '';
                    var fieldCounter = 1;
                    $('.marker').each(function() {

                        var fullClass = $(this).attr('class');
                        var classes = fullClass.split(" ");
                        var tempPlaceHolderClass = classes.find(function(className) {
                            return className.startsWith("marker-prefix");
                        });

                        if (tempPlaceHolderClass) {
                            var prefix = tempPlaceHolderClass.replace("marker-prefix-", "");

                            if(currentPrefix != prefix){ //if prefix change reset counter
                                fieldCounter = 1;
                                currentPrefix = prefix;
                            }

                            var $element = $(this); //decide what to do based on the element


                            if ( $element.is('input[type="text"]') ){ //normal text input, set placeholder
                                //attach placeholder
                                // $element.attr('placeholder', prefix.trim()+fieldCounter);
                                $element.val(prefix.trim() + fieldCounter);


                            } else if( $element.is('span.radio-options') ) { //radio option, append a span tag
                                // Create the new <span> element & Append the new <span> element as the last sibling
                                var newSpan = $('<span class="marker-flag">').html('&nbsp;' + prefix.trim() + fieldCounter);
                                $element.after(newSpan);


                            }else if( $element.is('td.data-picker') ) {//datepicker, find child input and det placeholder
                                // Find the nested child input and set its placeholder
                                // var nestedInput = $element.find('input.form-control');
                                // nestedInput.attr('placeholder', prefix.trim() + fieldCounter);

                                var newSpan = $('<span class="marker-flag">').html('&nbsp;' + prefix.trim() + fieldCounter);
                                $element.append(newSpan);

                            }else if( $element.is('input[type="checkbox"]') ) {//checkbox, find next span label and attach a trailing span
                                // Checkbox, find the next sibling span label and attach a trailing <span>
                                var labelSpan = $element.next('span');
                                var newSpan = $('<span class="marker-flag">').html('&nbsp;' + prefix.trim() + fieldCounter);

                                if (labelSpan.length > 0) {
                                    labelSpan.after(newSpan);
                                } else {
                                    $element.after(newSpan);
                                }

                            }else if( $element.is('textarea') ) {//textarea, set placeholder
                                // $element.attr('placeholder', prefix.trim() + fieldCounter);
                                $element.val(prefix.trim() + fieldCounter);
                            }

                            fieldCounter++;
                        }
                    });
                }

                setFieldMarkers();

                document.addEventListener('livewire-model-updated', function () {
                    setFieldMarkers();
                });

                // Find all dropdowns on the page
                $('.select2').each(function() {
                    // Initialize Select2 on each dropdown
                    $(this).select2();
                });


            });
        </script>
    @endif

@stop




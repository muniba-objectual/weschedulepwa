<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--    <head>--}}
{{--         Base Meta Tags--}}
{{--        <meta charset="utf-8">--}}
{{--        <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--        <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--        <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--        <link rel="stylesheet" href="{{ resource_path('views/pdf/css/styles.css') }}" media="all" />--}}

{{--        <style>--}}

{{--            /*pre{*/--}}
{{--            /*    white-space: pre-wrap;*/--}}
{{--            /*    word-break: break-word;*/--}}
{{--            /*}*/--}}

{{--            label {--}}
{{--                white-space: nowrap !important;--}}
{{--            }--}}
{{--            label .long_label {--}}
{{--                /*display: block;*/--}}
{{--                /*width: 100%;*/--}}
{{--                /*height: 24px;*/--}}
{{--                /*float: left;*/--}}
{{--                /*white-space: nowrap;*/--}}
{{--            }--}}
{{--            body {--}}
{{--                background-color: white !important;--}}
{{--            }--}}

{{--        </style>--}}

{{--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}

{{--        <!-- Include the overlay-component.css stylesheet -->--}}
{{--        <link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">--}}

{{--        <!-- Include the overlay-component.js script -->--}}
{{--        <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>--}}

{{--        <!-- Alpine Plugins -->--}}
{{--        <script  src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>--}}



{{--    </head>--}}
{{--    <body bgcolor="white">--}}

{{--        <div class="container-fluid">--}}
{{--            <div class="text-center"><img src="/img/carpe_diem_logo.png"/></div>--}}
{{--            @livewire($viewPath, [$formId, true])--}}


{{--            @livewireStyles--}}
{{--            @livewireScripts--}}

{{--        </div>--}}
{{--    </body>--}}
{{--</html>--}}





@extends('adminlte::page')
<link rel="stylesheet" href="/pdf/css/styles.css" media="all" />
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<style>
    .main-sidebar {
        /*display:none;*/
    }

    .unless-read-only{
        display: none;
    }

    label{
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
    }

    .row
    {
        /*display: -webkit-box;*/
    }

    .card-title {
        white-space:nowrap;
    }



    @media print {
        div.pbf {
          page-break-before: always;
      }
        .pbf {
            page-break-after: always;
        }

        /*h2 {*/
        /*    page-break-before: always;*/
        /*}*/
        /*h3, h4 {*/
        /*    page-break-after: avoid;*/
        /*}*/
        /*pre, blockquote {*/
        /*    page-break-inside: avoid;*/
        /*}*/
    }


</style>

@section('title', $title)

@livewireStyles


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Include the overlay-component.css stylesheet -->
<link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

<!-- Include the overlay-component.js script -->
<script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>

<!-- Alpine Plugins -->
<script  src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>


@section('content')


    <script>
        document.addEventListener("livewire:load", function () {

            // Disable all fields
            const inputs = document.querySelectorAll('input, textarea');
            inputs.forEach((input) => {
                input.disabled = true;

                input.classList.add('disabled-field'); //tag the field for custom control

                input.style.border = 'none'; // Hide borders of all text input fields
                input.style.background = 'transparent';
            });


            // Hide radio option values that are not selected
            const radioGroups = document.querySelectorAll('input[type="radio"][name]');
            radioGroups.forEach((group) => {
                group.addEventListener('change', () => {
                    const selectedValue = group.querySelector('input[type="radio"]:checked').value;
                    const options = group.querySelectorAll('input[type="radio"]');
                    options.forEach((option) => {
                        const label = document.querySelector(`label[for="${option.id}"]`);
                        if (option.value !== selectedValue) {
                            label.style.display = 'none';
                        } else {
                            label.style.display = 'block';
                        }
                    });
                });
            });


            // Replace "card card-primary" with "card card-default"
            const cards = document.querySelectorAll('.card.card-primary');
            cards.forEach((card) => {
                // card.classList.remove('card-primary');
                // card.classList.add('card-default');
            });
        });
    </script>


<div class="container" style="width:100%">
    <div class="text-center"><img src="https://casemanage.ca/img/carpe_diem_logo.png" height="200px"/></div>
    @livewire($viewPath, [$formId, true])
</div>

    @livewireScripts
@stop



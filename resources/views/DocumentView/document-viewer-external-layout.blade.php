@extends('layouts.documentViewer')


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

<script src="/pdfJS/build/pdf.js"></script>

@section('content_header')
    @if (isset($makePDF))
        @if (!$makePDF)
    <h1 class="m-0 text-dark">Forms</h1>
    @endif
        @endif
@stop



@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-12" align="center">
                    <img src="/img/carpe_diem_logo.jpg" width="400px"/>
                </div>
            </div>
        </div>
        <script>



            var pdfDataBase64 = atob("<?php echo $embedded;?>");
            pdfjsLib.GlobalWorkerOptions.workerSrc = '/pdfJS/build/pdf.worker.js';

            // Using DocumentInitParameters object to load binary data.
            var loadingTask = pdfjsLib.getDocument({data: pdfDataBase64});
            loadingTask.promise.then(function(pdf) {
                console.log('PDF loaded');

                    document.getElementById('pdf-js-viewer').contentWindow.postMessage(pdfDataBase64, window.location.origin);

                },
                function (reason) {
                    // PDF loading error
                    console.error(reason);
                });

        </script>

                <div align="center">
                <iframe id="pdf-js-viewer" src="/pdfJS/web/viewer.html?file=" title="webviewer" frameborder="0" width="85%" height="100%"></iframe>
                </div>

{{--        @php echo $embedded; @endphp--}}

        <div class="col-12 mt-5" align="center">
            <img src="/img/casemanage_logo_orig.png" width="400px"/>
        </div>
    </div>
    @livewire('forms.case-manage.temp.email-link-sharing')

    @livewireScripts

@stop

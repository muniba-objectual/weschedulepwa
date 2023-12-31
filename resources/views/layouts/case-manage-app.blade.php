<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

        <title>
            Case Manage :: @yield('title', 'Home')
        </title>
        {{-- <title>{{ $title ?? 'Home' }}</title> --}}

        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="{{ asset('css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
        <!-- Nepcha Analytics (nepcha.com) -->
        <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
        <script data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
 
        <!-- Include the overlay-component.css stylesheet -->
        <link defer rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

        @livewireStyles()
    </head>
    <body class="g-sidenav-show  bg-gray-100">
        @livewire("case-manage.layout.aside")
        {{-- @livewire("layout.content") --}}
        {{-- @yield('content') --}}
        {{ $slot }}

        <!--   Core JS Files   -->
        <script src="{{ asset('js/core/popper.min.js') }}"></script>
        <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
        {{-- <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script> --}}
    
        <!-- Github buttons -->
        <script async src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('js/soft-ui-dashboard.min.js?v=1.0.7') }}"></script>

        <!-- Include the overlay-component.js script -->
        <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
        

        <!-- Alpine Plugins -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
 
        @stack("script")
        @livewireScripts()
    </body>
</html>

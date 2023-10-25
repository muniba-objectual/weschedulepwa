<div class="preloader flex-column justify-content-center align-items-center">


    @if (str_contains(url()->current(),'casemanage.ca') || str_contains(url()->current(),'casemanage.local'))

        {{-- Preloader logo --}}
        <img src="{{ asset(config('adminlte.preloader_casemanage.img.path', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
             class="{{ config('adminlte.preloader_casemanage.img.effect', 'animation__shake') }}"
             alt="{{ config('adminlte.preloader_casemanage.img.alt', 'We-Schedule.ca') }}"
             width="{{ config('adminlte.preloader_casemanage.img.width', 60) }}"
             height="{{ config('adminlte.preloader_casemanage.img.height', 60) }}">

    @else

        {{-- Preloader logo --}}
        <img src="{{ asset(config('adminlte.preloader.img.path', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
             class="{{ config('adminlte.preloader.img.effect', 'animation__shake') }}"
             alt="{{ config('adminlte.preloader.img.alt', 'We-Schedule.ca') }}"
             width="{{ config('adminlte.preloader.img.width', 60) }}"
             height="{{ config('adminlte.preloader.img.height', 60) }}">


    @endif

</div>

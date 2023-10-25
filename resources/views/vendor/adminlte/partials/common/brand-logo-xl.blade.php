@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@if (str_contains(url()->current(),'casemanage.ca') || str_contains(url()->current(),'casemanage.local'))
{{--    <div style="width:100% !important; height:100% !important; background-color:#343a40 !important;" class="text-center">--}}
    <div class="text-center">
    <a href="{{ $dashboard_url }}"
       @if($layoutHelper->isLayoutTopnavEnabled())
           class="navbar-brand {{ config('adminlte.classes_brand') }}"
       @else
           class="brand-link  {{ config('adminlte.classes_brand') }}"
        @endif>

        {{--    --}}{{-- Small brand logo --}}
        {{--    <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"--}}
        {{--         alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"--}}
        {{--         class="{{ config('adminlte.logo_img_class', 'brand-image-xl') }} logo-xs">--}}

        {{-- Large brand logo --}}
            <img src="{{ asset(config('adminlte.logo_img_xl_casemanage')) }}" width="220px" height="100px"
                 class="logo">

    </a>
    </div>

        @else

    <div class="text-center">
        <a href="{{ $dashboard_url }}"
           @if($layoutHelper->isLayoutTopnavEnabled())
               class="navbar-brand {{ config('adminlte.classes_brand') }}"
           @else
               class="brand-link l {{ config('adminlte.classes_brand') }}"
            @endif>

            {{--    --}}{{-- Small brand logo --}}
            {{--    <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"--}}
            {{--         alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"--}}
            {{--         class="{{ config('adminlte.logo_img_class', 'brand-image-xl') }} logo-xs">--}}

            {{-- Large brand logo --}}

                <img src="{{ asset(config('adminlte.logo_img_xl')) }}"
                     alt="{{ config('adminlte.logo_img_alt', 'We-Schedule') }}"
                     width="220px">
                {{--             class="{{ config('adminlte.logo_img_xl_class', 'brand-image-xs') }} logo-xl">--}}


        </a>
    </div>
        @endif


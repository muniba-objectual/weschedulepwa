@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <div class="{{ $auth_type ?? 'login' }}-box">

        {{-- Logo --}}
        <div class="{{ $auth_type ?? 'login' }}-logo">

            @if (str_contains(url()->current(),'casemanage.ca') || str_contains(url()->current(),'casemanage.local'))
                <a href="{{ $dashboard_url }}">
                    <img src="{{ asset(config('adminlte.logo_img_casemanage_orig')) }}" width="300px">
                    {{-- !! config('adminlte.logo', '<b>Admin</b>LTE') !! --}}
                </a>
            @else
                <a href="{{ $dashboard_url }}">
                    <img src="{{ asset(config('adminlte.logo_img_orig')) }}" height="200px">
                    {{-- !! config('adminlte.logo', '<b>Admin</b>LTE') !! --}}
                </a>
            @endif
        </div>

        {{-- Card Box --}}
        @if (str_contains(url()->current(),'casemanage.ca'))
            <div class="card {{ config('adminlte.classes_auth_card_casemanage', 'card-outline card-primary') }}">
                @else
                    <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">
                        @endif
                        {{-- Card Header --}}
                        @hasSection('auth_header')
                            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                                <h3 class="card-title float-none text-center">
                                    @yield('auth_header')
                                </h3>
                            </div>
                        @endif

                        {{-- Card Body --}}
                        <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                            @yield('auth_body')
                        </div>

                        {{-- Card Footer --}}
                        @hasSection('auth_footer')
                            <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                                @yield('auth_footer')
                            </div>
                        @endif

                    </div>

            </div>
            <br />

@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop

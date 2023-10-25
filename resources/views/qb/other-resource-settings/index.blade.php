<?php
    $pageTitle = "Other QB Settings";
    $breadcrumbs = [
        [
            'text' => 'QB Dashboard',
            'url' => route('qb.dashboard')
        ],
        [
            'text' => $pageTitle
        ],
    ];
?>

@extends('layouts.with-all-menus')

@section('title', "We-Schedule | $pageTitle")

@section('section-body-content')
    <div class="row">
        <div class="col-12">
            @livewire('qb.quickbooks-settings')
        </div>
    </div>

    <script>
        window.addEventListener('showSpinner', eventData => {
            const propId = eventData.propId;
            console.log('show spinner');

            // Show the spinner
            $(".pleaseWaitSpinner."+propId).css({
                visibility: 'visible'
            });
        });

        window.addEventListener('hideSpinner', eventData => {
            const propId = eventData.propId;
            console.log('hide spinner');

            // Show the spinner
            $(".pleaseWaitSpinner."+propId).css({
                visibility: 'hidden'
            });
        });

        $(document).ready(function() {
            $(".pleaseWaitSpinner").css({
                visibility: 'hidden'
            });
        });
    </script>
@stop

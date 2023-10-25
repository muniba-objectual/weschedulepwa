<?php
$pageTitle = "All QB Accounts For Item Categories";
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
            @livewire('qb.item-category-list')
        </div>
    </div>
@stop

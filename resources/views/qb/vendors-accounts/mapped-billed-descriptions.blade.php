<?php
$pageTitle = "Vendor Accounts Mapped With Bill Descriptions";

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
    @livewire('qb.vendor-mapped-bill-descriptions')
@stop

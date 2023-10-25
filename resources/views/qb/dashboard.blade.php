<?php
$pageTitle = "Dashboard";
$breadcrumbs = [
    [
        'text' => 'QB'
    ],
    [
        'text' => $pageTitle
    ],
];
?>

@extends('layouts.with-all-menus')

@section('title', "We-Schedule | QB Dashboard")

@section('section-body-content')
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">QB Connection</h5>
                    <br>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('qb.authorize') }}">Authorize QB Connection</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Manage Vendor Accounts</h5>
                    <br>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('qb.vendors-accounts.index') }}">View All Vendor Accounts</a></li>
                        <li><a href="{{ route('qb.vendors-accounts.duplicates') }}">View Duplicate Vendor Accounts</a></li>
                        <li><a href="{{ route('qb.vendors-accounts.mapped-billed-description') }}">Mapped Bill Descriptions</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Manage Item Categories</h5>
                    <br>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('qb.item-categories.index') }}">View All QB Accounts</a></li>
                        <li><a href="#" title="pending...">Mapped Vendors</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Manually Force Sync</h5>
                    <br>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('qb.vendors-accounts.sync') }}">Sync Vendor Accounts</a></li>
                        <li><a href="{{ route('qb.item-categories.sync') }}">Sync Accounts (For Item Categories)</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Testing</h5>
                    <br>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('qb.test.companyInfo') }}">Test Company Info</a></li>
                        <li><a href="{{ route('qb.test.vendors') }}">Load Vendors</a></li>
                        <li><a href="{{ route('qb.test.accounts') }}">Load Accounts</a></li>
                        <li><a href="{{ route('qb.test.customers') }}">Load Customers</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Other Configurations</h5>
                    <br>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('qb.other-settings') }}">Other Configurations</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

<?php
    $pageTitle = "All Vendor Accounts";
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
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Sync Token</th>
                    <th>Display Name</th>
                    <th>AcctNum</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->id }}</td>
                        <td>{{ $vendor->SyncToken }}</td>
                        <td>{{ $vendor->DisplayName }}</td>
                        <td>{{ $vendor->AcctNum }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

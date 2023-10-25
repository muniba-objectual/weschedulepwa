<?php
    $pageTitle = "QB Duplicated Vendor Account Numbers";
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
            <div class="row">
                @forelse($duplicates->groupBy('AcctNum') as $acctNum => $vendors)
                    <h3>Account Number: {{ $acctNum }}</h3>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Display Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vendors as $vendor)
                            <tr>
                                <td>{{ $vendor->Id }}</td>
                                <td>{{ $vendor->DisplayName }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @empty
                    <h5 style="text-align: center;">No Duplicates Found Yet!</h5>
                @endforelse
            </div>
        </div>
    </div>
@stop

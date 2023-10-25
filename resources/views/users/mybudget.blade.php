
@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">My Budgets</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md6">
                <div class="card">
                    <div class="card-body">

                        <!-- form start -->

                    <a href="/img/sample_budget.jpg"><img src="/img/sample_budget.jpg" width="85%" /></a>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


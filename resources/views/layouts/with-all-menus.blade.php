@extends('adminlte::page')

@section('title', 'We-Schedule') {{--default title--}}

@section('content_header')
    @livewireStyles

    @stack('content_headers')
@stop

@section('content')
    </section>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$pageTitle??''}}</h1>
            </div>
            <div class="col-sm-6">
                @if(isset($breadcrumbs))
                    <ol class="breadcrumb float-sm-right">
                        @foreach($breadcrumbs as $breadCrumpIndex  => $breadcrumb)
                            @php
                                $isLastItemInLoop = $breadCrumpIndex  === count($breadcrumbs) - 1;
                            @endphp
                            <li class="breadcrumb-item {{$isLastItemInLoop?'active':''}}">
                                @if($isLastItemInLoop || isset($breadcrumb['url']))
                                    <a href="{{$breadcrumb['url']??'#'}}">{{$breadcrumb['text']}}</a>
                                @else
                                    {{$breadcrumb['text']}}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @yield('section-body-content')
            </div>
        </div>
    </section>
    <!-- /.content -->

    @livewireScripts
@stop

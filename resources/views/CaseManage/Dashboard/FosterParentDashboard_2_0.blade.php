@extends('adminlte::page')

@section('title', 'We-Schedule')

@section('content_header')
    @livewireStyles
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')
    <section class="mx-2 pb-3"> <span class="float-right">
            <i class="fas fa-arrow-circle-left" onclick="history.back()"></i></span>

        <ul class="nav nav-pills" id="myTabMD" role="tablist">

                @if (auth()->user()->user_type == "5.1")


                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" id="profile-tab-md" data-toggle="tab" href="#admin_assistant" role="tab" aria-controls="charlene" aria-selected="false">{{auth()->user()->get_user_type->type}} -
                        {{auth()->user()->name}}</a> <br />
                </li>

                @endif

        </ul>


        <div class="tab-content card pt-5" id="myTabContentMD">



                @if (auth()->user()->user_type == "5.1" || auth()->user()->user_type == "4.2" || auth()->user()->id == 1 || auth()->user()->id == 2)

                                <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">
                                <section class="content">
                                    <div class="container-fluid">
                                        <!-- Small boxes (Stat box) -->
                                        <div class="row">
                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-yellow">
                                                    <div class="inner">
                                                        <h5>2.4 - Foster Parents</h5>

                                                    </div>

                                                    <div class="icon">
                                                        <i class="fas fa-users"></i>
                                                    </div><br />

                                                    <br />

                                                </div>



                                            </div>



                                        </div>
                                </section>


                                </div>


        </div>
                <!-- New Foster Parent [2.3] Profiles -->
                <div class="container-fluid mt-3 mb-3">

                    <div class="container-fluid">
                        <div class="row justify-content-md">

                            <div class="container-fluid mt-3 mb-3">
                                @livewire('dashboard-elements.lists.case-manage.all-full-time-foster-parent-list')

                            </div>




                        </div>
                        <!-- *Foster Parent Profiles -->



            </div>
                    @endif

        </div>
    </section>
    @livewireScripts

@stop

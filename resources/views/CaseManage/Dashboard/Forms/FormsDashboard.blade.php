@extends('adminlte::page')

@section('title', 'Case Manage')

@section('content_header')
    @livewireStyles

    <!-- Include the overlay-component.css stylesheet -->
    <link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

    <!-- Include the overlay-component.js script -->
    <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
    <!-- Alpine Plugins -->
    <script  src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    <!-- Date Picker -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')

    <section class="mx-2 pb-3"> <span class="float-right">
            <i class="fas fa-arrow-circle-left" onclick="history.back()"></i></span>

        <ul class="nav nav-pills" id="myTabMD" role="tablist">

            {{-- @if (auth()->user()->user_type == "5.1") --}}


            <li class="nav-item waves-effect waves-light">
                <a class="nav-link active" id="profile-tab-md" data-toggle="tab" href="#admin_assistant" role="tab" aria-controls="charlene" aria-selected="false">{{auth()->user()->get_user_type->type}} -
                    {{auth()->user()->name}}</a> <br />
            </li>

            {{-- @endif --}}

        </ul>


        <div class="tab-content card pt-1" id="myTabContentMD">



            {{-- @if (auth()->user()->user_type == "5.1") --}}

            <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">

                <section class="content">
                    <div class="container-fluid">

                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-gradient-olive">
                                    <div class="inner">
                                        <h5>Foster Parent Learning</h5>

                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div><br />
                                    <!-- <a href="javascript:window.livewire.emit('showModal', 'SomeData')" class="small-box-footer"><i
                                             class="fas fa-arrow-circle-right"></i></a> -->

                                    <a href="/TestFormBuilder/1?back-text=Forms Dashboard" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-gradient-olive">
                                    <div class="inner">
                                        <h5>Safety Plan</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div><br/>
                                    <a href="/TestFormBuilder/2?back-text=Forms Dashboard" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-gradient-olive">
                                    <div class="inner">
                                        <h5>Pre-Admissions</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-door-open"></i>
                                    </div><br/>
                                    <a href="/TestFormBuilder/3?back-text=Forms Dashboard" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-gradient-olive">
                                    <div class="inner">
                                        <h5>Preliminary Assessment</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-door-open"></i>
                                    </div><br/>
                                    <a href="/TestFormBuilder/4?back-text=Forms Dashboard" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-gradient-olive">
                                    <div class="inner">
                                        <h5>Agreement & Authorization to Provide Services to a Child in a Children Residence</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-door-open"></i>
                                    </div><br/>
                                    <a href="/TestFormBuilder/5?back-text=Forms Dashboard" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-gradient-olive">
                                    <div class="inner">
                                        <h5>Authorization For Supervised Activities</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-door-open"></i>
                                    </div><br/>
                                    <a href="/TestFormBuilder/6?back-text=Forms Dashboard" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-gradient-olive">
                                    <div class="inner">
                                        <h5>Approval To Administer All Medication</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-door-open"></i>
                                    </div><br/>
                                    <a href="/TestFormBuilder/7?back-text=Forms Dashboard" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>

    </section>
    <!-- Require the Modal Pro component -->
    @livewire('modal-pro')
    @livewireScripts

@stop

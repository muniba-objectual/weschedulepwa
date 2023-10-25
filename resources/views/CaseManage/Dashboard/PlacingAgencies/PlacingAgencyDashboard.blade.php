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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7gZgrs12bkKHrcUN5ySRN-UIOZorEV6U&libraries=places"></script>

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


        <div class="tab-content card pt-2 pb-0" id="myTabContentMD">



            {{-- @if (auth()->user()->user_type == "5.1") --}}

            <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">

                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h5>{{$agency->name}}</h5>

                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                    </div><br />
                                    <script>
                                        $agencyID = {{$agency->id}};
                                    </script>
                                    <a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.create-case-worker-modal', {'agencyID':$agencyID}, {'size':'xl'})" class="small-box-footer"><i
                                            class="fas fa-plus-circle"></i> Add New Case Worker</a>
                                </div>



                            </div>






                        </div>
                </section>


            </div>


        </div>
        <!-- Placing Agency [7.1] Profiles -->
        <div class="container-fluid mt-3 mb-3">

            <div class="container-fluid">
                <div class="row justify-content-md">
                    <div class="container-fluid mt-3 mb-3">
                        @livewire('dashboard-elements.lists.case-manage.placing-agencies.placing-agency-list',['search' => $search, 'agency' => $agency])
                    </div>
                </div>
                <!-- *Foster Parent Profiles -->
            </div>
            {{-- @endif --}}

        </div>

    </section>

    <!-- Require the Modal Pro component -->
    @livewire('modal-pro')
    @livewireScripts

    <script>
        window.addEventListener('refreshPage', event => {
            location.reload();
        });
    </script>

@stop

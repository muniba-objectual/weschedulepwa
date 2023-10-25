@extends('adminlte::page')


@section('title', 'Case Manage')

@section('content_header')
    @unless (Auth::check())
        You are not signed in.

    @endunless


    <!-- Include the overlay-component.css stylesheet -->
    <link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

    <!-- Include the overlay-component.js script -->
    <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
    <!-- Alpine Plugins -->
    <script  src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>


@stop

@section('content')

    @livewireStyles
    <x-comments::styles />



    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Placing Agency Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Placing Agency Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="/img/ws_icon.jpg"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{$agency->name}}


                            </h3>

                            <p class="text-muted text-center">
                                <script>
                                    $placingAgencyID = {{$agency->id}};
                                </script>

                            </p>

                            <table class="table table-hover table-striped table-bordered text-sm">

                                <tr>
                                    <th scope="row" colspan="2">Children In Care</th>

                                </tr>

                                @if ($agency->getChildren)
                                    @foreach ($agency->getChildren as $tmpChild)
                                        <tr>
                                            <th class="text-right" colspan="2" scope="row"><a href="/children/{{$tmpChild->id}}">{{$tmpChild->initials}}</a></th>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <th class="text-right" colspan="2" scope="row">No Children Assigned</th>
                                    </tr>
                                @endif

                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul id="myTab" class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a>
                                </li>

                                <li class="nav-item"><a class="nav-link" href="#documents" data-toggle="tab">Documents</a>
                                </li>

                                <li class="nav-item"><a class="nav-link" href="#financials" data-toggle="tab">Financials</a>
                                </li>

                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->

                        <div class="card-body pt-1 mt-0">
                            <div class="tab-content">

                                <div class="active tab-pane" id="profile">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            @livewire('agency-profile', ['placingAgencyID' => $agency->id])
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>

                                <div class="tab-pane" id="documents">
                                    <div class="row mb-2">

                                        {{-- Setup data for datatables --}}
                                        @php
                                            $heads = [
                                                'Type',
                                                'Description',
                                                'Date',
                                                'Renewal Date',
                                                'Attachment',
                                                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                                            ];

                                            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                                        </button>';
                                            $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                                              <i class="fa fa-lg fa-fw fa-trash"></i>
                                                          </button>';
                                            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                                               <i class="fa fa-lg fa-fw fa-eye"></i>
                                                           </button>';

                                            $config = [
                                                'data' => [
                                                    ["Service Agreement", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Christmas Funding", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Uniform Funding", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>']



                                                ],
                                                'order' => [[1, 'asc']],
                                                'columns' => [null, null, null, ['orderable' => false]],
                                                'search' => [true]

                                            ];
                                        @endphp

                                        {{-- Minimal example / fill data using the component slot --}}
                                        <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" striped hoverable>
                                            @foreach($config['data'] as $row)
                                                <tr>
                                                    @foreach($row as $cell)
                                                        <td>{!! $cell !!}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </x-adminlte-datatable>

                                    </div>
                                </div>

                                <div class="tab-pane" id="financials">
                                    @livewire('agency-financials', ['placingAgencyID' => $agency->id])
                                </div>

                                <div class="tab-pane" id="timeline">
                                    @livewire('agency-timeline', ['placingAgencyID' => $agency->id])
                                </div>

                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    @livewire('modal-pro')
    @livewireScripts

    <x-comments::scripts />

@stop

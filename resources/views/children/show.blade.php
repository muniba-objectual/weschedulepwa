@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    @unless(Auth::check())
        You are not signed in.
    @endunless


    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.js"></script>


    <style>
        .timeline-body {
            padding: 10px !important;
        }

        input[type="file"] {
            display: none;
        }

        input[type="file"].SRA_Contract {
            display: block;
        }

        input[type="file"].ISA_Contract {
            display: block;
        }

        input[type="file"].PFA_Contract {
            display: block;
        }

        input[type="file"].CarpeDiem_Contract {
            display: block;
        }

        .empty {
            color: red !important;
        }

        .custom-file-upload {
            background-color: blue;
            color: white;
            padding: 2px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            border-radius: 0rem;
            cursor: pointer;
            margin-top: 1px;

        }

        .custom-send {
            background-color: red;
            color: white;
            padding: 2px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            border-radius: 0rem;
            cursor: pointer;
            margin-top: 1px;


        }

        .popover {
            max-width: 900px !important;
        }

        /*fix for auto-resize textarea */
        .tab-pane {
            height: 0;
            overflow: hidden;
            display: block !important;
        }

        .tab-pane.active {
            height: auto;
            overflow: visible;
        }
    </style>

@stop

@section('content')

    @livewireStyles
    <x-comments::styles />



    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Child Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Child Profile</li>
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
                                <img class="mr-1 " {{--                                     src="/img/ws_icon.jpg" --}} width="250px" height="200px"
                                    src="/img/child_avatar.jpg" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $child->initials }}

                                <div class="mb-0 mt-3" style="margin-bottom:-10px !important;">
                                    @livewire('profile-elements.active-toggle', ['model' => $child])

                                    <!-- <input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="Deactivated" data-onstyle="success" data-offstyle="danger"> -->
                                </div>

                                @if ($child->SRA)
                                    <a data-toggle="popover-click-toggleProgram"><span
                                            class="badge bg-success">SRA</span></a>
                                @endif
                                @if ($child->PFA)
                                    <a data-toggle="popover-click-toggleProgram"><span
                                            class="badge bg-gradient-yellow">PFA</span></a>
                                @endif
                                @if ($child->ISA)
                                    <a data-toggle="popover-click-toggleProgram"><span
                                            class="badge bg-gradient-indigo">ISA</span></a>
                                @endif
                                @if ($child->CARPE_DIEM)
                                    <a data-toggle="popover-click-toggleProgram"><span
                                            class="badge bg-gradient-navy mt-0">CARP&Eacute; DIEM</span></a>
                                @endif

                            </h3>

                            <div id="popover-content-wrapper-toggleProgram" style="display: none;">
                                <p>
                                    Which Program will this child be assigned to?
                                </p>
                                <div class="row">
                                    <div class="col-md-2" id="SRAProgram">
                                        <span class="badge bg-success">SRA</span>
                                    </div>
                                    <div class="col-md-2" id="PFAProgram">
                                        <span class="badge bg-gradient-yellow">PFA</span>
                                    </div>
                                    <div class="col-md-2" id="ISAProgram">
                                        <span class="badge bg-gradient-indigo">ISA</span>
                                    </div>
                                    <div class="col-md-3 mr-3" id="CARPEProgram">
                                        <span class="badge bg-gradient-navy">CARP&Eacute; DIEM</span>
                                    </div>
                                    <div class="col-md-2" id="NONE">
                                        <span class="badge bg-gradient-red">NONE</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-muted text-center">Home - {{ $child->get_home->name }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total Shifts</b> <a class="float-right">{{ $child->get_shifts_count }}</a>
                                </li>
                                <li class="list-group-item">

                                    <b>Staff Assigned ({{ $child->get_assigned_user_count }})</b> <br /> <a
                                        class="float-right">
                                        @foreach ($child->getAssignedUser as $staff)
                                            <a href="/users/{{ $staff->id }}">{{ $staff->name }}</a><br />
                                        @endforeach
                                    </a>
                                </li>

                            </ul>
                            @if ($child->SRA)
                                <p class="text-center"><b><u>SRA Reports</u></b></p>
                                @livewire('s-r-a-reports', ['user' => Auth::user(), 'child' => $child])
                            @endif
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
                                <li class="nav-item"><a class="nav-link active" href="#profile"
                                        data-toggle="tab">Profile</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#activity2" data-toggle="tab">Activity</a>
                                </li>
                                <!--
                                    <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a>
                                    </li>
                                    -->
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                </li>
                                @if ($child->id == '3')
                                    <li class="nav-item"><a class="nav-link" href="#medicationTab"
                                            data-toggle="tab">Medication</a>
                                    </li>
                                @endif
                                {{-- HIDE INCIDENTS - TEMPORARY
                                <li class="nav-item"><a class="nav-link" href="#incidents"
                                                        data-toggle="tab">Incidents</a></li>
                                --}}
                                <li class="nav-item"><a class="nav-link" href="#safety_plan"
                                        onclick="autosize($('.autoResize'));" data-toggle="tab">Safety
                                        Plan</a></li>
                                @if ($child->SRA)
                                    <li class="nav-item"><a class="nav-link" href="#SRA" data-toggle="tab">SRA</a></li>
                                @endif

                                @if ($child->ISA)
                                    <li class="nav-item"><a class="nav-link" href="#ISA" data-toggle="tab">ISA</a>
                                    </li>
                                @endif

                                @if ($child->PFA)
                                    <li class="nav-item"><a class="nav-link" href="#PFA" data-toggle="tab">PFA</a>
                                    </li>
                                @endif

                                @if ($child->CARPE_DIEM)
                                    <li class="nav-item"><a class="nav-link" href="#CarpeDiem"
                                            data-toggle="tab">CARP&Eacute; DIEM</a></li>
                                @endif
                                <!--
                                    <li class="nav-item"><a class="nav-link" href="#Admin" data-toggle="tab">Admin</a></li>
                                    -->
                                @if (Auth()->user()->id == '1')
                                    <li class="nav-item"><a class="nav-link" href="#ADMIN" data-toggle="tab"><i
                                                class="fa fa-fw fa-cog"></i> ADMIN</a></li>
                                @endif
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="profile">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">

                                            <!-- form start -->
                                            <form>
                                                <div class="form-group">
                                                    <label for="initials">Initials</label>
                                                    <input disabled type="initials" class="form-control" id="initials"
                                                        placeholder="{{ $child->initials }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="DOB">Date of Birth</label>
                                                    <input disabled type="DOB" class="form-control" id="DOB"
                                                        placeholder="{{ $child->DOB }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="initials">Assigned Home</label>
                                                    <input disabled type="home" class="form-control" id="home"
                                                        placeholder="{{ $child->get_home->name }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="notes">Notes</label>
                                                    <textarea disabled type="notes" class="form-control" id="notes">{{ $child->notes }}</textarea>
                                                </div>


                                            </form>


                                        </div>

                                        <!-- /.card -->

                                    </div>
                                </div>

                                <div class="tab-pane" id="activity2">

                                    {{--                                    <!-- include summernote css/js --> --}}
                                    {{--                                    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> --}}
                                    {{--                                    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script> --}}


                                    {{--                                       {{-- <livewire:comments :model="$child" newest-first /> --}}

                                    @livewire('custom-comments.comments-component', ['model' => $child, 'newestFirst' => true])


                                    {{-- <livewire:custom-comments.custom-comments-component :model="$child" newest-first /> --}}

                                    <script>
                                        window.addEventListener('new_image_filename', event => {
                                            // $("#previewImage").html("Image Preview: <img src='/storage/" + event.detail.filename.substring(7) + "' width='400px' />");
                                            //alert('New image: ' + event.detail.filename.substring(7));
                                            $("#commentBox").html("<figure><figcaption>Enter Caption</figcaption><br /><br /><img src='/storage/" +
                                                event.detail.filename.substring(7) + "' height='300px' /></figure>");

                                            console.log(event);
                                            // $("#summernote111").summernote('code', "Image: <br />  src='/storage/" + event.detail.filename.substring(7) + "' style='width:400px'  />");


                                        })

                                        window.addEventListener('setToggleActiveStatus', data => {
                                            if (data) {
                                                $('#customSwitch1').prop('checked', true)
                                            } else {
                                                $('#customSwitch1').prop('checked', false)

                                            }
                                        })
                                    </script>
                                </div>
                                <div class="tab-pane" id="activity">

                                    {{-- @livewire('activity-wall', ['user' => $user, 'child' => $child]) --}}
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">

                                    <script>
                                        $(document).ready(function() {
                                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                            $.ajax({
                                                /* the route pointing to the post function */
                                                url: "{{ route('child.getTimelineData') }}",
                                                type: 'GET',
                                                /* send the csrf-token and the input to the controller */
                                                data: {
                                                    _token: CSRF_TOKEN,
                                                    page: 1,
                                                    childID: {{ $child->id }}
                                                },
                                                //dataType: 'JSON',
                                                /* remind that 'data' is the response of the AjaxController */
                                                success: function(data) {
                                                    //console.log(data);
                                                    $('#timeline').html(data);
                                                }
                                            });


                                        });
                                    </script>

                                </div>
                                <div class="tab-pane" id="medicationTab">

                                    {{-- Hayden Only --}}
                                    @if ($child->id == '3')
                                        @livewire('medication', ['user' => $user, 'child' => $child])
                                    @endif

                                    {{-- @include('medication.index') --}}
                                </div>


                                <!-- /.tab-pane -->
                                {{-- HIDE INCIDENTS - TEMPORARY
                                <div class="tab-pane" id="incidents">

                                    @livewire('i-r', ['user' => $user, 'child' => $child])

                                </div>
                                --}}
                                <div class="tab-pane" id="safety_plan">
                                    @livewire('l-v_-child-safety-plan', ['user' => $user, 'child' => $child])
                                </div>

                                <div class="tab-pane" id="SRA">
                                    <script>
                                        var activeTab = window.localStorage.getItem('activeTab');
                                        // alert (activeTab);
                                    </script>
                                    @if ($child->SRA)
                                        @livewire('s-r-a', ['user' => $user, 'child' => $child, 'SRA_Form_entries' => $SRA_Form_entries])
                                    @endif
                                </div>

                                <div class="tab-pane" id="ISA">
                                    <script>
                                        var activeTab = window.localStorage.getItem('activeTab');
                                        // alert (activeTab);
                                    </script>
                                    @if ($child->ISA)
                                        @livewire('i-s-a', ['user' => $user, 'child' => $child])
                                    @endif
                                </div>

                                <div class="tab-pane" id="PFA">
                                    <script>
                                        var activeTab = window.localStorage.getItem('activeTab');
                                        // alert (activeTab);
                                    </script>
                                    @if ($child->PFA)
                                        @livewire('p-f-a', ['user' => $user, 'child' => $child])
                                    @endif
                                </div>

                                <div class="tab-pane" id="CarpeDiem">
                                    <script>
                                        var activeTab = window.localStorage.getItem('activeTab');
                                        // alert (activeTab);
                                    </script>
                                    @if ($child->CARPE_DIEM)
                                        @livewire('carpe-diem', ['user' => $user, 'child' => $child])
                                    @endif
                                </div>

                                <div class="tab-pane" id="ADMIN">
                                    <script>
                                        var activeTab = window.localStorage.getItem('activeTab');
                                        // alert (activeTab);
                                    </script>
                                    @if (Auth()->user()->id == '1' || Auth()->user()->id == '2')
                                        {{--
                                        @livewire('child-admin', ['user' => $user, 'child' => $child ])
                                        --}}
                                    @endif
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

        <script>
            $(document).ready(function() {
                console.log("ready555!");
                $('#commentBox').on('input', (e) => {
                    // your code here
                    console.log(e.target.innerHTML)
                    Livewire.emit('UpdateText', e.target.innerHTML);
                    Livewire.emit('UpdateReplyText', e.target.innerHTML);

                });
            });
        </script>
        @livewireScripts
        <x-comments::scripts />

        <script>
            $(function() {

                /* var queryPairs = window.location.href.split('?').pop().split('&');
                 for (var i = 0; i < queryPairs.length; i++)
                 {
                     var pair = queryPairs[i].split('=');
                     if (pair[1] == 'AW')
                     {
                         $('#myTab a[href="#activity"]').tab('show'); // Select tab by name

                         return;
                     }
                     if (pair[1] == 'SafetyPlan')
                     {
                         $('#myTab a[href="#safety_plan"]').tab('show'); // Select tab by name

                         return;
                     }

                     if (pair[1] == 'Profile')
                     {
                         $('#myTab a[href="#profile"]').tab('show'); // Select tab by name

                         return;
                     }
                 }*/

                $('a[data-toggle="tab"]').on('click', function(e) {
                    var activeTab = window.localStorage.getItem('activeTab');

                    window.localStorage.setItem('activeTab', $(e.target).attr('href'));

                });
                var activeTab = window.localStorage.getItem('activeTab');
                if (activeTab) {
                    $('#myTab a[href="' + activeTab + '"]').tab('show');

                    window.localStorage.removeItem("activeTab");
                    autosize($('.autoResize'));

                }

            })

            function viewIR($id) {
                $('#myTab a[href="#incidents"]').tab('show');
                var $text = $id;
                var WithOutBrackets = $text.toString().replace(/[\[\]']+/g, '');

                Livewire.emit('view', WithOutBrackets);
            }

            function viewSRA($id) {
                $('#myTab a[href="#SRA"]').tab('show');
                var $text = $id;
                var WithOutBrackets = $text.toString().replace(/[\[\]']+/g, '');

                Livewire.emit('viewSRA', WithOutBrackets);
            }

            function addActivityMessage($childID) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (document.getElementById('inputAddMessage').value != "") {


                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    $.ajax({
                        type: 'POST',
                        // url: "{{ route('activity.edit') }}",
                        url: "{{ route('myshifts.edit') }}",
                        data: {
                            type: 'AddMessage',
                            UserID: {{ Auth::id() }},
                            ChildID: $childID,
                            message: document.getElementById('inputAddMessage').value,

                        },
                        success: function(data) {
                            //  alert(data.success + "|" + data.message);
                            Toast.fire({
                                    type: 'success',
                                    //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                                    title: 'We-Schedule.ca | Activity Entry has been added successfully.',
                                    //icon: 'success',
                                    //timerProgressBar: true,
                                },
                                function() {
                                    window.location.reload(true);
                                }
                            );
                        }
                    });
                } else {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    Toast.fire({
                        type: 'warning',
                        //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                        title: 'We-Schedule.ca | Error cannot post blank message',
                        icon: 'warning',
                        timerProgressBar: true,


                    })
                }

            }


            Livewire.on('new_image_filename', filename => {
                alert('A new image was uploaded: ' + filename);
            })

            $(document).ready(function() {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $("#customSwitch1").on('change', function() {
                    //console.log('change event {{ Auth::User()->get_user_type->name }}',$(this).is(':checked'));
                    $.ajax({
                        /* the route pointing to the post function */
                        url: "{{ route('child.updateChildStatus', Auth::id()) }}",
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: {
                            _token: CSRF_TOKEN,
                            active: $(this).is(':checked'),
                            child: {{ $child->id }}
                        },
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */
                        success: function(data) {
                            console.log(data);
                        }
                    });
                });



                $('[data-toggle="popover-click-toggleProgram"]').popover({
                    html: true,
                    trigger: 'click',
                    placement: 'right',
                    content: function() {
                        return $('#popover-content-wrapper-toggleProgram').html();
                    }
                });

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

                function fireToast($result) {
                    Toast.fire({
                        type: 'success',
                        //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                        title: 'We-Schedule.ca | ' + $result,
                        //icon: 'success',
                        //timerProgressBar: true,
                    }).then((result) => {
                        window.location.reload(true);
                    })
                };


                function updateChildProgram($program) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        /* the route pointing to the post function */
                        url: "{{ route('child.updateChildProgram', Auth::id()) }}",
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: {
                            _token: CSRF_TOKEN,
                            program: $program,
                            child: {{ $child->id }}
                        },
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */
                        success: function(data) {
                            console.log(data);
                        }
                    });

                }

                $(document).on('click', '#SRAProgram', function() {
                    $('[data-toggle="popover-click-toggleProgram"]').popover("hide");
                    updateChildProgram('SRA');
                    fireToast('SRA Program has been selected.');

                });

                $(document).on('click', '#PFAProgram', function() {
                    $('[data-toggle="popover-click-toggleProgram"]').popover("hide");
                    updateChildProgram('PFA');

                    fireToast('PFA Program has been selected.');
                });

                $(document).on('click', '#ISAProgram', function() {
                    $('[data-toggle="popover-click-toggleProgram"]').popover("hide");
                    updateChildProgram('ISA');

                    fireToast('ISA Program has been selected.');
                });

                $(document).on('click', '#CARPEProgram', function() {
                    $('[data-toggle="popover-click-toggleProgram"]').popover("hide");
                    updateChildProgram('CARPE_DIEM');

                    fireToast('Carpe Diem Program has been selected.');
                });

                $(document).on('click', '#NONE', function() {
                    $('[data-toggle="popover-click-toggleProgram"]').popover("hide");
                    updateChildProgram('NONE');
                    fireToast('No Program has been selected.');

                });

                console.log('ready2');
                autosize($('.autoResize'));

                window.addEventListener('autoResizeTextArea', event => {
                    // autosize($('.autoResize'));

                    console.log('resized_textarea');


                })

                document.addEventListener("DOMContentLoaded", () => {
                    Livewire.hook('component.initialized', (component) => {
                        //console.log(component);
                        autosize($('.autoResize'));
                    });
                });

            });
        </script>


    @stop

@extends('adminlte::page')


@section('title', 'Case Manage')

@section('content_header')


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Include the overlay-component.css stylesheet -->
    <link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

    <!-- Include the overlay-component.js script -->
    <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/media_library_styles.css') }}">

    <style>
       .timeline-body {
           padding:10px !important;
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

       .tree, .tree ul {
           margin:0;
           padding:0;
           list-style:none
       }
       .tree ul {
           margin-left:1em;
           position:relative
       }
       .tree ul ul {
           margin-left:.5em
       }
       .tree ul:before {
           content:"";
           display:block;
           width:0;
           position:absolute;
           top:0;
           bottom:0;
           left:0;
           border-left:1px solid
       }
       .tree li {
           margin:0;
           padding:0 1em;
           line-height:2em;
           color:#369;
           font-weight:700;
           position:relative
       }
       .tree ul li:before {
           content:"";
           display:block;
           width:10px;
           height:0;
           border-top:1px solid;
           margin-top:-1px;
           position:absolute;
           top:1em;
           left:0
       }
       .tree ul li:last-child:before {
           background:#fff;
           height:auto;
           top:1em;
           bottom:0
       }
       .indicator {
           margin-right:5px;
       }
       .tree li a {
           text-decoration: none;
           color:#369;
       }
       .tree li button, .tree li button:active, .tree li button:focus {
           text-decoration: none;
           color:#369;
           border:none;
           background:transparent;
           margin:0px 0px 0px 0px;
           padding:0px 0px 0px 0px;
           outline: 0;
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

                              @if ($child->getMedia('Child_Profile')->first())
                                    <img class="mr-1 "
                                         {{--                                     src="/img/ws_icon.jpg"--}} height="250px"
                                         src="{{ $child->getMedia('Child_Profile')->first()->getUrl()}}"
                                         alt="User profile picture">

                                @else
                                <img class="mr-1 "
                                     {{--                                     src="/img/ws_icon.jpg"--}} width="250px" height="200px"
                                     src="/img/child_avatar.jpg"
                                     alt="User profile picture">
                                  @endif
                            </div>

                            @livewire('child.child-status-management',[$child, auth()->user()->user_type != '10.0'])

                            <p class="text-muted text-center">
                                <script>
                                    $childID = {{$child->id}};
                                </script>
                                @livewire('dashboard-elements.text.case-manage.get-child-foster-home',['child' => $child])
                            </p>

                            <table class="table table-hover table-striped table-bordered text-sm">

                                <tr>
                                    <th scope="row">Case Manager</th>
                                    <td>
                                        @if ($child->getCaseManageAssignedHome && $child->getCaseManageAssignedHome->getCaseManageAssignedHomeCaseManager)
                                            <a href="/users/{{$child->getCaseManageAssignedHome->getCaseManageAssignedHomeCaseManager->id}}">{{$child->getCaseManageAssignedHome->getCaseManageAssignedHomeCaseManager->name}}</a>
                                        @else
                                            N/A
                                        @endif
                                        <br/>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        <b><a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.manage-c-a-s-agency-modal', {'childID':$childID}, {'size':'md'})" class="mt-2">CAS Agency</a></b>
                                    </th>
                                    <td>@if ($child->getCASAgency)<a href="/placingAgency/{{$child->getCASAgency->id}}">{{$child->getCASAgency->name}}</a>@else TBD @endif</td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        <b><a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.manage-c-a-s-worker-modal', {'childID':$childID}, {'size':'md'})" class="mt-2">CAS Worker</a></b>
                                    </th>
                                    <td>@if ($child->getCASAgencyWorker){{$child->getCASAgencyWorker->name}}@else TBD @endif</td>
                                </tr>

                                <tr>
                                    <th scope="row">CAS Worker Email</th>
                                    <td>@if ($child->getCASAgencyWorker){{$child->getCASAgencyWorker->email}}@else TBD @endif</td>
                                </tr>

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

                                <li class="nav-item"><a class="nav-link" href="#activity2" data-toggle="tab">Lifebook</a>
                                </li>

                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                </li>
{{--                                <li class="nav-item"><a class="nav-link" href="#documents" data-toggle="tab">Documents</a>--}}
{{--                                </li>--}}

                                <li class="nav-item"><a class="nav-link" href="#placement_history" data-toggle="tab">Placement History</a>
                                </li>

{{--                                <li class="nav-item"><a class="nav-link" href="#financials" data-toggle="tab">Financials</a>--}}
{{--                                </li>--}}

{{--                                <li class="nav-item"><a class="nav-link" href="#drive_history" data-toggle="tab">Drive History</a>--}}
{{--                                </li>--}}

{{--                                <li class="nav-item"><a class="nav-link" href="#POCs" data-toggle="tab">Plan of Cares</a>--}}
{{--                                </li>--}}

{{--                                <li class="nav-item"><a class="nav-link" href="#SOs_IRs" data-toggle="tab">SO's / IR's</a>--}}
{{--                                </li>--}}

                                <li class="nav-item"><a class="nav-link" href="#admission_forms" data-toggle="tab">Admission Forms</a>
                                </li>

                                <li class="nav-item"><a class="nav-link" href="#safety_forms" data-toggle="tab">Safety Forms</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="profile">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            @livewire('c-m-child-profile', ['childID' => $child->id])
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>

{{--                                <div class="tab-pane" id="documents">--}}
{{--                                    @livewire('child-documents', ['child' => $child])--}}
{{--                                </div>--}}

                                <div class="tab-pane" id="placement_history">
                                    Action Buttons:
                                    {{--                                    <button>Add Permanent Entry</button>--}}
                                    {{--                                    <button>Add Relief Entry</button>--}}
                                    {{--                                    <button>Discharge Child</button>--}}
                                    {{--                                    <button>Re-Admit</button>--}}

                                    <a href="javascript:window.livewire.emit('modal.open', 'placements.placement-form-modal', { 'childId':'{{$child->id}}', 'placementType': '{{\App\Models\Placements::TYPE__PERMANENT}}'}, {'size':'md'})" class="mb-2 btn btn-sm btn-primary">Add Permanent Entry</a>
                                    &nbsp;
                                    <a href="javascript:window.livewire.emit('modal.open', 'placements.placement-form-modal', { 'childId':'{{$child->id}}', 'placementType': '{{\App\Models\Placements::TYPE__RELIEF}}' }, {'size':'md'})" class="mb-2 btn btn-sm btn-primary">Add Relief Entry</a>

                                    @livewire('placements.placements', ['child' => $child])
                                </div>

{{--                                <div class="tab-pane" id="financials">--}}
{{--                                    <div class="row">--}}
{{--                                        <h5 class="mt-1 text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Rates</h5>--}}

{{--                                        <div class="col-2">--}}
{{--                                            <label for="" class="text-sm">Per Diem Rate</label>--}}
{{--                                            <input readonly type="text" class="form-control"--}}
{{--                                                   value="{{$child->getCASAgency->per_diem_rate ?? ""}}">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-2">--}}
{{--                                            <label for="" class="text-sm">ISA/PFA Rate</label>--}}
{{--                                            <input  readonly type="text" class="form-control"--}}
{{--                                                    value="{{$child->getCASAgency->ISA_PFA_Rate ?? ""}}" >--}}
{{--                                        </div>--}}
{{--                                        <div class="col-2">--}}
{{--                                            <label for="" class="text-sm">Outside Resp. Rate</label>--}}
{{--                                            <input  readonly type="text" class="form-control"--}}
{{--                                                    value="{{$child->getCASAgency->outside_respite_rate ?? ""}}" >--}}
{{--                                        </div>--}}
{{--                                        <div class="col-2">--}}
{{--                                            <label for="" class="text-sm">Holding Rate</label>--}}
{{--                                            <input readonly type="text" class="form-control"--}}
{{--                                                   value="{{$child->getCASAgency->holding_rate ?? ""}}" >--}}
{{--                                        </div>--}}
{{--                                        <div class="col-2">--}}
{{--                                            <label for="" class="text-sm">Mileage Rate</label>--}}
{{--                                            <input readonly type="text" class="form-control"--}}
{{--                                                    value="{{$child->getCASAgency->mileage_rate ?? ""}}" >--}}
{{--                                        </div>--}}
{{--                                        <div class="col-2">--}}
{{--                                            <label for="" class="text-sm">Mileage Terms</label>--}}
{{--                                            <input  readonly type="text" class="form-control"--}}
{{--                                                    value="{{$child->getCASAgency->mileage_terms ?? ""}}" >--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="tab-pane" id="activity2">
                                    @livewire('custom-comments.comments-component', ['model' => $child, 'newestFirst' => true])

                                    <script>
                                        window.addEventListener('new_image_filename', event => {
                                            $("#previewImage").html("Image Preview: <img src='/storage/" + event.detail.filename.substring(7) + "' width='400px' />");
                                            //alert('New image: ' + event.detail.filename.substring(7));
                                            console.log (event);
                                            //$("#summernote111").summernote('code', "Image: <br />  src='/storage/" + event.detail.filename.substring(7) + "' style='width:400px'  />");
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
                                    {{--@livewire('activity-wall', ['user' => $user, 'child' => $child])--}}
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="timeline">
                                    <script>
                                        $(document).ready(function(){


                                            $.fn.extend({
                                                treed: function (o) {

                                                    var openedClass = 'fa-solid fa-folder-open';
                                                    var closedClass = 'fa-solid fa-folder-closed';

                                                    if (typeof o != 'undefined'){
                                                        if (typeof o.openedClass != 'undefined'){
                                                            openedClass = o.openedClass;
                                                        }
                                                        if (typeof o.closedClass != 'undefined'){
                                                            closedClass = o.closedClass;
                                                        }
                                                    };

                                                    //initialize each of the top levels
                                                    var tree = $(this);
                                                    tree.addClass("tree");
                                                    tree.find('li').has("ul").each(function () {
                                                        var branch = $(this); //li with children ul
                                                        branch.prepend("<i class='pr-1 " + closedClass + "'> </i>");
                                                        branch.addClass('branch');
                                                        branch.on('click', function (e) {
                                                            if (this == e.target) {
                                                                var icon = $(this).children('i:first');
                                                                icon.toggleClass(openedClass + " " + closedClass);
                                                                $(this).children().children().toggle();
                                                            }
                                                        })
                                                        branch.children().children().toggle();
                                                    });

                                                    //fire event from the dynamically added icon
                                                    tree.find('.branch .indicator').each(function(){
                                                        $(this).on('click', function () {
                                                            $(this).closest('li').click();
                                                        });
                                                    });

                                                    //fire event to open branch if the li contains an anchor instead of text
                                                    tree.find('.branch>a').each(function () {
                                                        $(this).on('click', function (e) {
                                                            $(this).closest('li').click();
                                                                e.preventDefault();
                                                        });
                                                    });

                                                    //fire event to open branch if the li contains a button instead of text
                                                    tree.find('.branch>button').each(function () {
                                                        $(this).on('click', function (e) {
                                                            $(this).closest('li').click();
                                                                e.preventDefault();
                                                        });
                                                    });
                                                }
                                            });

                                            //Initialization of treeviews
                                            $('#tree2').treed({openedClass:'fa-solid fa-folder-open', closedClass:'fa-solid fa-folder-closed'});

                                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                            $.ajax({
                                                /* the route pointing to the post function */
                                                url: "{{route('child.getTimelineData')}}",
                                                type: 'GET',
                                                /* send the csrf-token and the input to the controller */
                                                data: {_token: CSRF_TOKEN, page:1, childID:{{$child->id}}},
                                                //dataType: 'JSON',
                                                /* remind that 'data' is the response of the AjaxController */
                                                success: function (data) {
                                                    $('#timeline').html(data);
                                                }
                                            });
                                        });

                                    </script>
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


                                <div class="tab-pane" id="ADMIN">
                                    <script>
                                        var activeTab = window.localStorage.getItem('activeTab');
                                        // alert (activeTab);
                                    </script>
                                    {{--
                                    @if (Auth()->user()->id == "1" || Auth()->user()->id == "2")
                                         @livewire('child-admin', ['user' => $user, 'child' => $child ])
                                    @endif
                                    --}}
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="admission_forms">

                                    <div class="container-fluid">
                                        <!-- Small boxes (Stat box) -->
                                        <div class="row">

                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-gradient-olive">
                                                    <div class="inner">
                                                        <span class="small">AGREEMENT AND AUTHORIZATION TO PROVIDE SERVICES TO A CHILD IN A CHILDREN’S RESIDENCE</span>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="fas fa-door-open"></i>
                                                    </div><br/>
                                                    <a href="/TestFormBuilder/5/{{ $child->getOrCreateFormId('agreement_and_authorization_form_id') }}/?back-text=Child {{$child->initials}}" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-gradient-olive">
                                                    <div class="inner">
                                                        <span class="small">APPROVAL TO ADMINISTER ALL MEDICATION INCLUDING PSYCHOTROPIC, PRESCRIPTION AND OVER THE COUNTER MEDICATION</span>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="fas fa-door-open"></i>
                                                    </div><br/>
                                                    <a href="/TestFormBuilder/7/{{ $child->getOrCreateFormId('approval_to_administer_all_medication_form_id') }}/?back-text=Child {{$child->initials}}" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-gradient-olive">
                                                    <div class="inner">
                                                        <span class="small">AUTHORIZATION FOR SUPERVISED ACTIVITIES</span>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="fas fa-door-open"></i>
                                                    </div><br/>
                                                    <a href="/TestFormBuilder/6/{{ $child->getOrCreateFormId('authorization_for_supervised_activities_form_id') }}/?back-text=Child {{$child->initials}}" class="small-box-footer"><i class="fas fa-plus-circle"></i> View Form</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--                                    <div style="margin: 1em;">--}}
{{--                                        @livewire('forms.case-manage.temp.pre-admissions', [$child->preAdmissionForm->id])--}}
{{--                                    </div>--}}
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="safety_forms">
                                    <div style="margin: 1em;">
                                        @livewire('safety-plan-table', [$child->id])
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

        <script>
            $(function () {

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

                $('a[data-toggle="tab"]').on('click', function (e) {
                    var activeTab = window.localStorage.getItem('activeTab');

                    window.localStorage.setItem('activeTab', $(e.target).attr('href'));
                });
                var activeTab = window.localStorage.getItem('activeTab');
                if (activeTab) {
                    $('#myTab a[href="' + activeTab + '"]').tab('show');
                    window.localStorage.removeItem("activeTab");
                }

            })

            function viewIR($id) {
                $('#myTab a[href="#incidents"]').tab('show');
                var $text = $id;
                var WithOutBrackets = $text.toString().replace(/[\[\]']+/g, '');

                Livewire.emit('view', WithOutBrackets);
            }

            function addActivityMessage($childID) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
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
                        url: "{{route('myshifts.edit')}}",
                        data: {
                            type: 'AddMessage',
                            UserID: {{Auth::id()}},
                            ChildID: $childID,
                            message: document.getElementById('inputAddMessage').value,

                        },
                        success: function (data) {
                            //  alert(data.success + "|" + data.message);
                            Toast.fire({
                                    type: 'success',
                                    //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                                    title: 'We-Schedule.ca | Activity Entry has been added successfully.',
                                    //icon: 'success',
                                    //timerProgressBar: true,
                                },
                                function () {
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

            $(document).ready(function(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $("#customSwitch1").on('change',function(){
                    //console.log('change event {{ Auth::User()->get_user_type->name }}',$(this).is(':checked'));
                    $.ajax({
                    /* the route pointing to the post function */
                        url: "{{route('child.updateChildStatus', Auth::id() )}}",
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: {_token: CSRF_TOKEN, active:$(this).is(':checked'),child:{{$child->id}}},
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) {
                            console.log(data);
                        }
                    });
                });

                $('[data-toggle="popover-click-toggleProgram"]').popover({
                    html: true,
                    trigger: 'click',
                    placement: 'right',
                    content: function () { return $('#popover-content-wrapper-toggleProgram').html(); }
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
                        }
                    )
                }


                $('#commentBox').on('input', (e) => {
                    // your code here
                    console.log (e.target.innerHTML)
                    Livewire.emit('UpdateText',e.target.innerHTML);
                    Livewire.emit('UpdateReplyText',e.target.innerHTML);

                });
            });
        </script>

@stop

@extends('adminlte::page')


@section('title', 'We-Schedule')


@section('content_header')

    @unless(Auth::check())
        You are not signed in.
    @endunless


@stop
@section('content')

    {{-- ddd($myshift_activities_photos) --}}
    {{-- ddd($myshift_activities) --}}

    {{-- ddd($myshift->get_user->name) --}}


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>View Shift</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/myshifts">My Shifts</a></li>
                <li class="breadcrumb-item active">View Shift</li>
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
                                <img class="profile-user-img img-fluid img-circle" src="/img/ws_icon.jpg"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $myshift->title }}</h3>
                            <h3 class="profile-username text-center text-sm">{{ $myshift->get_user->name }}</h3>

                            <p class="text-muted text-center text-xs">{{ $myshift->get_child->get_home->name }}</p>

                            Shift Details
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Date</b> <a class="float-right">{{ Str::before($myshift->start, ' ') }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Start Time</b> <a class="float-right">{{ Str::after($myshift->start, ' ') }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>End Time</b> <a class="float-right">{{ Str::after($myshift->end, ' ') }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Scheduled Hours</b> <a class="float-right">{{ $myshift->calculateShiftHours() }}</a>
                                </li>

                                @if ($myshift->status == 'Pending' && $myshift->actual_start_time)
                                    {{-- //start time exists, so the user is signed in --}}
                                    <li class="list-group-item">
                                        <b>Time Elapsed</b> <a
                                            class="float-right">{{ $myshift->calculateActiveShiftHours() }}</a>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <b>Time Worked</b> <a
                                            class="float-right">{{ $myshift->calculateActualShiftHours() }}</a>
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">{{ $myshift->status }}</a>
                                </li>
                            </ul>


                            @if ($myshift->status == 'Pending' && !$myshift->actual_shift_start)
                                {{-- //start time exists, so the user is signed in --}}
                                <a href="#" class="btn btn-primary btn-block"
                                    onclick=startShift("{{ $myshift->id }}")><b>Start Shift</b></a>
                            @endif

                            @if ($myshift->status == 'Started' && $myshift->actual_shift_start)
                                {{-- //start time exists, so the user is signed in --}}
                                <a href="#" class="btn btn-primary btn-block"
                                    onclick=stopShift("{{ $myshift->id }}")><b>End Shift</b></a>
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

                            <ul class="nav nav-pills" id="myTab">
                                <li class="nav-item"><a class="nav-link active" href="#activity"
                                        data-toggle="tab">Activity</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#shiftform"
                                        onclick="//getShiftForm({{ $myshift->id }})" data-toggle="tab">Shift Form</a></li>
                                <li class="nav-item"><a class="nav-link" href="#medication" data-toggle="tab">Medication</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#incidents" data-toggle="tab">Incidents</a>
                                </li>


                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane active" id="activity">
                                    <!-- Post -->
                                    <style>
                                        input[type="file"] {
                                            display: none;
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
                                    </style>
                                    <form id="ActivityAddMessageORImage" class="form-horizontal" method="post">
                                        {{ csrf_field() }}

                                        <div id="files_list"></div>
                                        <p id="loading"></p>
                                        <input type="hidden" name="file_ids" id="file_ids" value="">
                                        <input type="submit" value="Upload" hidden>

                                        <div class="input-group input-group-sm mb-0">
                                            <input style="margin-bottom: 5px;" class="form-control form-control-sm"
                                                id="inputAddMessage" placeholder="Add New Message"><br />

                                            <div class="input-group">
                                                <label for="button" class="custom-send"
                                                    onclick="addActivityMessage('{{ $myshift->get_child->id }}')">Post
                                                    Message</label>
                                                <button hidden type="button" class="btn btn-danger"
                                                    onclick="addActivityMessage('{{ $myshift->get_child->id }}')">Send</button>
                                                &nbsp;&nbsp; <label for="fileupload" class="custom-file-upload">
                                                    Add Photos
                                                </label>

                                                <input type="file" name="photos[]" id="fileupload"
                                                    data-url="{{ route('myshifts.edit') }}" multiple=""
                                                    class="form-control">

                                            </div>
                                        </div>
                                    </form>
                                    <hr /><br />

                                    @comments(['model' => $myshift->get_child])

                                    @if ($myshift_activities->count() >= 999)
                                        {{-- @if ($myshift->get_child->get_activities->count() >= 0)
                                        @foreach ($myshift->get_child->get_activities->reverse() as $activity) --}}
                                        @foreach ($myshift_activities as $activity)
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="/img/ws_icon.jpg"
                                                        alt="user image">
                                                    <span class="username">
                                                        <a href="#">{{ $activity->get_user->name }}</a>
                                                        <a href="#" class="float-right btn-tool"><i
                                                                class="fas fa-times"></i></a>
                                                    </span>
                                                    <span class="description">Posted
                                                        {{ $activity->getPostTimeRelative() }}</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>

                                                    @if (str_starts_with($activity->message, '[!photo!]:'))
                                                        <div class="col-md-8"><a
                                                                href="/storage/activities_photos/{{ substr($activity->message, 35) }}"><img
                                                                    width="50%"
                                                                    src="/storage/activities_photos/{{ substr($activity->message, 35) }}" /></a>
                                                        </div>
                                                    @else
                                                        {{ $activity->message }}
                                                    @endif
                                                </p>

                                            </div>
                                        @endforeach
                                    @endif

                                    <br />
                                    <!-- /.post -->
                                    <div class="d-flex justify-content-center">
                                        {-- !! $myshift_activities->links() !! --}
                                    </div>
                                </div>
                                <!-- /.post -->

                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-danger">
                                                01 Dec. 2021
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-envelope bg-primary"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 08:35</span>

                                                <h3 class="timeline-header"><a href="#">We-Schedule.ca
                                                        Management</a> generated a new shift for
                                                    {{ $myshift->get_user->name }}</h3>

                                                <div class="timeline-body">
                                                    Start Time: {{ $myshift->start }}<br />
                                                    End Time: {{ $myshift->end }}
                                                </div>
                                                <div class="timeline-footer">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->

                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-success">
                                                14 Dec. 2021
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-user bg-info"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 9:05 AM</span>

                                                <h3 class="timeline-header border-0"><a
                                                        href="#">{{ $myshift->get_user->name }}</a> started their
                                                    shift.
                                                </h3>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-comments bg-warning"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                                <h3 class="timeline-header"><a
                                                        href="#">{{ $myshift->get_user->name }}</a> posted a
                                                    comment.</h3>

                                                <div class="timeline-body">
                                                    {{-- $myshift_activities[0]->message --}}
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-warning btn-flat btn-sm">View
                                                        comment</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->

                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-camera bg-purple"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 10 mins ago</span>

                                                <h3 class="timeline-header"><a
                                                        href="#">{{ $myshift->get_user->name }}</a> uploaded new
                                                    attachments</h3>

                                                <div class="timeline-body">
                                                    <img src="/img/science.jpg" width="30%" alt="...">
                                                    <img src="/img/science1.jpg" width="30%" alt="...">

                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <!-- /.tab-pane for Shift Form -->
                                <div class="tab-pane" id="shiftform">

                                    <section class="content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">CYC Daily Report</h3>

                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"></button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="inputDescription">Date/Time</label>
                                                            <input type="text" id="inputDateTime"
                                                                class="form-control "
                                                                value="{{ old('datetime') ?? ($myshift->get_shiftform->datetime ?? date('Y-m-d H:i:s')) }}">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputMood">Mood Upon Arrival</label>
                                                            <textarea id="inputMood" class="form-control" rows="4">{{ old('mood_upon_arrival') ?? ($myshift->get_shiftform->mood_upon_arrival ?? '') }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputInteraction">Interaction with Staff</label>
                                                            <textarea id="inputInteraction" class="form-control" rows="4">{{ old('interaction_with_staff') ?? ($myshift->get_shiftform->interaction_with_staff ?? '') }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputGeneral">General Observations</label>
                                                            <textarea id="inputGeneral" class="form-control" rows="4">{{ old('general_observations') ?? ($myshift->get_shiftform->general_observations ?? '') }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputDietary">Dietary Notes</label>
                                                            <textarea id="inputDietary" class="form-control" rows="4">{{ old('dietary_notes') ?? ($myshift->get_shiftform->dietary_notes ?? '') }}</textarea>
                                                        </div>

                                                        <div class="card card-primary collapsed-card">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Photos</h3>
                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse"><i
                                                                            class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group" id="medication_form_entry"
                                                                    name="medication_form_entry" style="">
                                                                    <style>
                                                                        input[type="file"] {
                                                                            display: none;
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
                                                                    </style>
                                                                    <form id="ActivityAddMessageORImage"
                                                                        class="form-horizontal" method="post">
                                                                        {{ csrf_field() }}

                                                                        <div id="files_list"></div>
                                                                        <p id="loading"></p>
                                                                        <input type="hidden" name="file_ids"
                                                                            id="file_ids" value="">
                                                                        <input type="submit" value="Upload" hidden>

                                                                        <div class="input-group input-group-sm mb-0">

                                                                            <div class="input-group">
                                                                                <button hidden type="button"
                                                                                    class="btn btn-danger"
                                                                                    onclick="addActivityMessage('{{ $myshift->get_child->id }}')">Send</button>
                                                                                &nbsp;&nbsp; <label
                                                                                    for="fileupload_shiftform"
                                                                                    class="custom-file-upload">
                                                                                    Add Photos
                                                                                </label>

                                                                                <input type="file" name="photos[]"
                                                                                    id="fileupload_shiftform"
                                                                                    data-url="#" multiple=""
                                                                                    class="form-control">


                                                                            </div>
                                                                        </div>
                                                                    </form> <br />
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->

                                                <!-- /.card -->
                                                @if ($myshift->get_shiftform)
                                                    <center>Last Updated: {{ $myshift->get_shiftform->updated_at }}
                                                    </center>
                                                @else
                                                    <center>*No previous entries found</center>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="#" class="btn btn-secondary">Cancel</a>
                                                <input type="button" value="Save Changes"
                                                    class="btn btn-success float-right"
                                                    onclick="updateShiftForm('{{ $myshift->id }}')">
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <!-- end of tab-pane for Shift Form -->
                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputName"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience"
                                                class="col-sm-2 col-form-label">Experience</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputSkills"
                                                    placeholder="Skills">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms and
                                                            conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="medication">
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Medication Entries</h3>

                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"></button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">


                                                        {{-- $myshift->get_medicationentries --}}
                                                        @if ($myshift->get_medicationentries->Count() > 0)

                                                            <div class="table-responsive">
                                                                <table
                                                                    class="table table-striped table-bordered dt-responsive nowrap"
                                                                    id="tbl_medicationentries"
                                                                    name="tbl_medicationentries" style="width:100%">

                                                                    <!-- Table Headings -->
                                                                    <thead>
                                                                        <th>Medication</th>
                                                                        <th>Dosage</th>
                                                                        <th>Time to be Administered</th>
                                                                        <th>Time Administered</th>
                                                                        <th>&nbsp;</th>
                                                                    </thead>

                                                                    <!-- Table Body -->
                                                                    <tbody>

                                                                        @foreach ($myshift->get_medicationentries as $entry)
                                                                            <tr>
                                                                                <!-- Task Name -->
                                                                                <td class="table-text">
                                                                                    <div>{{ $entry->medication }}</div>
                                                                                </td>
                                                                                <td class="table-text">
                                                                                    <div>{{ $entry->dosage }}</div>
                                                                                </td>

                                                                                <td class="table-text">
                                                                                    <div>
                                                                                        {{ $entry->time_to_be_administered }}
                                                                                    </div>
                                                                                </td>
                                                                                <td class="table-text">
                                                                                    <div>{{ $entry->time_administered }}
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <button
                                                                                        onclick="delMedicationEntry('{{ $entry->id }}',{{ $loop->index }})">Delete</button>
                                                                                    <!-- TODO: Delete Button -->
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <script>
                                                                function detailFormatter(index, row) {
                                                                    var html = []
                                                                    $.each(row, function(key, value) {
                                                                        html.push('<p><b>' + key + ':</b> ' + value + '</p>')
                                                                    })
                                                                    return html.join('')
                                                                }
                                                            </script>
                                                        @else
                                                            No medication entries found.<br />
                                                            <hr>
                                                        @endif
                                                        <!-- Add Task Button
                                                                               <div class="form-group">
                                                                                   <div class="col-sm-offset-3 col-sm-6">
                                                                                       <button type="button" class="btn btn-default">
                                                                                           <i class="fa fa-plus"></i> Add Entry
                                                                                       </button>
                                                                                   </div>
                                                                               </div>
                                                                               -->
                                                        <br />

                                                        <div class="card card-primary collapsed-card">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Add New Medication Entry</h3>
                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse"><i
                                                                            class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group" id="medication_form_entry"
                                                                    name="medication_form_entry" style="">
                                                                    <div class="form-group">
                                                                        <label for="inputMedication">Medication</label>
                                                                        <input type="text" id="inputMedication"
                                                                            class="form-control" value="Tylenol - Child"
                                                                            step="1">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputDosage">Dosage</label>
                                                                        <input type="text" id="inputDosage"
                                                                            class="form-control" value="10ml"
                                                                            step="1">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputTimetobeAdministered">Time to be
                                                                            Administered</label>
                                                                        <input type="text"
                                                                            id="inputTimeToBeAdministered"
                                                                            class="form-control timepicker" />

                                                                        <label for="inputTimeAdministered">Time
                                                                            Administered</label>
                                                                        <input type="text" id="inputTimeAdministered"
                                                                            class="form-control timepicker">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="button" id="inputSubmitEntry"
                                                                            class="form-control" value="Add This Entry"
                                                                            onclick="addMedicationEntry('{{ $myshift->id }}')">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                            <br />

                                                            <div class="card card-primary collapsed-card">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">Photos</h3>
                                                                    <div class="card-tools">
                                                                        <button type="button" class="btn btn-tool"
                                                                            data-card-widget="collapse"><i
                                                                                class="fas fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="form-group" id="medication_form_entry"
                                                                        name="medication_form_entry" style="">
                                                                        <style>
                                                                            input[type="file"] {
                                                                                display: none;
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
                                                                        </style>
                                                                        <form id="ActivityAddMessageORImage"
                                                                            class="form-horizontal" method="post">
                                                                            {{ csrf_field() }}

                                                                            <div id="files_list"></div>
                                                                            <p id="loading"></p>
                                                                            <input type="hidden" name="file_ids"
                                                                                id="file_ids" value="">
                                                                            <input type="submit" value="Upload" hidden>

                                                                            <div class="input-group input-group-sm mb-0">

                                                                                <div class="input-group">
                                                                                    <button hidden type="button"
                                                                                        class="btn btn-danger"
                                                                                        onclick="addActivityMessage('{{ $myshift->get_child->id }}')">Send</button>
                                                                                    &nbsp;&nbsp; <label
                                                                                        for="fileupload_shiftform"
                                                                                        class="custom-file-upload">
                                                                                        Add Photos
                                                                                    </label>

                                                                                    <input type="file" name="photos[]"
                                                                                        id="fileupload_shiftform"
                                                                                        data-url="#" multiple=""
                                                                                        class="form-control">


                                                                                </div>
                                                                            </div>
                                                                        </form> <br />
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <!-- /.card -->
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                    </section>
                                </div>
                                <div class="tab-pane" id="incidents">

                                    <section class="content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Incident Entries</h3>

                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"></button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        {{-- $myshift->get_medicationentries --}}
                                                        @if ($myshift->get_incidententries->Count() > 0)
                                                            <div class="table-responsive">

                                                                <table
                                                                    class="table table-striped table-bordered dt-responsive nowrap"
                                                                    id="tbl_incidententries" name="tbl_incidententries"
                                                                    style="width:100%">

                                                                    <!-- Table Headings -->
                                                                    <thead>
                                                                        <th>Type</th>
                                                                        <th>Date/Time</th>
                                                                        <th>Location</th>
                                                                        <th>Description</th>
                                                                        <th>&nbsp;</th>
                                                                    </thead>

                                                                    <!-- Table Body -->
                                                                    <tbody>

                                                                        @foreach ($myshift->get_incidententries as $entry)
                                                                            <tr>
                                                                                <!-- Task Name -->
                                                                                <td class="table-text">
                                                                                    <div><a
                                                                                            href="viewIncident('{{ $entry->id }}')">{{ $entry->incident_type }}</a>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="table-text">
                                                                                    <div>{{ $entry->date_of_incident }}
                                                                                    </div>
                                                                                </td>

                                                                                <td class="table-text">
                                                                                    <div>{{ $entry->location }}</div>
                                                                                </td>
                                                                                <td class="table-text">
                                                                                    <div>
                                                                                        {{ $entry->description_of_incident }}
                                                                                    </div>
                                                                                </td>

                                                                            </tr>
                                                                        @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            No incident entries found.<br />
                                                            <hr>
                                                        @endif
                                                        <!-- Add Task Button
                                                                               <div class="form-group">
                                                                                   <div class="col-sm-offset-3 col-sm-6">
                                                                                       <button type="button" class="btn btn-default">
                                                                                           <i class="fa fa-plus"></i> Add Entry
                                                                                       </button>
                                                                                   </div>
                                                                               </div>
                                                                               -->

                                                        <br />

                                                        <div class="card card-primary collapsed-card">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Add New Incident Entry</h3>
                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse"><i
                                                                            class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="card-body">

                                                                <div class="form-group" id="medication_form_entry"
                                                                    name="medication_form_entry" style="">
                                                                    <div class="form-group">
                                                                        <label for="inputNameOfChild">Name of Child</label>
                                                                        <input type="inputNameOfChild"
                                                                            class="form-control" id="inputNameOfChild"
                                                                            readonly
                                                                            value="{{ $myshift->get_child->initials }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputDOB">Date of Birth</label>
                                                                        <input type="inputDOB" class="form-control"
                                                                            id="inputDOB" readonly
                                                                            value="{{ $myshift->get_child->DOB }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputDateofPlacement">Date of
                                                                            Placement</label>
                                                                        <input type="inputDateofPlacement"
                                                                            class="form-control" id="inputDateofPlacement"
                                                                            readonly
                                                                            value="{{ Str::before($myshift->start, ' ') }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputFosterHome">Foster Home</label>
                                                                        <input type="inputFosterHome" class="form-control"
                                                                            id="inputFosterHome">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputPlacingAgency">Placing
                                                                            Agency</label>
                                                                        <input type="inputPlacingAgency"
                                                                            class="form-control" id="inputPlacingAgency">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputLegalGuardian">Legal Guardian's
                                                                            Name</label>
                                                                        <input type="inputLegalGuardian"
                                                                            class="form-control" id="inputLegalGuardian">
                                                                    </div>



                                                                    <div class="form-group">
                                                                        <span style="color:red;">NOTIFY / REPORT WITHIN 24
                                                                            HOURS / S.O. AS SOON AS POSSIBLE</span>
                                                                        <br /><b>*Carpe Diem must submit Serious Occurrence
                                                                            Reports to Ministry within 24 hours</b>

                                                                        <label for="inputIncidentType">Incident</label>
                                                                        <select id="inputIncidentType"
                                                                            class="form-control">
                                                                            <option value="Serious Occurence">-Serious
                                                                                Occurence-</option>
                                                                            <option value="Level 1 Serious Occurence">
                                                                                -Level 1 Serious Occurence-</option>
                                                                            <option selected value="Injury">Injury</option>
                                                                            <option value="Property Damage / Destruction">
                                                                                Property Damage / Destruction</option>
                                                                            <option value="Disclosure">Disclosure</option>
                                                                            <option value="Alcohol / Drug Use">Alcohol /
                                                                                Drug Use</option>
                                                                            <option value="Sexualized Behaviour">Sexualized
                                                                                Behaviour</option>
                                                                            <option value="Lying">Lying</option>
                                                                            <option
                                                                                value="School Issues (Concern, Suspension)">
                                                                                School Issues (Concern, Suspension)</option>
                                                                            <option value="Food Issues (hoarding)">Food
                                                                                Issues (hoarding)</option>
                                                                            <option
                                                                                value="Aggression / Defiance / Tantrums">
                                                                                Aggression / Definance / Tantrums</option>
                                                                            <option value="Medication Error">Medication
                                                                                Error</option>
                                                                            <option value="Stealing">Stealing</option>
                                                                            <option value="Fire Setting">Fire Setting
                                                                            </option>
                                                                            <option
                                                                                value="Issues Relating to Visits or Family Contact">
                                                                                Issues Relating to Visits or Family Contact
                                                                            </option>
                                                                            <option
                                                                                value="Suicidal Thoughts or Attempts / Self-Harm">
                                                                                Suicidal Thoughts or Attempts / Self-Harm
                                                                            </option>
                                                                            <option value="Other">Other</option>


                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputSeriousOccurence">Serious
                                                                            Occurence</label>
                                                                        <select id="inputSeriousOccurence"
                                                                            class="form-control">
                                                                            <option value="Death">Death</option>
                                                                            <option value="Serious Injury">Serious Injury
                                                                            </option>
                                                                            <option selected value="Serious Illness">
                                                                                Serious Illness</option>
                                                                            <option value="Serious Individual Action">
                                                                                Serious Individual Action</option>
                                                                            <option value="Restrictive Intervention">
                                                                                Restriction Intervention</option>
                                                                            <option value="Abuse or Mistreatment">Abuse or
                                                                                Mistreatment</option>
                                                                            <option value="Error or Omission">Error or
                                                                                Omission</option>
                                                                            <option value="Serious Complaint">Serious
                                                                                Complaint</option>



                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputLevel1SeriousOccurence">Level 1 -
                                                                            Serious Occurence</label>
                                                                        <select id="inputLevel1SeriousOccurence"
                                                                            class="form-control">
                                                                            <option value="Media Coverage">Media Coverage
                                                                            </option>
                                                                            <option value="Emeregency Services">Emergency
                                                                                Services used in response to a significant
                                                                                incident involving a client</option>

                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputDateofIncident">Date of
                                                                            Incident</label>
                                                                        <input type="inputDateofIncident"
                                                                            class="form-control" id="inputDateofIncident"
                                                                            value="{{ Str::before($myshift->start, ' ') }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="inputTimeDuration">Time/Duration</label>
                                                                        <input type="inputTimeDuration"
                                                                            class="form-control" id="inputTimeDuration">
                                                                    </div>

                                                                    <div class="form-group">

                                                                        <label for="inputDateTimeReportReceived">Date/Time
                                                                            Report Received</label>
                                                                        <input type="inputDateTimeReportReceived"
                                                                            class="form-control"
                                                                            id="inputDateTimeReportReceived"
                                                                            value="{{ Str::before($myshift->start, ' ') }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputLocationofIncident">Location of
                                                                            Incident</label>
                                                                        <textarea id="inputLocationofIncident" class="form-control" rows="4"></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputAntecedent">Antecedent leading to
                                                                            the Incident</label>
                                                                        <textarea id="inputAntecedent" class="form-control" rows="4"></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputDescription">Description of
                                                                            Incident (What, When, Where and How)</label>
                                                                        <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputActionTaken">Action Taken</label>
                                                                        <textarea id="inputActionTaken" class="form-control" rows="4"></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputWhoWasNotified">Who Was
                                                                            Notified</label><br />
                                                                        <input type="checkbox" checked
                                                                            name="inputWhoWasNotified[]"
                                                                            value="Carpe Diem Case Manager / Supervisor">
                                                                        Carpe Diem Case Manager / Supervisor<br>
                                                                        <input type="checkbox"
                                                                            name="inputWhoWasNotified[]"
                                                                            value="Carpe Diem On Call Worker"> Carpe Diem
                                                                        On Call Worker - (FOSTER PARENT – Call After Hours
                                                                        905-799-2947x8)<br>
                                                                        <input type="checkbox"
                                                                            name="inputWhoWasNotified[]"
                                                                            value="CAS Worker /After Hours Worker"> CAS
                                                                        Worker /After Hours Worker - (TO BE DONE BY CARPE
                                                                        DIEM ON CALL WORKER)<br>
                                                                        <input type="checkbox"
                                                                            name="inputWhoWasNotified[]" value=Other">
                                                                        Other<br>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputPhysicalInjuries">Physical
                                                                            Injuries (Include specific details of injury and
                                                                            medical intervention)</label>
                                                                        <textarea id="inputPhysicalInjuries" class="form-control" rows="4"></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputPropertyDamage">Property Damage
                                                                            (Attach Damage Form)</label>
                                                                        <textarea id="inputPropertyDamage" class="form-control" rows="4"></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="inputComments">Comments (Why)</label>
                                                                        <textarea id="inputComments" class="form-control" rows="4"></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="button" id="inputSubmitEntry"
                                                                            class="form-control" value="Add This Entry"
                                                                            onclick="AddIncidentEntry('{{ $myshift->id }}')">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                            <br />

                                                            <div class="card card-primary collapsed-card">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">Photos</h3>
                                                                    <div class="card-tools">
                                                                        <button type="button" class="btn btn-tool"
                                                                            data-card-widget="collapse"><i
                                                                                class="fas fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="form-group" id="medication_form_entry"
                                                                        name="medication_form_entry" style="">
                                                                        <style>
                                                                            input[type="file"] {
                                                                                display: none;
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
                                                                        </style>
                                                                        <form id="ActivityAddMessageORImage"
                                                                            class="form-horizontal" method="post">
                                                                            {{ csrf_field() }}

                                                                            <div id="files_list"></div>
                                                                            <p id="loading"></p>
                                                                            <input type="hidden" name="file_ids"
                                                                                id="file_ids" value="">
                                                                            <input type="submit" value="Upload" hidden>

                                                                            <div class="input-group input-group-sm mb-0">

                                                                                <div class="input-group">
                                                                                    <button hidden type="button"
                                                                                        class="btn btn-danger"
                                                                                        onclick="addActivityMessage('{{ $myshift->get_child->id }}')">Send</button>
                                                                                    &nbsp;&nbsp; <label
                                                                                        for="fileupload_shiftform"
                                                                                        class="custom-file-upload">
                                                                                        Add Photos
                                                                                    </label>

                                                                                    <input type="file" name="photos[]"
                                                                                        id="fileupload_shiftform"
                                                                                        data-url="#" multiple=""
                                                                                        class="form-control">


                                                                                </div>
                                                                            </div>
                                                                        </form> <br />
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                        </div>
                                                        <!-- /.card -->
                                                    </div>
                                                </div>
                                    </section>
                                </div>

                                <div class="tab-pane" id="files">
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title">File Entries</h3>

                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"></button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                    </section>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->

    </section>
    <!-- /.content -->
    </div>


    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });

            $('#tbl_medicationentries').DataTable();
            $('#tbl_incidententries').DataTable();

            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });


        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            //interval: 15,
            dynamic: true,
            dropdown: true,
            scrollbar: false
        });

        function startShift($id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('myshifts.edit') }}",
                data: {
                    type: 'StartShift',
                    id: $id
                },
                success: function(data) {
                    alert(data.success);
                    window.location.reload(true);

                }
            });
        }

        function stopShift($id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('myshifts.edit') }}",
                data: {
                    type: 'StopShift',
                    id: $id
                },
                success: function(data) {
                    alert(data.success);
                    window.location.reload(true);
                }
            });
        }

        function getShiftForm($id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            /* $.ajax({
                     type:'GET',
                     url:"{{ route('getShiftForm') }}",
                data:{
                    id: $id
                },
                success:function(data){
                    alert(data.success);
                }
            });
        */
        }

        function updateShiftForm($id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('myshifts.edit') }}",
                data: {
                    type: 'UpdateShiftForm',
                    id: $id,
                    datetime: document.getElementById(('inputDateTime')).value,
                    mood_upon_arrival: document.getElementById('inputMood').value,
                    interaction_with_staff: document.getElementById(('inputInteraction')).value,
                    general_observations: document.getElementById(('inputGeneral')).value,
                    dietary_notes: document.getElementById(('inputDietary')).value,



                },
                success: function(data) {
                    //  alert(data.success + "|" + data.message);
                    /*  $(document).Toasts('create', {
                          title: 'We-Schedule.ca',
                          body: 'Shift Form has been updated successfully. (' + data.success + "|" + data.message + ')',
                          position: 'topRight',
                          autohide: true,
                          delay: 5000,
                          fade: true

                      })
                      */
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });


                    Toast.fire({
                            type: 'success',
                            //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                            title: 'We-Schedule.ca | Shift Form updated successfully.',
                            //icon: 'success',
                            //timerProgressBar: true,
                        },
                        function() {
                            window.location.reload(true);
                        }

                    );
                }
            });

        }

        function addMedicationEntry($id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('myshifts.edit') }}",
                data: {
                    type: 'AddMedicationEntry',
                    id: $id,
                    medication: document.getElementById('inputMedication').value,
                    dosage: document.getElementById('inputDosage').value,
                    time_to_be_administered: document.getElementById('inputTimeToBeAdministered').value,
                    time_administered: document.getElementById('inputTimeAdministered').value
                },
                success: function(data) {
                    Toast.fire({
                            type: 'success',
                            //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                            title: 'We-Schedule.ca | Medication Entry added successfully.',
                            //icon: 'success',
                            //timerProgressBar: true,
                        },
                        function() {
                            window.location.reload(true);
                        }

                    );
                }
            });
        }

        function delMedicationEntry($id, $rowindex) {
            window.alert($rowindex);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('myshifts.edit') }}",
                data: {
                    type: 'DelMedicationEntry',
                    id: $id,

                },
                success: function(data) {
                    Toast.fire({
                            type: 'success',
                            //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                            title: 'We-Schedule.ca | Medication Entry deleted successfully.',
                            //icon: 'success',
                            //timerProgressBar: true,
                        },
                        function() {
                            window.location.reload(true);
                        }

                    );
                }

            });
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
                        UserID: {{ $myshift->get_user->id }},
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

        function AddIncidentEntry($id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            var arrayWhoWasNotified = []
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

            for (var i = 0; i < checkboxes.length; i++) {
                arrayWhoWasNotified.push(checkboxes[i].value)
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('myshifts.edit') }}",
                data: {
                    type: 'AddIncidentEntry',
                    id: $id,
                    child: document.getElementById('inputNameOfChild').value,
                    dob: document.getElementById('inputDOB').value,
                    date_of_placement: document.getElementById('inputDateofPlacement').value,
                    foster_home: document.getElementById('inputFosterHome').value,
                    placing_agency: document.getElementById('inputPlacingAgency').value,
                    legal_guardian: document.getElementById('inputLegalGuardian').value,
                    incident_type: document.getElementById('inputIncidentType').value,
                    serious_occurence: document.getElementById('inputSeriousOccurence').value,
                    level1_serious_occurence: document.getElementById('inputLevel1SeriousOccurence').value,
                    date_of_incident: document.getElementById('inputDateofIncident').value,
                    time_duration: document.getElementById('inputTimeDuration').value,
                    datetime_report_received: document.getElementById('inputDateTimeReportReceived').value,
                    location_of_incident: document.getElementById('inputLocationofIncident').value,
                    antecedent_leading_to_incident: document.getElementById('inputAntecedent').value,
                    description_of_incident: document.getElementById('inputDescription').value,
                    action_taken: document.getElementById('inputActionTaken').value,
                    who_was_notified: arrayWhoWasNotified,
                    physical_injuries: document.getElementById('inputPhysicalInjuries').value,
                    property_damage: document.getElementById('inputPropertyDamage').value,
                    comments: document.getElementById('inputComments').value

                },
                success: function(data) {
                    //  alert(data.success + "|" + data.message);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000
                    });

                    Toast.fire({
                        type: 'success',
                        //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                        title: 'We-Schedule.ca | Incident Entry added successfully.',
                        icon: 'success',
                        timerProgressBar: true,


                    })
                }
            });
        }




        var formData = $('ActivityAddMessageORImage').serializeArray();

        $('#fileupload').fileupload({
            dataType: 'json',
            formData: {
                type: 'AddPhoto',
                ChildID: '{{ $myshift->get_child->id }}',
                UserID: '{{ $myshift->get_user->id }}',
                _token: '{{ csrf_token() }}'
            },

            add: function(e, data) {
                $('#loading').text('Uploading...');

                data.submit();
            },
            done: function(e, data) {
                $.each(data.result.files, function(index, file) {
                    // $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                    if ($('#file_ids').val() != '') {
                        $('#file_ids').val($('#file_ids').val() + ',');
                    }
                    //   $('#file_ids').val($('#file_ids').val() + file.fileID);
                });
                // $('#loading').text('');

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });




                Toast.fire({
                    type: 'success',
                    //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                    title: 'We-Schedule.ca | Image Upload(s) has been added successfully.',
                    icon: 'success',
                    timerProgressBar: true,


                })
            }
        });
    </script>


@stop

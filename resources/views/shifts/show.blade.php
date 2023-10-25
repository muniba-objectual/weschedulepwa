@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Shift Management - Edit Shift</h1>
    @unless(Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table(['id' => 'myshifts', 'class' => 'table table-bordered stripe'], false) }}
                @section('js')
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


                    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


                    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap5.min.css">
                    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap5.min.css">
                    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap5.min.css">
                    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">

                    <link rel="stylesheet" href="/plugins/editor/css/editor.dataTables.min.css">
                    <link rel="stylesheet"
                        href="https://editor.datatables.net/extensions/Editor/css/editor.bootstrap5.min.css">

                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.bootstrap5.min.js"></script>
                    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
                    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
                    <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
                    <script src="https://editor.datatables.net/extensions/Editor/js/editor.bootstrap5.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>


                    <script src="{{ asset('plugins/editor/js/dataTables.editor.js') }}"></script>

                    <script>
                        $(function() {


                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });

                            var editor = new $.fn.dataTable.Editor({
                                ajax: "/shifts",
                                dbTable: "shifts",

                                table: "#myshifts",
                                //                                display: "bootstrap",


                                fields: [{
                                        label: "Title:",
                                        name: "title"
                                    },
                                    {
                                        label: "Start:",
                                        name: "start",
                                        type: 'datetime',
                                        format: 'YYYY-MM-DD HH:mm:ss'
                                    },
                                    {
                                        label: "End:",
                                        name: "end",
                                        type: 'datetime',
                                        format: 'YYYY-MM-DD HH:mm:ss'
                                    },
                                    {
                                        label: "Status:",
                                        name: "status",
                                        type: "select",
                                        options: [{
                                                label: "Pending",
                                                value: "Pending"
                                            },
                                            {
                                                label: "Started",
                                                value: "Started"
                                            },
                                            {
                                                label: "Ended - Incomplete",
                                                value: "Ended - Incomplete"
                                            },
                                            {
                                                label: "Ended - Pending Verification",
                                                value: "Ended - Pending Verification"
                                            },
                                            {
                                                label: "Complete",
                                                value: "Complete"
                                            },
                                        ]
                                    },

                                    {
                                        label: "Staff Assigned:",
                                        name: "fk_UserID"
                                    },

                                    {
                                        label: "Date Created:",
                                        name: "created_at",
                                        type: "readonly"
                                    },
                                    {
                                        label: "Date Updated:",
                                        name: "updated_at",
                                        type: "readonly"
                                    },

                                ]
                            });

                            {{ $dataTable->generateScripts() }}
                        })
                    </script>
                @stop

                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Shift Form - CYC Daily Report</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/shifts">Shift Entries</a></li>
                                    <li class="breadcrumb-item active">Edit Shift</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">General</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputName">Child</label>
                                        <input type="text" id="inputName" class="form-control" value="M F">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDescription">Date/Time</label>
                                        <input type="text" id="inputDateTime" class="form-control"
                                            value="December 2, 2021 - 10:15AM">

                                    </div>
                                    <div class="form-group">
                                        <label for="inputMood">Mood Upon Arrival</label>
                                        <textarea id="inputMood" class="form-control" rows="4">MF was in a positive mood and was looking forward to the activities scheduled for the day.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputInteraction">Interaction with Staff</label>
                                        <textarea id="inputInteraction" class="form-control" rows="4">lorem ipson</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputGeneral">General Observations</label>
                                        <textarea id="inputGeneral" class="form-control" rows="4">lorem ipson</textarea>
                                    </div>
                                    <!--  <div class="form-group">
                                            <label for="inputDietary">Dietary Notes</label>
                                            <textarea id="inputDietary" class="form-control" rows="4">lorem ipson</textarea>
                                        </div> -->


                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Medication Entries</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputEstimatedBudget">Medication</label>
                                        <input type="text" id="inputEstimatedBudget" class="form-control"
                                            value="Tylenol - Child" step="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSpentBudget">Dosage</label>
                                        <input type="text" id="inputSpentBudget" class="form-control" value="10ml"
                                            step="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDosageTime">Time to be Administered</label>
                                        <input type="time" id="inputDosageTime" class="form-control"
                                            value="11AM" step="1">
                                        <label for="inputDosageTimeAdministered">Time Administered</label>
                                        <input type="time" id="inputDosageTimeAdministered" class="form-control"
                                            value="11AM" step="1">
                                    </div>
                                    <div class="form-group">
                                        <input type="button" id="inputSubmitEntry" class="form-control"
                                            value="Add Entry">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Files</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>File Size</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>img_tylenol.jpg</td>
                                                <td>349.85 kb</td>
                                                <td class="text-right py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="#" class="btn btn-info"><i
                                                                class="fas fa-eye"></i></a>
                                                        <a href="#" class="btn btn-danger"><i
                                                                class="fas fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>img_activity.jpg</td>
                                                <td>428.43 kb</td>
                                                <td class="text-right py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="#" class="btn btn-info"><i
                                                                class="fas fa-eye"></i></a>
                                                        <a href="#" class="btn btn-danger"><i
                                                                class="fas fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <!-- /.card-body -->
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Upload file/image</label>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Save Changes" class="btn btn-success float-right">
                        </div>
                    </div>
                </section>


                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
    </div>
</div>
</div>

@stop

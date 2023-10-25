@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Shift Layout Management</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-group col-3">
                        {!! Form::Label('staff_id', 'Staff Filter:') !!}
                        <select class="form-control" name="staff_id" id="staff_id">
                            <option value="All_Staff">All</option>
                            @foreach($staff as $user)
                                <option value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{ $dataTable}}

                    @section('js')
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">

                        <link rel="stylesheet" href="/plugins/editor/css/editor.dataTables.min.css">
                        <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.bootstrap5.min.css">

                        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
                        <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
                        <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap5.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.bootstrap5.min.js"></script>
                        <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
                        <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
                        <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
                        <script src="https://editor.datatables.net/extensions/Editor/js/editor.bootstrap5.min.js"></script>



                        <script src="{{asset('plugins/editor/js/dataTables.editor.js')}}"></script>



                        <script>
                            $(function() {

                                var staff_select = document.getElementById('staff_id').value;

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                                    }
                                });


                                var editor = new $.fn.dataTable.Editor({
                                    ajax: "/shiftlayout",
                                    dbTable: "shiftlayout",

                                    table: "#shiftlayout",
//                                display: "bootstrap",


                                    fields: [
                                        {label: "Day of Week:", name: "day_of_week", type: 'select',
                                            options: [
                                                "Monday",
                                                "Tuesday",
                                                "Wednesday",
                                                "Thursday",
                                                "Friday",
                                                "Saturday",
                                                "Sunday",
                                            ],
                                            placeholder: 'Select a day of the week'},
                                        {label: "Start Time:", name: "start_time", type: 'datetime',  format: 'HH:mm',
                                            fieldInfo: '24 hour clock format'},
                                        {label: "End Time:", name: "end_time", type: 'datetime',  format: 'HH:mm',
                                            fieldInfo: '24 hour clock format' },
                                        {label: "Staff Assigned:", name: "fk_UserID", type: 'select', placeholder: 'Select Staff Member', options:
                                                [
                                                        @foreach ($staff as $user)
                                                    {label: '{{$user->first_name}} {{$user->last_name}}', value: {{$user->id}}},
                                                    @endforeach


                                                ]},
                                        {label: "Child Assigned:", name: "fk_ChildID", type:'select', placeholder: 'Select Child', options:
                                                [
                                                        @foreach ($children as $child)
                                                    {label: '{{$child->initials}}', value: {{$child->id}}},
                                                    @endforeach


                                                ]},


                                        {label: "Date Created:", name:"created_at", type: "readonly"},
                                        {label: "Date Updated:", name:"updated_at", type: "readonly"},

                                    ]
                                });

                                $('#shiftlayout').on('click', 'tbody td:not(:first-child)', function (e) {
                                    editor.inline(this);
                                });



                                $('#staff_id').on('change', function() {
                                    window.location = "/shiftlayout?staffID=" + $('#staff_id').val();


                                    //calendar.refetchEvents();
                                });
                            })


                        </script>
                    @stop
                </div>
            </div>
        </div>
    </div>

@stop

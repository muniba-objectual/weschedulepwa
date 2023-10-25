@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Child Management - Notifications Schedule</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                        {{ $dataTable->table(['id' => 'child_notifications_schedule', 'class' => 'table table-bordered stripe'], false) }}

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
<script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
<script src="https://editor.datatables.net/extensions/Editor/js/editor.bootstrap5.min.js"></script>



                        <script src="{{asset('plugins/editor/js/dataTables.editor.js')}}"></script>



                        <script>
                        $(function() {

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                }
                            });


                            var editor = new $.fn.dataTable.Editor({
                                ajax: "/ChildNotificationsSchedule",
                                dbTable: "child_notifications_schedule",

                                table: "#child_notifications_schedule",
//                                display: "bootstrap",


                                fields: [
                                    {label: "Events:", name: "notification_events", type: 'checkbox', options: [
                                            { label: "Incident Reports",    value: 'Incident Reports' },
                                            { label: "Serious Occurences",    value: 'Serious Occurences' },
                                            { label: "Medication Entries",    value: 'Medication' },
                                            { label: "Appointment Reminders",    value: 'Appointments' }

                                        ],

                                        separator: ','

                                    },
                                    {label: "Notification Message:", name: "notification_message", type: 'textarea', attr: {
                                            placeholder: "Please enter your notification message here"
                                        }},
                                    {label: "Notification Schedule", name: "notification_schedule", type: 'textarea', attr: {
                                            placeholder: "i.e. Daily at 6PM; Every Monday at 9AM; On-Demand...etc."
                                        }},
                                    {label: "Notification Method:", name: "notification_method", type: 'select', options: [
                                            { label: "Email",    value: 'Email' },
                                            { label: "SMS (Text Message)", value: 'SMS' }


                                        ]},
                                    {label: "Notification Addresses", name: "notification_addresses", type: 'textarea', attr: {
                                            placeholder: "Enter 1 or many addresses (for email, enter xyz@domain.com; for SMS enter +1[Area Code][Mobile Number])"
                                        }},

                                    {label: "Assigned Child:", name: "fk_ChildID", type: "datatable",  options:
                                    [
                                        @foreach ($children as $child)
                                        {label: '{{$child->initials}}', value: {{$child->id}}},
                                        @endforeach


                                    ]},



                                ]
                            });

                            $('#child_notifications_schedule').on('click', 'tbody td:not(:first-child)', function (e) {
                                editor.inline(this);
                            });

                            {{$dataTable->generateScripts()}}
                        })


                    </script>
                        @stop
                </div>
            </div>
        </div>
    </div>

@stop

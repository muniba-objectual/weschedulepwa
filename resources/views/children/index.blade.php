@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Child Management</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                        {{ $dataTable->table(['id' => 'children', 'class' => 'table table-bordered stripe'], false) }}

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
                                ajax: "/children",
                                dbTable: "children",

                                table: "#children",
//                                display: "bootstrap",


                                fields: [
                                    {label: "Initials:", name: "initials"},
                                    {label: "Date of Birth:", name: "DOB", type:'datetime',def:   function () { return new Date(); }},
                                    {label: "Notes:", name: "notes", type: 'textarea'},
                                    {label: "SRA", name: "SRA", type: 'select', label: 'SRA', options: [
                                            { label: "YES", value: 1 },
                                            { label: "NO",    value: 0 }
                                        ]},

                                    {label: "Assigned Home:", name: "fk_HomeID", type: "datatable",  options:
                                    [
                                        @foreach ($homes as $home)
                                        {label: '{{$home->name}}', value: {{$home->id}}},
                                        @endforeach


                                    ]},

                                    {label: "We-Schedule Enabled", name: "WeSchedule", def: 1, type: 'select', options: [
                                            { label: "YES", value: 1 },
                                            { label: "NO",    value: 0 }
                                        ]},



                                ]
                            });

                            $('#children').on('click', 'tbody td:not(:first-child)', function (e) {
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

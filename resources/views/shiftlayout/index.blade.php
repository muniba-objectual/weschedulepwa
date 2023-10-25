@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Shift Layout Templates</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">




                    {{ $dataTable->table(['id' => 'shiftlayout', 'class' => 'table table-bordered stripe'], true) }}

                    @section('js')
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">

                        <link rel="stylesheet" href="/plugins/editor/css/editor.dataTables.min.css">
                        <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.min.css">

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
                        <script src="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>




                        <script src="{{asset('plugins/editor/js/dataTables.editor.js')}}"></script>



                        <script>
                            $(function() {

                                function generateSchedule() {
                                    window.location = '{{route("generateSchedule")}}';
                                }


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
                                                    {label: '{{$user->name}}', value: {{$user->id}}},
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

                                {{$dataTable->generateScripts()}}


// Display an Editor form that allows the user to pick the CSV data to apply to each column
                                function selectColumns ( editor, csv, header ) {
                                    var selectEditor = new $.fn.dataTable.Editor();
                                    var fields = editor.order();

                                    for ( var i=0 ; i<fields.length ; i++ ) {
                                        var field = editor.field( fields[i] );

                                        selectEditor.add( {
                                            label: field.label(),
                                            name: field.name(),
                                            type: 'select',
                                            options: header,
                                            def: header[i]
                                        } );
                                    }

                                    selectEditor.create({
                                        title: 'Map CSV fields',
                                        buttons: 'Import '+csv.length+' records',
                                        message: 'Select the CSV column you want to use the data from for each field.',
                                        onComplete: 'none'
                                    });

                                    selectEditor.on('submitComplete', function (e, json, data, action) {
                                        // Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
                                        editor.create( csv.length, {
                                            title: 'Confirm import',
                                            buttons: 'Submit',
                                            message: 'Click the <i>Submit</i> button to confirm the import of '+csv.length+' rows of data. Optionally, override the value for a field to set a common value by clicking on the field below.'
                                        } );

                                        for ( var i=0 ; i<fields.length ; i++ ) {
                                            var field = editor.field( fields[i] );
                                            var mapped = data[ field.name() ];

                                            for ( var j=0 ; j<csv.length ; j++ ) {
                                                field.multiSet( j, csv[j][mapped] );
                                            }
                                        }
                                    } );
                                }

                                // Upload Editor - triggered from the import button. Used only for uploading a file to the browser
                                var uploadEditor = new $.fn.dataTable.Editor( {
                                    fields: [ {
                                        label: 'CSV file:',
                                        name: 'csv',
                                        type: 'upload',
                                        ajax: function ( files, done ) {
                                            // Ajax override of the upload so we can handle the file locally. Here we use Papa
                                            // to parse the CSV.
                                            Papa.parse(files[0], {
                                                header: true,
                                                skipEmptyLines: true,
                                                complete: function (results) {
                                                    if ( results.errors.length ) {
                                                        console.log( results );
                                                        uploadEditor.field('csv').error( 'CSV parsing error: '+ results.errors[0].message );
                                                    }
                                                    else {
                                                        selectColumns( editor, results.data, results.meta.fields );
                                                    }

                                                    // Tell Editor the upload is complete - the array is a list of file
                                                    // id's, which the value of doesn't matter in this case.
                                                    done([0]);
                                                }
                                            });
                                        }
                                    } ]
                                } );
                            })


                        </script>
                    @stop
                </div>
            </div>
        </div>
    </div>

@stop

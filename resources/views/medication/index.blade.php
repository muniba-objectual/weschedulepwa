

    <div class="container">

        <div class="table-responsive">


   <table id="tblMedication"  class="table table-striped table-bordered dt-responsive nowrap" width="100%">
        <thead>
            <tr>
                <th>Image</th>
                <th>Type</th>
                <th>Dosage</th>
                <th>Time</th>
                <th>Compliance</th>
                <th>Food</th>
                <th>PRN</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

                    @section('js')
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">


                        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

                        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>
                        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.0.3/css/rowGroup.bootstrap4.min.css"/>

                        <script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
                        <script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
                <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

                <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.0.3/js/dataTables.rowGroup.min.js"></script>

                <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
                <script src="https://editor.datatables.net/extensions/Editor/js/editor.bootstrap5.min.js"></script>
                <script src="{{asset('plugins/editor/js/dataTables.editor.js')}}"></script>

                        <script>
                        $(function() {
                                var collapsedGroups = {};
                                var table = $('#tblMedication').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        pageLength: 100,

                                    ajax: "{{ route('child.getMedication',$child->id) }}",
                                    order: [
                                        [3, 'desc']
                                    ],

                                    rowGroup: {
                                        // Uses the 'row group' plugin
                                        dataSrc: 'date_time',
                                        startRender: function (rows, group) {
                                            var collapsed = !!collapsedGroups[group.substr(0,10)];

                                            /*
                                            rows.nodes().each(function (r) {
                                                r.style.display = collapsed ? 'none' : '';
                                            });
                                            */

                                            rows.nodes().each(function (r) {
                                                r.style.display = 'none';
                                                if (collapsed) {
                                                    r.style.display = '';
                                                }});

                                            // Add category name to the <tr>. NOTE: Hardcoded colspan
                                            if (rows.count() > 1) {
                                                return $('<tr/>')
                                                    .append('<td colspan="7">' + group.substr(0,10) + ' (' + rows.count() + ' entries)</td>')
                                                    .attr('data-name', group.substr(0,10))
                                                    .toggleClass('collapsed', collapsed);
                                            }
                                            else if (rows.count() <= 1) {
                                                return $('<tr/>')
                                                    .append('<td colspan="7">' + group.substr(0,10) + ' (' + rows.count() + ' entry)</td>')
                                                    .attr('data-name', group.substr(0,10))
                                                    .toggleClass('collapsed', collapsed);
                                            }

                                        }
                                    },
                                    columns: [
                                            {name: 'photo', data: 'photo', orderable: false, render: function ( data, type, full, meta ) {



                                                        if (data){
                                                            return  '<img height="50px" src="/storage/' + data.substr(7) + '" alt="image" class="imaged w64">';
                                                        } else {
                                                            return '<ion-icon name="medical" class="text-danger"></ion-icon>';
                                                        }


                                                }
                                                },

                                            {data: 'medication_type', name: 'medication_type', orderable: false},
                                            {data: 'dosage', name: 'dosage', orderable: false},
                                        {name: 'date_time', data: 'date_time', render: function ( data, type, full, meta ) {


                                                   // return  data.substr(11,5);
                                                    return data.substr(11,5);




                                            }
                                        },
                                            {data: 'compliance', name: 'compliance', orderable: false},
                                            {data: 'taken_with_food', name: 'taken_with_food', orderable: false},
                                            {data: 'PRN', name: 'PRN', orderable: false},

                                           /* {
                                                data: 'action',
                                                name: 'action',
                                                orderable: true,
                                                searchable: true
                                            },

                                            */
                                        ]
                                    });

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                }
                            });

                            $('#tblMedication tbody').on('click', 'tr.group-start', function () {
                             console.log ('clicked...');
                                var name = $(this).data('name');
                                collapsedGroups[name] = !collapsedGroups[name];
                                table.draw(false);
                            });

                            var editor = new $.fn.dataTable.Editor({
                                ajax: "#",
                                dbTable: "medication_entries",

                                table: "#tblMedication",
//                                display: "bootstrap",


                                fields: [
                                    {label: "Type:", name: "medication_type"},
                                    {label: "Dosage", name: "dosage"},
                                    {label: "Date/Time", name: "date_time", type: 'datetime', format:  'YYYY-MM-DD HH:mm'},
                                    {label: "Compliance", name: "compliance"},
                                    {label: "Food:", name: "food", type: "select",
                                        options: [
                                            { label: "Yes", value: "1" },
                                            { label: "No",    value: "0" },
                                        ]},
                                    {label: "PRN:", name: "PRN", type: "select",
                                        options: [
                                            { label: "Yes", value: "1" },
                                            { label: "No",    value: "0" },
                                        ]},


                                ]
                            });



                        });



                        </script>
                        @stop
                </div>
            </div>


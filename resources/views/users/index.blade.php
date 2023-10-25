
@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Staff Management</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        {{ $dataTable->table(['id' => 'users', 'class' => 'table table-bordered stripe'], false) }}
                    <div id="customForm" style="visibility: hidden;">
                        <fieldset class="user_information">
                            <legend>User Information</legend>
                            <div data-editor-template="name"></div>

                            <div data-editor-template="email"></div>
                            <div data-editor-template="get_user_type"></div>
                            <div data-editor-template="user_type"></div>

                        </fieldset>
                        <fieldset class="address">
                            <legend>Address</legend>
                            <div data-editor-template="address"></div>
                            <div data-editor-template="city"></div>
                            <div data-editor-template="province"></div>
                            <div data-editor-template="postal"></div>
                        </fieldset>
                        <fieldset class="extra">
                            <legend>Extra</legend>
                            <div data-editor-template="drivers_license"></div>
                            <div data-editor-template="notes"></div>

                        </fieldset>
                    </div>

                    @section('js')
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

                       <style>



                           #customForm {
                               display: flex;
                               flex-flow: row wrap;
                           }

                           #customForm fieldset {
                               flex: 1;
                               border: 1px solid #aaa;
                               margin: 0.5em;
                           }

                           #customForm fieldset legend {
                               padding: 5px 20px;
                               border: 1px solid #aaa;
                               font-weight: bold;
                           }

                           #customForm fieldset.user_information {
                               flex: 2 100%;
                           }
                           #customForm fieldset.user_information legend {
                               background: red;
                           }


                           #customForm fieldset.address legend {
                               background: #bfffbf;
                           }

                           #customForm fieldset.extra legend {
                               background: #ffffbf;
                           }

                           #customForm fieldset.hr legend {
                               background: #ffbfbf;
                           }

                           #customForm div.DTE_Field {
                               padding: 5px;
                           }
                       </style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap5.min.css">
                        <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap5.min.css">
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
<script src="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>


                        <script src="{{asset('plugins/editor/js/dataTables.editor.js')}}"></script>



                        <script>
                        $(function() {


                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                }
                            });


                            var editor = new $.fn.dataTable.Editor({
                                ajax: "/users",


                                table: "#users",
//                                display: "bootstrap",
                                //template: '#customForm',
                               type:'datatable',

                                fields: [
                                    {label: "Name:", name: "name"},

                                    {label: "Email:", name: "email"},

                                    {label: "User Type:", name: "user_type", type: "select", options: [
                                            {label: 'CYSW', value: 1},
                                            {label: 'Case Manager', value: 2},
                                            {label: 'Administrator', value: 3},
                                            {label: 'Foster Parent Applicant', value: 2.3},
                                            {label: 'Admin Assistant', value: 5.1},
                                            {label: 'Carpe Diem Supervisor/Admin - Placement', value: 4.2},
                                        ]},
                                    {label: "Password:", name: "password", type: "password"},

                                    /*
                                    {label: "Assigned Children:", name: "get_assigned_children[].id", type: "datatable", multiple:true, options:
                                            [
                                                    @foreach ($children as $child)


                                                    @if (count($child->getAssignedUser) > 0)
                                                    {{--
                                                    dd($child->getAssignedUser->first()->pivot->salary)
                                                    --}}


                                                {label: '{{$child->initials}}', value: {{$child->id}}, salary: "$" + {{$child->getAssignedUser->first()->pivot->salary}}},
                                                    @else
                                                {label: '{{$child->initials}}', value: {{$child->id}}, salary: '0.00'},
                                                @endif



                                                @endforeach


                                            ],
                                        optionsPair: {
                                            value: 'id',
                                        },
                                        config: {
                                            columns: [
                                                {
                                                    title: 'Child',
                                                    data: 'label'
                                                },
                                                {
                                                    title: 'Salary',
                                                    data: 'salary'
                                                }
                                            ]
                                        }

                                    },
*/

                                /*
                                    {label: "Address:", name: "address"},
                                    {label: "City:", name: "city"},
                                    {label: "Province:", name: "province"},
                                    {label: "Postal Code:", name: "postal"},
                                    {label: "Drivers License:", name: "drivers_license"},
                                  */
                                    {label: "Notes:", name: "notes", type: 'textarea'},


                                ]
                            });

                           /*
                            editor.on('preOpen', function (e, type) {

                                //window.alert('pre-open');

                                var modifier = editor.modifier(); //get row
                                if (modifier) {
                                data = $("#users").DataTable().row(modifier).data();

                                console.log (JSON.stringify(data.assigned_children));
                                  //  editor.val( 'assigned_children', data.assigned_children );

                                if (data.assigned_children) {
                                    data.assigned_children.forEach(setDefaultSelected);


                                    function setDefaultSelected(item) {
                                        const removed = item.replace(/"/g, '');
                                       // editor.val('assigned_children', removed);

                                    }
                                }
                                   // editor.val('assigned_children', '1;2');
                                    //console.log (data);
                                }


                            } );
*/
                            $('#users').on('click', 'tbody td:not(:first-child)', function (e) {
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

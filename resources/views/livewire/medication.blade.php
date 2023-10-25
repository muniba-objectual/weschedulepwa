<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/pikaday.min.js"></script>-->
    <script src="/plugins/pikaday/pikaday.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/css/pikaday.min.css" integrity="sha512-yFCbJ3qagxwPUSHYXjtyRbuo5Fhehd+MCLMALPAUar02PsqX3LVI5RlwXygrBTyIqizspUEMtp0XWEUwb/huUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/group-by-v2/bootstrap-table-group-by.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>

    <!-- tailwind css for Medication Admin if Views-BS4-Livewire-Datatable-main not installed; breaks AW formatting
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.2/tailwind.min.css" integrity="sha512-l7qZAq1JcXdHei6h2z8h8sMe3NbMrmowhOl+QkP3UhifPpCW2MC4M0i26Y8wYpbz1xD9t61MLT9L1N773dzlOA==" crossorigin="anonymous" />
 -->

    <style>
        [x-cloak] {
            display: none;
        }
    </style>
    <!-- Add Medication Dialog -->
    <div wire:ignore class="modal fade dialog" id="addModal" data-accordion="static" tabindex="-1" role="dialog"
         aria-labelledby="addModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-blue">
                    <span class="modal-title" id="mymodelLabel">Add Medication Entry</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="frmAddMedication" wire:submit.prevent="submit" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="form-group col">
                                <label for="medication_type">Medication Type</label>


                                <br />
                                <select  style="width: 100%"  class="form-control" id="medication_type" wire:model="LW_medication_entry.medication_type" >
                                    <option></option>

                                @if (count($medication_Profile) >= 1)
                                        @foreach($medication_Profile as $row)
                                            <option value="{{ $row['id'] }}">{{ $row['type'] }}</option>
                                        @endforeach
                                    @else
                                    @endif

                                </select>
                                <!-- <input type="text" class="form-control" id="medication_type"
                                       wire:model="LW_medication_entry.medication_type">
                                       -->
                                @error('LW_medication_entry.medication_type') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col">
                                <label for="dosage">Dosage</label>
                                <input type="text" class="form-control" id="dosage"
                                       wire:model="LW_medication_entry.dosage">
                                @error('LW_medication_entry.dosage') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="form-group col">
                                <label for="date_time">Date/Time</label>
                                <input type="text" class="form-control" id="date_time"
                                       wire:model="LW_medication_entry.date_time">
                                @error('LW_medication_entry.date_time') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col">
                                <label for="compliance">Compliance</label>
                                <input type="text" class="form-control" id="compliance"
                                       wire:model="LW_medication_entry.compliance">
                                @error('LW_medication_entry.compliance') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="form-group col">
                                <label for="taken_with_food">Taken with Food</label>
                                <select name="taken_with_food" id="taken_with_food" class="form-control"
                                        wire:model="LW_medication_entry.taken_with_food"
                                        data-placeholder="Please Select">
                                    <option value="Please select...">Please Select...</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('LW_medication_entry.taken_with_food') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="form-group col">
                                <label for="PRN">PRN</label>
                                <select name="PRN" id="PRN" class="form-control"
                                        wire:model="LW_medication_entry.PRN">
                                    <option value="Please select...">Please Select...</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('LW_medication_entry.PRN') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control" id="photo" wire:model="photo"
                                   style="display:initial !important;">
                            @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div id="frmAdd_errors">

                        </div>

                        <div class="modal-footer">
                            <button type="submit" wire:click.prevent="submit" class="btn btn-danger">Save & Submit
                            </button>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
    <!-- *Add Medication Dialog -->

    <!-- View Medication Dialog -->
    <div wire:ignore.self class="modal fade dialog" id="viewModal" data-accordion="static" tabindex="-1" role="dialog"
         aria-labelledby="viewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-blue">
                    <span class="modal-title" id="mymodelLabel">View Medication Entry</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group col">
                            <label for="medication_type">Medication Type</label>
                            <input readonly type="text" class="form-control" id="medication_type_view"
                                   wire:model="LW_medication_entry.medication_type">

                        </div>

                        <div class="form-group col">
                            <label for="dosage">Dosage</label>
                            <input readonly type="text" class="form-control" id="dosage" wire:model="LW_medication_entry.dosage">

                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="form-group col">
                            <label for="date_time">Date/Time</label>
                            <input readonly type="text" class="form-control" id="date_time"
                                   wire:model="LW_medication_entry.date_time">

                        </div>

                        <div class="form-group col">
                            <label for="compliance">Compliance</label>
                            <input readonly type="text" class="form-control" id="compliance"
                                   wire:model="LW_medication_entry.compliance">

                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="form-group col">
                            <label for="taken_with_food">Taken with Food</label>
                            <input readonly  name="taken_with_food" id="taken_with_food" class="form-control"
                                   wire:model="LW_medication_entry.taken_with_food" />


                        </div>


                        <div class="form-group col">
                            <label for="PRN">PRN</label>
                            <input readonly name="PRN" id="PRN" class="form-control"
                                   wire:model="LW_medication_entry.PRN" />

                        </div>
                    </div>

                    <div class="form-group">
                        @if ($LW_medication_entry->photo != "")
                            Photo <br />
                            <img class="d-block mx-auto" src="/storage/{{substr($LW_medication_entry->photo,7)}}" wire:model="LW_medication_entry.photo" width="200px"/>
                        @else
                            No photo uploaded
                        @endif
                    </div>



                </div>


            </div>
        </div>
    </div>
    <!-- *View Medication Dialog -->

    <div>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#entries" class="nav-link active" data-toggle="tab">Entries</a>
                </li>
                <li class="nav-item"><a href="#admin" class="nav-link" data-toggle="tab">Admin</a>
                </li>
            </ul>
            <div wire:ignore class="tab-content">
                <div class="tab-pane  active" id="entries">
                    <div class="d-flex justify-content-center p-1 m-1">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Entry</button>
                    </div>
                    <div id="entries" wire:ignore>
                        <div class="container-fluid">

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
                                        <th>User</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                @section('js')
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

                                    <!--  issue with collapsing (multiple bootstrap loaded?)
                                    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                                    -->
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

                                    <!-- issue with collapsing (multiple bootstrap loaded?)
                                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
                                    -->

                                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>
                                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.0.3/css/rowGroup.bootstrap4.min.css"/>

                                    <script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
                                    <script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
                                    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

                                    <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.0.3/js/dataTables.rowGroup.min.js"></script>


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
                                                    dataSrc: function(row) {
                                                        return row.date_time.substr(0,10);
                                                    },

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
                                                                .append('<td colspan="8">' + group.substr(0,10) + ' (' + rows.count() + ' entries)</td>')
                                                                .attr('data-name', group.substr(0,10))
                                                                .toggleClass('collapsed', collapsed);
                                                        }
                                                        else if (rows.count() <= 1) {
                                                            return $('<tr/>')
                                                                .append('<td colspan="8">' + group.substr(0,10) + ' (' + rows.count() + ' entry)</td>')
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

                                                    {data: 'medication_type', name: 'medication_type', orderable: false, render: function ( data, type, row, meta ) {
                                                        // console.log (row);

                                                            @if (Auth::user()->user_type == "10.0")
                                                            return  data + " <i onclick=" + "'" + "deleteMed(" + row['id'] + ")' class='fa-solid fa-trash text-red'></i>";
                                                            @else
                                                            return data;
                                                            @endif
                                                    }
                                                    },
                                                    {data: 'dosage', name: 'dosage', orderable: false},
                                                    {name: 'date_time', data: 'date_time', render: function ( data, type, full, meta ) {


                                                            // return  data.substr(11,5);
                                                            return data.substr(11,5);




                                                        }
                                                    },
                                                    {data: 'compliance', name: 'compliance', orderable: false},
                                                    {data: 'taken_with_food', name: 'taken_with_food', orderable: false, render: function ( data, type, full, meta ) {
                                                            // return  data.substr(11,5);
                                                           if (data == 1) {
                                                               return "Yes";
                                                           }

                                                           if (data == 0) {
                                                               return "No";
                                                           }

                                                        }
                                                        },
                                                    {data: 'PRN', name: 'PRN', orderable: false, render: function ( data, type, full, meta ) {
                                                            // return  data.substr(11,5);
                                                            if (data == 1) {
                                                                return "Yes";
                                                            }

                                                            if (data == 0) {
                                                                return "No";
                                                            }

                                                        }
                                                    },
                                                    {data: 'username', name: 'User', orderable: false},

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




                                        });



                                    </script>
                                @stop
                            </div>
                        </div>






                    </div>

                </div>
                <div class="tab-pane fade in mt-3" id="admin">

                    <div class="d-flex justify-content-center p-1 m-1">
                        <x-adminlte-button label="Add Medication Profile" theme="success" icon="fas fa-plus" data-toggle="modal" data-target="#addMed"/>

                    </div>

                    @livewire('medication.medication-profiles', ['child' => $child])


                    <x-adminlte-modal id="addMed" title="Add Medication Profile" v-centered>

                        <form id="frmAddMed" method="POST" action="{{ route('AddMedicationProfile') }}">
                            @csrf
                        <input type="hidden" name="childID" id="childID" value ="{{$child->id}}"/>
                            {{-- With prepend slot --}}
                        <x-adminlte-input name="AddMedType" label="Medication Type" placeholder="Enter Medication Type">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-input name="AddMedDosage" label="Medication Dosage" placeholder="Enter Medication Dosage">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                            @if ($errors->has('AddMedType'))
                                {{ $errors->first('AddMedType') }}
                            @endif

                            @if ($errors->has('AddMedDosage'))
                                {{ $errors->first('AddMedDosage') }}
                            @endif
                        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>

                       </form>

                    </x-adminlte-modal>
                    <script>

                        function deleteMed(id) {
                            $del = confirm('Are you sure you want to delete this Medication entry?');
                            if ($del) {
                                livewire.emit('setDeleteID',id);
                                livewire.emit('deleteRecord');

                            }


                        }
                        function successAddMed() {
                            livewire.emit('refreshDataTable');
                            $('#addMed').modal('hide');

                        }

                        $(function () {
                            $('#frmAddMed').submit(function (e) {
                                e.preventDefault();
                                let formData = $(this).serializeArray();
                                $(".invalid-feedback").children("strong").text("");
                                $("#frmAddMed input").removeClass("is-invalid");
                                $.ajax({
                                    method: "POST",
                                    headers: {
                                        Accept: "application/json"
                                    },
                                    url: "{{ route('AddMedicationProfile') }}",
                                    data: formData,
                                    success: successAddMed(),
                                {{--success: () => window.location.assign("{{ route('auth.account') }}"),--}}
                                    error: (response) => {
                                        if(response.status === 422) {
                                            let errors = response.responseJSON.errors;
                                            Object.keys(errors).forEach(function (key) {
                                                $("#" + key + "Input").addClass("is-invalid");
                                                $("#" + key + "Error").children("strong").text(errors[key][0]);
                                            });
                                        } else {
                                            //window.location.reload();
                                        }
                                    }
                                })
                            });
                        })
                    </script>
                </div>
            </div>
        </div>








    <!-- Modal -->
    <div wire:ignore.self class="modal fade dialogbox" id="deleteModal" data-bs-backdrop="static" tabindex="-1"
         role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Medication</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete this entry?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="deleteRecord()" class="btn btn-danger close-modal"
                            data-bs-dismiss="modal">Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>


        window.addEventListener('SuccessMessage', event => {
            //$("#frmAddMedication").trigger('reset');

            $('#addModal').modal('hide')

        });

        window.addEventListener('ReloadWindow', event => {
            //$("#frmAddMedication").trigger('reset');
            window.location.reload();


        });

        window.addEventListener('error_in_addMedication', event => {
            //$("#frmAddMedication").trigger('reset');
            //$("#frmAdd_errors").show();
           // if (event.detail.tmpErrors['LW_medication_entry.PRN']) {
           //     $("#frmAdd_errors").html($("#frmAdd_errors").html() + "PRN is required <br />");
           // }




         //   $("#frmAdd_errors").html(JSON.stringify(event.detail.tmpErrors));
            //$("#frmAdd_errors").html(event.detail.tmpErrors);
            window.alert ('Error - Please make sure to fill out all fields');


        });


        window.addEventListener('closeAddMedicationModal', event => {
            //$("#frmAddMedication").trigger('reset');

            $('#addModal').modal('hide');
            window.location.hash = 'medicationTab';
            window.location.reload();        });

        window.addEventListener('viewMedicationModal', event => {
            //$("#frmAddMedication").trigger('reset');

            $('#viewModal').modal('show')

        });



        //stop background scrolling when modal is open

        window.addEventListener('hidden.bs.modal', event => {
            //$("#frmAddMedication").trigger('reset');

            $('body').css('overflow', 'auto');
            $('#appCapsule').css('overflow', 'auto');
            $('#frmAddMedication').trigger('reset');

        });

        window.addEventListener('shown.bs.modal', event => {
            $("#frmAddMedication").trigger('reset');

            $('body').css('overflow', 'hidden');
            $('#appCapsule').css('overflow', 'hidden');
        });


        $('#addModal').on('shown.bs.modal', function (e) {
            $("#frmAdd_errors").hide();
        });

        function test(key, entries) {
           //console.log (key);

           //console.log (entries);
           return ([key]);
        }

        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (el, component) => {
                //console.log ('message processed');
               //console.log (el);
             //  console.log (component);
           // console.log ($('#el').bootstrapTable());

                /*
                $('#table').bootstrapTable(
                    {
                        search: true,
                    }
                );
*/

             //  $('#table').bootstrapTable('append',{'id':999, 'image':'bob','type':'bob','dosage':'1','date_time':'2022-03-11', 'date_time_groupby':'2022-03-11', 'compliance':'1', 'food':'1', 'prn':'1'});

            })

               });


        $(document).ready(function() {
            var picker = new Pikaday({field: $('#date_time')[0]});
            picker.setDate (new Date());
            console.log ('ready - med');


            window.initMedTypeSelect2=()=> {
                $('#medication_type').select2(
                    {
                        tags: true,
                        dropdownParent: $("#frmAddMedication"),
                        placeholder: "Select Medication Profile",
                        //searchInputPlaceholder: 'Add PRN Entry...',

                        allowClear: true,
                        createTag: function (tag) {
                            return {
                                id: tag.term,
                                text: tag.term,
                                newTag: true
                            };
                        },

                    }
                );
              $('#medication_type').val({{ $LW_medication_entry->medication_type}});

            }
                initMedTypeSelect2();

            $('#medication_type').on('select2:opening', function (e) {
                $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Add PRN Entry...')

            });

                $('#medication_type').on('select2:unselecting', function (e) {

                console.log ('cleared');
                //$(this).val('').trigger('change');
                //e.preventDefault();
                $("#dosage").prop('readonly',false);
                $("#dosage").val('');
                $("#compliance").prop('readonly',false);
                $("#compliance").val('');
                $("#PRN").prop('disabled',false);
                $("#PRN").val('0');

            });








            $('#medication_type').on('select2:select', function (e) {

                console.log ('selected!!!');
                console.log (e.params.data);
                //@this.LW_medication_entry.medication_type =  e.params.data.text;
                //window.livewire.find($("#medication_type").attr('wire:id')).set('LW_medication_entry.medication_type', e.params.data.text);


                if (e.params.data.newTag) {


                    //new tag created; wait for save function...
                   livewire.emit('setMedicationType', e.params.data.text);
                    $("#dosage").prop('readonly', false);
                    $("#compliance").prop('readonly', true);
                    $("#PRN").val('Yes');
                    $("#PRN").prop('disabled', true);





                } else {
                    livewire.emit('setMedication', e.params.data.text, e.params.data.id);
                    //disable form boxes due to pre-population of fields
                    $("#dosage").prop('readonly', true);
                    $("#compliance").prop('readonly', true);
                    $("#PRN").prop('disabled', true);
                    $("#PRN").val('No');



                    //  $('#medication_type').text(e.params.data.text);
                 //   $('#dosage').val(e.params.data.id);
                //    $('#dosage').text(e.params.data.id);

               //     $('#date_time').val()
                }

            });

                window.livewire.on('select2',()=>{
                    initMedTypeSelect2();
                });

            //var $table = $('#table');
         //   $('#table').bootstrapTable();

           // $('#table').bootstrapTable('load',{'id':999, 'image':'bob','type':'bob','dosage':'1','date_time':'2022-03-11', 'date_time_groupby':'2022-03-11', 'compliance':'1', 'food':'1', 'prn':'1'});


        });
    </script>

</div>



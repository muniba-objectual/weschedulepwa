<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/pikaday.min.js"></script>-->
    <script src="/plugins/pikaday/pikaday.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/css/pikaday.min.css" integrity="sha512-yFCbJ3qagxwPUSHYXjtyRbuo5Fhehd+MCLMALPAUar02PsqX3LVI5RlwXygrBTyIqizspUEMtp0XWEUwb/huUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" />

    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/group-by-v2/bootstrap-table-group-by.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>

    <!-- Add Medication Dialog -->
    <div wire:ignore.self class="modal fade dialog" id="addModal" data-accordion="static" tabindex="-1" role="dialog"
         aria-labelledby="addModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                                <input type="text" class="form-control" id="medication_type"
                                       wire:model="LW_medication_entry.medication_type">
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
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                @error('LW_medication_entry.taken_with_food') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="form-group col">
                                <label for="PRN">PRN</label>
                                <select name="PRN" id="PRN" class="form-control"
                                        wire:model="LW_medication_entry.PRN">
                                    <option value="Please select...">Please Select...</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
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
                            <input readonly type="text" class="form-control" id="medication_type"
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

    <div class="d-flex justify-content-center p-1 m-1">
        <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Entry</button>
    </div>

    <div id="entries" wire:ignore>
        @if ($LW_medication_entries->count() > 0)

        <table wire:poll id="table" class="table table-hover" data-toggle="table" data-search="true"
               data-show-columns="false"
               data-show-refresh="true"
               data-group-by-collapsed-groups="test"
               class="table table-striped table-borderless"
               data-group-by="true"
               data-group-by-field="date_time_groupby"
               data-group-by-toggle="true"
               data-group-by-show-toggle-icon="true"
               data-toggle="table"
               data-unique-id="id"
               data-sort-name="date_time_groupby"
               data-sort-order="desc"
        >
            <thead>
            <tr>
                <th data-field="id" data-visible="false">id</th>
                <th data-field="image">Image</th>
                <th data-field="type">Type</th>
                <th data-field="dosage">Dosage</th>
                <th data-field="date_time" data-sort-order="desc" data-sortable="true" data-sort-name="id">Date/Time</th>
                <th data-field="date_time_groupby" data-visible="false">Date/Time</th>
                <th data-field="compliance">Compliance</th>
                <th data-field="food">Food</th>
                <th data-field="prn">PRN</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($LW_medication_entries as $index=>$medication)

                    <tr>
                        <td>{{$medication->id}}</td>
                <td wire:ignore><a href="#" wire:click="view({{$medication->id}})" class="item"> @if ($medication->photo)
                        <img height="50px" src="/storage/{{substr($medication->photo,7)}}" alt="image" class="imaged w64">
                    @else
                        <ion-icon name="medical" class="text-danger"></ion-icon>
                        @endif</a>
                </td>
                <td>{{$medication->medication_type}}</td>
                <td>{{$medication->dosage}}</td>
                <td>{{$medication->date_time}}</td>
                <td>{{substr($medication->date_time,0,10)}}</td>
                <td>{{$medication->compliance}}</td>
                <td>{{$medication->taken_with_food}}</td>
                <td>{{$medication->PRN}}</td>

            </tr>
                @endforeach
            </tbody>
        </table>

        @else
            <p>No Medication Entries</p>
        @endif

            {{ $LW_medication_entries->links() }}





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

        window.addEventListener('closeAddMedicationModal', event => {
            //$("#frmAddMedication").trigger('reset');

            $('#addModal').modal('hide')

        });

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

        });

        function test(key, entries) {
           //console.log (key);

           //console.log (entries);
           return ([key]);
        }

        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (el, component) => {
                console.log ('message processed');
               //console.log (el);
             //  console.log (component);
           // console.log ($('#el').bootstrapTable());

                $('#table').bootstrapTable(
                    {
                        search: true,
                    }
                );

             //  $('#table').bootstrapTable('append',{'id':999, 'image':'bob','type':'bob','dosage':'1','date_time':'2022-03-11', 'date_time_groupby':'2022-03-11', 'compliance':'1', 'food':'1', 'prn':'1'});

            })

               });
        $(document).ready(function() {
            var picker = new Pikaday({field: $('#date_time')[0]});

            //var $table = $('#table');
         //   $('#table').bootstrapTable();

           // $('#table').bootstrapTable('load',{'id':999, 'image':'bob','type':'bob','dosage':'1','date_time':'2022-03-11', 'date_time_groupby':'2022-03-11', 'compliance':'1', 'food':'1', 'prn':'1'});


        });
    </script>

</div>



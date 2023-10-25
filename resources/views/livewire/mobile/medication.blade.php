<div wire:ignore>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" ></script>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/pikaday.min.js"></script>-->
    <script src="/plugins/pikaday/pikaday.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/css/pikaday.min.css" integrity="sha512-yFCbJ3qagxwPUSHYXjtyRbuo5Fhehd+MCLMALPAUar02PsqX3LVI5RlwXygrBTyIqizspUEMtp0XWEUwb/huUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" />

    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.css" rel="stylesheet">

    <!-- Add Medication Dialog -->
    <div wire:ignore class="modal fade dialog" id="addModal" data-accordion="static" tabindex="-1" role="dialog"
         aria-labelledby="addModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-blue">
                    <span class="modal-title" id="mymodelLabel">Add Medication Entry</span>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Add Entry</button>
    </div>
{{--    <div id="entries" wire:poll.visible>--}}
    <div id="entries" wire:ignore>
        @if ($LW_medication_entries->count() > 0)



                @foreach ($LW_medication_entries->sortByDesc('date_time')->groupBy(function ($item, $key) {
                            return substr($item['date_time'],0,10);
                        }) as $index=>$medication)
                <ul class="listview image-listview media mb-2">
                    <li class="multi-level">
                        <a href="#" class="item">
                        {{$index}}
                        </a>
                        @foreach ($medication as $medication_entry)
                          @php
                          $user_entry = App\Models\User::where('id','=',$medication_entry->fk_UserID)->first();
                              @endphp
                            <ul wire:ignore.self class="listview link-listview">
                                <li>
                                    <a href="#" wire:click="view({{$medication_entry->id}})" class="item">
                                        <div wire:ignore class="imageWrapper">
                                            @if ($medication_entry->photo)
                                                <img src="/storage/{{substr($medication_entry->photo,7)}}" alt="image" class="imaged w64">
                                            @else
                                                <ion-icon name="medical" class="text-danger"></ion-icon>
                                            @endif
                                        </div>
                                        <div class="in">
                                            <div>
                                                {{$medication_entry->medication_type}} [{{$medication_entry->dosage}}]
                                                <div class="text-muted">Submitted at {{substr($medication_entry->date_time,11,5)}} by @if ($user_entry) {{$user_entry->name}} @else N/A @endif</div>
                                            </div>
                                            <span  class="text-muted">View</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </li>

                </ul>

                @endforeach
            </ul>
            {{-- $LW_medication_entries->links() --}}
        @else
            <p>No Medication Entries</p>
        @endif
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

            $('#addModal').modal('hide')
            window.location.hash = 'medicationTab';
            window.location.reload();


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

       $(document).ready(function() {
           var picker = new Pikaday({field: $('#date_time')[0]});
           picker.setDate (new Date());
           console.log ('ready - med mobile');


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



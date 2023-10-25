
<div class="container-fluid">
<div class="row">
    <!-- Include Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href=
    "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script>
        window.addEventListener('viewSRAModal', event => {
            //$("#frmAddMedication").trigger('reset');

            $('#viewModal_SRA').modal('show')


        });

        window.addEventListener('DateSaved', event => {
            //$("#frmAddMedication").trigger('reset');

            alert ('Date of Approved SRA Contract has been saved.');


        });

        window.addEventListener('closeSRAModal', event => {
            //$("#frmAddMedication").trigger('reset');

            $('#viewModal_SRA').modal('hide');
         //   window.location.hash = 'medicationTab';
         //   window.location.reload();
        });

        window.addEventListener('updateTinyMCE', event => {
          //  console.log (event);
            //tinymce.activeEditor.setContent('hi');
            tinymce.activeEditor.setContent(event.detail.htmlContent);
            alert ('Report has been generated.');
        });


        window.addEventListener('user_selected_empty_entry', event => {
            //  console.log (event);
            //tinymce.activeEditor.setContent('hi');
            alert ('Error: Please de-select empty entries prior to generating the report.');
            tinymce.activeEditor.setContent('Report has not been generated.');
        });

        window.addEventListener('no_entries_selected', event => {
            //  console.log (event);
            //tinymce.activeEditor.setContent('hi');
            alert ('Error: No entries selected.');
        });

        $( document ).ready(function() {
            $('#DateOfApprovedSRA').datepicker({
                format: 'yyyy-mm-dd'
            });
        });


    </script>
    <!-- View Medication Dialog -->
    <div  wire:ignore class="modal fade" id="viewModal_SRA" data-accordion="static" tabindex="-1" role="dialog"
         aria-labelledby="viewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-blue">
                    <span class="modal-title" id="mymodelLabel">View SRA Entry</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                   <div class="container-fluid">
                    <div class="row g-3">
                        <div class="form-group col">
                            <label for="interaction_with_staff">Interaction with Staff</label>
                            <textarea rows="12" cols="80" class="form-control" id="interaction_with_staff" wire:model="SRA_entry.interaction_with_staff"></textarea>

                        </div>

                    </div>


                            <div class="modal-footer">
                                <button type="submit" wire:click.prevent="submit" class="btn btn-primary">Save & Submit
                                </button>
                            </div>




                </div>


            </div>
        </div>
    </div>
    </div>
    <!-- *View Medication Dialog -->


    <div class="col-6 form-group">
        <b>Entries</b>

    <ul>
        @if (count($SRA_Form_entries)> 0)
            <form method="post" action="#">


                    @php
                        $groupedArray = array();

                    @endphp
                    @foreach ($SRA_Form_entries as $tmpkey=>$entry)
                        @php
                            if (is_array($entry)) {
                                $month = \Carbon\Carbon::parse($entry['start'])->format('M Y');
                            } else {
                            $month = \Carbon\Carbon::parse($entry->start)->format('M Y');

                            }
                            // echo $month;
                             $groupedArray[$month][] = $entry;

                        @endphp
                    @endforeach

                    @php
                       //  var_dump ($groupedArray);
                    @endphp

                <div wire:ignore class="accordion" id="accordionExample">

                @foreach ($groupedArray as $tmpkey=>$entry)
                        <div class="accordion-item">

                            <h2 class="accordion-header mb-0" id="heading_{{ str_replace(' ', '', $tmpkey)}}">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_{{str_replace(' ', '', $tmpkey)}}" aria-expanded="@if ($tmpkey == date('M Y')) true @else false @endif" aria-controls="collapse_{{str_replace(' ', '', $tmpkey)}}">
                                    {{$tmpkey}}
                                </button>
                            </h2>
                            <div id="collapse_{{str_replace(' ', '', $tmpkey)}}" class="accordion-collapse @if ($tmpkey == date('M Y'))  collapse show @else collapse @endif" aria-labelledby="heading_{{str_replace(' ', '', $tmpkey)}}" data-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($entry as $entrytmp)
                                        @if (is_array($entry))

                                            <input type="checkbox" class="chkbox_entry_{{$tmpkey}}" wire:model="selectedSRA.{{$entrytmp['id']}}" id="selectedSRA" value="@if (!$entrytmp['shift_form'])empty @else {{$entrytmp['id']}} @endif" > <a  @if (!$entrytmp['shift_form']) class="empty" @endif href="javascript:viewSRA('{{$entrytmp['id']}}')">{{$entrytmp['user']}}</a> - {{ Carbon\Carbon::parse($entrytmp['start'])->format("M d @ h:i A")}}<br>
                                        @else
                                            <input type="checkbox" class="chkbox_entry_{{$tmpkey}}"  wire:model="selectedSRA.{{$entrytmp->id}}"  id="selectedSRA" value="@if (!$entrytmp->shift_form)empty @else {{$entrytmp->id}} @endif"> <a href="javascript:viewSRA('{{$entrytmp->id}}')">{{$entrytmp->user}}</a> - {{ Carbon\Carbon::parse($entrytmp->start)->format("M d @ h:i A")}}<br>
                                        @endif

                                    @endforeach

                                </div>
                            </div>
                        </div>


                @endforeach
                </div>

                    <br>


                    <input type="button" wire:click="generate" value="Generate SRA Report from Selected Entries">


                </fieldset>
            </form>
        @endif

    </ul>
    </div>
    <div class="col-6">

        @livewire('s-r-a-notes', ['user' => Auth::user(), 'child' => $child,  ])

        <div class="form-group mt-5">

                <label for="DateOfApprovedSRA">Date of Approved SRA</label>


                    <input type="text" class="form-control" id="DateOfApprovedSRA" value="{{$child->DateOfApprovedSRA}}">

                <button class="float-right mt-2 mb-2" type="button" onclick="saveDateSRA();">Save Date</button>

        </div>
        @livewire('s-r-a-contracts', ['user' => Auth::user(), 'child' => $child,  ])


    </div>
    </div>
    <div wire:ignore>
               <textarea  id="SRA_test">
                    {{$this->html_template}}



               </textarea>
        <script type="text/javascript">
            $(document).ready(function(){


                tinymce.init({
                    selector: '#SRA_test',
                    height: 600,
                    theme: 'modern',
                    readonly: 0,
                    menubar: false,
                    toolbar: 'customSave | customPrint',
                    plugins: 'noneditable print',
                    noneditable_noneditable_class: "mceNonEditable",

                    //toolbar: 'customSave',
                    //toolbar2: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |',
                    //toolbar1: 'print preview',
                    //image_advtab: true,

                    setup: function(editor) {
                        editor.on('change', function(e) {
                            //console.log('The Editor has changed.');
                            // window.livewire.emit('editorChanged',tinymce.activeEditor.getContent());
                        });

                      /*  editor.ui.registry.addButton('customSave', {
                            text: 'Save SRA Report',
                            onAction: function (_) {
                                editor.insertContent('&nbsp;<strong>It\'s my button!</strong>&nbsp;');
                            }
                        });
                        */
                        editor.addButton('customSave', {
                            icon: 'save',
                            text: "Save Report",
                            onclick: function () {
                                $title = prompt("Please enter a title for this report");
                                if ($title) {
                                    Livewire.emitTo('s-r-a-reports', 'saveReport', '{{Auth::id()}}', '{{$child->id}}', $title, editor.getContent());
                                } else {
                                    alert ('Title cannot be blank, report not saved.');
                                }
                                /*
                                $.ajax({
                                    url: '{{route('MakeFromHTML')}}',
                                    data: { html: editor.getContent() },
                                    success: function (data) {

                                        var blob = new Blob([data], {type: 'application/pdf'});
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = "test.pdf";
                                        link.click();


                                    }


                                });
                                */
                            }
                        });

                        editor.addButton('customOpen', {
                            icon: 'browse',
                            text: "Open Report",
                            onclick: function () {
                                alert("My Button clicked!");
                            }
                        });

                        editor.addButton('customPrint', {
                            icon: 'print',
                            text: "Print",
                            onclick: function () {
                                tinymce.activeEditor.execCommand('mcePrint');
                            }
                        });

                        editor.addButton('customEmail', {
                            icon: 'link',
                            text: "Email",
                            onclick: function () {
                                alert("My Button clicked!");
                            }
                        });
                    },


                });

                // Add down arrow icon for collapse element which is open by default
                $(".collapse.show").each(function(){
                    $(this).prev(".card-header").find(".fa").addClass("fa-angle-down").removeClass("fa-angle-right");
                });

                // Toggle right and down arrow icon on show hide of collapse element
                $(".collapse").on('show.bs.collapse', function(){
                    $(this).prev(".card-header").find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
                }).on('hide.bs.collapse', function(){
                    $(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
                });

            });


            function saveDateSRA() {
                Livewire.emit('saveDateOfApprovedSRA', $('#DateOfApprovedSRA').val());

            }
        </script>

    </div>

</div>

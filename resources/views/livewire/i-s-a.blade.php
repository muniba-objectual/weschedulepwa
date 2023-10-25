
<div class="container-fluid">
<div class="row">
    <!-- Include Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href=
    "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script>


        window.addEventListener('DateSavedISA', event => {
            //$("#frmAddMedication").trigger('reset');

            alert ('Date of Approved ISA Contract has been saved.');


        });







        $( document ).ready(function() {
            $('#DateOfApprovedISA').datepicker({
                format: 'yyyy-mm-dd'
            });
        });

        function saveDateISA() {
            Livewire.emit('saveDateOfApprovedISA', $('#DateOfApprovedISA').val());

        }
    </script>

    <div class="col-12">

        @livewire('i-s-a-notes', ['user' => Auth::user(), 'child' => $child,  ])

        <div class="form-group mt-5 col-6">

                <label for="DateOfApprovedISA">Date of Approved ISA</label>


                    <input type="text" class="form-control" id="DateOfApprovedISA" value="{{$child->DateOfApprovedISA}}">

                <button class="mt-2 mb-2" type="button" onclick="saveDateISA();">Save Date</button>

        </div>
        @livewire('i-s-a-contracts', ['user' => Auth::user(), 'child' => $child,  ])


    </div>
    </div>

</div>

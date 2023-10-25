
<div class="container-fluid">
<div class="row">
    <!-- Include Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href=
    "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script>


        window.addEventListener('DateSavedCarpeDiem', event => {
            //$("#frmAddMedication").trigger('reset');

            alert ('Date of Approved Carpe Diem Contract has been saved.');


        });







        $( document ).ready(function() {
            $('#DateOfApprovedCarpeDiem').datepicker({
                format: 'yyyy-mm-dd'
            });
        });

        function saveDateCarpeDiem() {
            Livewire.emit('saveDateOfApprovedCarpeDiem', $('#DateOfApprovedCarpeDiem').val());

        }

    </script>

    <div class="col-12">

        @livewire('carpe-diem-notes', ['user' => Auth::user(), 'child' => $child,  ])

        <div class="form-group mt-5 col-6">

                <label for="DateOfApprovedCarpeDiem">Date of Approved Carp&eacute; Diem Contract</label>


                    <input type="text" class="form-control" id="DateOfApprovedCarpeDiem" value="{{$child->DateOfApprovedCarpeDiem}}">

                <button class="mt-2 mb-2" type="button" onclick="saveDateCarpeDiem();">Save Date</button>

        </div>
        @livewire('carpe-diem-contracts', ['user' => Auth::user(), 'child' => $child,  ])


    </div>
    </div>

</div>



<div class="container-fluid">
<div class="row">
    <!-- Include Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href=
    "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script>


        window.addEventListener('DateSavedPFA', event => {
            //$("#frmAddMedication").trigger('reset');

            alert ('Date of Approved PFA has been saved.');


        });







        $( document ).ready(function() {
            $('#DateOfApprovedPFA').datepicker({
                format: 'yyyy-mm-dd'
            });
        });

        function saveDatePFA() {
            Livewire.emit('saveDateOfApprovedPFA', $('#DateOfApprovedPFA').val());

        }

    </script>

    <div class="col-12">

        @livewire('p-f-a-notes', ['user' => Auth::user(), 'child' => $child,  ])

        <div class="form-group mt-5 col-6">

                <label for="DateOfApprovedPFA">Date of Approved PFA</label>


                    <input type="text" class="form-control" id="DateOfApprovedPFA" value="{{$child->DateOfApprovedPFA}}">

                <button class="mt-2 mb-2" type="button" onclick="saveDatePFA();">Save Date</button>

        </div>
        @livewire('p-f-a-contracts', ['user' => Auth::user(), 'child' => $child,  ])


    </div>
    </div>

</div>



@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Child Management</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>

                    <table class="table table-bordered yajra-datatable">

                       <thead>
                        <tr>
                            <th class="text-center">ID</th>

                            <th class="text-center">Initials</th>
                            <th class="text-center">Date of Birth</th>
                            <th class="text-center">Assigned Home</th>


                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@stop
@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                ajax: "{{ route('child.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'initials', name: 'initials'},
                    {data: 'DOB', name: 'DOB'},
                    {data: 'HomeRelationship', name: 'HomeRelationship'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });




        } );
    </script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Child</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label for="initials" class="col-form-label">Initials:</label>
                            <input type="text" class="form-control" id="initials">

                            <label for="DOB" class="col-form-label">Date of Birth:</label>
                            <input type="text" class="form-control" id="dob">

                            <label for="assigned_home" class="col-form-label">Assigned Home:</label>
                            <select class="form-control" name="assigned_home" id="assigned_home">

                                @foreach ($homes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            <label for="notes" class="col-form-label">Notes:</label>
                            <input type="textarea" class="form-control" id="notes">
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.



            $.ajax({
                type:'POST',
                url:"{{ route('ajaxRequest.post') }}",
                //data:{name:name, password:password, email:email},
                data:{id:recipient},
                success:function(data){
                    //alert(data);
                    //alert(data.id);

                    $(exampleModal).find('.modal-title').text('Edit Child')
                    document.getElementById('initials').value = data.initials
                    document.getElementById('dob').value = data.DOB
                    document.getElementById('assigned_home').value = data.fk_HomeID
                    document.getElementById('notes').value = data.notes

                }
            });



        })


    </script>
@stop

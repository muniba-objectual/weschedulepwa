<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    @if ($methed == "add")
        <x-slot name="title">Create New</x-slot>
    @elseif ($methed == "update")
        <x-slot name="title">Edit</x-slot>
    @endif

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <form role="form">
              <label>Name</label>
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="Name" aria-label="Name">
              </div>
              <label>Email</label>
              <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email" aria-label="Email">
              </div>
              <label>User Type</label>
             <div class="f-group mb-3">
                <select class="f-control f-dropdown w-100">
                  <option>Select User Type</option>
                </select>
              </div>
              <label>Password</label>
              <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" aria-label="Password">
              </div>
              <label>Notes</label>
              <div class="mb-3">
                <textarea class="form-control" placeholder="Notes" aria-label="Notes"></textarea>
              </div>
              @if ($methed == "add")
                <button type="button" class="float-right btn bg-gradient-dark w-60 w-md-20 w-lg-25 mb-2">Create</button>
              @elseif ($methed == "update")
                <button type="button" class="float-right btn bg-gradient-dark w-60 w-md-20 w-lg-25 mb-2">Update</button>
              @endif
            </form>
          </div>
        </div>
    </div>
</x-wire-elements-pro::bootstrap.modal>
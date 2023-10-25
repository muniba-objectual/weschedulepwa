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
                  <label>Child</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Child" aria-label="Child">
                  </div>
                  <label>Start Date</label>
                  <div class="mb-3">
                    <input type="date" class="form-control" placeholder="Start Date" aria-label="Start Date">
                  </div>
                  <label>End Date</label>
                  <div class="f-group mb-3">
                    <input type="date" class="form-control" placeholder="End Date" aria-label="End Date">
                  </div>
                  <label>Status</label>
                  <div class="f-group mb-3">
                    <select class="f-control f-dropdown w-100">
                      <option>Pending</option>
                    </select>
                  </div>
                  <label>Staff Assigned</label>
                  <div class="f-group mb-3">
                    <select class="f-control f-dropdown w-100">
                      <option>Bobby Handles</option>
                    </select>
                  </div>
                  <label>Date Created</label>
                  <div class="mb-3">
                    <input type="date" class="form-control" placeholder="Date Created" aria-label="Date Created">
                  </div>
                  <label>Date Updated</label>
                  <div class="f-group mb-3">
                    <input type="date" class="form-control" placeholder="Date Updated" aria-label="Date Updated">
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
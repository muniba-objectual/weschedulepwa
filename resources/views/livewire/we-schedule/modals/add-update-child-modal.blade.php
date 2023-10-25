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
                  <label>Initials</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Initials" aria-label="Initials">
                  </div>
                  <label>Date of Birth</label>
                  <div class="mb-3">
                    <input type="date" class="form-control" placeholder="Date of Birth" aria-label="Date of Birth">
                  </div>
                  <label>Notes</label>
                  <div class="f-group mb-3">
                    <input type="text" class="form-control" placeholder="Notes" aria-label="Notes">
                  </div>
                  <label>SRA</label>
                  <div class="mb-3">
                    <select class="f-control f-dropdown w-100">
                      <option>Yes</option>
                      <option>No</option>
                    </select>
                  </div>
                  <label>Assigned Home</label>
                  <div class="f-group mb-3">
                    <input type="text" class="form-control" placeholder="Assigned Home" aria-label="Assigned Home">
                  </div>
                  <div class="d-flex justify-content-end mt-3">
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item">
                          <a class="page-link" href="javascript:;" aria-label="Previous">
                            <i class="fa fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="javascript:;">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="javascript:;" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                  <label>We-Schedule Enabled</label>
                  <div class="mb-3">
                    <select class="f-control f-dropdown w-100">
                      <option>Yes</option>
                      <option>No</option>
                    </select>
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
<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">Identifying Information</x-slot>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <label class="form-label text-md">Name</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Name" required="required">
            </div>
            <label class="form-label text-md mt-3">Date of Birth</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="date" placeholder="Date of Birth" required="required">
            </div>
            <label class="form-label text-md mt-3">Date of Adoption</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="date" placeholder="Date of Adoption" required="required">
            </div>
            <label class="form-label text-md mt-3">C.S.W.</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="C.S.W." required="required">
            </div>
            <label class="form-label text-md mt-3">Branch</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Branch" required="required">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn bg-gradient-primary">Save changes</button>
          </div>
        </div>
      </div>
</x-wire-elements-pro::bootstrap.modal>
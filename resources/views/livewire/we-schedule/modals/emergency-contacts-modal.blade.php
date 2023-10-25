<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">Emergency Contacts</x-slot>

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <label class="form-label text-md">Foster Parent Name</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Foster Parent Name"
                required="required">
            </div>
            <label class="form-label text-md mt-3">Foster Parent Address</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Foster Parent Address"
                required="required">
            </div>
            <label class="form-label text-md mt-3">Foster Parent Contact</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Foster Parent Contact"
                required="required">
            </div>
            <label class="form-label text-md mt-3">Case Manager</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Case Manager" required="required">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn bg-gradient-primary">Save changes</button>
          </div>
        </div>
      </div>
</x-wire-elements-pro::bootstrap.modal>
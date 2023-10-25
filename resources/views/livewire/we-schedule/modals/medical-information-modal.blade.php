<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">Medical Information</x-slot>

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <label class="form-label text-md">Health Card #</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Health Card #" required="required">
            </div>
            <label class="form-label text-md mt-3">Physician</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Physician" required="required">
            </div>
            <label class="form-label text-md mt-3">Allergies</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Allergies" required="required">
            </div>
            <label class="form-label text-md mt-3">Food Restrictions</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Food Restrictions"
                required="required">
            </div>
            <label class="form-label text-md mt-3">Medical Condition (if applicable)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Medical Condition (if applicable)"
                required="required">
            </div>
            <label class="form-label text-md mt-3">Medication (if applicable)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Medication (if applicable)"
                required="required">
            </div>
            <label class="form-label text-md mt-3">PRN's</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="PRN's" required="required">
            </div>
            <label class="form-label text-md mt-3">Diagnosed With</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="Diagnosed With" required="required">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn bg-gradient-primary">Save changes</button>
          </div>
        </div>
      </div>
</x-wire-elements-pro::bootstrap.modal>
<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">Other Information</x-slot>

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <label class="form-label text-md">Risk of Injury/Behavior (Purpose of safety plan)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="" required="required">
            </div>
            <label class="form-label text-md mt-3">Description of Specific Behavior(s)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="" required="required">
            </div>
            <label class="form-label text-md mt-3">Triggers (Known factors that will increase the probability of
              impulsivity, anxiety, or aggressive behavior)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="" required="required">
            </div>
            <label class="form-label text-md mt-3">Indicators (Physical signs/cues that the youth is about to become
              aggressive or assaultive)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="" required="required">
            </div>
            <label class="form-label text-md mt-3">Non-Physical Responses (Provide non-physical intervention/strategies to
              be used to de-escalate the youth & situation)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="" required="required">
            </div>
            <label class="form-label text-md mt-3">Physical Responses (Provide physical intervention/strategies to be used
              to de-escalate the youth & situation)</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="" required="required">
            </div>
            <label class="form-label text-md mt-3">Additional Information</label>
            <div class="input-group">
              <input name="firstName" class="form-control" type="text" placeholder="" required="required">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn bg-gradient-primary">Save changes</button>
          </div>
        </div>
      </div>
</x-wire-elements-pro::bootstrap.modal>
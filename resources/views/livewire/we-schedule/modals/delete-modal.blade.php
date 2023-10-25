<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">Delete</x-slot>

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            Are you sure you wish to delete 1 row?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary">Cancel</button>
            <button type="button" class="btn bg-gradient-primary">Delete</button>
          </div>
        </div>
      </div>
</x-wire-elements-pro::bootstrap.modal>
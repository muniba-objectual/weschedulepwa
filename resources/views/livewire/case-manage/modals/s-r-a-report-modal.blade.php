<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">SRA Report</x-slot>

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img src="{{ asset('img/invoice.png') }}" class="w-100" />
          </div>
        </div>
      </div>
</x-wire-elements-pro::bootstrap.modal>
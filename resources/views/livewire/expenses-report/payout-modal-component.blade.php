<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="false">
    <x-slot name="title">Payout</x-slot>

    <x-slot name="headerButtons">
        <button type="button" class="btn btn-primary" wire:click="saveChanges">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-offset-2">
                <b>Payout Amount:</b> <br>
                <b>Breakdown:</b> {{$payout->amount}} [ Cards: {{ $companyCardTotal }} + Other: {{ $otherTotal }} ] <br>
                <b>Payout To:</b> {{$payout->paidToUser->name}}<br>

                @if($payout->status == \App\Models\ExpensePayout::STATUS__PAID)
                    <b>Paid at:</b> {{ $payout->paid_at->format('Y-m-d H:i A') }}
                @endif
            </div>
        </div>
    </div>

    <x-slot name="buttons">
        @unless($payout->status == \App\Models\ExpensePayout::STATUS__PAID)
            <a class="btn btn-success" wire:click="payoutNow()" href="#">Mark as paid</a>
        @endunless
    </x-slot>

</x-wire-elements-pro::bootstrap.modal>

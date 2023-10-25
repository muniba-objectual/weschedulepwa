<div>
    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">{{$this->editingPlacementId?'Editing the':'Add A'}} {{ucwords($placementType)}} Placement</x-slot>
        <form>
            <div class="form-group">
                <label for="fromDate">From Date:</label>
                <input type="date" wire:model="fosterPlacement.from_date" class="form-control @error('fosterPlacement.from_date') is-invalid @enderror">
                @error('fosterPlacement.from_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="toDate">To Date <i>(Optional)</i>:</label>
                <input type="date" wire:model="fosterPlacement.to_date" class="form-control @error('fosterPlacement.to_date') is-invalid @enderror">
                @error('fosterPlacement.to_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="selectedFosterParent">Foster Parent:</label>
                <select wire:model="fosterPlacement.fk_FosterUserID" class="form-control @error('fosterPlacement.fk_FosterUserID') is-invalid @enderror" placeholder="Select Foster Parent">
                    <option value=''>Select Foster Parent</option>
                    @foreach ($fosterFamilies as $fosterFamily)
                        <option value="{{$fosterFamily->id}}">{{$fosterFamily->name}}</option>
                    @endforeach
                </select>
                @error('fosterPlacement.fk_FosterUserID') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </form>

        <x-slot name="buttons">
            <button type="button" class="btn btn-primary" wire:click.prevent="add">
                {{$this->editingPlacementId?'Update':'Add'}} {{ucwords($placementType)}} Placement
            </button>
        </x-slot>
    </x-wire-elements-pro::bootstrap.modal>
</div>

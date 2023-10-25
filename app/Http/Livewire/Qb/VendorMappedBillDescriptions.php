<?php

namespace App\Http\Livewire\Qb;

use App\Models\VendorAccountPredictionList;
use Livewire\Component;

class VendorMappedBillDescriptions extends Component
{
    public bool $canDelete;

    public function mount(): void
    {
        $this->canDelete = auth()->user()->user_type == 10.0;
    }

    public function render()
    {
        $billTitles = VendorAccountPredictionList::query()
            ->with('vendor')
            ->get()
            ->groupBy('alternative_vendor_name');

        return view('livewire.qb.vendor-mapped-bill-descriptions', compact('billTitles'));
    }

    public function deleteVendorMapping(int $vendorId)
    {
        VendorAccountPredictionList::query()->whereId($vendorId)->delete();
    }
}

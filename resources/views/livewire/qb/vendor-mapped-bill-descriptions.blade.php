<?php
    /** @var \App\Models\VendorAccountPredictionList[]|\Illuminate\Support\Collection $billTitleGroup */
?>

<div>
    <style>
        .bill-description-node td {
            border-top: solid black 1px;
        }

        .table-row-borderless td {
            border: none;
        }
    </style>


    <div class="row">
        <div class="col-12">
            <table class="table table-responsive table-borderless">
                <thead>
                    <tr>
                        <th>Bill Description</th>
                        <th>Mapped Vendor Name</th>
                        <th>Hits</th>
                        @if($canDelete)
                            <th>#</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($billTitles as $alternative_vendor_name => $billTitleGroup)
                        <tr class="bill-description-node">

                            <td>{{$alternative_vendor_name}}</td>

                            <?php
                                $billTitleGroup = $billTitleGroup
                                    ->sortBy(function ($vendor) {
                                        return [-$vendor->hits, -$vendor->updated_at->timestamp];
                                    });
                                $z = count($billTitleGroup);
                            ?>
                            @foreach($billTitleGroup as $i => $billDescription)
                                    <td>{{$billDescription->vendor->DisplayName}}</td>
                                    <td>{{$billDescription->hits}}</td>
                                    @if($canDelete)
                                        <td><button wire:click="deleteVendorMapping({{ $billDescription->id }})" class="btn btn-danger btn-sm">Delete</button></td>
                                    @endif

                                @if($i < $z)
                                    </tr>
                                    <tr>
                                        <td></td>
                                @endif

                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

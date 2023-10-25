<?php

namespace App\Http\Controllers\Qb;

use App\Http\Controllers\Controller;
use App\Models\QBVendor;
use Illuminate\Http\Request;

class QbVendorController extends Controller
{
    use QbApiCore;

    public function index()
    {
        $vendors = QBVendor::all();
        return view('qb.vendors-accounts.all-vendors', compact('vendors'));
    }

    public function listDuplicates()
    {
        $duplicates = QBVendor::getDuplicates();
        return view('qb.vendors-accounts.duplicated-account-numbers', compact('duplicates'));
    }

    public function sync(Request $request = null, \Illuminate\Console\Command $command = null)
    {
        $this->syncQbCollection(
            'QB-Vendor',
            "SELECT * FROM Vendor",
            (function(&$vendor){
                return QBVendor::updateOrCreate(
                    ['Id' => $vendor->Id],
                    [
                        'SyncToken' => $vendor->SyncToken,
                        'DisplayName' => $vendor->DisplayName,
                        'AcctNum' => empty(trim($vendor->AcctNum)) ? null : $vendor->AcctNum,
                    ]
                );
            }),
            true,
            $request,
            $command
        );
    }
}

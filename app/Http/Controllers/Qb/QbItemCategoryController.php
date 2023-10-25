<?php

namespace App\Http\Controllers\Qb;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class QbItemCategoryController extends Controller
{
    use QbApiCore;

    public function index()
    {
        return view('qb.item-categories.all-categories');
    }

    public function sync(Request $request = null, \Illuminate\Console\Command $command = null)
    {
        $this->syncQbCollection(
            'QB-Item-Category',
            "SELECT * FROM Account",
            (function(&$account){
                if(
                    !$account->AcctNum //skip accounts without account numbers
                    || array_search($account->Classification, config('quickbooks.credit-card-classification')) !== false //skip credit cards
                ){
                    return null; //skip if no account-number is set!
                }

                return ExpenseCategory::updateOrCreate(
                    ['id' => $account->AcctNum],
                    [
                        'qb_account_id'     => $account->Id,
                        'name'              => $account->Name,
                        'qb_account_type'   => $account->Classification,
                        'qb_sync_token'     => $account->SyncToken,
                    ]
                );
            }),
            true,
            $request,
            $command
        );
    }
}

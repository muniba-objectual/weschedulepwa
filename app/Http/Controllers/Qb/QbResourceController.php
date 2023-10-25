<?php

namespace App\Http\Controllers\Qb;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use App\Models\Expenses;
use App\Models\QuickbooksSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use QuickBooksOnline\API\Core\CoreConstants;
use QuickBooksOnline\API\Facades\Purchase;

class QbResourceController extends Controller
{
    use QbApiCore;

    public function purchase(Expenses &$expense){

        $debug = false;
        $tokenDebugTracker = 'token:'.random_int(1,100).'--';

        //Vendor Account
        $vendorReference_Id     = $expense->vendor_id;
        $vendorReference_name   = $expense->vendor_name;

        //CreditCard Account
        $creditCardAccountId    = $expense->creditCard->qb_account_id;
        $creditCardAccountName  = $expense->creditCard->qb_account_type; //rename the variable

        //Prepare the memo
        $memoArrayData = [
            'CreatedThrough' => 'CaseManage',
            'PaymentApprovedBy' => auth()->user()->name,
            'ExpenseCreatedAt' => $expense->created_at,
            'ExpenseId' => $expense->id,

        ];
        foreach ($memoArrayData as $key => &$val){
            $val = "`".$key."` : `".$val."`"; //2wise escape quotes, since we are json_decoding once again before parsing
        }
        $memoArrayData = implode(', ', $memoArrayData);
        $memo = ($debug?$tokenDebugTracker:'').$memoArrayData;

        $config = QuickbooksSetting::all()->keyBy('name');

        //FixedConfiguration
        $PaymentMethodRef = $expense->payment_type == Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD?
            $config->get(QuickbooksSetting::key_cardPaymentMethodReference)->value:
            $config->get(QuickbooksSetting::key_cashPaymentMethodReference)->value;

        $dynamicTaxRateRef = $config->get(QuickbooksSetting::key_dynamicTaxRateReference)->value;

        $lineItemTaxCodeRef = $config->get(QuickbooksSetting::key_lineItemTaxCodeReference)->value;

        $currencyID = $config->get(QuickbooksSetting::key_currencyId)->value;


        /** @var ExpenseCategory $categoryInstance */
        $expenseCategories = ExpenseCategory::all()->keyBy('id');

        $currency = '
        "CurrencyRef": {
             "value": "'.$currencyID.'"
        },
        ';

        $lineItemTax = ',
           "TaxCodeRef": {
                "value": "'.$lineItemTaxCodeRef.'"
           }
        ';

//        $dynamicTax = ',
//        "GlobalTaxCalculation": "TaxExcluded",
//        "TxnTaxDetail": {
//         "TotalTax": '.$expense->HST.',
//         "TaxLine": [
//          {
//           "Amount": '.$expense->HST.',
//           "DetailType": "TaxLineDetail",
//           "TaxLineDetail": {
//            "TaxRateRef": {
//             "value": "11"
//            },
//            "PercentBased": true,
//            "TaxPercent": 13,
//            "NetAmountTaxable": '.$expense->total.'
//           }
//          }
//         ]
//        }
//        ';

        $dynamicTax = ',
        "GlobalTaxCalculation": "TaxExcluded",
        "TxnTaxDetail": {
         "TotalTax": '.$expense->HST.',
         "TaxLine": [
          {
           "Amount": '.$expense->HST.',
           "DetailType": "TaxLineDetail",
           "TaxLineDetail": {
            "TaxRateRef": {
             "value": "'.$dynamicTaxRateRef.'"
            },
            "PercentBased": false,
            "NetAmountTaxable": '.$expense->subtotal.'
           }
          }
         ]
        }
        ';


        $jsonItemArray = [];
        $billItemCategories = [$expense->category_id]; //TODO:: will be multi category in future
        $categoryCount = count($billItemCategories);
        foreach ($billItemCategories as $categoryId){
            $itemTotal = $expense->subtotal/$categoryCount;
            $categoryInstance = $expenseCategories->get($categoryId);
            $description = "Grouped {$categoryInstance->name} items";

            $jsonItemArray[] = '
            {
              "DetailType": "AccountBasedExpenseLineDetail",
              "Amount": '.$itemTotal.',
              "Description": "'.$description.'",
              "AccountBasedExpenseLineDetail": {
                "AccountRef": {
                  "name": "'.$categoryInstance->name.'",
                  "value": "'.$categoryInstance->qb_account_id.'"
                }
                '.$lineItemTax.'
              }
            }
            ';
        }

        $payload = '
        {
          '.$currency.'
          "AccountRef": {
            "name": "'.$creditCardAccountName.'",
            "value": "'.$creditCardAccountId.'"
          },
          "PaymentMethodRef": {
            "value": "'.$PaymentMethodRef.'"
          },
          "PaymentType": "CreditCard",
          "EntityRef": {
             "value": "'.$vendorReference_Id.'",
             "name": "'.$vendorReference_name.'"
          },
          "TotalAmt": '.($expense->total).',
          "PrivateNote": "'.$memo.'",
          "Line": [
            '.implode(", ", $jsonItemArray).'
          ]
          '.$dynamicTax.'
        }
        ';


        $qbConnection = $this->initQbConnection();
        if ($qbConnection instanceof RedirectResponse) {
            // Redirect to the intended URL
            return $qbConnection;
        }

        $obj = $this->dataService->add(
            Purchase::create(json_decode($payload, true))
        );
        $this->handleError(true, $error);

        if($obj){
            $expense->qb_payment_id = $obj->Id;
            $expense->qb_purchase_is_sandbox = config('app.quickbooks_base_url') == CoreConstants::DEVELOPMENT_SANDBOX;
            $expense->save();
        }

        if($debug){
            dd($tokenDebugTracker, json_decode($payload, true), $obj, $error);
        }

        //        \QuickBooksOnline\API\Data\IPPPurchase::class;
    }


    /**
     * Load customer from QuickBooks.
     *
     * @return RedirectResponse|JsonResponse
     */
    public function loadCustomers(): RedirectResponse|JsonResponse
    {
        $qbConnection = $this->initQbConnection();
        if ($qbConnection instanceof RedirectResponse) {
            // Redirect to the intended URL
            return $qbConnection;
        }

        try {

            // Query the customers using the Customer entity
            $customers = $this->dataService->Query("SELECT * FROM Customer");
            $this->handleError();

            // Process the customers
            $customerData = [];
            foreach ($customers ?? [] as $customer) {
                $customerData[] = [
                    'id' => $customer->Id,
                    'name' => $customer->DisplayName,
                    // Add more fields as needed
                ];
            }

            // Return the customer data
            return response()->json(['customers' => $customerData]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Load vendors from QuickBooks.
     *
     * @return RedirectResponse|JsonResponse
     */
    public function loadVendors(): \Illuminate\Http\RedirectResponse | \Illuminate\Http\JsonResponse
    {
        $qbConnection =  $this->initQbConnection();
        if ($qbConnection instanceof RedirectResponse) {
            // Redirect to the intended URL
            return $qbConnection;
        }

        //this block will be changing
        try {
            // Query the vendors using the Vendor entity
            $vendors = $this->dataService->Query("SELECT * FROM Vendor");
            $this->handleError();

            // Process the vendors
            $vendorData = [];
            foreach ($vendors??[] as $vendor) {
                $vendorData[] = [
                    'id' => $vendor->Id,
                    'name' => $vendor->DisplayName,
                    // Add more fields as needed
                ];
            }

            // Return the vendor data
            return response()->json(['vendors' => $vendorData]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Load accounts from QuickBooks.
     *
     * @return RedirectResponse|JsonResponse
     */
    public function loadAccounts(): \Illuminate\Http\RedirectResponse | \Illuminate\Http\JsonResponse
    {
        $qbConnection =  $this->initQbConnection();
        if ($qbConnection instanceof RedirectResponse) {
            // Redirect to the intended URL
            return $qbConnection;
        }


        try {
            // Query the accounts using the Account entity
            $accounts = $this->dataService->Query("select * from Account");
            $this->handleError();

            // Process the accounts
            $accountData = [];
            foreach ($accounts ?? [] as $account) {
                $accountData[] = [
                    'id' => $account->Id,
                    'name' => $account->Name,
                    // Add more fields as needed
                ];
            }

            // Return the account data
            return response()->json(['accounts' => $accountData]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function dashboard(){
        return view('qb.dashboard');
    }

    public function uploadPurchaseBillAsAttachment(Expenses &$expense)
    {
        set_time_limit(600); //uploads can take time
        ini_set('memory_limit', '500M'); // Set memory limit to 100 megabytes, file max siz allowed is 100MB

        $debug = false; //TODO::ashain, comment|false b4 committing

        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $mediaFile*/
        $mediaFile = $expense->getFirstMedia("Expenses");

        //$niceFileName = $mediaFile->file_name;
        $niceFileName = "InvNo {$expense->qb_payment_id}, TakenAt {$expense->created_at->format('Y.m.d.H.i')}, By {$expense->getUser->name}.{$mediaFile->extension}";

        //TODO::optimize/compress
        $mediaUrl = $mediaFile->getUrl();

        //tempy image URL fix
        //$mediaUrl = str_replace('http://localhost:8000/', 'https://casemanage.ca' . '/', $mediaUrl);


        // Prepare the attachment metadata
        $attachmentData = new \QuickBooksOnline\API\Data\IPPAttachable([
            'FileName'          => $niceFileName,
            'Note'              => 'Bill photo for the purchase', // Optional note
            'AttachableRef'     => new \QuickBooksOnline\API\Data\IPPAttachableRef([
                                        'IncludeOnSend'     => true,
                                        'EntityRef'         => new \QuickBooksOnline\API\Data\IPPReferenceType([
                                                                    'type'  => 'Purchase',
                                                                    'value' => $expense->qb_payment_id,
                                                                ]),
                                    ])
        ]);


        //Init dataService if not already initialized
        if(!isset($this->dataService)){
            $qbConnection =  $this->initQbConnection();
            if ($qbConnection instanceof RedirectResponse) {
                // Redirect to the intended URL
                return $qbConnection;
            }
        }


        // Upload the attachment using the Upload function
        $result = $this->dataService->Upload(
            base64_encode(file_get_contents($mediaUrl)),
            $niceFileName,
            $mediaFile->mime_type,
            $attachmentData
        );

        // Handle the result
        if ($result->Fault) {
            if($debug){
                dd($result);
            }
        } else {
            $expense->qb_attachment_id = $result->Attachable->Id;
            $expense->save();
        }
    }

}

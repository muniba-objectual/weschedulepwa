<?php

namespace App\CustomClasses\BillUploadWizard;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Models\Expenses;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Spatie\LivewireWizard\Components\StepComponent;

class ExpensesForm_UploadReceiptStep extends StepComponent
{
    use WithFileUploads;
    use LivewireAlert;
    use ExpenseCore;

    public $user;
    public $homes;

    public $expenses;
    public $upload;

    public $receipt;
    public $receiptTmpPath;
    public $OCR_ResultID;

    protected $rules = [
        'expenses.datetime' => 'nullable',
        'upload' => 'nullable',
    ];


    public function updatedUpload() {

        $this->validate([
            'upload' => 'required', // 1MB Max
        ]);


        $tmpFile = $this->upload->store('tmpExpenseUpload');


        DebugBar::info($tmpFile);
        $this->receiptTmpPath = $tmpFile;
        $this->alert('info', 'Performing OCR...', ['position' => 'center', 'timer' => 3000, 'toast'=>true]);

        sleep(1);
        $this->performOCR();

        $this->getOCRResults();

    }



    public function stepInfo(): array
    {
        return [
            'label' => 'Upload Receipt',
//            'icon' => '',
        ];
    }

    public function saveUpload() {
        $this->nextStep();
    }



    public function mount() {

        $this->initExpenseConfig();

        if(!$this->hasMobileExpenseCreateForm){
            abort(403, 'You don`t have this feature enabled.');
        }

//        $this->performOCR();
//        $this->getOCRResults();

        $this->expenses = new Expenses();
        $this->expenses->datetime = date('m/d/Y H:i');
//DebugBar::info ($this->state());
        clock()->info($this->state());
    }

    public function performOCR() {


//        dd (pathinfo(storage_path("app") . "/" . $this->receiptTmpPath, PATHINFO_EXTENSION));

//        $tmp = fopen(storage_path('app') . "/" . $this->receiptTmpPath,'r');

//    dd('http://99.231.251.24/storage/' . substr($this->receiptTmpPath,7));
        clock()->info("Uploading for OCR...");

        $response = Http::withHeaders(
            [
                "Content-Type" => "application/json",
                "Ocp-Apim-Subscription-Key" => "8bfd3da05c3340b4ad4bd12ef66f97f0",

            ]
        )
            ->post('https://cmws-receiptocr.cognitiveservices.azure.com/formrecognizer/documentModels/prebuilt-receipt:analyze?api-version=2022-08-31', [
//            'urlSource' => 'https://raw.githubusercontent.com/Azure-Samples/cognitive-services-REST-api-samples/master/curl/form-recognizer/rest-api/receipt.png'
//            'urlSource' => 'https://expensesreceipt.com/assets/img/standard-grocery-receipt-template.png?ver=1.231'
//            'urlSource' => 'https://www.nutemplates.com/wp-content/uploads/costco-receipt-example2.jpg'
//        'urlSource' => 'http://99.231.251.24/storage/app/' . substr($this->receiptTmpPath,7)
                'base64Source' => base64_encode(file_get_contents(storage_path('app') . "/" . $this->receiptTmpPath))
            ]);

//        curl -v -i POST "https://cmws-receiptocr.cognitiveservices.azure.com/formrecognizer/documentModels/prebuilt-receipt:analyze?api-version=2022-08-31" -H "Content-Type: application/json" -H "Ocp-Apim-Subscription-Key: 8bfd3da05c3340b4ad4bd12ef66f97f0" --data-ascii "{'urlSource': 'https://raw.githubusercontent.com/Azure-Samples/cognitive-services-REST-api-samples/master/curl/form-recognizer/rest-api/receipt.png'}"

        $resultID = null;
        if ($response->status() == "202") {
            //get ID from header
            $resultIDHeader = $response->header('Operation-location');
//            "https://cmws-receiptocr.cognitiveservices.azure.com/formrecognizer/documentModels/prebuilt-receipt/analyzeResults/b751fc7e-896b-4b04-b001-1b664859a5ae?api-version=2022-08-31"
            $resultID =  (substr($resultIDHeader,strpos($resultIDHeader,"analyzeResults/") + 15));
            $resultID = substr($resultID,0,strpos($resultID,"?"));
            $this->OCR_ResultID = $resultID;
            /*            DebugBar::addMessage($resultID);*/
            clock()->info($resultID);
        }



    }

    public function getOCRResults()
    {

//        get results of Analysis
//                curl -v -i POST "https://cmws-receiptocr.cognitiveservices.azure.com/formrecognizer/documentModels/prebuilt-receipt/analyzeResults/eecbed5b-d834-4e8e-b655-15ebab20ed42?api-version=2022-08-31" -H "Content-Type: application/json" -H "Ocp-Apim-Subscription-Key: 8bfd3da05c3340b4ad4bd12ef66f97f0"

        clock()->info("Sending for OCR parsing...");
        do {
            clock()->info("Sleeping for 2...");
            sleep(2);

            $response = Http::withHeaders(
                [
                    "Content-Type" => "application/json",
                    "Ocp-Apim-Subscription-Key" => "8bfd3da05c3340b4ad4bd12ef66f97f0",

                ]
            )->get('https://cmws-receiptocr.cognitiveservices.azure.com/formrecognizer/documentModels/prebuilt-receipt/analyzeResults/' . $this->OCR_ResultID . '?api-version=2022-08-31');
            $result =  ($response->json());
            clock()->info("Result status: " . $result['status']);


        }

        while ($result['status'] != "succeeded");


        //$result contains array
//        dd ($result);
//        if (isset($result['status'])) {
//            if ($result['status'] == "succeeded")  {

//            dd ($result['analyzeResult']);
        $receiptResponse = isset($result['analyzeResult']['documents'][0]) ? $result['analyzeResult']['documents'][0] : "";
//        dd ($receiptResponse);
//dd ($receiptResponse['fields']['TaxDetails']['valueArray'][0]['valueObject']['Amount']['content']);


        //get TAX
        $tax = 0.00;
        if (isset($receiptResponse['fields']['TotalTax']['valueNumber'])) {
            $tax = $receiptResponse['fields']['TotalTax']['valueNumber'];
        } elseif (isset($receiptResponse['fields']['TaxDetails']['valueArray'])) {
//            [0]['valueObject']['Amount']['content']))
            $taxArray = $receiptResponse['fields']['TaxDetails']['valueArray'];
            foreach ($taxArray as $taxDetails) {
                if (isset($taxDetails['valueObject']['Amount']['valueCurrency']['amount'])) {
                    $tax = $taxDetails['valueObject']['Amount']['valueCurrency']['amount'];
                } else {
                    $tax = 0.00;
                }
            }
        }

        $receipt = [
            "TxnDate" => isset($receiptResponse['fields']['TransactionDate']['valueDate']) ? $receiptResponse['fields']['TransactionDate']['valueDate'] : "N/A" ,
            "TxnTime" => isset($receiptResponse['fields']['TransactionTime']['valueTime']) ? $receiptResponse['fields']['TransactionTime']['valueTime'] : "N/A",

            "Merchant" => isset($receiptResponse['fields']['MerchantName']['valueString']) ? $receiptResponse['fields']['MerchantName']['valueString'] : "N/A",
            "MerchantAddress" => isset($receiptResponse['fields']['MerchantAddress']['content']) ? $receiptResponse['fields']['MerchantAddress']['content'] : "N/A" ,
            "MerchantPhone" => isset($receiptResponse['fields']['MerchantPhoneNumber']['content']) ? $receiptResponse['fields']['MerchantPhoneNumber']['content'] : "N/A",
            "SubTotal" => isset($receiptResponse['fields']['Subtotal']['valueNumber']) ? $receiptResponse['fields']['Subtotal']['valueNumber'] : "0.00",
            "Total" => isset($receiptResponse['fields']['Total']['valueNumber']) ? $receiptResponse['fields']['Total']['valueNumber'] : "0.00",
            "Tax" => $tax,
            "Items" => isset($receiptResponse['fields']['Items']['valueArray']) ? $receiptResponse['fields']['Items']['valueArray'] : "N/A"

        ];
//        dd ($receipt);
//                clock()->info("Receipt is: " . implode(",",$receipt));
        clock()->info (json_encode($receipt));
//              dd(json_encode($receipt));

        $this->receipt = $receipt;
        $this->alert('success', 'OCR Analysis Complete', ['position' => 'center', 'timer' => 3000]);
        $this->dispatchBrowserEvent("OCR_Complete");
//        $this->alert('success', 'OCR Analysis Complete');


//        dd($receipt);
    }


    public function render()
    {
        return view ('livewire.forms.ExpensesForm_step1');
    }


}

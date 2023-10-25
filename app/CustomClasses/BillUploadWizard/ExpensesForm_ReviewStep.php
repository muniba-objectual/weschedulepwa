<?php

namespace App\CustomClasses\BillUploadWizard;

use App\Models\ExpenseCategory;
use App\Models\Expenses;
use Spatie\LivewireWizard\Components\StepComponent;

class ExpensesForm_ReviewStep extends StepComponent
{

    public $user;
    public $receipt;
    public $expenses;
    public bool $manualDataEntryMode = false;
    public $expenseCategories;
    public $paymentSources = [
        0 => Expenses::PAYMENT_METHOD__UNSPECIFIED //default payment method
    ];
    public $setDefaultCategory = null;

    protected $rules = [
        "expenses.description" => "nullable", //Merchant Name
        "expenses.payment_source" => "required",

        "expenses.HST" => "nullable",
        "expenses.total" => "nullable",
        "expenses.subtotal" => "nullable",

        "expenses.line_items.*.item" => "nullable",
        "expenses.line_items.*.category" => "nullable",
        "expenses.line_items.*.qty" => "nullable",
        "expenses.line_items.*.price" => "nullable",
        "expenses.line_items.*.total" => "nullable",

//        "tmpExpenses.*.qty" => "nullable",
//        "tmpExpenses.*.price" => "nullable",
//        "tmpExpenses.*.total" => "nullable",

    ];

    protected $listeners = [
        'refreshMe' => '$refresh',
        'updateCategory' => 'updateCategory'
    ];

    public function updateCategory($key, $value) {

        $tmpExpenses = $this->expenses->line_items;

        foreach ($tmpExpenses as $tmpKey=>$items) {
            if ($tmpKey == $key) {
                $tmpExpenses[$key]['category'] = $value;
            }
        }

        $this->expenses->line_items = $tmpExpenses;
    }


    public function stepInfo(): array
    {
        return [
            'label' => 'Review',
//            'icon' => '',
        ];
    }


    public function mount() {

        //attach user's credit cards to the payment source list
        $this->paymentSources = $this->paymentSources + auth()->user()->creditCards->pluck('friendly_identifier', 'id')->toArray();

        $this->expenseCategories = ExpenseCategory::pluck('name', 'id');

        $this->receipt = $this->state()->forStep("UploadReceipt")['receipt'];

        //build `line_items` | correct it, cast to array if 'N/A'.
        if( is_string($this->receipt['Items']) ){
            $this->manualDataEntryMode = true;
            $this->receipt['Items'] = [];
        }

        //if navigated back
        $expenseDataFromNextPage = $this->state()->forStep("Linking")['expenses'] ?? null;

        //Build expense from next_page->expenses (if returning from back)
        // else take data from previous slide receipt parameter.
        $this->expenses = new Expenses();
        if( $expenseDataFromNextPage ){
            $this->expenses->fill($expenseDataFromNextPage);
            $this->expenses->line_items = (array) $this->expenses->line_items; //cast to array

        }else{
            //$this->receipt = json_decode('{"TxnDate":"N\/A","TxnTime":"N\/A","Merchant":"COSTCO\u00ae\nWHOLESALE","MerchantAddress":"20499 64 AVE LANGLEY, CN V2Y 1N5","MerchantPhone":"(604) 539-8916","SubTotal":78.11,"Total":81.01,"Tax":"N\/A","Items":[{"type":"object","valueObject":{"Description":{"type":"string","valueString":"CASCADE POW","content":"CASCADE POW","boundingRegions":[{"pageNumber":1,"polygon":[207,511,312,512,312,529,207,529]}],"confidence":0.986,"spans":[{"offset":134,"length":11}]},"TotalPrice":{"type":"number","valueNumber":19.99,"content":"19.99","boundingRegions":[{"pageNumber":1,"polygon":[370,513,417,513,417,529,370,529]}],"confidence":0.988,"spans":[{"offset":146,"length":5}]}},"content":"4227777\nCASCADE POW\n19.99 AB","boundingRegions":[{"pageNumber":1,"polygon":[100,512,447,512,447,529,100,529]}],"confidence":0.502,"spans":[{"offset":118,"length":7},{"offset":134,"length":20}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"BEYOND MEAT","content":"BEYOND MEAT","boundingRegions":[{"pageNumber":1,"polygon":[207,541,314,542,314,560,207,559]}],"confidence":0.986,"spans":[{"offset":155,"length":11}]},"TotalPrice":{"type":"number","valueNumber":18.99,"content":"18.99","boundingRegions":[{"pageNumber":1,"polygon":[370,542,418,543,417,559,369,559]}],"confidence":0.988,"spans":[{"offset":167,"length":5}]}},"content":"2338620\nBEYOND MEAT\n18.99","boundingRegions":[{"pageNumber":1,"polygon":[100,540,418,542,418,561,100,558]}],"confidence":0.582,"spans":[{"offset":126,"length":7},{"offset":155,"length":17}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"DEMPSTERS","content":"DEMPSTERS","boundingRegions":[{"pageNumber":1,"polygon":[206,573,302,572,302,589,207,589]}],"confidence":0.981,"spans":[{"offset":173,"length":10}]},"TotalPrice":{"type":"number","valueNumber":4.99,"content":"4.99","boundingRegions":[{"pageNumber":1,"polygon":[370,572,408,572,408,588,370,587]}],"confidence":0.988,"spans":[{"offset":184,"length":4}]}},"content":"DEMPSTERS\n4.99\n1449482","boundingRegions":[{"pageNumber":1,"polygon":[101,572,408,572,408,589,101,589]}],"confidence":0.717,"spans":[{"offset":173,"length":15},{"offset":223,"length":7}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"HALF + HALF","content":"HALF + HALF","boundingRegions":[{"pageNumber":1,"polygon":[207,602,311,602,311,617,207,617]}],"confidence":0.985,"spans":[{"offset":189,"length":11}]},"TotalPrice":{"type":"number","valueNumber":1.99,"content":"1.99","boundingRegions":[{"pageNumber":1,"polygon":[370,601,407,601,407,617,370,617]}],"confidence":0.988,"spans":[{"offset":201,"length":4}]}},"content":"HALF + HALF\n1.99\n1019","boundingRegions":[{"pageNumber":1,"polygon":[129,601,407,601,407,617,129,617]}],"confidence":0.515,"spans":[{"offset":189,"length":16},{"offset":231,"length":4}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"ORGANIC HOM","content":"ORGANIC HOM","boundingRegions":[{"pageNumber":1,"polygon":[207,632,311,632,311,647,207,647]}],"confidence":0.986,"spans":[{"offset":206,"length":11}]},"TotalPrice":{"type":"number","valueNumber":8.29,"content":"8.29","boundingRegions":[{"pageNumber":1,"polygon":[370,631,408,631,408,646,370,646]}],"confidence":0.988,"spans":[{"offset":218,"length":4}]}},"content":"ORGANIC HOM\n8.29\n695035","boundingRegions":[{"pageNumber":1,"polygon":[109,631,408,631,408,647,109,647]}],"confidence":0.578,"spans":[{"offset":206,"length":16},{"offset":236,"length":6}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"BEYOND MEAT","content":"BEYOND MEAT","boundingRegions":[{"pageNumber":1,"polygon":[209,661,313,661,313,677,209,677]}],"confidence":0.986,"spans":[{"offset":265,"length":11}]},"TotalPrice":{"type":"number","valueNumber":-4,"content":"4.00-","boundingRegions":[{"pageNumber":1,"polygon":[371,662,417,663,417,676,371,677]}],"confidence":0.988,"spans":[{"offset":277,"length":5}]}},"content":"1608447\nBEYOND MEAT\n4.00-","boundingRegions":[{"pageNumber":1,"polygon":[101,661,417,661,417,677,101,677]}],"confidence":0.569,"spans":[{"offset":243,"length":7},{"offset":265,"length":17}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"(2T)DR SEUS","content":"(2T)DR SEUS","boundingRegions":[{"pageNumber":1,"polygon":[209,690,314,690,314,710,209,710]}],"confidence":0.986,"spans":[{"offset":283,"length":11}]},"TotalPrice":{"type":"number","valueNumber":9.99,"content":"9.99","boundingRegions":[{"pageNumber":1,"polygon":[369,692,407,692,407,707,370,707]}],"confidence":0.988,"spans":[{"offset":295,"length":4}]}},"content":"1576253\n(2T)DR SEUS 9.99 B","boundingRegions":[{"pageNumber":1,"polygon":[101,690,425,690,425,710,101,710]}],"confidence":0.496,"spans":[{"offset":251,"length":7},{"offset":283,"length":18}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"BANANAS","content":"BANANAS","boundingRegions":[{"pageNumber":1,"polygon":[208,722,273,722,272,737,208,737]}],"confidence":0.982,"spans":[{"offset":302,"length":7}]},"TotalPrice":{"type":"number","valueNumber":1.89,"content":"1.89","boundingRegions":[{"pageNumber":1,"polygon":[370,722,407,722,407,736,370,736]}],"confidence":0.988,"spans":[{"offset":310,"length":4}]}},"content":"30669\nBANANAS\n1.89","boundingRegions":[{"pageNumber":1,"polygon":[120,721,407,721,407,737,120,737]}],"confidence":0.725,"spans":[{"offset":259,"length":5},{"offset":302,"length":12}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"ORGANIC RED","content":"ORGANIC RED","boundingRegions":[{"pageNumber":1,"polygon":[207,751,312,751,312,767,207,767]}],"confidence":0.986,"spans":[{"offset":315,"length":11}]},"TotalPrice":{"type":"number","valueNumber":8.99,"content":"8.99","boundingRegions":[{"pageNumber":1,"polygon":[370,752,407,752,407,766,370,766]}],"confidence":0.988,"spans":[{"offset":327,"length":4}]}},"content":"ORGANIC RED\n8.99\n1059994","boundingRegions":[{"pageNumber":1,"polygon":[101,751,407,751,407,767,101,767]}],"confidence":0.575,"spans":[{"offset":315,"length":16},{"offset":373,"length":7}]},{"type":"object","valueObject":{"Description":{"type":"string","valueString":"BLUEBERRIES","content":"BLUEBERRIES","boundingRegions":[{"pageNumber":1,"polygon":[208,782,310,782,310,796,208,797]}],"confidence":0.982,"spans":[{"offset":332,"length":11}]},"TotalPrice":{"type":"number","valueNumber":6.99,"content":"6.99","boundingRegions":[{"pageNumber":1,"polygon":[370,781,407,781,407,796,370,795]}],"confidence":0.988,"spans":[{"offset":344,"length":4}]}},"content":"BLUEBERRIES\n6.99\n57554","boundingRegions":[{"pageNumber":1,"polygon":[119,778,407,781,407,800,119,797]}],"confidence":0.726,"spans":[{"offset":332,"length":16},{"offset":381,"length":5}]}]}',true);

            $this->expenses->datetime = date('m/d/Y H:i');
            $this->expenses->description = $this->receipt['Merchant'];
            $this->expenses->total = $this->receipt['Total'];
            $this->expenses->HST = $this->receipt['Tax'];
            $this->expenses->subtotal = $this->receipt['SubTotal'];


            $tmpExpenses = [];
            foreach ($this->receipt['Items'] as $key => $items) {
                //$tmpExpenses[$key]['category'] = $this->setDefaultCategory??null;

                $tmpExpenses[$key]['item'] = $items['valueObject']['Description']['valueString']??null;
                $tmpExpenses[$key]['category'] = null;

                $tmpExpenses[$key]['qty'] = isset($items['valueObject']['Quantity']['valueNumber']) ? $items['valueObject']['Quantity']['valueNumber'] : "1";
                $tmpExpenses[$key]['price'] = (isset($items['valueObject']['TotalPrice']['valueNumber']) ? $items['valueObject']['TotalPrice']['valueNumber'] : "0") / (isset($items['valueObject']['Quantity']['valueNumber']) ? $items['valueObject']['Quantity']['valueNumber'] : "1");
                $tmpExpenses[$key]['total'] = (isset($items['valueObject']['Quantity']['valueNumber']) ? $items['valueObject']['Quantity']['valueNumber'] : "1")*(isset($items['valueObject']['TotalPrice']['valueNumber']) ? $items['valueObject']['TotalPrice']['valueNumber'] : "0") / (isset($items['valueObject']['Quantity']['valueNumber']) ? $items['valueObject']['Quantity']['valueNumber'] : "1");
            }
            $this->expenses->line_items = $tmpExpenses;
        }

    }


    public function addLineItem(){
        $key = count($this->expenses->line_items);
        $tmpExpenses = $this->expenses->line_items;
        $tmpExpenses[$key]['category'] = $this->setDefaultCategory ?? null;
        $tmpExpenses[$key]['item'] = 'Item '.($key+1);
        $tmpExpenses[$key]['qty'] = 1.00;
        $tmpExpenses[$key]['price'] = 0.00;
        $tmpExpenses[$key]['total'] = 0.00;
        $this->expenses->line_items = $tmpExpenses;
    }

    public function updateTotals(){
        //update totals
        $subTotal = 0.00;
        $items = $this->expenses->line_items;
        foreach ($items as &$lineItem){
            $lineItem['total'] = (float)$lineItem['price'] * (float)$lineItem['qty'];
            $subTotal += $lineItem['total'];
        }
        $this->expenses->line_items = $items;
        $this->expenses->subtotal = $subTotal;
        $this->expenses->total = (float) $this->expenses->HST + $this->expenses->subtotal;
    }

    public function render()
    {
        clock()->info($this->state()->all());

        //on every element refresh calculate totals automatically
//        if($this->manualDataEntryMode){
//            $this->updateTotals();
//        }

        return view ('livewire.forms.ExpensesForm_step2');
    }

}

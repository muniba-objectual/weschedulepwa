<?php

namespace App\Http\Livewire\ExpensesReport;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Models\CreditCard;
use App\Models\ExpenseCategory;
use App\Models\ExpensePayout;
use App\Models\Expenses;
use App\Models\ExpensesVerifiers;
use App\Models\Notifications;
use App\Models\QBVendor;
use App\Models\VendorAccountPredictionList;
use App\Models\VendorItemCategoryPredictionList;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DynamicExpenseReportComponent extends Component
{
    use WithPagination, ExpenseCore;

    public $user;
    public $viewed;
    public $expandedExpenses = [];
    public $expenseVendorIds = [];
    protected bool $highlightWhereImTaggedIn = true;
    public $expenseIdToFocus;

    //Edit expense variables
    public $editingExpenseId = null;
    public $editingExpenseSubTotal, $editingExpenseTotal, $editingExpenseHst;

    protected $timeline_data;
    public $expenseCategoryIds = []; //expense all categories
    public $allChildren;
    public $expenseChildrenIds = [];

    public bool $optimizedMode = false;
    public array $optimisedDateDates = [];


    public function updateExpenseCategorySelection($expenseId): void
    {
        $expense = \App\Models\Expenses::find($expenseId);
        $expense->category_id = $this->expenseCategoryIds[$expenseId];
        $expense->save();

        if($expense->vendor_id){
            $suggestedMapping = VendorItemCategoryPredictionList::updateOrCreate(
                [
                    'vendor_id'     => $expense->vendor_id,
                    'category_id'   => $expense->category_id,
                ],
                [
                    'hits' => \DB::raw('hits + 1'), // Increment hits by 1 or set to 1 on creation
                ]
            );

//            //update similar category expenses
//            Expenses::query()
//                ->whereNull('expense_payout_id')    //expenses not already marked as paid
//                ->whereNull('category_id')          //only if category_id is not set, this is important to avoid loop back of category_id updates
//                ->where(function ($query) use ($expense) { //operation are done monthly, so filter >= same month.
//                    $query->whereYear('created_at', '>=', $expense->created_at->year)
//                        ->whereMonth('created_at', '>=', $expense->created_at->month);
//                })
//                ->whereVendorId($expense->vendor_id)  //with same vendor
//
//                ->update(['category_id' => $expense->category_id]);
        }
    }

    public function updateExpenseChildrenSelection($expenseId): void{//dd($this->expenseChildrenIds[$expenseId]??[]);
        $model = \App\Models\Expenses::find($expenseId);
        $model->multiChild()->sync($this->expenseChildrenIds[$expenseId]??[]);
        $model->save();
    }

    public function updateVendorSelection(Expenses $expense): void
    {
        /** @var QBVendor $vendorInstance */
        $vendorInstance = QBVendor::find( $this->expenseVendorIds[$expense->id] );

        $expense->vendor_id             = $vendorInstance->Id;
        $expense->vendor_name           = $vendorInstance->DisplayName;
        $expense->save();

        //update similar merchant expenses
        Expenses::query()
            ->whereNull('expense_payout_id')    //expenses not already marked as paid
            ->whereNull('vendor_id')            // only if vendor is not set, this is important to avoid loop back of vendor updates
            ->where(function ($query) use ($expense) { //operation are done monthly, so filter >= same month.
                $query->whereYear('created_at', '>=', $expense->created_at->year)
                    ->whereMonth('created_at', '>=', $expense->created_at->month);
            })
            ->whereDescription($expense->description)  //with same bill description (merchant naming)

            ->update([
                'vendor_id'             => $vendorInstance->Id,
                'vendor_name'           => $vendorInstance->DisplayName,
                'vendor_was_predicted'  => true,
            ]);

        $suggestedMapping = VendorAccountPredictionList::updateOrCreate(
            [
                'vendor_id'                 => $vendorInstance->Id,
                'alternative_vendor_name'   => $expense->description,
            ],
            [
                'hits' => \DB::raw('hits + 1'), // Increment hits by 1 or set to 1 on creation
            ]
        );

    }

    protected $listeners = [
        'delete' => 'delete',
        'updateLineItems' => 'updateLineItems',
        'toggleExpand' => 'toggleExpand',
        'toggleExpandMonth' => 'toggleExpandMonth',
        'dismissNotifications' => 'dismissNotifications',
        'focusToExpense' => 'focusToExpense',
    ];


    public function mount(int $focussedExpense = null) {
        $this->expenseIdToFocus = $focussedExpense; //on page load focus to expense if needed.
        $this->user = Auth::user();
        $this->initExpenseConfig();
        $this->allChildren = \App\Models\Child::orderBy('initials')->get(['id', 'initials'])->toArray();
        $this->expenseChildrenIds = \DB::table('expense_children')->pluck('child_id', 'expense_id')->toArray();

        if (request()->get('optimized', false)) {
            $this->optimizedMode = true;
            $filterDate = (new Carbon(request('forDate', now())))->format('Y-m');
            $this->optimisedDateDates[$filterDate] = $filterDate; //should be in database date prefix format (yyyy-mm)
        }
    }

    public function editTotals(Expenses $expense){
        $this->editingExpenseHst = $expense->HST;
        $this->editingExpenseSubTotal = $expense->subtotal;
        $this->editingExpenseTotal = $expense->total;
        $this->editingExpenseId = $expense->id;
    }

    public function overrideTotals(Expenses $expense){
        if( $this->editingExpenseId == $expense->id){
            $expense->updateAutoCorrection($this->editingExpenseHst, $this->editingExpenseTotal, $this->editingExpenseSubTotal);
            $this->editingExpenseId = null;
       }
    }

    public function resetTotals(Expenses $expense){
        if( $this->editingExpenseId == $expense->id ){

            $subTotal = 0.00;
            foreach(json_decode($expense->line_items) as $lineItem) {
                $subTotal += (float)$lineItem->total;
            }

            $expense->subtotal = $subTotal;
//            $expense->HST = //tage fromimage //TODO::ashain, complete this
            $expense->total = $subTotal+$expense->HST;
            $expense->is_override_totals = false;
            $expense->save();

            $this->editingExpenseId = null;
        }
    }


    public function makePayout($nodeKey){
        //recursive grouping
        $this->initExpenseConfig();

        //get query for the active tab
        $grouped = $this->getSourceQueryBuilder()
            ->whereNotNull('verified_at')
            ->get();

        //apply group by functions for the given group by level, use the key to derive the group by level
        $filterValues = explode('.', $nodeKey);
        $depth = count($filterValues);$i=0;
        foreach ($this->groupByLogic as $filterData){
            if($depth>0){
                $grouped = $grouped->groupBy($filterData['logic'])->get($filterValues[$i]);

                //break process if no records found
                if(is_null($grouped)){
                    return;
                }

            }
            $depth--;$i++;
        }

        //create or find payout instance
        $expenseHavingAPayout = $grouped->whereNotNull('expense_payout_id')->first();
        if($expenseHavingAPayout){
            $payout = ExpensePayout::find($expenseHavingAPayout->expense_payout_id);
        }else{
            $payout = new ExpensePayout();
            $payout->status = ExpensePayout::STATUS__PENDING;
            $payout->paid_to_user_id = $grouped->first()->fk_UserID;
        }

        //update totals
        $payout->amount = $grouped->sum('total') + $grouped->sum('HST');
        $payout->save();

        //map expenses to the payout if not mapped already
        $grouped->map(function (Expenses $model) use($payout){
            $model->expense_payout_id = $payout->id;
            if($model->isDirty()){
                $model->save();
            }
        });

        //open payout-modal-component
        $this->emit('modal.open', 'expenses-report.payout-modal-component', ['payout' => $payout->id]);
    }

    public function focusToExpense($expenseId){
        $this->expenseIdToFocus = $expenseId;
    }

    public function toggle($expenseId){
        //TODO::michello, you have an unimplemented method
    }

    public function dismissNotifications($expenseId): void
    {
        Notifications::query()
            ->where('fk_UserID','=',Auth::id())
            ->where('model','Expenses')
            ->where('fk_ModelID', $expenseId)
            ->update(['active' =>0]);
    }

    public function findTabForExpense($expenseId): ?string
    {
        if(!$this->conf){
            $this->loadConfigurationForLoginLevel();
        }
        foreach ($this->conf['web']['expenses']['tabs'] ?? [] as $tabName => $tabData) {
            if(!($tabData['enabled']??false)){ // skip any disabled tabs
                continue;
            }
            $this->activeTab = $tabName;
            if($this->getSourceQueryBuilder()->where('id', $expenseId)->count()){
                return $tabName;
            }
        }
        //this line will only execute if the user does not have "standard" access to the expense!
        return null;
    }

    public function toggleVerified($expenseId){
        $userId = auth()->id();
        $expense = Expenses::find($expenseId);

        if($expense->is_verified){
            //you can un-verify something only you have verified before, unless you are a super admin.
            if($expense->verified_by == $userId || ExpensesVerifiers::hasAdminPrivileges()){
                $expense->verified_by = null;
                $expense->verified_at = null;
            }
        }else{
            $expense->verified_by = $userId;
            $expense->verified_at = now();
        }
        $expense->save();
    }

    public function updateLineItems($expenseId, $content){
        /** @var Expenses $expense */
        $expense = Expenses::find($expenseId);

        //if verified or is manually calcualted, then do not update line items or totals
        if( !$expense->is_verified ){
            $expense->updateLineItems(json_decode($content));
        }
    }


    public function toggleExpand($byUser){
        if($this->expandedExpenses[$byUser] ?? false){
            $this->expandedExpenses[$byUser] = false;
        }else{
            $this->expandedExpenses[$byUser] = true;
        }
    }

    public function toggleExpandMonth($monthYear, $key): void
    {
        if( isset($this->optimisedDateDates[$monthYear]) ){
            unset($this->optimisedDateDates[$monthYear]);
        }else{
            $this->optimisedDateDates[$monthYear] = $monthYear;
        }
        $this->toggleExpand($key);
    }

    protected function getView(... $params){
        $viewFilePrefix = \Illuminate\Support\Str::slug($this->activeTab);
        return view('livewire.expenses-report.'.$viewFilePrefix.'-expense-report-component', ... $params);
    }

    public function render(){
        $this->initExpenseConfig();

        if($this->hasPersonalizedView()){
            $renderFunction = 'render'.\Illuminate\Support\Str::studly($this->activeTab); //guess function name
            return $this->$renderFunction();
        }

        $allExpensesCategories = ExpenseCategory::readyToUse()->pluck('name', 'id');
        $previousVendorCategories = \App\Models\VendorItemCategoryPredictionList::query()
            ->latest('hits')
            ->get()
            ->groupBy('vendor_id')
            ->map(function($modelGroup, $vendorId){
                return $modelGroup->pluck('category_id')->toArray();
            });

        $grouped = $this->getSourceQueryBuilder()
            ->tap(function (\Illuminate\Database\Eloquent\Builder &$collection) {
                if ($this->optimizedMode) {
                    $collection->whereIn(\DB::raw("LEFT(created_at, 7)"), $this->optimisedDateDates);
                }
            })
            ->get();

        //can verify permissions
        $expensesCanVerify=[];
        $companyCreditCards = CreditCard::all()->groupBy('user_id'); //TODO::limit to userIds when key by is switched from userId to
        foreach ($grouped->groupBy('fk_UserID')->keys() as $expenseUserId){
            $expensesCanVerify[$expenseUserId] = $this->getCanVerifyFunction($expenseUserId);
        }

        foreach ($grouped as $expense){
            $this->expenseCategoryIds[$expense->id] = $expense->category_id;
            $this->expenseVendorIds[$expense->id] = $expense->vendor_id;
        }


        $summaryDetails = collect(); //holds: all summary details
        $propertyDetails = collect(); //holds: self-tagging
        $additionalData = []; //input data

        if($this->highlightWhereImTaggedIn){
            //list of expenses I'm tagged in
            $additionalData['self-tagged-expenses'] = Notifications::query()
                ->where([
                    'fk_UserID' => auth()->id(),
                    'model' => 'Expenses',
                    'active' => 1,
                ])
                ->pluck('fk_ModelID');
        }

        //recursive grouping
        if(count($this->groupByLogic)){
            $grouped = $this->recursiveGroupBy($this->groupByLogic, $grouped, $summaryDetails, $propertyDetails, $additionalData);
        }

        clock()->info($grouped);
        $per_page = 62; //1 day per page

        $current_page = $data['page'] ?? 1;

        // $array = $array->slice(($current_page - 1) * $per_page, $per_page);
        $pagination = new LengthAwarePaginator(
            $grouped->slice(($current_page - 1) * $per_page, $per_page),
            $grouped->count(),
            $per_page,
            $current_page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        $timeline_data = $this->timeline_data = $pagination;

        $thisMonthKey = \Carbon\Carbon::now()->format('M-Y');

        $tmpUsers = \App\Models\User::query()
            ->where(function($q){
                return $q
                    ->whereBetween('user_type', ['3.0', '6.0'])
                    ->orWhere('user_type', '10.0');
            })
            ->get()
            ->keyBy('name');


        $virtualMonthNodes =  [];
        if ($this->optimizedMode) {

            $virtualMonthNodes = Expenses::query()
                ->selectRaw("LEFT(created_at, 7) as `created_at`") //reduced created, to get distinct 'yyyy-mm', also kept as created_at to take the benefit of Carbon.
                ->distinct()
                ->orderByDesc('created_at')
                ->get()
                ->keyBy('created_at'); // `yyyy-mm` format
        }

        $allVendorsAccounts = \App\Models\QBVendor::orderBy('DisplayName')->pluck('DisplayName', 'Id');

        return view('livewire.expenses-report.dynamic-expense-report-component', compact(
            'virtualMonthNodes',
            'timeline_data', 'previousVendorCategories', 'allExpensesCategories', 'tmpUsers',
            'summaryDetails', 'propertyDetails', 'expensesCanVerify', 'companyCreditCards', 'thisMonthKey', 'allVendorsAccounts'
        ));
    }

    private function recursiveGroupBy($groupConfigs, $collection, &$summaries, &$properties, &$additionalData, $parentKey='root'){

        //if item has $gropings, run group by function
        if(count($groupConfigs)){

            $GroupByLogicIndex = array_key_first($groupConfigs); //get the first logic level index
            $groupByConfig = $groupConfigs[$GroupByLogicIndex]; //store the group conf
            array_shift($groupConfigs); //drop first conf, leave the rest for the next iteration


            if($groupByConfig['enable']??false){
                //perform groupBy
                $collection = $collection->groupBy($groupByConfig['logic'], true);
            }

            //iterate through grouped items
            $collection->transform(function($item, $key) use($parentKey, $groupConfigs, &$summaries, &$properties, &$additionalData, $GroupByLogicIndex, $groupByConfig) {

                //key refactor
                /*
                if(empty($key)){
                    if( isset($groupByConfig['nullKeys']) ){
                        $key = $groupByConfig['nullKeys'] instanceof \Closure ?
                            $groupByConfig['nullKeys']($item, $key, $parentKey) : $groupByConfig['nullKeys'];
                    }else{
                        $key='null';
                    }
                }*/
                $fullKeyPath = $parentKey . '.' . str_replace('.', '-', $key);
                //end key refactor

                /**Summary Details */
                //Group type
                $groupSummaryDetails['type'] = $GroupByLogicIndex;

                //URL to grouped source
                $groupSummaryDetails['url'] = '#';
                if (isset($groupByConfig['url'])) {
                    $uncompletedUrl = $groupByConfig['url'][0];
                    $prop = $groupByConfig['url'][1];
                    $groupSummaryDetails['url'] = str_replace('{slug}', $item->first()->$prop, $uncompletedUrl);
                }

                //group summary
                foreach ($groupByConfig['summary'] ?? [] as $summaryName => $function) {
                    if(is_array($function)){
                        foreach ($function as $key => $function){
                            $groupSummaryDetails['summary'][$summaryName][$key] = $function($item, $key);
                        }
                    }else{
                        $groupSummaryDetails['summary'][$summaryName] = $function($item, $key);
                    }
                }

                $summaries->put($fullKeyPath, $groupSummaryDetails);


                //Start additional properties
                $groupProperties = [];

                //prop 1
                $groupProperties['force-expand'] = $this->expenseIdToFocus && $item->where('id', $this->expenseIdToFocus)->count();

                //prop 2
                $groupProperties['verified-expenses-count'] = $item->whereNotNull('verified_at')->count();

                //prop 3
                if ($this->highlightWhereImTaggedIn){
                    $groupProperties['im-tagged'] = (bool)$item->whereIn('id', $additionalData['self-tagged-expenses'])->count();
                }

                //prop 4 - count payouts which are paid
                $groupProperties['paid-payout-count'] = $item->where('expensePayout.status', ExpensePayout::STATUS__PAID)->count();


                //prop 5 - payouts
                if ($this->highlightWhereImTaggedIn){
                    $expenseWithAPayout = $item->whereNotNull('expense_payout_id')->first();
                    $groupProperties['payout-id'] = $expenseWithAPayout->expense_payout_id??null;
                    if($expenseWithAPayout){
                        $groupProperties['payout-details'] = $expenseWithAPayout->expensePayout->toArray();
                    }
                }

                //prop 6 - totals
                if ($this->highlightWhereImTaggedIn){
                    $groupProperties['expense-count'] = $item->count();
                }

                $properties->put($fullKeyPath, $groupProperties);
                //End additional properties

                //if has further groupBy logic, call recursive groupBy to this N`th element.
                if(count($groupConfigs)){
                    $item = $this->recursiveGroupBy($groupConfigs, $item, $summaries, $properties,$additionalData, $fullKeyPath);

                }else{
                    //on last node, loop through actual expenses
                    foreach($item as $expense){
                        //Start additional properties
                        $groupProperties=[];
                        $groupProperties['force-expand'] = $this->expenseIdToFocus && $expense->id == $this->expenseIdToFocus;
                        if ($this->highlightWhereImTaggedIn) {
                            $groupProperties['im-tagged'] = (bool)$additionalData['self-tagged-expenses']->contains($expense->id);
                        }
                        $properties->put($fullKeyPath.'.'.$expense->id, $groupProperties);
                        //End additional properties
                    }
                }

                return $item;
            });
        }


        //return item after transformation
        return $collection;
    }

    public function delete(?Expenses $expense): void
    {
        if (
            $expense &&
            ( $this->user->user_type == 10.0 || $this->user->id == $expense->fk_UserID )
            && !$expense->is_verified
        ) {
            $expense->delete();
        }

    }
}

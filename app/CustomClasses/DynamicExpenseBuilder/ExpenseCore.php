<?php

namespace App\CustomClasses\DynamicExpenseBuilder;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait ExpenseCore
{
    protected $conf = null;
    protected $loginLevel = null;
    protected bool $has_loaded = false;


    /** Tab Controls */
    public string $activeTab;
    public array $tabCollection = [];


    /** (Allowed to verify) feature flag */
    public bool $hasCanVerifyFeature;


    /** (Allowed to verify) dynamic logic flag */
    public bool $hasDynamicCanVerifyLogic;


    /** (Allowed to verify) static logic stored as cache */
    protected mixed $staticDynamicCanVerifyLogic;


    //Mobile Variables..........................................................
    public ?string $mobileHomeRoute;
    public bool $mobileExpenseCreateFormStage3, $hasMobileExpenseListView, $hasMobileExpenseCreateForm = false;
    public array $dropDown1, $dropDown2;

    protected array $groupByLogic;

    protected function isRunningAsWebApp(){
        return true; //TODO::ashain,derive this from a middleware
    }

    protected function isRunningAsMobileApp(){
        return true; //TODO::ashain,derive this from a middleware
    }

    protected function getWebActiveExpenseTabData(): array
    {
        return $this->conf['web']['expenses']['tabs'][$this->activeTab];
    }

    public static function getLoginRoleLevel(User $user = null): ?string
    {
        $usersRole = ($user ?? auth()->user())->user_type;
        foreach(ExpenseConfig::roleMapping() as $roleLevel => $roles){
            if( in_array($usersRole, $roles) ){
                return $roleLevel;
            }
        }
        return null;
    }


    public static function getTabHeads(): array
    {
        $tabs = [];
        foreach (ExpenseConfig::config()[self::getLoginRoleLevel()]['web']['expenses']['tabs'] ?? [] as $tabName => $tabData) {
            if ($tabData['enabled'] ?? false) {
                $tabs[] = $tabName;
            }
        }
        return $tabs;
    }

    private function initWebComponents(): void
    {
        //tab control
        foreach ($this->conf['web']['expenses']['tabs'] ?? [] as $tabName => $tabData) {
            if ($tabData['enabled'] ?? false) {
                $this->tabCollection[] = $tabName;
            }
        }

        if(count($this->tabCollection) == 0){
            abort(403, "Feature not allowed");
        }

        //get active-tab or assign first tab
        if (!session('expense.report.active-tab')) { //if not set, get the first tab
            session()->put('expense.report.active-tab', $this->tabCollection[0]);
        }
        $this->activeTab = session('expense.report.active-tab');

        //abort if trying access a invalid tab.
        if (!in_array($this->activeTab, $this->tabCollection)) {
            session()->forget('expense.report.active-tab');
            abort(403, "Insufficient privileges");
        }

        //verification module
        if (isset($this->getWebActiveExpenseTabData()["can-verify"])) {

            if (is_array($this->getWebActiveExpenseTabData()["can-verify"])) {
                //flag
                $this->hasDynamicCanVerifyLogic = !($this->getWebActiveExpenseTabData()["can-verify"]['is_flat_logic'] ?? false);

                //flag
                $this->hasCanVerifyFeature = true;

                if (!$this->hasDynamicCanVerifyLogic) {
                    //store static response
                    $function = $this->getWebActiveExpenseTabData()["can-verify"]['logic'];
                    $this->staticDynamicCanVerifyLogic = $function(null);
                }
            } else {
                $this->hasDynamicCanVerifyLogic = false;
                $this->hasCanVerifyFeature = $this->getWebActiveExpenseTabData()["can-verify"];
                $this->staticDynamicCanVerifyLogic = $this->getWebActiveExpenseTabData()["can-verify"];
            }
        }

        //group by logic
        $this->groupByLogic = $this->getWebActiveExpenseTabData()["group-by"] ?? [
                'monthyear' => ExpenseConfig::groupByTimeLine(),
                $this->activeTab => ExpenseConfig::groupByCreator(true, true, true), //for the key: guess the user type from the tab-header
            ];
    }

    private function initMobileConfiguration():void {

//                $this->conf['mobile']['redirect-to'];
        $this->mobileHomeRoute = $this->conf['mobile']['home-route']??null;
        $this->hasMobileExpenseListView = $this->conf['mobile']['expenses']['list-view']['enable']??false;
        $this->hasMobileExpenseCreateForm =
            ( is_bool($this->conf['mobile']['expenses']['create-form']) && $this->conf['mobile']['expenses']['create-form'] )
            ||
            ($this->conf['mobile']['expenses']['create-form']['enabled'] ?? false);

        //default values
        $subOptionCount = 0;
        $this->mobileExpenseCreateFormStage3 = false;
        $linkCollection = [
            'My Self' => [
                'value' => null,
                'sub-options' => null
            ],
        ];

        if( $this->hasMobileExpenseCreateForm ){
            //get the collection to a variable
            $linkToCollection = $this->conf['mobile']['expenses']['create-form']['link-to']??$linkCollection;

            $this->dropDown1 = [];
            $this->dropDown2 = [];

            //build dropdown-options
            foreach ($linkToCollection as $textValue => &$subOptions){
                $key = $subOptions['value'];           //dropdown actual value (linkTo)
                $this->dropDown1[$key] = $textValue; //displace value of dropdown1

                //if sub-option is a function, execute and get value
                if($subOptions['sub-options'] instanceof \Closure){
//                            $subOptionsIsDynamic = true;
                    $subOptions['sub-options'] = $subOptions['sub-options'](); //execute function to get the exact value
                }

                //if sub-option is a collection, convert to array
                if( $subOptions['sub-options'] instanceof  Collection ){
                    $subOptions['sub-options'] = $subOptions['sub-options']->toArray();
                }

                $subOptionCount++;

                //if sub-options is null, convert to array with a null value
                $this->dropDown2[$key] = $subOptions['sub-options']??[]; //create a sub menu item with value null.
            }

            //if you have more than one value option enable stage 3
            $this->mobileExpenseCreateFormStage3 = $subOptionCount>1;

            //auto disable form feature if not a single sub-option is available.
            $this->hasMobileExpenseCreateForm = $subOptionCount>0;
        }

//                dd(
//                    $subOptionCount,
//                    $this->hasMobileExpenseCreateForm,
//                    $this->mobileExpenseCreateFormStage3,
//                    $linkToCollection,
//                    $this->dropDown1,
//                    $this->dropDown2
//                );
    }

    public function loadConfigurationForLoginLevel(): void
    {
        //lock into configuration, based on the login level
        $this->loginLevel = self::getLoginRoleLevel();
        if(!$this->loginLevel){
            abort(403, "Insufficient privileges");
        }
        $this->conf = ExpenseConfig::config()[$this->loginLevel];
    }


    public function initExpenseConfig(): void
    {
        if(!$this->has_loaded){

            $this->loadConfigurationForLoginLevel();


            //Web browser related configuration
            if($this->isRunningAsWebApp() && isset($this->conf['web']) ){
                $this->initWebComponents();
            }


            //Mobile app related configuration
            if($this->isRunningAsMobileApp() && isset($this->conf['mobile']) ){
                $this->initMobileConfiguration();
            }

            $this->has_loaded = true;
        }
    }


    public function getCanVerifyFunction(int $userId): bool
    {
        if ($this->hasDynamicCanVerifyLogic) {
            $function = $this->getWebActiveExpenseTabData()["can-verify"]['logic'];
            return $function($userId);
        } else {
            return $this->staticDynamicCanVerifyLogic;
        }
    }

    public function getSourceQueryBuilder(): Builder{
        $builderFunction = $this->getWebActiveExpenseTabData()["collection"];
        return $builderFunction();
    }

    public function hasPersonalizedView(): bool{
        return $this->getWebActiveExpenseTabData()["custom-view"]??false;//TODO::ashain, implement on config
    }
}

<?php

namespace App\CustomClasses\DynamicExpenseBuilder;

use App\Models\Child;
use App\Models\ExpenseCategory;
use App\Models\Expenses;
use App\Models\ExpensesVerifiers;
use App\Models\User;
use Illuminate\Support\Collection;

class ExpenseConfig
{
    public static function roleMapping(){
        /*
            'CYSW', '1.0'
            'Foster Parent', '2.0'

            'Etel - Accountant', '7.0'
            'CAS Workers', '7.1'
            'Placement Staff (Students)', '1.1'
            'Drivers', '1.3'
            'Foster Parent - Full Time', '2.4'
            'Case Managers', '3.4'
            'Admin Staff', '3.3'
         */
        return [
            'super-admin' => [
                10.0  //Super Administrator
            ],
            'regular-staff' => [
                //3.0 >= x <=6.0.......... except:{case-manager, role-managers}
                3.0,
                4.3
            ],
            'role-manager' => [
                //3.3, 4.1, 4.4, "5<=x<=6"...........
                3.1, 3.2, 3.3, 3.4,
                4.0, 4.1, 4.2, 4.4,
                5.0, 5.1, 5.2, 6.0, //TODO::ashain, 4.4 is missing!
                7.0
            ],
            'case-manager' => [
                3.4,
            ],
            'cysw' => [
                1.0
            ],
            'foster-parent' => [
                //2.0>= x <=2.4
                2.1, 2.2, 2.3, 2.4
            ],

            'foster-homes' => [
                2.2, 2.1, 2.4
            ],
        ];
    }


    /* GroupBy Logic Block : Root/Time */
    public static function groupByTimeLine(bool $enable=true): array
    {
        return [
            'enable' => $enable,
            'logic' => 'monthyear',
        ];
    }


    /* GroupBy Logic Block : Child */
    private static function groupByChild(bool $enable=true, bool $includeVerifiedOnly = false, bool $splitByPaymentType = false): array
    {
        if($splitByPaymentType){
            $summary=[];
            foreach ([
                         Expenses::PAYMENT_METHOD__UNSPECIFIED => 'Other Payment Methods',
                         Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD => 'Company Credit Card'
                     ] as $paymentType => $title
            ){
                $summary[$title] = self::defaultSummary($includeVerifiedOnly, $paymentType);
            }
        }else{
            $summary = self::defaultSummary($includeVerifiedOnly);
        }

        return [
            'enable' => $enable,
            'logic' => 'getChild.initials',
            'url' => ['child/{slug}/edit', 'linkToID'],
            'summary' => $summary,
        ];
    }

    private static function defaultSummary(bool $includeVerifiedOnly, string $paymentTypeFilter = null){
        return [
            'Total' => (function(Collection $collection) use($includeVerifiedOnly, $paymentTypeFilter): string{
                if($paymentTypeFilter){
                    $collection = $collection->where('payment_type', $paymentTypeFilter);
                }
                if($includeVerifiedOnly){
                    $collection = $collection->whereNotNull('verified_at');
                }
                return (string)$collection->sum('total');
            }),

            'HST' => (function(Collection $collection) use($includeVerifiedOnly, $paymentTypeFilter): string{
                if($paymentTypeFilter){
                    $collection = $collection->where('payment_type', $paymentTypeFilter);
                }
                if($includeVerifiedOnly){
                    $collection = $collection->whereNotNull('verified_at');
                }
                return (string)$collection->sum('HST');
            }),

            'Receipts' => (function(Collection $collection) use ($includeVerifiedOnly, $paymentTypeFilter): string{
                if($paymentTypeFilter){
                    $collection = $collection->where('payment_type', $paymentTypeFilter);
                }
                $total = $collection->count();

                if($includeVerifiedOnly){
                    $verified =  $collection->whereNotNull('verified_at')->count();
                    return "{$verified} / {$total}";
                }else{
                    return (string)$total;
                }
            }),

            'CategorySummary' => (function(Collection $collection) use($includeVerifiedOnly, $paymentTypeFilter){
                if($paymentTypeFilter){
                    $collection = $collection->where('payment_type', $paymentTypeFilter);
                }
                if($includeVerifiedOnly){
                    $collection = $collection->whereNotNull('verified_at');
                }

                static $allExpenseCategories;
                if (!isset($allExpenseCategories)) {
                    // Initialize the static variable here
                    $allExpenseCategories = ExpenseCategory::all()->keyBy('id');
                }

                $categorySubTotals=[];

                foreach($collection as $expense){
                    foreach(json_decode($expense->line_items) as $lineItem) {
                        //calculate totals category wise, if category is null, assume index as `0`.
                        $key = $allExpenseCategories[$lineItem->category]->name ?? 'Other';
                        if (isset( $categorySubTotals[$key] )) {
                            $categorySubTotals[$key] = bcadd($categorySubTotals[$key], (float)$lineItem->total, 2);
                        } else {
                            $categorySubTotals[$key] = (float)$lineItem->total;
                        }
                    }
                }

                return $categorySubTotals;
            }),
        ];
    }


    /* GroupBy Logic Block : Creator */
    public static function groupByCreator(bool $enable=true, bool $includeVerifiedOnly = false, bool $splitByPaymentType = false): array
    {
        if($splitByPaymentType){
            $summary=[];
            foreach ([
                        Expenses::PAYMENT_METHOD__UNSPECIFIED => 'Other Payment Methods',
                        Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD => 'Company Credit Card'
                     ] as $paymentType => $title
            ){
                $summary[$title] = self::defaultSummary($includeVerifiedOnly, $paymentType);//ucwords(str_replace('-', ' ', $key))
            }
        }else{
            $summary = self::defaultSummary($includeVerifiedOnly);
        }

        return [
            'enable' => $enable,
            'logic' => 'getUser.name',
            'url' => ['/users/{slug}', 'fk_UserID'],
            'summary' => $summary,
        ];
    }


    public static function config(){
        return [
            'super-admin' => [
                'web' => [
                    'expenses' => [
                        /*
                        'color-highlights' => [
                            is_tampered_at not null=>
                                colured in red full hyrachy
                            else is_manually_entered=>
                                colured in yellow full hyrachy

                            if(values is updated)[
                                is_tampered=> true,
                            ]else[
                                is_tampered=> false,
                            ]
                        ],
                        */
                        'tabs' => [
                            'My Expenses' => [
                                'enabled' => true,
                                'can-verify' => false,
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->where('fk_UserID' , auth()->id())
                                        ->whereNull('linkTo')
                                        ->whereNull('linkToID')
//                                        ->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                            ],
                            'Staff' => [
                                'enabled' => true,
                                'can-verify' => [
                                    'logic' => (function(?int $userId){
                                        return true;
                                    }),
                                    'is_flat_logic' => true,
                                ],
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->whereIn( 'fk_UserID', User::query()
                                            ->whereBetween('user_type', ['3.0', '10.0'])
                                            ->where('inactive', 0)
                                            ->pluck('id')
                                        )
//                                        ->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'monthyear' => ExpenseConfig::groupByTimeLine(),
                                    'Staff' => ExpenseConfig::groupByCreator(true, true, true),
                                ]
                            ],
                            'CYSW' => [
                                'enabled' => false,
                                'can-verify' => [
                                    'logic' => (function(?int $userId){
                                        return true;
                                    }),
                                    'is_flat_logic' => true,
                                ],
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->whereIn(
                                            'fk_UserID',
                                            User::where('user_type', '1.0')->where('inactive', 0)->pluck('id')
                                        )
//                                        ->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'monthyear' => self::groupByTimeLine(),
                                    'CYSW' => self::groupByCreator(true, true, true),
                                    'Child' => self::groupByChild(true),
                                ],
                            ],
                            'Foster Parents' => [
                                'enabled' => false,
                                'can-verify' => [
                                    'logic' => (function(?int $userId){
                                        return true;
                                    }),
                                    'is_flat_logic' => true,
                                ],
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->whereIn( 'fk_UserID', User::query()
                                            ->whereBetween('user_type', ['2.0', '2.4'])
                                            ->where('inactive', 0)
                                            ->pluck('id')
                                        )
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'Month' => self::groupByTimeLine(),
                                    'Foster Parent' => self::groupByCreator(true, true, true),
                                    'Child' => self::groupByChild(true),
                                ],
                            ],
                            'Children' => [
                                'enabled' => false,
                                'can-verify' => [
                                    'logic' => (function(?int $userId){
                                        return true;
                                    }),
                                    'is_flat_logic' => true,
                                ],
                                'collection' => (function(){
                                    $childrenIds = Child::query()
                                        ->where('inactive', 0)
                                        ->where('WeSchedule', 1)
                                        ->pluck('id');
                                    return Expenses::query()
                                        ->where('linkTo', 'Children')
                                        ->whereIn('linkToID', $childrenIds)
//                                        ->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'getChild', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'Month' => self::groupByTimeLine(),
                                    'child' => self::groupByChild(true, false, true),
                                ],
                            ],

                        ],
                    ]
                ],
                'mobile' => [
                    'expenses' => [
                        'create-form' => true, //stage 3 auto disabled and linked direct to login person only
                        'list-view' => true,
                    ],
                ],
            ],

            'regular-staff' => [

                //only dynamic can approve ???
                //my/what image
                //view variation

                'web' => [
                    'expenses' => [
                        'tabs' => [
                            'Staff' => [
                                'enabled' => true,
                                'can-verify' => [
                                    'logic' => (function(?int $userId){
                                        /*
                                           verification-administration-control-by: {
                                               - admini-role: "10.0"
                                               - user-allocatoin-range: role 3.0 between 6.0
                                           },
                                        */
                                        return (bool) ExpensesVerifiers::query()
                                            ->where([
                                                'verifier_user_id'  => auth()->id(), //person to verify
                                                'expense_user_id'   => $userId,    //the expense owner
                                            ])
                                            ->first();
                                    }),
                                    'is_flat_logic' => false,
                                ],
                                'collection' => (function(){

                                    return Expenses::query()

                                        ->where(function ($subQuery){
                                            $usersAllowedToVerify = ExpensesVerifiers::query()
                                                ->where('verifier_user_id', auth()->id())
                                                ->whereIn('expense_user_id', User::query()
                                                    ->whereBetween('user_type', ['3.0', '6.0'])
                                                    ->pluck('id')
                                                )
                                                ->pluck('expense_user_id');

                                            return $subQuery
                                                ->whereIn('fk_UserID' , $usersAllowedToVerify)
                                                ->orWhere('fk_UserID' , auth()->id());
                                        })

                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'monthyear' => ExpenseConfig::groupByTimeLine(),
                                    'Staff' => ExpenseConfig::groupByCreator(true, true, true),
                                ]
                            ],
                        ],
                    ]
                ],

                'mobile' => [
                    'home-route' => "/mobileCM",
                    'redirect-to' => '',//expense create button location.
                    'expenses' => [
                        'create-form' => true, //stage 3 auto disabled and linked direct to login person only
                        'list-view' => [
                            'enable' => true,
                        ],
                    ],

                    /*
                    if(manual_mode)[
                        add delete button per each row
                    ],
                    */
                    //disable stage 3, directyly map to myself, fk_User_id //linkTO =>null inkToId =>null
                    //utilize session variables instead loading from step() function

                ],
            ],

            'role-manager' => [
                'web' => [
                    'expenses' => [
                        'tabs' => [
                            'My Expenses' => [
                                'enabled' => true,
                                'can-verify' => false,
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->where('fk_UserID' , auth()->id())
                                        ->whereNull('linkTo')
                                        ->whereNull('linkToID')
                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),

                            ],
                            'Staff' => [
                                'enabled' => true,

                                'can-verify' => [
                                    'logic' => (function(?int $userId){
                                        return (bool) ExpensesVerifiers::query()
                                            ->where([
                                                'verifier_user_id'  => auth()->id(), //person to verify
                                                'expense_user_id'   => $userId,    //the expense owner
                                            ])
                                            ->first();
                                    }),
                                    'is_flat_logic' => false,
                                ],
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->where(function($q){
                                            $usersAllowedToVerify = ExpensesVerifiers::query()
                                                ->where('verifier_user_id', auth()->id())
                                                ->whereIn('expense_user_id', User::query()
                                                    ->whereBetween('user_type', ['3.0', '6.0'])
                                                    ->where('inactive', 0)
                                                    ->pluck('id')
                                                )
                                                ->pluck('expense_user_id');

                                            return $q
                                                ->whereIn('fk_UserID', $usersAllowedToVerify)
                                                ->orWhere('fk_UserID', auth()->id());
                                        })
//                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'monthyear' => ExpenseConfig::groupByTimeLine(),
                                    'Staff' => ExpenseConfig::groupByCreator(true, true, true),
                                ]

                            ],
                            'CYSW' => [
                                'enabled' => false,
                                'can-verify' => true,
                                'collection' => (function(){
                                    $usersAllowedToVerify = ExpensesVerifiers::query()
                                        ->where('verifier_user_id', auth()->id())
                                        ->whereIn('expense_user_id', User::query()
                                            ->whereIn('user_type', ['1.0'])
                                            ->where('inactive', 0)
                                            ->pluck('id')
                                        )
                                        ->pluck('expense_user_id');

                                    return Expenses::query()
                                        ->whereIn('fk_UserID', $usersAllowedToVerify)
                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),

                            ],
                            'Foster Parents' => [
                                'enabled' => false,
                                'can-verify' => true,
                                'collection' => (function(){
                                    $usersAllowedToVerify = ExpensesVerifiers::query()
                                        ->where('verifier_user_id', auth()->id())
                                        ->whereIn('expense_user_id', User::query()
                                            ->whereBetween('user_type', ['2.0', '2.4'])
                                            ->where('inactive', 0)
                                            ->pluck('id')
                                        )
                                        ->pluck('expense_user_id');

                                    return Expenses::query()
                                        ->whereIn('fk_UserID', $usersAllowedToVerify)
                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'monthyear' => ExpenseConfig::groupByTimeLine(),
                                    'Foster Parent' => ExpenseConfig::groupByCreator(true, true, true),
                                ]

                            ],
                            'Children' => [
                                'enabled' => false,
                                'can-verify' => true,
                                'collection' => (function(){
                                    $childrenIds = Child::query()
                                        ->where('inactive', 0)
                                        ->where('WeSchedule', 1)
                                        ->pluck('id');

                                    return Expenses::query()
                                        ->where('linkTo', 'Children')
                                        ->whereIn('linkToID', $childrenIds)
                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),

                            ],
                        ],
                    ]
                ],
                'mobile' => [
                    'expenses' => [
                        'create-form' => true, //stage 3 auto disabled and linked direct to login person only
                        'list-view' => true,
                    ],
                ],
            ],

            'case-manager' => [
                'web' => [
                    'expenses' => [
                        'tabs' => [
                            'My Expenses' => [
                                'enabled' => true,
                                'can-verify' => false,
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->where('fk_UserID' , auth()->id())
                                        ->whereNull('linkTo')
                                        ->whereNull('linkToID')
                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),

                            ],

                            'Foster Parents' => [
                                'enabled' => false,
                                'can-verify' => true,
                                'collection' => (function(){
                                    //getStaffFromCaseManager
                                    $fosterIds = User::query()
                                        ->where('fk_CaseManagerID', auth()->id())
                                        ->whereIn('user_type', self::roleMapping()['foster-parent'])
                                        ->pluck('id');

                                    return Expenses::query()
                                        ->whereIn('fk_UserID', $fosterIds)
                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'monthyear' => ExpenseConfig::groupByTimeLine(),
                                    'Foster Parent' => ExpenseConfig::groupByCreator(true, true, true),
                                ]

                            ],

                            'Children' => [
                                'enabled' => false,
                                'can-verify' => true,
                                'collection' => (function(){
                                    $childrenIds = Child::query()
                                        ->where('FosterHome_fk_UserID', auth()->id())
                                        ->where('inactive', 0)
                                        ->where('WeSchedule', 1)
                                        ->pluck('id');

                                    return Expenses::query()
                                        ->whereIn('linkToID', $childrenIds)
                                        ->where('linkTo', 'Children')
                                        //->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),

                            ],
                        ],
                    ]
                ],
                'mobile' => [
                    'expenses' => [
                        'create-form' => true, //stage 3 auto disabled and linked direct to login person only
                        'list-view' => true,
                    ],
                ],
            ],

            'cysw' => [
                'mobile' => [
                    'home-route' => "/mobile",
                    'redirect-to' => '',//home
                    'expenses' => [
                        'create-form' => [
                            /*
                                - expense-create-form {
                                if(manual_mode){
                                    add delete button per each row
                                    is_manually_entered: true,
                                }else{
                                    is_manually_entered: false,
                                }

                                if(values is updated){
                                    is_tampered: true,
                                }else{
                                    is_tampered: false,
                                }

                                - imbeded in the child view->expese tab

                                utilize session variables instead loading from step() function
                             */
                            'enabled' => true,
                            'link-to' => [
                                'Child' => [ //display name
                                    'value' => 'Children', //linkTo Value
                                    'sub-options' =>
                                    /**
                                     * @return iterable
                                     * Can be a:-
                                     * - (Array|Collection) of 'lnkToId'(s) //static key-pair data
                                     * - Function returning [Array|Collection of `linkToId`(s) -OR- a single `linkToId`] //for runtime evaluated data
                                     */
                                        (function() : iterable{
                                            return ['' => Session('expense.child_id')];
                                        }),
                                ],
                            ],
                        ],
                        'list-view' => [
                            'enable' => true,
                            'collection' => (function (){
                                /*
                                    order-by: {
                                        my expenses first "user()->expenses()->latest()->limit(this_month)",
                                        second children "user()->assgnedChildren()->expenses()->latest()->limit(this_month)"
                                    }
                                    //ignore:group by child
                                    //on left menu after profile element
                                */
                                return Expenses::query()
                                    ->where('fk_UserID' , auth()->id())
                                    ->limitToThisMonth()
                                    ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                    ->orderBy('datetime','DESC');
                            }),
                        ],
                    ],
                ],
            ],

            'foster-parent' => [
                'web' => [
                    'expenses' => [
                        'tabs' => [
                            'Foster Parent' => [
                                'enabled' => false,
                                'can-verify' => false,
                                'collection' => (function(){
                                    return Expenses::query()
                                        ->where('fk_UserID' , auth()->id())
//                                        ->whereNull('linkTo')
//                                        ->whereNull('linkToID')
                                        ->limitToThisMonth()
                                        ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                        ->orderBy('datetime','DESC');
                                }),
                                'group-by' => [
                                    'monthyear' => self::groupByTimeLine(),
                                    'Child' => self::groupByChild(true, true, true),//more customization
                                    //TODO::ashain, not implemented, 'fk_UserID_&_linkToId'
                                ],
                            ],
                        ],
                    ]
                ],

                'mobile' => [
                    'home-route' => "/mobileCM",
                    'redirect-to' => '',//expense create button location.
                    'expenses' => [
                        'create-form' => [
                            /*
                                - expense-create-form {
                                if(manual_mode){
                                    add delete button per each row
                                    is_manually_entered: true,
                                }else{
                                    is_manually_entered: false,
                                }

                                if(values is updated){
                                    is_tampered: true,
                                }else{
                                    is_tampered: false,
                                }

                                - imbeded in the child view->expese tab

                                utilize session variables instead loading from step() function
                             */
                            'enabled' => true,
                            'link-to' => [
                                'My Self' => [
                                    'value' => null, //linkTo
                                    'sub-options' => null //linkToId
                                ],
                                'Child' => [
                                    'value' => 'Children',
                                    'sub-options' =>
                                    /**
                                     * @return iterable
                                     * Can be a:-
                                     * - (Array|Collection) of 'lnkToId'(s) //static key-pair data
                                     * - Function returning [Array|Collection of `linkToId`(s) -OR- a single `linkToId`] //for runtime evaluated data
                                     */
                                        (function() : iterable{
                                            return auth()->user()->getCaseManageChildren->pluck('initials', 'id');
                                        }),
                                ],
                            ],
                        ],
                        'list-view' => [
                            'enable' => true,
                            'collection' => (function (){
                                /*
                                    order-by: {
                                        my expenses first "user()->expenses()->latest()->limit(this_month)",
                                        second children "user()->assgnedChildren()->expenses()->latest()->limit(this_month)"
                                    }
                                    //ignore:group by child
                                    //on left menu after profile element
                                */
                                return Expenses::query()
                                    ->where('fk_UserID' , auth()->id())
                                    ->limitToThisMonth()
                                    ->with(['media', 'multiChild', 'expensePayout', 'getUser', 'verifiedBy'])
                                    ->orderBy('datetime','DESC');
                            }),
                        ],
                    ],
                ],
            ],

        ];

    }
}

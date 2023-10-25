<?php

namespace App\CustomClasses\DynamicExpenseBuilder;

use App\Models\Child;
use App\Models\CreditCard;
use App\Models\Expenses;
use App\Models\User;
use Illuminate\Support\Collection;

class ExpenseTester extends Expenses
{

    use ExpenseCore;

    private static function randomDummyLineItems(): array
    {
        $allItems = [
            [
                "qty" => "32",
                "item" => "ITEM 1",
                "price" => "1.98",
                "total" => "63.36",
                "category" => "5662"
            ],
            [
                "qty" => "14",
                "item" => "ITEM 2",
                "price" => "4",
                "total" => "56.00",
                "category" => "5772"
            ],
            [
                "qty" => "2",
                "item" => "ITEM 3",
                "price" => 1,
                "total" => "2.00",
                "category" => "5226"
            ],
            [
                "qty" => "9",
                "item" => "ITEM 4",
                "price" => 1,
                "total" => "9.00",
                "category" => "5772"
            ],
            [
                "qty" => "1",
                "item" => "ITEM",
                "price" => 1,
                "total" => 1,
                "category" => "5772"
            ],
            [
                "qty" => "1",
                "item" => "ITEM",
                "price" => 1,
                "total" => 1,
                "category" => "5772"
            ],
            [
                "qty" => "1",
                "item" => "ITEM",
                "price" => 1,
                "total" => "1.00",
                "category" => "5772"
            ],
            [
                "qty" => "1",
                "item" => "ITEM",
                "price" => 1,
                "total" => 1,
                "category" => "5772"
            ],
            [
                "qty" => "2",
                "item" => "ITEM",
                "price" => 1,
                "total" => "2.00",
                "category" => "5772"
            ],
            [
                "qty" => "7",
                "item" => "ITEM 10",
                "price" => 1.99,
                "total" => "13.93",
                "category" => "5772"
            ],
            [
                "qty" => "2",
                "item" => "Test",
                "price" => "3",
                "total" => "6.00",
                "category" => null
            ]
        ];

        $sendingItems = [];
        foreach ($allItems as $item){
            if(random_int(0,1)){
                $sendingItems[] = $item;
            }
        }
        return $sendingItems;
    }

    private static function addExpense($label, $fk_UserID, $linkTo, $linkToID=null, $lineItems = null): Expenses
    {
        $expense = new self();
        $expense->fk_UserID = $fk_UserID;

        //attach credit card randomly if exist with a probability of 70%
        $userCreditCards = CreditCard::query()->where('user_id', $fk_UserID)->get();
        if($userCreditCards->isNotEmpty()){

            if(random_int(1,100) >= 30){ //30% possibility for a card payment

                $expense->payment_type = Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD;
                $expense->last_four_digits = $userCreditCards->random()->last_four_digits;  //randomly pick a card attached to user

            }else{
                $expense->payment_type = Expenses::PAYMENT_METHOD__UNSPECIFIED;
            }

        }else{
            $expense->payment_type = Expenses::PAYMENT_METHOD__UNSPECIFIED;
        }

        $expense->datetime =  now();
        $expense->description = "COSTCO ({$label}) Sample-X".random_int(9, 999);
        $expense->attachment = '2prsnoBhoz2XJNtwgYf4mijrbkU6sq35kQro8Vs3.jpg';
        $expense->HST = 1.02;
        $expense->updateLineItems($lineItems??self::randomDummyLineItems(), false);
        $expense->notes = 'some notes';

        $expense->linkTo = $linkTo;//model to link to
        $expense->linkToID = $linkToID;// model id

        $expense->save();
        return $expense;
    }

    private function randomlyMarkAsVerified(User $user =  null): static
    {
        if(random_int(1,10)<=4){ //25% verified
            $this->verified_by = $user?$user->id:auth()->id();
            $this->verified_at = now();
            $this->save();
            return $this;
        }
        return $this;
    }

    public static function seed($type){

        $label = $type;
        $roles = ExpenseConfig::roleMapping();
        $linkTo = null;
        $linkToId = null;


        //Staff
        if($type == 'staff'){
            $users = $regularUsers = User::whereIn('user_type', $roles['regular-staff'])->get();
            $label.=" / regular";

//            $users = $roleManager = User::whereIn('user_type', $roles['role-manager'])->get();
//            $label.=" / role-manager";

//            $users = $caseManager = User::whereIn('user_type', $roles['case-manager'])->get();
//            $label.=" / case-manager";
            $creator = ($users->where('id', auth()->id())->first()??$users->first());

            self::addExpense($label, $creator->id, $linkTo, $linkToId)
                ->randomlyMarkAsVerified();

        }elseif($type == 'CYSW'){
            $users = $cysw = User::whereIn('user_type', $roles['cysw'])->get();
            $linkTo = 'Children';
            /** @var Child $child */
            $child = Child::first();
            $linkToId = $child->id;
            $label.=" / Child:{$child->initials}";
            $creator = ($users->where('id', auth()->id())->first()??$users->first());

            self::addExpense($label, $creator->id, $linkTo, $linkToId)
                ->randomlyMarkAsVerified();

        }elseif($type == 'FosterParent'){
            $users = $fosterParents = User::whereIn('user_type', $roles['foster-parent'])->get();
            $creator = ($users->where('id', auth()->id())->first()??$users->first());

            self::addExpense($label, $creator->id, $linkTo, $linkToId)
                ->randomlyMarkAsVerified();

            $linkTo = 'Children';
            /** @var Child $child */
            $child = Child::first();
            $linkToId = $child->id;
            $label.=" / Child:{$child->initials}";

            self::addExpense($label, $creator->id, $linkTo, $linkToId)
                ->randomlyMarkAsVerified();
        }

    }

    public static function seedExpensesToAllUsers(bool $truncate = true){
        /** @var User[]|Collection $allSystemUsers*/
        $allSystemUsers = User::all();

        if($truncate){
            Expenses::truncate();
        }

        foreach ($allSystemUsers as $expenseCreator){
            /** @var User $expenseCreator */
            $loginLevel = self::getLoginRoleLevel($expenseCreator); //find login level to derive functions allowed
            $targetCount = random_int(3, 10); //number of expenses to create

            $shopNameSuffix = $loginLevel; //inject login level to shop name

            //default flags
            $canRaiseOwnExpense = false;
            $canRaiseChileExpense = false;
            $linkTo = null;
            $linkToId = null;

            //override default value and initiate more variables based on the login level
            switch ($loginLevel){
                case 'super-admin'   :
                    break;
                case 'case-manager':
                case 'role-manager':
                case 'regular-staff' :
                    $canRaiseOwnExpense = true; //override
                    break;

                case 'cysw'          :
                    $canRaiseChileExpense = true;  //override
                    $linkTo = 'Children';  //override
                    $usersChildren = $expenseCreator->getAssignedChildren;
                    break;

                case 'foster-parent' :
                    $canRaiseOwnExpense = true;  //override
                    $canRaiseChileExpense = true;  //override
                    $linkTo = 'Children';  //override
                    $usersChildren = $expenseCreator->getCaseManageChildren;
                    break;
            }

            for($expIndex = 0; $expIndex<$targetCount; $expIndex++){

                if($canRaiseOwnExpense) {
                    self::addExpense($shopNameSuffix, $expenseCreator->id, null, null)->randomlyMarkAsVerified();
                }

                if($canRaiseChileExpense) {
                    foreach ($usersChildren as $child) {
                        self::addExpense($shopNameSuffix ." / Child:{$child->initials}", $expenseCreator->id, $linkTo, $child->id)->randomlyMarkAsVerified();
                    }
                }
            }
        }


    }
}

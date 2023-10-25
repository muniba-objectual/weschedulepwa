<?php

namespace App\Http\Livewire\ExpensesReport;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use Livewire\Component;

class DynamicScrumBoardComponent extends Component
{
    use ExpenseCore;

    public function render()
    {
        $this->initExpenseConfig();

        $collection = $this->getSourceQueryBuilder()->get()->groupBy('fk_UserID');

        $collection->transform(function ($userExpenseCollection, $fkUserID){
            $group = [
                'items' => $userExpenseCollection,
                'user' => $userExpenseCollection->first()->getUser,
                'unverified' => $userExpenseCollection->count(),
                'verified' => $userExpenseCollection->count(),
                'paid' => $userExpenseCollection->count(),
            ];

            if($group['verified']>0 && session('fake_stage'.$fkUserID)==1){
                $group['stage'] = 1;
            }elseif($group['unverified']>0 && session('fake_stage'.$fkUserID)==2){
                $group['stage'] = 2;
            }elseif($group['paid']>0 && session('fake_stage'.$fkUserID)==3){
                $group['stage'] = 3;
            }else{
                $group['stage']=1;
                session()->put('fake_stage'.$fkUserID, 1);
            }

            return $group;
        });

        return view('livewire.expenses-report.dynamic-scrum-board-component', compact('collection'));
    }

    public function updateStage($userId, $stageLevel){
        session()->put('fake_stage'.$userId,$stageLevel);
    }

    private function recursiveGroupBy($groupConfigs, $collection, &$summaries, $parentKey='root'){

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
            $collection->transform(function($item, $key) use($parentKey, $groupConfigs, &$summaries, $GroupByLogicIndex, $groupByConfig) {

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
                $fullKeyPath = $parentKey.'.'.str_replace('.', '-',$key);
                //end key refactor

                /**Summary Details */
                //Group type
                $groupSummaryDetails['type'] = $GroupByLogicIndex;

                //URL to grouped source
                $groupSummaryDetails['url'] = '#';
                if(isset($groupByConfig['url'])){
                    $uncompletedUrl = $groupByConfig['url'][0];
                    $prop = $groupByConfig['url'][1];
                    $groupSummaryDetails['url'] = str_replace('{slug}', $item->first()->$prop, $uncompletedUrl);
                }

                //group summary
                foreach ($groupByConfig['summary']??[] as $summaryName => $function){
                    $groupSummaryDetails['summary'][$summaryName] = $function($item, $key);
                }

                $summaries->put($fullKeyPath, $groupSummaryDetails);

                //if has further groupBy logic, call recursive groupBy to this N`th element.
                if(count($groupConfigs)){
                    $item = $this->recursiveGroupBy($groupConfigs, $item, $summaries, $fullKeyPath);
                }

                return $item;
            });
        }


        //return item after transformation
        return $collection;
    }

}

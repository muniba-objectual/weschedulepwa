<?php

/**
 * This file contains process to turn data into pivot table
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */
/*
->pipe(new Pivot(array(
    "column"=>"orderYear, orderMonth",
    "row"=>"customerName, productLine, productName"
    "aggregates"=>array(
        "sum"=>"dollar_sales",
        "count"=>"dollar_sales",
        "avg"=>"dollar_sales",
    )
)))
 */

namespace koolreport\pivot\processes;

use \koolreport\core\Utility as Util;

class Pivot extends \koolreport\core\Process
{
    protected static $instanceId = 0;

    protected $pivotId;
    protected $dimensions = array();
    protected $aggregates = array();
    protected $validOperators = array(
        'sum', 'count', 'avg', 'min', 'max',
        'count percent', 'sum percent',
        'count distinct', 'sum distinct',
        'count not null',
    );

    protected $data = array();
    protected $count = array();
    protected $countAll = array();
    protected $sumAll = array();
    protected $hasAvg = array();
    protected $hasCountPercent = array();
    protected $hasSumPercent = array();
    protected $distinctValues = array();

    protected $nameToIndexD = array();
    protected $indexToNameD = array();
    protected $nameToNode = [];
    protected $forwardMeta;

    protected $partialProcessing;
    protected $expandTrees;
    protected $command;

    protected $isUpdate = false;
    protected $index = 0;
    protected $cacheData;

    protected $incrementalProcessing;
    protected $orderField;
    protected $lastRowReached = false;
    protected $lastRow;
    protected $cacheUpdated = null;

    protected function onInit()
    {
        $this->pivotId = Util::get($this->params, "id", $this::$instanceId++);
        // echo "this->pivotId={$this->pivotId}<br>";
        $this->partialProcessing = Util::get($this->params, "partialProcessing", false);
        $this->cache = Util::get($this->params, "cache");
        $this->showCacheInfo = Util::get($this->cache, "showCacheInfo");
        $this->showUsage = Util::get($this->params, ['debug', 'showUsage']);
        $this->customAggregates = Util::get($this->params, "customAggregates", []);
        $this->incrementalProcessing = Util::get($this->params, 'incrementalProcessing');
        $this->orderField = Util::get($this->incrementalProcessing, 'orderField');

        $trimArray = function ($arr, $defaultArr = []) {
            if (empty($arr)) {
                $arr = [];
            }

            $arr = is_string($arr) ? explode(",", $arr) : $arr;
            // $arr = array_map('trim', $arr);
            // $arr = array_filter($arr, function ($v) {
            //     return !empty($v);
            // });
            foreach ($arr as $k => $v) {
                if (is_string($v)) {
                    $arr[$k] = trim($v);
                    if (empty($arr[$k])) unset($arr[$k]);
                }
            }
            return !empty($arr) ? $arr : $defaultArr;
        };

        if ($this->showUsage) {
            echo "Pivot init(): PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        }

        $this->isUpdate = $isUpdate = false;
        if (isset($_POST['koolPivotUpdate'])) {
            $koolPivotConfig = &$_POST['koolPivotConfig'];
            $config = is_string($koolPivotConfig) ? json_decode($koolPivotConfig, true) : $koolPivotConfig;
            // Util::prettyPrint($config);
            // $config['expandTrees'] = [];
            if ($config['pivotId'] == $this->pivotId) {
                $this->isUpdate = $isUpdate = true;
            }
            if ($this->showUsage) echo "Pivot init 1: PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        }
        if ($isUpdate) {
            $this->expandTrees = &$config['expandTrees'];
            $koolPivotCommand = &$_POST['koolPivotCommand'];
            $this->command = is_string($koolPivotCommand) ? json_decode($koolPivotCommand, true) : $koolPivotCommand;
            // echo "Pivot init 2: PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
            // $this->command = $input['koolPivotCommand'];
            $columnFields = $config["columnFields"];
            $rowFields = $config["rowFields"];
            if (count($columnFields) > 0 && $columnFields[0] === 'root') {
                $columnFields = array_slice($columnFields, 1);
            }

            if (count($rowFields) > 0 && $rowFields[0] === 'root') {
                $rowFields = array_slice($rowFields, 1);
            }

            $dimensions = array(
                'column' => $columnFields,
                'row' => $rowFields,
            );
            $this->dimensions = array();
            foreach ($dimensions as $d => $fields) {
                $this->dimensions[$d] = array();
                if (is_string($fields)) {
                    $fields = explode(',', $fields);
                }

                foreach ($fields as $field) {
                    $field = trim($field);
                    if (!empty($field)) {
                        array_push($this->dimensions[$d], $field);
                    }
                }
            }
            $aggregates = array();
            $measures = $config["dataFields"];
            // $measures = [
            //     "dollar_sales - sum",
            //     "order_id - count",
            //     "dollar_sales - avg",
            // ];
            foreach ($measures as $measure) {
                $fieldAgg = explode(" - ", $measure);
                if (empty($aggregates[$fieldAgg[1]])) {
                    $aggregates[$fieldAgg[1]] = $fieldAgg[0];
                } else {
                    $aggregates[$fieldAgg[1]] .= ", " . $fieldAgg[0];
                }
            }
        } else {
            $this->dimensions = Util::get($this->params, "dimensions", array());
            $this->expandTrees = array();
            $this->command = array();
            foreach ($this->dimensions as $d => $fields) {
                $this->expandTrees[$d] = array(
                    'name' => 'root',
                    'children' => array(),
                );
                $this->command[$d] = array();
            }
            $dimensions = array();
            foreach ($this->dimensions as $d => $fields) {
                // echo "fields = "; print_r($fields); echo "<br>";
                $dimensions[$d] = [];
                $fields = $trimArray($fields);
                // echo "fields = "; print_r($fields); echo "<br>";
                foreach ($fields as $k => $v) {
                    if (is_string($v)) $dimensions[$d][] = $v;
                    else if (is_array($v)) {
                        $dimensions[$d][] = $k;
                    }
                }
                // echo "dimensions d = "; print_r($dimensions[$d]); echo "<br>";
            }
            $this->dimensions = $dimensions;
            $aggregates = Util::get($this->params, "aggregates", array());
        }

        // $this->emptyTrees = [];
        // foreach ($this->dimensions as $d => $fields) {
        //     $this->emptyTrees[$d] = array(
        //         'name' => 'root',
        //         'children' => array(),
        //     );
        // }

        $this->hasAvg = [];
        // $aggregates = [
        //     "sum"=>"dollar_sales",
        //     "count"=>"dollar_sales, order_id",
        //     "avg"=>"dollar_sales",
        // ];
        foreach ($aggregates as $operator => $aggFields) {
            $op = trim(strtolower((string) $operator));
            if (!in_array($op, $this->validOperators)) {
                continue;
            }
            $aggFields = $trimArray($aggFields);
            foreach ($aggFields as $af) {
                Util::init($this->aggregates, $af, []);
                $this->aggregates[$af][] = $op;
                if ($op === 'avg') {
                    $this->hasAvg[$af] = true;
                }
                if ($op === 'count percent') {
                    $this->hasCountPercent[$af] = true;
                }
                if ($op === 'sum percent') {
                    $this->hasSumPercent[$af] = true;
                }
            }
        }
        // $this->aggregates = [
        //     'dollar_sales' => ['sum', 'count', 'avg'],
        //     'order_id' => ['count']
        // ];

        foreach ($this->dimensions as $d => $dimension) {
            $this->nameToIndexD[$d] = array();
            $this->indexToNameD[$d] = array();
        }

        if ($this->showUsage) {
            echo "Pivot end of init(): PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        }
    }

    protected function addToTree(&$expandTree, $fields, $node, $level)
    {
        $tree = &$expandTree;
        for ($i = 0; $i < $level && $i < count($fields); $i++) {
            $field = $fields[$i];
            if ($node[$field] === '{{all}}') {
                continue;
            }

            $foundNode = false;
            if (!isset($tree['children'])) $tree['children'] = [];
            foreach ($tree['children'] as &$child) {
                if ((string) $child['name'] === (string) $node[$field]) {
                    $tree = &$child;
                    $foundNode = true;
                    break;
                }
            }

            if (!$foundNode) {
                $newNode = array(
                    'name' => $node[$field],
                    'children' => array(),
                );
                array_push($tree['children'], $newNode);
                $tree = &$newNode;
            }
        }
        return true;
    }

    protected function isInTree(&$expandTree, $fields, $node)
    {
        $tree = &$expandTree;
        foreach ($fields as $i => $field) {
            if ($i === 0) {
                continue;
            }

            if ($node[$field] === '{{all}}') {
                break;
            }

            $parentField = $fields[$i - 1];
            $foundParentNode = false;
            foreach ($tree['children'] as &$child) {
                if ((string) $child['name'] === (string) $node[$parentField]) {
                    $tree = &$child;
                    $foundParentNode = true;
                    break;
                }
            }

            if (!$foundParentNode) {
                return false;
            }
        }
        return true;
    }

    protected function onInput($row)
    {
        if (isset($this->hasCacheData)) {
            if (isset($this->orderField)) {
                $currentOrder = isset($row[$this->orderField]) ? $row[$this->orderField] : null;
                // echo "currentOrder = $currentOrder<br>";
                if ($currentOrder < $this->lastOrder) {
                    // echo "Processed row, smaller order<br>";
                    return;
                } else if ($currentOrder === $this->lastOrder) {
                    // print_r($this->cachedLastRow); echo "<br>";
                    // print_r($row); echo "<br>";
                    $sameRow = true;
                    foreach ($row as $k => $v) {
                        if ($this->cachedLastRow[$k] !== $v) {
                            $sameRow = false;
                            break;
                        }
                    }
                    if ($sameRow && !$this->lastRowReached) {
                        $this->lastRowReached = true;
                    }
                    if (!$this->lastRowReached && !$sameRow) {
                        // echo "Process row, same order<br>";
                        return;
                    }
                    if ($this->lastRowReached && $sameRow) {
                        // echo "Process row, same order<br>";
                        return;
                    }
                    // echo "New row, same order<br>";
                } else {
                    // echo "New row, bigger order<br>";
                }
            } else {
                return;
            }
        }
        // echo "onInput<br>";

        $this->cacheUpdated = false;

        $this->lastRow = $row;

        $this->index++;
        $nodesD = array();

        foreach ($this->dimensions as $dimensionName => $labelFields) {
            $d = $dimensionName;
            $expandTree = &$this->expandTrees[$d];
            $command = &$this->command[$d];
            $nameToIndex = &$this->nameToIndexD[$d];
            $indexToName = &$this->indexToNameD[$d];
            $nodesD[$d] = array();

            $node = array();
            foreach ($labelFields as $i => $labelField) {
                $node[$labelField] = '{{all}}';
            }

            $nodeName = implode(' - ', $node);
            if (!isset($nameToIndex[$nodeName])) {
                $index = count($indexToName);
                $nameToIndex[$nodeName] = $index;
                $indexToName[$index] = $node;
            }
            array_push($nodesD[$d], 0);

            foreach ($labelFields as $i => $labelField) {
                $node[$labelField] = Util::get($row, $labelField, '{{other}}');
                $expandLevel = Util::get($command, "expand", -1);
                if (!$this->partialProcessing) {
                    $expandLevel = count($labelFields);
                }

                if ($expandLevel >= $i) {
                    $this->addToTree($expandTree, $labelFields, $node, $expandLevel);
                } else if (!$this->isInTree($expandTree, $labelFields, $node)) {
                    continue;
                }

                $nodeName = implode(' - ', $node);
                if (isset($nameToIndex[$nodeName])) {
                    $nodeIndex = $nameToIndex[$nodeName];
                } else {
                    $nodeIndex = count($indexToName);
                    $nameToIndex[$nodeName] = $nodeIndex;
                    $indexToName[$nodeIndex] = $node;
                }
                array_push($nodesD[$d], $nodeIndex);
            }
        }

        // error_reporting(E_ALL);

        $data = &$this->data;
        $count = &$this->count;
        $countAll = &$this->countAll;
        $sumAll = &$this->sumAll;
        $dataNodes = $this->buildDataNodes($nodesD);
        // echo "nodesD = "; print_r($nodesD); echo '<br>';
        // echo "dataNodes = "; Util::prettyPrint($dataNodes); echo '<br>';
        foreach ($this->aggregates as $aggregateField => $operators) {
            $af = $aggregateField;
            if (!isset($row[$af])) {
                continue;
            }

            foreach ($dataNodes as $dataNode) {
                // $dn = datanode name
                $dn = implode(" : ", $dataNode);
                $this->nameToNode[$dn] = $dataNode;

                Util::init($data, [$dn, $af], []);
                $datum = &$data[$dn][$af];
                foreach ($operators as $op) {
                    Util::init($datum, $op, $this->initValue($op, $af));
                    $datum[$op] = $this->aggValue($op, $datum[$op], $row[$af], $af, $row, $dn);
                }
                unset($datum);
                if (isset($this->hasAvg[$af])) {
                    Util::init($count, [$dn, $af], $this->initValue('count'));
                    $count[$dn][$af] += 1;
                }
            }

            if (isset($this->hasCountPercent[$af])) {
                Util::init($countAll, $af, $this->initValue('count'));
                $countAll[$af] += 1;
            }
            if (isset($this->hasSumPercent[$af])) {
                Util::init($sumAll, $af, $this->initValue('sum'));
                $sumAll[$af] += $row[$af];
            }
        }
    }

    protected function buildDataNodes($nodesD)
    {
        if (empty($nodesD)) return [[0]];
        $dataNodes = array();
        $nodes1 = reset($nodesD);
        if (count($nodesD) <= 1) {
            foreach ($nodes1 as $node1) {
                $dataNode = [$node1];
                $dataNodes[] = $dataNode;
            }
            return $dataNodes;
        }
        $nodesD2 = array_slice($nodesD, 1);
        $dataNodes2 = $this->buildDataNodes($nodesD2);
        foreach ($nodes1 as $node1) {
            $dataNode1 = [$node1];
            foreach ($dataNodes2 as $dataNode2) {
                $dataNode = array_merge($dataNode1, $dataNode2);
                $dataNodes[] = $dataNode;
            }
        }
        return $dataNodes;
    }

    protected function initValue($operator, $af = null)
    {
        $customOperator = Util::get($this->customAggregates, $operator, null);
        if (isset($customOperator)) {
            $func = Util::get($customOperator, '{initValue}', 0);
            $initValue = is_callable($func) ?
                $func($operator, $af) : $func;
            return $initValue;
        }
        switch ($operator) {
            case 'min':
                return PHP_INT_MAX;
            case 'max':
                return PHP_INT_MIN;
            case 'sum':
            case 'sum percent':
            case 'sum distinct':
            case 'count':
            case 'count percent':
            case 'count distinct':
            case 'count not null':
            case 'avg':
            default:
                return 0;
        }
    }

    protected function aggValue($operator, $aggValue, $value = null, $af = null, $row = null, $dn = null)
    {
        $customOperator = Util::get($this->customAggregates, $operator, null);
        if (isset($customOperator)) {
            $func = Util::get($customOperator, '{aggValue}', null);
            $aggValue = is_callable($func) ?
                $func($aggValue, $value, $af, $row, $dn) : $aggValue;
            return $aggValue;
        }
        switch ($operator) {
            case 'min':
                return min($aggValue, $value);
            case 'max':
                return max($aggValue, $value);
            case 'count':
            case 'count percent':
                return $aggValue + 1;
            case 'count distinct':
                if (isset($this->distinctValues[$af][$dn][$value])) return $aggValue;
                else {
                    Util::init($this->distinctValues, [$af, $dn, $value], true);
                    return (int) $aggValue + 1;
                }
            case 'sum distinct':
                if (isset($this->distinctValues[$af][$dn][$value])) return $aggValue;
                else {
                    Util::init($this->distinctValues, [$af, $dn, $value], true);
                    return (float) $aggValue + (float) $value;
                }
            case 'count not null':
                return $value !== null ? $aggValue + 1 : $aggValue;
            case 'avg':
            case 'sum':
            case 'sum percent':
            default:
                return (float) $aggValue + (float) $value;
        }
    }

    protected function processAverageAggregates()
    {
        foreach ($this->data as $dn => &$nodeValues) {
            foreach ($nodeValues as $af => &$datum) {
                if (!is_array($datum)) continue;

                if (isset($this->hasAvg[$af]) && isset($this->count[$dn][$af])) {
                    $datum['avg'] *= 1 / $this->count[$dn][$af];
                }

                if (isset($this->hasCountPercent[$af]) && isset($this->countAll[$af])) {
                    $datum['count percent'] *= 100 / $this->countAll[$af];
                }

                if (isset($this->hasSumPercent[$af]) && isset($this->sumAll[$af])) {
                    $datum['sum percent'] *= 100 / $this->sumAll[$af];
                }

                foreach ($datum as $op => &$v) {
                    $customOperator = Util::get($this->customAggregates, $op, null);
                    if (isset($customOperator)) {
                        $func = Util::get($customOperator, '{finalValue}', null);
                        $v = is_callable($func) ?
                            $func($v, $af, $dn) : $v;
                    }
                }
            }
        }
        unset($nodeValues, $datum, $v);
    }

    protected function processAggregateComputations()
    {
        // echo "this->dimensions = "; Util::prettyPrint($this->dimensions);
        // echo "dimensionNames = "; Util::prettyPrint($dimensionNames);
        $computations = $this->computations = Util::get($this->params, 'computations', []);
        if (!empty($computations)) {
            $evaluator = new \koolreport\pivot\Evaluator();
            foreach ($computations as $computationName => $formulaOrFunc) {
                $this->forwardMeta['pivotAggregates'][] = $computationName;
                $this->forwardMeta['columns'][$computationName] = ['type' => 'number'];
            }
        }
        // echo "this->forwardMeta columns = "; Util::prettyPrint($this->forwardMeta['columns']);

        // echo "this->data = "; Util::prettyPrint(reset($this->data));
        $dimensionNames = array_keys($this->dimensions);
        $count = -1;
        foreach ($this->data as $dn => $nodeValues) {
            $count++;
            $row = array();
            foreach ($nodeValues as $af => $datum) {
                if (!is_array($datum)) continue;
                foreach ($datum as $operator => $value) {
                    $row[$af . ' - ' . $operator] = $value;
                }
            }

            $dataNode = $this->nameToNode[$dn];
            // Util::prettyPrint($dataNode);
            foreach ($dataNode as $di => $node) {
                // $row['column'] = 0; $row['row'] = 0;
                $dimensionName = Util::get($dimensionNames, $di, 'root');
                $row[$dimensionName] = $this->indexToNameD[$dimensionName][$node];
            }
            // if ($count < 2) { 
            //     echo "row = "; Util::prettyPrint($row);
            // }

            // $row['dollar_sales - custom op'] = 0;
            foreach ($computations as $computationName => $formulaOrFunc) {
                if (is_string($formulaOrFunc)) {
                    $formula = $formulaOrFunc;
                    // echo "row = "; print_r($row); echo "<br>";
                    foreach ($row as $k => $v) {
                        $formula = str_replace('{' . $k . '}', $v, $formula);
                    }
                    // echo "formula = $formula <br>";
                    $this->data[$dn][$computationName] = $evaluator->execute($formula);
                } else if (is_callable($formulaOrFunc)) {
                    $func = $formulaOrFunc;
                    $this->data[$dn][$computationName] = $func($row);
                }
            }
        }
        // echo "this->data = "; Util::prettyPrint(array_slice($this->data, 0, 5));
    }

    protected function processDimensionComputations()
    {
        $allNodesD = [];
        foreach ($this->dimensions as $dName => $lFields) {
            $allNodesD[$dName] = range(0, count($this->indexToNameD[$dName]) - 1);
        }

        $dimensionNames = array_keys($this->dimensions);
        $dimensionIndex = 0;
        foreach ($this->dimensions as $dimensionName => $labelFields) {
            $nameToIndex = &$this->nameToIndexD[$dimensionName];
            $indexToName = &$this->indexToNameD[$dimensionName];
            $nodesD = $allNodesD;
            $nodesD[$dimensionName] = [];
            // echo "nodesD = "; Util::prettyPrint($nodesD);   
            // $dataNodes = $this->buildDataNodes($nodesD);
            // echo "dataNodes = "; Util::prettyPrint($dataNodes);   
            foreach ($labelFields as $levelIndex => $labelField) {
                $labelComputations = Util::get($this->params, ['dimensions', $dimensionName, $labelField, 'computations']);
                if (!empty($labelComputations)) {
                    // echo "levelIndex = $levelIndex<br>";
                    $expandTree = $this->expandTrees[$dimensionName];
                    // echo "expandTree = "; Util::prettyPrint($expandTree); exit;
                    $endLevel = $levelIndex;
                    $startLevel = 0;
                    $distinctNodes = $this->getDistinctNodes($expandTree, $startLevel, $endLevel);
                    // echo "distinctNodes = "; Util::prettyPrint($distinctNodes);
                    foreach ($distinctNodes as $distinctNode) {
                        $nodeChildren = $this->getNodeChildren($expandTree, $distinctNode);
                        // echo "nodeChildren = "; Util::prettyPrint($nodeChildren);
                        $nodeChildrenIndexes = $this->getNodeIndexes($nodeChildren, $dimensionName);
                        // echo "nodeChildrenIndexes = "; Util::prettyPrint($nodeChildrenIndexes);
                        foreach ($labelComputations as $computationName => $formulaOrFunc) {
                            $newNode = array_slice($distinctNode, 1); // remove "root" node part at the beginning
                            array_push($newNode, "{{" . $computationName . "}}");
                            for ($i = $levelIndex + 1; $i < count($labelFields); $i++) {
                                array_push($newNode, "{{all}}");
                            }
                            // echo "newNode = "; Util::prettyPrint($newNode);
                            $compNodeName = implode(' - ', $newNode);
                            if (!isset($nameToIndex[$compNodeName])) {
                                $newIndex = count($indexToName);
                                $nameToIndex[$compNodeName] = $newIndex;
                                $indexToName[$newIndex] = array_combine($labelFields, $newNode);

                                $nodesD[$dimensionName] = [$newIndex];
                                $newDataNodes = $this->buildDataNodes($nodesD);
                                // echo "newDataNodes = "; print_r($newDataNodes); echo "<br>";
                                foreach ($newDataNodes as $newDataNode) {
                                    // echo "newDataNode = "; print_r($newDataNode); echo "<br>";
                                    // echo "newDataRow = "; print_r($newDataRow); echo "<br>";
                                    $newDataNodeName = implode(' : ', $newDataNode);
                                    $this->nameToNode[$newDataNodeName] = $newDataNode;
                                    $newDataRow = [];

                                    $dimensionRow = [];
                                    foreach ($newDataNode as $ndi => $nNode) {
                                        // $row['column'] = 0; $row['row'] = 0;
                                        $thisDimensionName = Util::get($dimensionNames, $ndi, 'root');
                                        if (isset($this->indexToNameD[$thisDimensionName][$nNode]))
                                            $dimensionRow[$thisDimensionName] = $this->indexToNameD[$thisDimensionName][$nNode];
                                    }

                                    $aggRow = $dimensionRow;
                                    foreach ($this->aggregates as $df => $operators) {
                                        $newDataRow[$df] = [];
                                        foreach ($operators as $operator) {
                                            $childrenDataNode = $newDataNode;
                                            // var_dump($childrenDataNode); exit;
                                            foreach ($nodeChildrenIndexes as $nodeChildrenIndex) {
                                                $nodeChildName = $indexToName[$nodeChildrenIndex];
                                                // var_dump($nodeChildName); exit;
                                                $childrenDataNode[$dimensionIndex] = $nodeChildrenIndex;
                                                // echo "childrenDataNode = "; var_dump($childrenDataNode); echo "<br>";
                                                $nodeChildrenStr = implode(' : ', $childrenDataNode);
                                                // var_dump($nodeChildrenStr); exit;
                                                $aggRow[$nodeChildName[$labelField]] = Util::get($this->data, [$nodeChildrenStr, $df, $operator]);
                                            }
                                            // echo "1. aggRow = "; print_r($aggRow); echo "<br>";
                                            $measure = "$df - $operator";
                                            if (is_string($formulaOrFunc)) {
                                                $formula = $formulaOrFunc;
                                                foreach ($aggRow as $k => $v) {
                                                    if (isset($v)) $formula = str_replace('{' . $k . '}', (float)$v, $formula);
                                                }
                                                $defaultEmptyAggValue = 0;
                                                $formula = preg_replace('/\{[^{}]*\}/', $defaultEmptyAggValue, $formula);
                                                if (!isset($evaluator)) $evaluator = new \koolreport\pivot\Evaluator();
                                                $newDataRow[$df][$operator] = $evaluator->execute($formula);
                                            } else if (is_callable($formulaOrFunc)) {
                                                // echo "2. aggRow = "; print_r($aggRow); echo "<br>";
                                                $func = $formulaOrFunc;
                                                $newDataRow[$df][$operator] = $func($aggRow, $measure);
                                            }
                                        }
                                    }

                                    $aggRow = $dimensionRow;
                                    foreach ($this->computations as $computationName => $computation) {
                                        $newDataRow[$computationName] = [];
                                        $childrenDataNode = $newDataNode;
                                        // var_dump($childrenDataNode); exit;
                                        foreach ($nodeChildrenIndexes as $nodeChildrenIndex) {
                                            $nodeChildName = $indexToName[$nodeChildrenIndex];
                                            // var_dump($nodeChildName); exit;
                                            $childrenDataNode[$dimensionIndex] = $nodeChildrenIndex;
                                            // echo "childrenDataNode = "; var_dump($childrenDataNode); echo "<br>";
                                            $nodeChildrenStr = implode(' : ', $childrenDataNode);
                                            // var_dump($nodeChildrenStr); exit;
                                            $aggRow[$nodeChildName[$labelField]] = Util::get($this->data, [$nodeChildrenStr, $computationName]);
                                        }
                                        // echo "1. aggRow = "; print_r($aggRow); echo "<br>";
                                        $measure = $computationName;
                                        if (is_string($formulaOrFunc)) {
                                            $formula = $formulaOrFunc;
                                            foreach ($aggRow as $k => $v) {
                                                if (isset($v)) $formula = str_replace('{' . $k . '}', $v, $formula);
                                            }
                                            $defaultEmptyAggValue = 0;
                                            $formula = preg_replace('/\{[^{}]*\}/', $defaultEmptyAggValue, $formula);
                                            if (!isset($evaluator)) $evaluator = new \koolreport\pivot\Evaluator();
                                            $newDataRow[$measure] = $evaluator->execute($formula);
                                        } else if (is_callable($formulaOrFunc)) {
                                            // echo "2. aggRow = "; print_r($aggRow); echo "<br>";
                                            $func = $formulaOrFunc;
                                            $newDataRow[$measure] = $func($aggRow, $measure);
                                        }
                                    }
                                    // echo "aggRow = "; Util::prettyPrint($aggRow); echo "<br>";
                                    // echo "newDataRow = "; Util::prettyPrint($newDataRow); exit;

                                    $this->data[$newDataNodeName] = $newDataRow;
                                }
                            }
                        }
                    }
                }
            }
            $dimensionIndex++;
            unset($nameToIndex, $indexToName);
        }
        // echo "this->aggregates = "; Util::prettyPrint($this->aggregates);
    }

    protected function finalize()
    {
        $this->processAverageAggregates();

        $this->processAggregateComputations();

        $this->processDimensionComputations();

        $metaData = array();
        foreach ($this->dimensions as $dimensionName => $fields) {
            $d = $dimensionName;
            $metaDimension = array();
            $indexToName = $this->indexToNameD[$d];
            foreach ($indexToName as $i => $name) {
                array_push($metaDimension, $name);
            }
            $metaData[$d] = array('type' => 'dimension', 'index' => $metaDimension);
        }
        // Util::prettyPrint($this->forwardMeta);
        $this->forwardMeta['columns'] = array_merge(
            Util::get($this->forwardMeta, 'columns', array()),
            $metaData
        );

        // if aggregate operator is average, divide total sum by total count

        // echo "this->data = "; Util::prettyPrint(array_slice($this->data, 0, 5));

        // Util::prettyPrint($metaData);
        // Util::prettyPrint($this->data);
        // Util::prettyPrint($this->nameToNode);
        // echo "this->nameToIndexD['column'] = "; Util::prettyPrint($this->nameToIndexD['column']);
        // echo "this->indexToNameD['column'] = "; Util::prettyPrint($this->indexToNameD['column']);

        // if ($this->showUsage) {
        //     echo "Before copying data to originalData: PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        // }
        // $this->originalData = $this->data;
        // echo $this->hasNewRow ? "has new row<br>" : "Not has new row<br>";
        if ($this->cache && $this->lastRow) {
            $this->forwardMeta['pivotExpandTrees'] = $this->expandTrees;
            // $this->forwardMeta['pivotExpandTrees'] = $this->emptyTrees;
            if ($this->showCacheInfo) {
                echo "Save last row: ";
                print_r($this->lastRow);
                echo "<br>";
            }
            // Util::prettyPrint($this->data);
            file_put_contents($this->cacheMetaFile, json_encode([
                'meta' => &$this->forwardMeta,
                'nameToIndexD' => &$this->nameToIndexD,
                'indexToNameD' => &$this->indexToNameD,
                'nameToNode' => &$this->nameToNode,
                'lastRow' => &$this->lastRow,
            ], JSON_UNESCAPED_UNICODE), LOCK_EX);
            file_put_contents($this->cacheDataFile, json_encode($this->data, JSON_UNESCAPED_UNICODE), LOCK_EX);
        }
        // if ($this->showUsage) {
        //     echo "After copying data to originalData: PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        // }

        $dimensionNames = array_keys($this->dimensions);
        $rows = array();
        // echo "this->nameToNode = "; Util::prettyPrint($this->nameToNode);
        // echo "this->data = "; Util::prettyPrint(array_slice($this->data, 0, 5));
        foreach ($this->data as $dn => $nodeValues) {
            $row = array();
            foreach ($nodeValues as $af => $datum) {
                if (is_numeric($datum) || is_string($datum)) {
                    $row[$af] = $datum;
                }

                if (!is_array($datum)) continue;

                foreach ($datum as $operator => $value) {
                    $row[$af . ' - ' . $operator] = $value;
                }
            }

            $dataNode = $this->nameToNode[$dn];
            // Util::prettyPrint($dataNode);
            foreach ($dataNode as $di => $node) {
                // $row['column'] = 0; $row['row'] = 0;
                $dimensionName = Util::get($dimensionNames, $di, 'root');
                $row[$dimensionName] = $node;
            }

            array_push($rows, $row);
        }

        $this->data = null;
        $this->data = $rows;
        // echo "this->expandTrees column = "; Util::prettyPrint($this->expandTrees['column']);
        // $this->forwardMeta['pivotAggregates'] = null;
        // if ($this->showUsage) {
        //     echo "After changing data: PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        // }

        // Util::prettyPrint($metaData);
        // echo "this->data = "; Util::prettyPrint($this->data);
    }

    protected function getDistinctNodes($expandTree, $startLevel, $endLevel)
    {
        if ($startLevel > $endLevel) return [];

        $levelNode = $expandTree['name'];
        if ($startLevel === $endLevel) {
            return [[$levelNode]];
        }

        $nodes = [];
        foreach ($expandTree['children'] as $child) {
            // echo "child = "; Util::prettyPrint($child);
            $subNodes = $this->getDistinctNodes($child, $startLevel + 1, $endLevel);
            // echo "subNodes = "; Util::prettyPrint($subNodes);
            foreach ($subNodes as $subNode) {
                array_unshift($subNode, $levelNode);
                $nodes[] = $subNode;
            }
        }
        return $nodes;
    }

    protected function getNodeChildren($expandTree, $node)
    {
        if (empty($node)) return $expandTree;
        if ($node[0] !== $expandTree['name']) return [];
        $tmpTree = $expandTree;
        $lastNode = $tmpTree;
        $i = -1;
        foreach ($node as $nodeName) {
            $i++;
            if ($i === 0) continue;
            $children = $tmpTree['children'];
            foreach ($children as $child) {
                $childName = $child['name'];
                if ($nodeName === $childName) {
                    $tmpTree = $child;
                    $lastNode = $tmpTree;
                    break;
                }
            }
        }
        if ($i >= count($node) - 1) {
            $childNames = [];
            foreach ($lastNode['children'] as $child) {
                $nodeChild = $node;
                $nodeChild[] = $child['name'];
                $childNames[] = $nodeChild;
            }
            return $childNames;
        }
        return [];
    }

    protected function getNodeIndexes($nodes, $dimensionName)
    {
        $nameToIndex = &$this->nameToIndexD[$dimensionName];
        $dimensionSize = count($this->dimensions[$dimensionName]);
        $nodeIndexes = [];
        foreach ($nodes as $node) {
            // echo "node = "; print_r($node); echo "<br>";
            array_splice($node, 0, 1);
            for ($i = count($node); $i < $dimensionSize; $i++) {
                array_push($node, "{{all}}");
            }
            $nodeName = implode(' - ', $node);
            if (isset($nameToIndex[$nodeName])) $nodeIndexes[] = $nameToIndex[$nodeName];
        }
        return $nodeIndexes;
    }

    protected function getTempFolder()
    {
        $this->useLocalTempFolder = Util::get($this->cache, 'useLocalTempFolder');
        if (is_string($this->useLocalTempFolder)) {
            $path = $this->useLocalTempFolder;
            if (is_dir(realpath($path))) {
                return realpath($path);
            }
            $scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
            if (is_dir($scriptDir . "/" . $path)) {
                return $scriptDir . "/" . $path;
            }
            throw new \Exception("Temp directory does not exist: " . $path);
        } else if ($this->useLocalTempFolder) {
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            if (!is_dir(realpath($path) . "/tmp")) {
                mkdir(realpath($path) . "/tmp");
            }
            return realpath($path) . "/tmp";
        }
        return sys_get_temp_dir();
    }

    public function receiveMeta($metaData, $source)
    {
        if ($this->showUsage) {
            echo "Pivot begin of receiveMeta(): PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        }
        // echo "receiveMeta<br>";
        if ($this->showUsage) {
            $this->startTime = microtime(true);
        }

        if ($this->cache) {
            $report = $this->getReport();
            $reportPath = Util::getClassPath($report);
            $reportParams = $report->getParams();
            $pivotParams = [
                'dimension' => $this->dimensions,
                'aggregates' => $this->aggregates,
            ];
            $this->signature = md5(
                $reportPath . json_encode($reportParams) . $this->pivotId . json_encode($pivotParams)
            );
            // echo "reportPath = $reportPath<br>";
            // echo "reportParams = "; print_r($reportParams); echo "<br>";
            // Util::prettyPrint($this->dimensions);
            // Util::prettyPrint($this->aggregates);
            // echo "signature = " . $this->signature . "<br>";

            $tempFolder = $this->getTempFolder();
            $defaultCacheMetaName = "pivotcache_meta_" . $this->signature;
            $defaultCacheDataName = "pivotcache_data_" . $this->signature;
            $this->cacheMetaFile = Util::get($this->cache, 'metaFile', $defaultCacheMetaName);
            $this->cacheMetaFile = $tempFolder . "/" . $this->cacheMetaFile;
            $this->cacheDataFile = Util::get($this->cache, 'dataFile', $defaultCacheDataName);
            $this->cacheDataFile = $tempFolder . "/" . $this->cacheDataFile;
            $refreshCache = Util::get($this->cache, 'refresh', false);
            if ($refreshCache && !$this->isUpdate) {
                unlink($this->cacheMetaFile);
                unlink($this->cacheDataFile);
            } else {
                if ($this->showCacheInfo) {
                    echo "cacheMetaFile = " . $this->cacheMetaFile . "<br>\n";
                    echo "cacheDataFile = " . $this->cacheDataFile . "<br>\n";
                }
                $ttl = Util::get($this->cache, 'timeToLive', 3600);
                // echo "cacheFile = " . $this->cacheFile . "<br>";
                if (is_file($this->cacheMetaFile) && filemtime($this->cacheMetaFile) >= time() - 1 * $ttl) {
                    $this->cacheMeta = json_decode(file_get_contents($this->cacheMetaFile), true);
                    $this->nameToIndexD = &$this->cacheMeta['nameToIndexD'];
                    $this->indexToNameD = &$this->cacheMeta['indexToNameD'];
                    $this->nameToNode = &$this->cacheMeta['nameToNode'];
                    $this->cachedLastRow = $this->cacheMeta['lastRow'];
                    $this->forwardMeta = &$this->cacheMeta['meta'];
                    $this->expandTrees = &$this->forwardMeta['pivotExpandTrees'];
                    // echo "this->nameToIndexD = "; Util::prettyPrint($this->nameToIndexD);
                    // echo "this->indexToNameD = "; Util::prettyPrint($this->indexToNameD);
                    // echo "this->nameToNode = "; Util::prettyPrint($this->nameToNode);
                    // $this->cacheData = [];
                    // echo "has cacheData<br>";
                    // echo "cacheData = "; var_dump($this->cacheData); echo "<br>";
                    if ($this->showCacheInfo) {
                        echo "cachedLastRow = ";
                        print_r($this->cachedLastRow);
                        echo "<br>";
                    }
                    if (isset($this->orderField)) {
                        $this->lastOrder = Util::get($this->cachedLastRow, $this->orderField);
                        echo "lastOrder = $this->lastOrder<br>";
                    }
                }
                if (is_file($this->cacheDataFile) && filemtime($this->cacheDataFile) >= time() - 1 * $ttl) {
                    $this->hasCacheData = true;
                    $this->data = json_decode(file_get_contents($this->cacheDataFile), true);
                }
            }

            $isCli = php_sapi_name() == "cli";
            // Background processing and save the last state of pivot result
            $backgroundProcessing = Util::get($this->params, 'backgroundProcessing');
            // echo "backgroundProcessing = " ; var_dump($backgroundProcessing); echo "<br>\n";            
            if (!$isCli && $backgroundProcessing) {
                // $ignore_user_abort = Util::get($backgroundProcessing, 'ignore_user_abort', false);
                // if ($ignore_user_abort) ignore_user_abort(true);

                // $set_time_limit = Util::get($backgroundProcessing, 'set_time_limit', false);
                // $defaultTimeLimit = ini_get('max_execution_time');
                // if (is_numeric($set_time_limit)) {
                //     register_shutdown_function(function () use ($defaultTimeLimit) {
                //         set_time_limit($defaultTimeLimit);
                //     });
                //     set_time_limit($set_time_limit);
                // } 

                // $cacheFile = $this->cacheFile;
                // $data = &$this->data;
                // $meta = &$this->forwardMeta;
                // $lastRow = &$this->lastRow;
                // register_shutdown_function(function () use ($cacheFile, $data, $meta, $lastRow) {
                //     // ...
                // });

                // echo "current working directory = " . getcwd() . "<br>\n";
                $script_filename = $_SERVER['SCRIPT_FILENAME'];
                $backgroundFile = $backgroundFile = Util::get($backgroundProcessing, 'backgroundFile', $script_filename);
                if (is_file($backgroundFile)) {
                    $this->hasBackgroundFile = true;
                    $dir = dirname($backgroundFile);
                    // echo "file directory = " . dirname($backgroundFile) . "<br>\n";
                    chdir(dirname($backgroundFile));
                    // echo "current working directory = " . getcwd() . "<br>\n";
                    $isWindows =  strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
                    // $toNull = $isWindows ? " > NUL 2> NUL" : " > /dev/null 2>$1 &";
                    $toNull = $isWindows ? " > NUL" : " > /dev/null";

                    $lockFile = $backgroundFile;
                    $jobScript = "";
                    $jobScript .= "chdir(\"{$dir}\");";
                    $jobScript .= " \$lockFile = \"{$lockFile}\"; 
                        \$fp = fopen(\$lockFile, \"r+\"); 
                        if (!flock(\$fp, LOCK_EX | LOCK_NB)) { 
                            echo \"A previous job instance is running\\n\\n\"; 
                            exit; 
                        }; 
                        \$time = date(\"m/d/Y h:i:s a\", time());
                        echo \"\\nLock file \$lockFile: \$time \\n\\n\";
                    ";

                    // $jobScript .= " include_once \"{$olapJobPath}\";  \$olapJob = new {$olapJobClassName}();  \$olapJob->run(); ";
                    $jobScript .= "include_once \"{$backgroundFile}\";";

                    $jobScript .= " sleep(5); 
                        flock(\$fp, LOCK_UN); fclose(\$fp); 
                        \$time = date(\"m/d/Y h:i:s a\", time());
                        echo \"\\nRelease locked file \$lockFile: \$time \\n\\n\"; 
                        sleep(0); 
                    ";

                    // $jobScript = "echo \"php version = \" . phpversion();";

                    // $cmd = "php -d display_errors -r '{$jobScript}' >> {$olapJobClassName}.log 2>&1 &";
                    // $cmd = "php -d display_errors -r '{$jobScript}' > lock.log 2>&1 & echo $!; ";
                    $php = Util::get($backgroundProcessing, 'php', 'php');
                    $cmd = "$php -d display_errors -r '{$jobScript}' >> {$backgroundFile}.log 2>&1 & echo $!; ";
                    // $cmd = "php -d display_errors -r '{$jobScript}'";
                    echo "cmd = $cmd <br>\n";
                    // shell_exec($cmd);
                    $pid = exec($cmd, $output);

                    // shell_exec("php $backgroundFile $toNull"); // add & at the end to run in background
                }
            }

            // echo "SERVER = "; Util::prettyPrint($_SERVER);

            if ($this->showUsage) {
                echo "After loading cache: PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
            }
        }

        if (!empty($this->forwardMeta)) return;

        $this->metaData = array_merge($this->metaData, $metaData);
        $cMetas = $this->metaData['columns'];
        foreach ($this->aggregates as $af => $operators) {
            $cMeta = Util::get($cMetas, $af, []);
            foreach ($operators as $op) {
                $aggField = $af . ' - ' . $op;
                if ($op === 'count' || $op === 'count distinct' || $op === 'count not null') {
                    $cMetas[$aggField] = array_merge($cMeta, [
                        "type" => "number",
                        "decimals" => 0,
                    ]);
                } else if (in_array($op, ['count percent', 'sum percent'])) {
                    $cMetas[$aggField] = [
                        'type' => 'number',
                        'decimals' => 2,
                        'suffix' => '%',
                    ];
                } else if (in_array($op, ['sum', 'sum distinct', 'avg', 'min', 'max'])) {
                    $cMetas[$aggField] = $cMeta;
                } else {
                    $cMetas[$aggField] = $cMeta;
                }
            }
        }

        // echo "Pivot finalize this->dimensions = "; Util::prettyPrint($this->dimensions);
        $this->forwardMeta = [
            'pivotId' => $this->pivotId,
            'pivotDimensions' => $this->dimensions,
            'pivotRows' => Util::get($this->dimensions, 'row'),
            'pivotColumns' => Util::get($this->dimensions, 'column'),
            'pivotAggregates' => $this->aggregates,
            'pivotExpandTrees' => &$this->expandTrees,
            'columns' => $cMetas,
        ];
    }

    protected function onInputEnd()
    {
        // echo "this->data = "; Util::prettyPrint(array_slice($this->data, 0, 5));

        if (!isset($this->lastRow)) $this->cacheUpdated = true;

        $this->finalize();

        $this->sendMeta($this->forwardMeta);

        // echo "this->forwardMeta = "; Util::prettyPrint($this->forwardMeta);

        foreach ($this->data as $row) {
            $this->next($row);
        }

        if ($this->showUsage) {
            $time_elapsed_secs = microtime(true) - $this->startTime;
            echo "Pivot processing time = " . $time_elapsed_secs . "<br>";
            echo "Pivot PHP memory usage =  " . number_format(memory_get_usage()) . "<br>\n";
        }
    }

    public function getCacheMeta()
    {
    }

    public function getCacheData()
    {
    }
}

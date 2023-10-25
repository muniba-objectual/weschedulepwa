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
    ->pipe(new Pivot2D(array(
        "column"=>"orderYear, orderMonth",
        "row"=>"customerName, productLine, productName"
        "aggregates"=>array(
            "sum"=>"dollar_sales",
            "count"=>"dollar_sales",
            "avg"=>"dollar_sales",
            'sum percent' => 'dollar_sales',
            'count percent' => 'dollar_sales',
        )
    )))
  */

namespace koolreport\pivot\processes;

use \koolreport\core\Utility as Util;

class Pivot2D extends Pivot
{
    protected $fieldDelimiter;

    protected function onInit()
    {
        if (!isset($this->params["dimensions"])) {
            $columns = Util::get($this->params, "column", array());
            $rows = Util::get($this->params, "row", array());
            $this->params["dimensions"] = ['column' => $columns, 'row' => $rows];
        } else {
            Util::init($this->params, ["dimensions", "column"], []);
            Util::init($this->params, ["dimensions", "row"], []);
        }

        parent::OnInit();

        $this->fieldDelimiter = Util::get($this->params, "fieldDelimiter", ' -||- ');
        $dimensions = [
            'column' => $this->dimensions['column'],
            'row' => $this->dimensions['row'],
        ];
        $this->dimensions = $dimensions;
    }

    protected function finalize()
    {
        $this->processAverageAggregates();

        $this->processAggregateComputations();

        $this->processDimensionComputations();  

        $delimiter = $this->fieldDelimiter;
        $metaData = array('label' => 'string');
        $indexToName = $this->indexToNameD['column'];
        foreach ($indexToName as $i => $name) {
            $colName = implode($delimiter, $name);
            foreach ($this->aggregates as $af => $operators) {
                foreach ($operators as $op) {
                    $metaData[$colName . $delimiter .
                        $af . ' - ' . $op] = ['type' => 'number'];
                }
            }
        }
        $this->forwardMeta['columns'] = array_merge(
            $this->forwardMeta['columns'],
            $metaData
        );

        // echo "this->data = "; Util::prettyPrint(array_slice($this->data, 0, 5));

        

        $rows = array();

        // $computations = Util::get($this->params, 'computations', []);
        // if (!empty($computations)) {
        //     $evaluator = new \koolreport\pivot\Evaluator();
        //     foreach ($computations as $computationName => $formulaOrFunc) {
        //         $this->forwardMeta['pivotAggregates'][] = $computationName;
        //         $this->forwardMeta['columns'][$computationName] = ['type' => 'number'];
        //     }
        // }

        // echo "this->data = "; Util::prettyPrint($this->data);
        foreach ($this->data as $dn => $nodeValues) {
            $dataNode = $this->nameToNode[$dn];

            $indexToNameRow = $this->indexToNameD['row'];
            $nodeIndexRow = $dataNode[1];
            $nodeNameRow = implode($delimiter, $indexToNameRow[$nodeIndexRow]);
            Util::init($rows, $nodeNameRow, []);
            $rows[$nodeNameRow]['label'] = $row['label'] = $nodeNameRow;

            $indexToNameCol = $this->indexToNameD['column'];
            $nodeIndexCol = $dataNode[0];
            $nodeNameCol = implode($delimiter, $indexToNameCol[$nodeIndexCol]);
            $row = ['label' => $nodeNameRow];
            foreach ($nodeValues as $af => $datum) {
                if (is_numeric($datum) || is_string($datum)) {
                    $rows[$nodeNameRow][$nodeNameCol . $delimiter . $af] = $datum;
                }

                if (!is_array($datum)) continue;

                foreach ($datum as $operator => $value) {
                    $rows[$nodeNameRow][$nodeNameCol . $delimiter .
                        $af . ' - ' . $operator] = $value;
                }
            }
        }
        $this->data = &$rows;
    }

    public function receiveMeta($metaData, $source)
    {
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

        $this->forwardMeta = [
            'pivotId' => $this->pivotId,
            'pivotFormat' => 'pivot2D',
            'pivotRows' => $this->dimensions['row'],
            'pivotColumns' => $this->dimensions['column'],
            'pivotAggregates' => $this->aggregates,
            'pivotFieldDelimiter' => $this->fieldDelimiter,
            'pivotExpandTrees' => &$this->expandTrees,
            'columns' => $cMetas,
        ];
    }
}

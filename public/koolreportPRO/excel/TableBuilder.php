<?php

namespace koolreport\excel;

use \koolreport\core\Utility as Util;
use \PhpOffice\PhpSpreadsheet as ps;
use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use \Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use \Box\Spout\Common\Entity\Style\CellAlignment;

class TableBuilder extends WidgetBuilder
{
    public function saveContentToSheet($content, $sheet)
    {
        $this->sheet = $sheet;

        list($highestRow, $highestColumn, $range) =
            $this->getSheetRange($sheet, $content);
        $option = $content;
        $pos = Coordinate::coordinateFromString($range[0]);
        // echo "range = "; print_r($range); echo "<br>";
        // echo "pos = "; print_r($pos); echo "<br>";
        // $option['startColumn'] = Coordinate::columnIndexFromString($pos[0]);
        $option['startColumn'] = Coordinate::columnIndexFromString($pos[0]) - 1;
        $option['startRow'] = $pos[1];
        $this->option = $option;

        $sheetInfo = $this->exportHandler->sheetInfo;
        $tableAutoName = 'table_' . $sheetInfo['tableAutoId']++;
        $tableName = Util::get($content, 'name', $tableAutoName);
        $sheetInfo['tablePositions'][$tableAutoName]
            = $sheetInfo['tablePositions'][$tableName]
            = $this->saveDataStoreToSheet();
        $sheetInfo['tableSheet'][$tableAutoName]
            = $sheetInfo['tableSheet'][$tableName]
            = $sheet->getTitle();
        $this->exportHandler->sheetInfo = $sheetInfo;

        return $sheetInfo['tablePositions'][$tableName];
    }

    public function saveContentToBigSpreadsheet($content, $writer)
    {
        $this->writer = $writer;

        $translation = Util::get($content, ['attributes', 'translation'], "0:0");
        $translation = explode(":", $translation);
        $colTrans = $translation[0];
        $rowTrans = $translation[1];
        for ($i = 0; $i < $rowTrans; $i++) {
            $emptyRow = WriterEntityFactory::createRowFromArray([]);
            $writer->addRow($emptyRow);
        }
        $content['startColumn'] = $colTrans;
        $this->option = $content;
        $this->saveDataStoreToBigSpreadsheet();
    }

    protected function buildDatastore()
    {
        $option = $this->option;
        $ds = Util::get($option, 'dataSource', new \koolreport\core\DataStore());
        $filtering = Util::get($option, 'filtering', null);
        if (!empty($filtering)) {
            $ds = $ds->filter($filtering);
        }
        $sorting = Util::get($option, 'sorting', null);
        if (!empty($sorting)) {
            $ds = $ds->sort($sorting);
        }
        $paging = Util::get($option, 'paging', null);
        if (!empty($paging)) {
            $ds = $ds->paging($paging[0], $paging[1]);
        }

        $this->rowGroup = Util::get($this->option, 'rowGroup', []);
        $sorts = [];
        foreach ($this->rowGroup as $field => $grInfo) {
            $direction = Util::get($grInfo, 'direction', 'asc');
            $sorts[$field] = $direction;
        }
        if (!empty($sorts)) $ds->sort($sorts);

        return $ds;
    }

    protected function buildExportColumnsAndMetas()
    {
        $colMetas = $this->colMetas;
        $optCols = Util::get($this->option, 'columns', array_keys($colMetas));
        $this->expColKeys = [];
        foreach ($optCols as $k => $v) {
            if (is_array($v)) {
                $col = $k;
            } elseif (is_string($v)) {
                $col = $v;
            }
            $colKeys = array_keys($colMetas);
            $colLabels = array_filter($colMetas, function ($cMeta) use ($col) {
                $label = Util::get($cMeta, 'label', null);
                if ($label === $col) {
                    return true;
                } else {
                    return false;
                }
            });
            if (isset($colMetas[$col])) {
                $colKey = $col;
                if (is_array($v))
                    $colMetas[$col] = array_merge($colMetas[$col], $v);
            } else if (!empty($colLabels)) {
                $colKey = array_keys($colLabels)[0];
            } else if (isset($colKeys[$col])) {
                $colKey = $colKeys[$col];
            } else {
                continue;
            }

            $this->expColKeys[] = $colKey;
        }
        $this->colMetas = $colMetas;
    }

    public function getFormatted($value, $meta)
    {
        $formatCode = "";
        $isDateTime = false;
        $type = Util::get($meta, 'type', 'string');
        switch ($type) {
            case "number":
                $decimals = Util::get($meta, "decimals", 0);
                $prefix = Util::get($meta, "prefix", "");
                $suffix = Util::get($meta, "suffix", "");
                $zeros = "";
                for ($i = 0; $i < $decimals; $i++) $zeros .= "0";
                if ($decimals > 0) $zeros = ".$zeros";
                $formatCode = "\"{$prefix}\"#,##0{$zeros}\"{$suffix}\"";
                $formatCode = Util::get($meta, "excelFormatCode", $formatCode);
                break;
            case "datetime":
                $datetimeFormat = Util::get($meta, "format", "Y-m-d H:i:s");
                $defaultFormat = 'YYYY-MM-DD HH:MM:SS';
                $isDateTime = true;
                break;
            case "date":
                $datetimeFormat = Util::get($meta, "format", "Y-m-d");
                $defaultFormat = 'YYYY-MM-DD';
                $isDateTime = true;
                break;
            case "time":
                $datetimeFormat = Util::get($meta, "format", "H:i:s");
                $defaultFormat = 'HH:MM:SS';
                $isDateTime = true;
                break;
            default:
                $value = Util::format($value, $meta);
                break;
        }
        if ($isDateTime) {
            $formatCode = Util::get($meta, "displayFormat", $defaultFormat);
            if ($date = \DateTime::createFromFormat($datetimeFormat, $value)) {
                $value = $date;
            }
            $value = ps\Shared\Date::PHPToExcel($value);
        }

        return [$value, $formatCode];
    }

    protected function getHFValueAndStyle($colKey, $pos, $footerValue = null)
    {
        $map = Util::get($this->map, $pos, []);
        $style = Util::get($this->tableStyle, $pos, []);
        $colMeta = $this->colMetas[$colKey];
        $label = Util::get($colMeta, 'label', $colKey);
        $args = $pos === 'footer' ? [$colKey, $footerValue] : [$colKey];
        $value = Util::map($map, $args, empty($footerValue) ?
            ($pos === 'footer' ? "" : $label) : $footerValue);

        $type = Util::get($colMeta, 'type', 'string');
        $styleArray = Util::map($style, $args, []);
        Util::init($styleArray, ['font', 'bold'], true);
        if ($type === 'number') {
            $alignment = $this->exportType === 'excel' ?
                ps\Style\Alignment::HORIZONTAL_RIGHT : CellAlignment::RIGHT;
            Util::init($styleArray, ['alignment', 'horizontal'], $alignment);
        }

        return [$value, $styleArray];
    }

    protected function buildTableHeaderFooter($pos)
    {
        $rgBuilder = $this->rowGroupBuilder;
        $hfRowsName = $pos . "Rows";
        $this->{$hfRowsName} = [];
        $showDefault = $pos === 'header' ? true : false;
        if (!Util::get($this->option, 'show' . ucfirst($pos), $showDefault)) return;

        //Build headers, footers for row group columns
        $emptyCell = [];
        $hfRow = $indentCells = array_fill(0, $this->startCol, $emptyCell);
        $showHeaders = [];
        foreach ($rgBuilder->rowGroupFields as $grOrder => $grField) {
            if (!$rgBuilder->hasRowGroupTopBottom[$grOrder]) continue;

            $colKey = $grField;
            list($cellValue, $styleArray) = $this->getHFValueAndStyle($colKey, $pos);
            $cell = ["cellValue" => $cellValue, "styleArray" => $styleArray];
            $hfRow[] = $cell;

            if ($this->complexHeaderLabels) $showHeaders[] = $cellValue;
            else if ($this->complexHeaders) $showHeaders[] = $colKey;
        }

        //Build headers, footers for table columns
        foreach ($this->expColKeys as $colKey) {
            $fValue = null;
            if ($pos === 'footer') {
                $colMeta = $this->colMetas[$colKey];
                $fValue = "";
                $method = strtolower((string) Util::get($colMeta, "footer"));
                if (in_array($method, ["sum", "avg", "min", "max", "mode"])) {
                    $fValue = Util::formatValue($this->ds->$method($colKey), $colMeta);
                }
                $footerText = Util::get($colMeta, "footerText");
                if ($footerText !== null) {
                    $fValue = str_replace("@value", $fValue, $footerText);
                }
                $footerMap = Util::get($this->map, 'footer', []);
                $fValue = Util::map($footerMap, [$colKey, $fValue], $fValue);
            }

            list($cellValue, $styleArray) = $this->getHFValueAndStyle($colKey, $pos, $fValue);
            $cell = ["cellValue" => $cellValue, "styleArray" => $styleArray];
            $hfRow[] = $cell;

            if ($this->complexHeaderLabels) $showHeaders[] = $cellValue;
            else if ($this->complexHeaders) $showHeaders[] = $colKey;
        }

        if ($pos === "header" && $this->complexHeaders) {
            $headerRows = $this->buildComplexHeaders($showHeaders, $this->headerSeparator);
            foreach ($headerRows as $ri => $headerRow) {
                foreach ($headerRow as $ci => $header) {
                    $header["cellValue"] = $header["text"];
                    $header["styleArray"] = Util::get($hfRow, [$ci + $this->startCol, "styleArray"], []);
                    if (!isset($header['styleArray']['alignment']['vertical'])) {
                        $header['styleArray']['alignment']['vertical'] = ps\Style\Alignment::VERTICAL_CENTER;
                    }
                    $headerRows[$ri][$ci] = $header;
                }
                array_splice($headerRows[$ri], 0, 0, $indentCells);
            }
            $this->headerRows = $headerRows;
            // echo "headerRows = "; Util::prettyPrint($headerRows); exit;
        } else {
            $this->{$hfRowsName}[] = $hfRow;
        }
    }

    protected function buildTableBodyRow($dataRow)
    {
        $rgBuilder = $this->rowGroupBuilder;
        $cellMap = Util::get($this->map, 'cell');
        $cellStyle = Util::get($this->tableStyle, 'cell');
        $emptyCell = [];
        $bodyRow = array_fill(0, $this->startCol + $rgBuilder->totalRowGroupColumns, $emptyCell);
        foreach ($this->expColKeys as $colKey) {
            $colMeta = Util::get($this->colMetas, $colKey, []);
            $value = Util::get($dataRow, $colKey);
            $value = Util::map($cellMap, [$colKey, $value, $dataRow], $value);
            list($value, $formatCode) = $this->getFormatted($value, $colMeta);

            $type = Util::get($colMeta, 'type', 'string');
            $styleArray = Util::map($cellStyle, [$colKey, $value, $dataRow], []);
            if ($type === 'number') {
                $alignment = $this->exportType === 'excel' ?
                    ps\Style\Alignment::HORIZONTAL_RIGHT : CellAlignment::RIGHT;
                Util::init($styleArray, ['alignment', 'horizontal'], $alignment);
            }

            if ($this->exportType === 'excel') {
                Util::init($styleArray, 'formatCode', $formatCode);
            }

            $cell = ["cellValue" => $value, "styleArray" => $styleArray];
            $bodyRow[] = $cell;
        }
        return $bodyRow;
    }

    protected function buildTableBody()
    {
        $rgBuilder = $this->rowGroupBuilder;
        $rowGenerator = $this->ds->getRowGenerator();
        $prevDataRow = null;
        $prevBodyRows = [];
        $groupCell = !empty($this->groupCellsInColumns);
        // echo "this->groupCellsInColumns = "; Util::prettyPrint($this->groupCellsInColumns);
        $bodyRow = null;
        // $this->bodyRowIndexes = [];
        // $bodyRowIndex = 0;
        // $this->ds->popStart();
        // while (true) {
            
        // foreach ($rowGenerator as $currentRow) {
        //     if (isset($prevDataRow)) {
        //         $dataRow = $prevDataRow;
        //         writeExport($dataRow);
        //     } 

        //     $prevDataRow = $currentRow;
        // }
        // $dataRow = $currentRow;
        // writeExport($dataRow);
        // $rowspanCount = 0;
        foreach ($rowGenerator as $dataRow) {
            // echo "dataRow = "; print_r($dataRow); echo "<br>";
            // $dataRow = $this->ds->pop();

            $bottomGroupRows = $rgBuilder->buildBottomGroupRows($prevDataRow, $dataRow);
            
            if (!empty($bottomGroupRows)) {
                if ($groupCell && !empty($prevBodyRows)) {
                    // echo "output prevBodyRows before bottomGroupRows<br>";
                    $this->setRowspanForRows($prevBodyRows);
                    // echo "prevBodyRows = "; Util::prettyPrint($prevBodyRows);
                    if ($this->exportType === "excel") $this->rowsToExcel($prevBodyRows);
                    else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet($prevBodyRows);
                    // $rowspanCount++;
                    // if ($rowspanCount >= 5) return;
                    $prevBodyRows = [];
                }
                // echo "output bottomGroupRows<br>"; Util::prettyPrint($bottomGroupRows);
                if ($this->exportType === "excel") $this->rowsToExcel($bottomGroupRows);
                else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet($bottomGroupRows);
            }

            // $bodyRowIndex += count($bottomGroupRows);

            if (!isset($dataRow)) break;

            $topGroupRows = $rgBuilder->buildTopGroupRows($prevDataRow, $dataRow);
            
            if (!empty($topGroupRows)) {
                if ($groupCell && !empty($prevBodyRows)) {
                    // echo "output prevBodyRows before topGroupRows<br>";
                    $this->setRowspanForRows($prevBodyRows);
                    // echo "prevBodyRows = "; Util::prettyPrint($prevBodyRows);
                    if ($this->exportType === "excel") $this->rowsToExcel($prevBodyRows);
                    else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet($prevBodyRows);
                    // $rowspanCount++;
                    // if ($rowspanCount >= 5) return;
                    $prevBodyRows = [];
                }
                // echo "output topGroupRows<br>"; Util::prettyPrint($topGroupRows);
                if ($this->exportType === "excel") $this->rowsToExcel($topGroupRows);
                else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet($topGroupRows);
            }

            // $bodyRowIndex += count($topGroupRows);

            $rgBuilder->setLastGroupValues();

            $bodyRow = $this->buildTableBodyRow($dataRow);
            // echo "bodyRow = "; Util::prettyPrint($bodyRow); exit;
            
            if (!$groupCell) {
                // echo "output bodyRow<br>";
                if ($this->exportType === "excel") $this->rowsToExcel([$bodyRow]);
                else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet([$bodyRow]);
            } else {
                $lastBodyRow = end($prevBodyRows);
                if (empty($prevBodyRows) || $this->hasGroupCells($lastBodyRow, $bodyRow)) {
                    // echo "bodyRow = "; Util::prettyPrint($bodyRow); 
                    // echo "save bodyRow to prevBodyRows<br>";
                    // Util::prettyPrint($prevBodyRows);
                    array_push($prevBodyRows, $bodyRow);
                    // Util::prettyPrint($prevBodyRows);
                } else {
                    // echo "output prevBodyRows<br>";
                    $this->setRowspanForRows($prevBodyRows);
                    if ($this->exportType === "excel") $this->rowsToExcel($prevBodyRows);
                    else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet($prevBodyRows);
                    // echo "prevBodyRows = "; Util::prettyPrint($prevBodyRows);
                    unset($prevBodyRows);
                    $prevBodyRows = [$bodyRow];

                    // $rowspanCount++;
                    // if ($rowspanCount >= 5) return;
                }
            }

            // $this->bodyRowIndexes[] = $bodyRowIndex;
            // $bodyRowIndex += 1;

            $prevDataRow = $dataRow;
        }

        if ($groupCell && !empty($prevBodyRows)) {
            // echo "output prevBodyRows at the end<br>";
            $this->setRowspanForRows($prevBodyRows);
            // echo "prevBodyRows = "; Util::prettyPrint($prevBodyRows);
            if ($this->exportType === "excel") $this->rowsToExcel($prevBodyRows);
            else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet($prevBodyRows);
        }

        $dataRow = null;
        $bottomGroupRows = $rgBuilder->buildBottomGroupRows($prevDataRow, $dataRow);
        if ($this->exportType === "excel") $this->rowsToExcel($bottomGroupRows);
        else if ($this->exportType === "bigspreadsheet") $this->rowsToBigSpreadsheet($bottomGroupRows);

        // exit;
    }

    protected function hasGroupCells($lastBodyRow, $bodyRow)
    {
        $rgBuilder = $this->rowGroupBuilder;
        // echo "lastBodyRow = "; Util::prettyPrint($lastBodyRow);
        $colOrder = -1;
        foreach ($this->expColKeys as $colKey) {
            $colOrder++;
            if (
                !in_array($colKey, $this->groupCellsInColumns, true)
                && !in_array($colOrder, $this->groupCellsInColumns, true)
            ) {
                continue;
            }
            // if (in_array($colKey, $this->groupCellsInColumns, true)) {
            //     echo "in_array $colKey in groupCellsInColumns<br>";
            // }
            // if (in_array($colOrder - $this->startCol, $this->groupCellsInColumns, true)) {
            //     $realColOrder = $colOrder - $this->startCol;
            //     echo "in_array $realColOrder in groupCellsInColumns<br>";
            // }
            // echo "colOrder = $colOrder<br>";
            $realColOrder = $colOrder + $this->startCol + $rgBuilder->totalRowGroupColumns;
            if ($lastBodyRow[$realColOrder]['cellValue'] === $bodyRow[$realColOrder]['cellValue']) return true;
            else return false;
        }
        return false;
    }

    protected function setRowspanForRows(&$bodyRows)
    {
        $rgBuilder = $this->rowGroupBuilder;
        $colOrder = -1;
        $rowspanColOrders = $rowspanCounts = $lastCellValues = $isDifferentValues = $lastRowOrders = [];
        foreach ($this->expColKeys as $colKey) {
            $colOrder++;
            // echo "colKey = $colKey || colOrder = $colOrder <br>";
            if (
                !in_array($colKey, $this->groupCellsInColumns, true)
                && !in_array($colOrder, $this->groupCellsInColumns, true)
            ) {
                // echo "continue<br>";
                continue;
            }
            // if (in_array($colKey, $this->groupCellsInColumns, true)) {
            //     echo "in_array $colKey in groupCellsInColumns<br>";
            // }
            // if (in_array($colOrder - $this->startCol, $this->groupCellsInColumns, true)) {
            //     $realColOrder = $colOrder - $this->startCol;
            //     echo "in_array $realColOrder in groupCellsInColumns<br>";
            // }
            // echo "add $colOrder to rowspanColOrders<br>";
            $realColOrder = $colOrder + $this->startCol + $rgBuilder->totalRowGroupColumns;
            $rowspanColOrders[] = $realColOrder;
            $rowspanCounts[$realColOrder] = 1;
            $lastCellValues[$realColOrder] = null;
            $isDifferentValues[$realColOrder] = true;
            $lastRowOrders[$realColOrder] = 0;
        }

        // echo "rowspanColOrders = "; Util::prettyPrint($rowspanColOrders); exit;

        $emptyRow = [];
        $bodyRows[] = $emptyRow;
        foreach ($bodyRows as $i => $row) {
            foreach ($rowspanColOrders as $colOrder) {
                // echo "colOrder = $colOrder<br>";
                if ($i < count($bodyRows) - 1) {
                    $cellValue = Util::get($row, [$colOrder, 'cellValue']);
                    // echo "cellValue = $cellValue<br>";
                    // echo "lastCellValue == {$lastCellValues[$colOrder]} <br>";
                    $isDifferentValues[$colOrder] = 
                        ($cellValue !== $lastCellValues[$colOrder]);
                    // echo "current isDifferentValues[colOrder] = "; var_dump($isDifferentValues[$colOrder]); echo "<br>";
                } else {
                    //last row
                    $cellValue = null;
                    $isDifferentValues[$colOrder] = true;
                }
                if ($isDifferentValues[$colOrder]) {
                    // echo "isDifferentValue<br>";
                    // if ($lastCellValues[$colOrder] !== null) {
                        // echo "isDifferentValue lastCellValue == {$lastCellValues[$colOrder]} <br>";
                        // $bodyRows[$lastRowOrders[$colOrder]][$colOrder]['rowspan'] = $rowspanCounts[$colOrder];
                        // $mergedCellStyle = Util::get($this->tableStyle, 'mergedCell');
                        // $styleArray = Util::map($mergedCellStyle, [$colKey, $lastCellValue], []);
                        // if (!isset($styleArray['alignment']['vertical'])) {
                        //     $styleArray['alignment']['vertical'] = ps\Style\Alignment::VERTICAL_CENTER;
                        // }
                        // $style = $this->sheet->getStyle($lastCellAddress);
                        // $style->applyFromArray($styleArray);
                    // }
                    $bodyRows[$lastRowOrders[$colOrder]][$colOrder]['rowspan'] = $rowspanCounts[$colOrder];
                    $lastCellValues[$colOrder] = $cellValue;
                    $lastRowOrders[$colOrder] = $i;
                    $rowspanCounts[$colOrder] = 1;
                    // echo "set lastCellValue = "; var_dump($lastCellValues[$colOrder]); echo "<br>";
                } else {
                    $rowspanCounts[$colOrder]++;
                    // echo "Same value: increase rowspan count of colOrder $colOrder<br>";
                    $bodyRows[$i][$colOrder]['cellValue'] = null;
                }
            }
            // echo "<br>";
        }
        // echo "setRowspanForRows bodyRows = "; Util::prettyPrint($bodyRows); exit;
        array_pop($bodyRows);
    }

    protected function rowsToExcel($rows)
    {
        // echo "rowsToExcel rows = "; Util::prettyPrint($rows);
        foreach ($rows as $row) {
            $expColOrder = 0;
            foreach ($row as $cell) {
                // echo "cell = "; print_r($cell); echo "<br>";
                $expColOrder++;
                if (empty($cell)) continue;
                // echo "build cell<br>";
                $cellValue = Util::get($cell, 'cellValue');
                if ($cellValue === null) continue;
                $styleArray = Util::get($cell, 'styleArray', []);
                $formatCode = Util::get($styleArray, 'formatCode');
                $rowspan = Util::get($cell, "rowspan", 1);
                $colspan = Util::get($cell, "colspan", 1);

                $cellAddress = Coordinate::stringFromColumnIndex($expColOrder)
                    . $this->rowOrder;
                if ($rowspan > 1 || $colspan > 1) {
                    $mergeCellAddress = Coordinate::stringFromColumnIndex($expColOrder + $colspan - 1)
                        . ($this->rowOrder + $rowspan - 1);
                    // echo "cellAddress = $cellAddress<br>";
                    // echo "mergeCellAddress = $mergeCellAddress<br>";
                    if ($this->mergeCells) {
                        $this->sheet->mergeCells($cellAddress . ":" . $mergeCellAddress);
                        if (!isset($styleArray['alignment']['vertical'])) {
                            $styleArray['alignment']['vertical'] = ps\Style\Alignment::VERTICAL_CENTER;
                        }
                    } else {
                        $this->simulateMergeCells($cellAddress, $mergeCellAddress);
                        $this->setRangeValue($cellAddress, $mergeCellAddress, '');
                    }
                }
                $this->sheet->setCellValue($cellAddress, $cellValue);
                $style = $this->sheet->getStyle($cellAddress);
                if (!empty($formatCode)) {
                    $style->getNumberFormat()->setFormatCode($formatCode);
                }
                if (is_array($styleArray) && !empty($styleArray)) {
                    $style->applyFromArray($styleArray);
                }
            }
            $this->rowOrder++;
        }
    }

    protected function rowsToBigSpreadsheet($rows)
    {
        $thinNoneBorder = [ 'style' => 'none', 'width' => 'thin', 'color' => 'AAAAAA'];
        foreach ($rows as $ri => $cellValues) {
            foreach ($cellValues as $ci => $cell) {
                $rowspan = Util::get($cell, "rowspan", 1);
                $colspan = Util::get($cell, "colspan", 1);
                if ($rowspan > 1 || $colspan > 1) {
                    $startRow = $ri;
                    $endRow = $startRow + $rowspan - 1;
                    $startCol = $ci;
                    $endCol = $startCol + $colspan - 1;
                    for ($x = $startRow; $x <= $endRow; $x++) {
                        for ($y = $startCol; $y <= $endCol; $y++) {
                            $border = [
                                // 'color' => 'AAAAAA',
                                // 'width' => 'thin',
                                'top' => $thinNoneBorder,
                                'right' => $thinNoneBorder,
                                'bottom' => $thinNoneBorder,
                                'left' => $thinNoneBorder,
                            ];
                            if ($x === $startRow) $border["top"]["style"] = "solid";
                            if ($x === $endRow) $border["bottom"]["style"] = "solid";
                            if ($y === $startCol) $border["left"]["style"] = "solid";
                            if ($y === $endCol) $border["right"]["style"] = "solid";
                            Util::set($rows, [$x, $y, 'styleArray', 'border'], $border);
                            Util::set($rows, [$x, $y, 'styleArray', 'backgroundColor'], 'FFFFFF');
                        }
                    }
                }
            }
        }

        foreach ($rows as $ri => $cellValues) {
            $rowObj = [];
            foreach ($cellValues as $ci => $cell) {
                $cellValue = Util::get($cell, 'cellValue');
                $styleArray = Util::get($cell, 'styleArray');
                $cellObj = WriterEntityFactory::createCell(
                    $cellValue,
                    $this->getSpreadsheetStyleObj($styleArray)
                );
                $rowObj[] = $cellObj;
            }
            $rowFromValues = WriterEntityFactory::createRow($rowObj);
            $this->writer->addRow($rowFromValues);
        }
    }

    protected function mergeDuplicateRowsForCols()
    {
        $rgBuilder = $this->rowGroupBuilder;
        $colOrder = -1;
        foreach ($this->expColKeys as $colKey) {
            $colOrder++;
            if (
                !in_array($colKey, $this->groupCellsInColumns)
                && !in_array($colOrder, $this->groupCellsInColumns)
            ) {
                continue;
            }

            $realColOrder = $colOrder + $this->startCol + $rgBuilder->totalRowGroupColumns;
            $startBodyRow = $this->startRow + count($this->headerRows);
            $lastCellValue = $lastCellAddress = null;
            $prevRowOrder = null;
            $bodyRowIndexesPlusOne = $this->bodyRowIndexes;
            $bodyRowIndexesPlusOne[] = count($bodyRowIndexesPlusOne);
            foreach ($bodyRowIndexesPlusOne as $i => $bodyRowIndex) {
                $rowOrder = $startBodyRow + $bodyRowIndex;
                $cellAddress = Coordinate::stringFromColumnIndex($realColOrder)
                    . $rowOrder;
                if ($i < count($bodyRowIndexesPlusOne) - 1) {
                    $cellValue = $this->sheet->getCell($cellAddress)->getValue();
                    $isDifferentValue = $cellValue !== $lastCellValue;
                } else {
                    $cellValue = null;
                    $isDifferentValue = true;
                }
                if ($isDifferentValue) {
                    if ($lastCellValue !== null) {
                        $prevCellAddress = Coordinate::stringFromColumnIndex($realColOrder)
                            . ($prevRowOrder);
                        if ($this->mergeCells) {
                            $this->sheet->mergeCells($lastCellAddress . ":" . $prevCellAddress);
                        } else {
                            $this->simulateMergeCells($lastCellAddress, $prevCellAddress);
                            $this->setRangeValue($lastCellAddress, $prevCellAddress, '');
                        }
                        $this->sheet->setCellValue($lastCellAddress, $lastCellValue);
                        $mergedCellStyle = Util::get($this->tableStyle, 'mergedCell');
                        $styleArray = Util::map($mergedCellStyle, [$colKey, $lastCellValue], []);
                        if (!isset($styleArray['alignment']['vertical'])) {
                            $styleArray['alignment']['vertical'] = ps\Style\Alignment::VERTICAL_CENTER;
                        }
                        $style = $this->sheet->getStyle($lastCellAddress);
                        $style->applyFromArray($styleArray);
                    }
                    $lastCellValue = $cellValue;
                    $lastCellAddress = $cellAddress;
                }
                $prevRowOrder = $rowOrder;
            }
        }
    }

    protected function buildRowGroups()
    {
        // echo "this->startCol = " . $this->startCol . "<br>";
        $rgBuilder = new TableRowGroupsBuilder();
        $rgBuilder->setProperties([
            'rowGroups' => $this->rowGroup,
            'ds' => $this->ds,
            'colMetas' => $this->colMetas,
            'startCol' => $this->startCol,
            'expColKeys' => $this->expColKeys,
            'tableStyle' => $this->tableStyle,
        ])
            ->buildNumberOfGroupColumns()
            ->buildAggregates();
        $this->rowGroupBuilder = $rgBuilder;
    }

    protected function buildComplexHeaders($showColumnKeys, $sep)
    {
        $headerRows = [];
        //Create empty header rows array
        foreach ($showColumnKeys as $cKey) {
            $cKey = explode($sep, $cKey);
            if (count($headerRows) < count($cKey)) {
                $aHeaderRow = [];
                array_push($headerRows, $aHeaderRow);
            }
        }
        $numRow = count($headerRows);
        //Fill in header row values from column names
        foreach ($showColumnKeys as $cKey) {
            $cKey = explode($sep, $cKey);
            for ($i = 0; $i < $numRow; $i++) {
                $header = Util::get($cKey, $i, null);
                array_push($headerRows[$i], [
                    'text' => $header
                ]);
            }
        }
        $lastSameHeaderIndexes = [];
        $lastNotNullHeaderIndexes = [];
        // Util::prettyPrint($headerRows); 
        $newHeaderRows = $headerRows;
        foreach ($headerRows as $rowIndex => $aHeaderRow) {
            foreach ($aHeaderRow as $colIndex => $header) {
                $currentText = $header['text'];
                if (!isset($currentText)) {
                    if ($rowIndex === 0) continue;
                    $lastNotNull = $lastNotNullHeaderIndexes[$colIndex];
                    $rowspan = (int) Util::init(
                        $newHeaderRows,
                        [$lastNotNull, $colIndex, 'rowspan'],
                        1
                    );
                    $newHeaderRows[$lastNotNull][$colIndex]['rowspan'] = $rowspan + 1;
                } else {
                    $lastNotNullHeaderIndexes[$colIndex] = $rowIndex;
                    if (!isset($lastSameHeaderIndexes[$rowIndex])) {
                        $lastSameHeaderIndexes[$rowIndex] = $colIndex;
                        continue;
                    };
                    $lastIndex = $lastSameHeaderIndexes[$rowIndex];
                    $lastSameHeader = $aHeaderRow[$lastIndex]['text'];

                    // echo "$currentText - $lastSameHeader <br>";
                    $isEqual = ($currentText === $lastSameHeader);
                    $isSameParents = true;
                    for ($k = $rowIndex - 1; $k > -1; $k--) {
                        $currentParent = $headerRows[$k][$colIndex]['text'];
                        $lastParent = $headerRows[$k][$lastIndex]['text'];
                        // echo "$currentParent - $lastParent <br>";
                        if ($currentParent !== $lastParent) {
                            $isSameParents = false;
                            break;
                        }
                    }
                    // echo "isEqual = $isEqual<br>";
                    // echo "isSameParents = $isSameParents<br>";

                    if (!$isEqual || !$isSameParents) {
                        $lastSameHeaderIndexes[$rowIndex] = $colIndex;
                    } else if ($colIndex < count($aHeaderRow) - 1) {
                        // echo "is equal and same parent <br>";
                        $colspan = (int) Util::init(
                            $newHeaderRows,
                            [$rowIndex, $lastIndex, 'colspan'],
                            1
                        );
                        // echo "i=$rowIndex lastIndex=$lastIndex colspan=$colspan<br>";
                        $newHeaderRows[$rowIndex][$lastIndex]['colspan'] = $colspan + 1;
                        $newHeaderRows[$rowIndex][$colIndex]['text'] = null;
                    } else {
                        $colspan = (int) Util::init(
                            $newHeaderRows,
                            [$rowIndex, $lastIndex, 'colspan'],
                            1
                        );
                        $newHeaderRows[$rowIndex][$lastIndex]['colspan'] = $colspan + 1;
                        $newHeaderRows[$rowIndex][$colIndex]['text'] = null;
                    }
                }
            }
        }
        // Util::prettyPrint($newHeaderRows);  
        return $newHeaderRows;
    }

    protected function simulateMergeCells($cell, $endCell)
    {
        if ($this->exportType !== "excel") return;

        $style = $this->sheet->getStyle($cell . ":" . $endCell);
        $excelStyle = [
            'borders' => [
                'outline' => [
                    'borderStyle' => 'thin', //dashDot, dashDotDot, dashed, dotted, double, hair, medium, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot, thick, thin
                    'color' => [
                        'rgb' => 'BBBBBB',
                    ]
                ],
                //left, right, bottom, diagonal, allBorders, outline, inside, vertical, horizontal
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ]
        ];
        $style->applyFromArray($excelStyle);
    }

    protected function setRangeValue($cell, $endCell, $value)
    {
        if ($this->exportType !== "excel") return;

        [$startColumn, $startRow] = Coordinate::coordinateFromString($cell);
        [$endColumn, $endRow] = Coordinate::coordinateFromString($endCell);
        for ($row = $startRow; $row <= $endRow; ++$row) {
            $col = $startColumn;
            while ($col <= $endColumn) {
                $this->sheet->getCell($col . $row)->setValue($value);
                ++$col;
            }
        }
    }

    public function saveDataStoreToSheet()
    {
        $this->exportType = 'excel';
        $this->ds = $this->buildDatastore();
        $this->colMetas = $this->ds->meta()['columns'];

        $option = $this->option;
        $this->tableStyle = Util::get($option, 'excelStyle', []);
        $this->map = Util::get($option, 'map', []);
        $this->startCol = Util::get($option, 'startColumn', 1);
        $this->startRow = Util::get($option, 'startRow', 1);
        $this->rowOrder = $this->startRow;
        $removeDuplicate = Util::get($option, 'removeDuplicate', []);
        $rowspan = Util::get($option, 'rowspan', $removeDuplicate);
        $this->groupCellsInColumns = Util::get($option, 'groupCellsInColumns', $rowspan);
        $this->complexHeaderLabels = Util::get($option, "complexHeaderLabels", false);
        $this->complexHeaders = Util::get($option, "complexHeaders", $this->complexHeaderLabels);
        $this->headerSeparator = Util::get($option, 'headerSeparator', "-");
        $this->mergeCells = Util::get($option, 'mergeCells', true);

        $this->buildExportColumnsAndMetas();
        $this->buildRowGroups();

        $this->buildTableHeaderFooter('header');
        $this->rowsToExcel($this->headerRows);

        $this->buildTableBody();

        $this->buildTableHeaderFooter('footer');
        $this->rowsToExcel($this->footerRows);

        $this->buildTableHeaderFooter('bottomHeader');
        $this->rowsToExcel($this->bottomHeaderRows);

        // $this->tableToExcel();

        // if (!empty($this->groupCellsInColumns)) {
        //     $this->mergeDuplicateRowsForCols();
        // }

        // $sheet->calculateColumnWidths();
        $columnAutoSize = Util::get($option, 'columnAutoSize', true);
        if ($columnAutoSize) {
            for ($i = 0; $i < count($this->expColKeys); $i++) {
                $col = Coordinate::stringFromColumnIndex($i + 1);
                // $titlecolwidth = $sheet->getColumnDimension($col)->getWidth();
                // $sheet->getColumnDimension($col)->setWidth($titlecolwidth);
                $this->sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        return [
            'topLeft' => ($this->startCol) . ":" . ($this->startRow),
            'bottomRight' => ($this->startCol + count($this->expColKeys) - 1
                + $this->rowGroupBuilder->totalRowGroupColumns) . ":" . ($this->rowOrder - 1),
        ];
    }

    public function saveDataStoreToBigSpreadsheet()
    {
        $this->exportType = 'bigspreadsheet';
        $this->ds = $this->buildDatastore();
        $this->colMetas = $this->ds->meta()['columns'];

        $option = $this->option;
        $this->tableStyle = Util::get($option, 'spreadsheetStyle', []);
        $this->map = Util::get($option, 'map', []);
        $this->startCol = Util::get($option, 'startColumn', 1);
        $this->startRow = Util::get($option, 'startRow', 1);
        $this->rowOrder = $this->startRow;
        $removeDuplicate = Util::get($option, 'removeDuplicate', []);
        $rowspan = Util::get($option, 'rowspan', $removeDuplicate);
        $this->groupCellsInColumns = Util::get($option, 'groupCellsInColumns', $rowspan);
        $this->complexHeaderLabels = Util::get($option, "complexHeaderLabels", false);
        $this->complexHeaders = Util::get($option, "complexHeaders", $this->complexHeaderLabels);
        $this->headerSeparator = Util::get($option, 'headerSeparator', "-");

        $this->buildExportColumnsAndMetas();
        $this->buildRowGroups();

        $this->buildTableHeaderFooter('header');
        $this->rowsToBigSpreadsheet($this->headerRows);

        $this->buildTableBody();

        $this->buildTableHeaderFooter('footer');
        $this->rowsToBigSpreadsheet($this->footerRows);

        $this->buildTableHeaderFooter('bottomHeader');
        $this->rowsToBigSpreadsheet($this->bottomHeaderRows);
    }
}

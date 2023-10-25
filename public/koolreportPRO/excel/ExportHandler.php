<?php

/**
 * This file contains class the handle to file generated
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */

namespace koolreport\excel;

use \koolreport\core\Utility as Util;
use \PhpOffice\PhpSpreadsheet as ps;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class ExportHandler
{
    protected $report;
    protected $setting = [];
    protected $widgetParams = [];
    public $sheetInfo = [
        'tablePositions' => [],
        'tableSheet' => [],
        'tableAutoId' => 0,
        'chartAutoId' => 0,
    ];

    public function __construct($report, $dataStores)
    {
        $this->report = $report;
        $this->dataStores = &$dataStores;
        $this->dataStoresGenerator = &$report->dataStoresGenerator;
    }

    public function setting($setting)
    {
        $this->setting = array_merge($this->setting, $setting);
        $this->useLocalTempFolder = Util::get($this->setting, "useLocalTempFolder", false);
        $this->autoDeleteLocalTempFile = Util::get($this->setting, "autoDeleteLocalTempFile", false);
        $defaultAutoDeleteTempFile = $this->useLocalTempFolder ? $this->autoDeleteLocalTempFile : false;
        $this->autoDeleteTempFile = Util::get($this->setting, "autoDeleteTempFile", $defaultAutoDeleteTempFile);
    }

    public function setWidgetParams($name, $params)
    {
        $this->widgetParams[$name] = $params;
    }

    public function getWidgetParams($name)
    {
        return Util::get($this->widgetParams, $name, null);
    }

    public function getWidgetBuilder($type)
    {
        switch ($type) {
            case 'table':
                if (!isset($this->tableBuilder))
                    $this->tableBuilder = new TableBuilder();
                $Builder = $this->tableBuilder;
                break;
            case 'chart':
                if (!isset($this->chartBuilder))
                    $this->chartBuilder = new ChartBuilder();
                $Builder = $this->chartBuilder;
                break;
            case 'pivottable':
                if (!isset($this->pivottableBuilder))
                    $this->pivottableBuilder = new PivotTableBuilder();
                $Builder = $this->pivottableBuilder;
                break;
            case 'pivotmatrix':
                if (!isset($this->pivotmatrixBuilder))
                    $this->pivotmatrixBuilder = new PivotMatrixBuilder();
                $Builder = $this->pivotmatrixBuilder;
                break;
            case 'text':
            default:
                if (!isset($this->textBuilder))
                    $this->textBuilder = new TextBuilder();
                $Builder = $this->textBuilder;
        }
        $Builder->exportHandler = $this;
        return $Builder;
    }

    protected function getTemplateHtml($view)
    {
        $currentDir = dirname(Util::getClassPath($this->report));
        $excelTplFile = $currentDir . "/" . $view . ".excel.php";
        $viewTplFile = $currentDir . "/" . $view . ".view.php";
        if (is_file($excelTplFile)) {
            $oldActiveReport = (isset($GLOBALS["__ACTIVE_KOOLREPORT__"]))
                ? $GLOBALS["__ACTIVE_KOOLREPORT__"] : null;
            $GLOBALS["__ACTIVE_KOOLREPORT__"] = $this->report;
            ob_start();
            include($excelTplFile);
            $templateHtml = ob_get_clean();
            if ($oldActiveReport === null) {
                unset($GLOBALS["__ACTIVE_KOOLREPORT__"]);
            } else {
                $GLOBALS["__ACTIVE_KOOLREPORT__"] = $oldActiveReport;
            }
        } elseif (is_file($viewTplFile)) {
            $templateHtml = $this->report->render($view, true);
        } else {
            throw new \Exception("Could not found excel export template 
                file $viewTplFile or $excelTplFile");
        }
        return $templateHtml;
    }

    protected function setExcelMeta($spreadsheet, $properties)
    {
        $spreadsheet->getProperties()
            ->setCreator(Util::get($properties, "creator", "KoolReport"))
            ->setTitle(Util::get($properties, "title", ""))
            ->setDescription(Util::get($properties, "description", ""))
            ->setSubject(Util::get($properties, "subject", ""))
            ->setKeywords(Util::get($properties, "keywords", ""))
            ->setCategory(Util::get($properties, "category", ""));
    }

    protected function isJson($string)
    {
        $firstChar = mb_substr($string, 0, 1);
        $lastChar = mb_substr($string, -1);
        if (($firstChar !== "{" && $firstChar !== "[") ||
            ($lastChar !== "}" && $lastChar !== "]")
        ) {
            return false;
        }
        json_decode($string);
        $isJson = json_last_error() == JSON_ERROR_NONE;
        return $isJson;
    }

    protected function contentXmlToConfig($contentXml)
    {
        $contentStr = trim($contentXml->textContent);
        $content = $this->isJson($contentStr) ?
            json_decode($contentStr, true) : [
                'type' => 'text',
                'text' => $contentStr
            ];

        if (isset($content['name'])) {
            $content = $this->getWidgetParams($content['name']);
        }

        if (isset($content['dataSource']) && is_string($content['dataSource'])) {
            $content['dataSource'] =
                $this->report->dataStore($content['dataSource']);
        } elseif (isset($content['excelDataSource'])) {
            $content['dataSource'] = $content['excelDataSource'];
        }

        $contentAttrs = [];
        $attrs = $contentXml->attributes;
        foreach ($attrs as $attr) {
            $contentAttrs[$attr->nodeName] = $attr->nodeValue;
        }
        $content['attributes'] = $contentAttrs;

        return $content;
    }

    protected function sheetXmlToConfig($sheetXml)
    {
        $sheetConfig = [];
        $sheetConfig['name'] = $sheetXml->getAttribute('sheet-name');

        $xpath = $this->xpath;
        $contentXmls = $xpath->query("div", $sheetXml);
        $sheetConfig['contents'] = [];
        foreach ($contentXmls as $contentXml) {
            $sheetConfig['contents'][] = $this->contentXmltoConfig($contentXml);
        }
        return $sheetConfig;
    }

    protected function viewToConfig($view)
    {
        $config = [];
        $templateHtml = $this->getTemplateHtml($view);
        // $templateHtml = str_replace('<', '&lt;', $templateHtml);

        libxml_use_internal_errors(true);
        $doc = new \DomDocument();
        $doc->loadHTML($templateHtml);

        $properties = [];
        $metas = $doc->getElementsByTagName("meta");
        foreach ($metas as $meta) {
            $name = $meta->getAttribute('name');
            $value = $meta->getAttribute('content');
            $properties[$name] = $value;
        }
        $config['properties'] = $properties;

        $xpath = $this->xpath = new \DomXPath($doc);
        $sheetXmls = $xpath->query("*/div");
        $config['sheets'] = [];
        foreach ($sheetXmls as $i => $sheetXml) {
            $config['sheets'][] = $this->sheetXmlToConfig($sheetXml);
        }

        return $config;
    }

    protected function paramsToConfig($params)
    {
        $config = $params;

        $options = array();
        foreach ($params as $k => &$v) {
            $params[strtolower($k)] = $v; // accept all case insensitive properties
            unset($v);
        }
        $dataStoreNames = Util::get($params, "datastores", null);
        if (!isset($dataStoreNames) || !is_array($dataStoreNames))
            $exportDataStores = $this->dataStores;
        else {
            $options = array();
            $exportDataStores = array();
            foreach ($dataStoreNames as $k => $v) {
                if (isset($this->dataStores[$k])) {
                    $exportDataStores[$k] = $this->dataStores[$k];
                    $options[$k] = $v;
                } else if (isset($this->dataStores[$v]))
                    $exportDataStores[$v] = $this->dataStores[$v];
            }
        }
        $config['sheets'] = [];
        foreach ($exportDataStores as $name => $dataStore) {
            $type = isset($dataStore->meta()['pivotId']) ? 'pivottable' : 'table';
            $content = array_merge(Util::get($options, $name, []), [
                'type' => $type,
                'dataSource' => $dataStore
            ]);
            $config['sheets'][] = [
                'name' => $name,
                'contents' => [$content]
            ];
        }
        return $config;
    }

    protected function buildConfig($paramsOrView = [], $setting = [])
    {
        $this->setting($setting);
        if (is_string($paramsOrView)) {
            $view = $paramsOrView;
            $config = $this->viewToConfig($view);
        } elseif (is_array($paramsOrView)) {
            $params = $paramsOrView;
            $config = $this->paramsToConfig($params);
        }
        $this->config = array_merge($this->setting, $config);
    }

    protected function configToExcel()
    {
        $config = $this->config;
        $spreadsheet = $this->spreadsheet = new ps\Spreadsheet();
        $this->setExcelMeta($spreadsheet, Util::get($config, 'properties', []));

        $chartDataSheet = new ps\Worksheet\Worksheet($spreadsheet, 'chart_data');
        $spreadsheet->addSheet($chartDataSheet);
        if (Util::get($config, 'hideChartDataSheet', true)) {
            $chartDataSheet->setSheetState(ps\Worksheet\Worksheet::SHEETSTATE_HIDDEN);
        }

        $rtl = Util::get($config, 'rtl');
        foreach ($config['sheets'] as $i => $sheetConfig) {
            if ($i === 0) {
                $sheet = $spreadsheet->getSheet(0);
                if ($rtl) $sheet->setRightToLeft(true);
            } else {
                $sheet = new ps\Worksheet\Worksheet($spreadsheet);
                if ($rtl) $sheet->setRightToLeft(true);
                $spreadsheet->addSheet($sheet, $i);
            }
            $sheetName = $sheetConfig['name'];
            if (empty($sheetName)) {
                $sheetName = "Sheet" . ($i + 1);
            }
            $sheet->setTitle($sheetName);
            foreach ($sheetConfig['contents'] as $contentConfig) {
                $type = Util::get($contentConfig, 'type', 'text');
                $widgetBuilder = $this->getWidgetBuilder($type);
                $widgetBuilder->saveContentToSheet($contentConfig, $sheet);
            }
        }

        //The last added sheet is active, we set it to the first one
        $spreadsheet->setActiveSheetIndex(0);

        $tmpFilePath = $this->getTempFolder() . "/" . Util::getUniqueId() . ".xlsx";
        $objWriter = ps\IOFactory::createWriter($spreadsheet, "Xlsx");
        $objWriter->setPreCalculateFormulas(false);
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save($tmpFilePath);

        return $tmpFilePath;
    }

    protected function configToBigSpreadsheet($fileType)
    {
        $config = $this->config;
        $writer = WriterEntityFactory::createWriter($fileType);
        // echo "writer class = " . get_class($writer) . "<br>";
        $tmpFilePath = $this->getTempFolder() . "/" . Util::getUniqueId() . $fileType;
        $writer->openToFile($tmpFilePath);

        if ($fileType === 'csv') {
            $bom = Util::get($config, 'BOM', false);
            $writer->setShouldAddBOM($bom);
            $fieldDelimiter = Util::get($config, 'separator', ',');
            $fieldDelimiter = Util::get($config, 'fieldSeparator', $fieldDelimiter);
            $fieldDelimiter = Util::get($config, 'delimiter', $fieldDelimiter);
            $fieldDelimiter = Util::get($config, 'fieldDelimiter', $fieldDelimiter);
            $writer->setFieldDelimiter($fieldDelimiter);

            $enclosure = Util::get($config, "enclosure");
            if (!empty($enclosure)) $writer->setFieldEnclosure($enclosure);
        }

        foreach ($config['sheets'] as $i => $sheetConfig) {
            if (method_exists($writer, 'getCurrentSheet')) {
                $sheet = $i === 0 ?
                    $writer->getCurrentSheet() : $writer->addNewSheetAndMakeItCurrent();
                $sheetName = $sheetConfig['name'];
                if (empty($sheetName)) {
                    $sheetName = "Sheet" . ($i + 1);
                }
                $sheet->setName($sheetName);
            }

            foreach ($sheetConfig['contents'] as $contentConfig) {
                $type = Util::get($contentConfig, 'type', 'text');
                $widgetBuilder = $this->getWidgetBuilder($type);
                $widgetBuilder->saveContentToBigSpreadsheet($contentConfig, $writer);
            }
        }
        $writer->close();
        return $tmpFilePath;
    }

    public function exportToExcel($paramsOrView = [], $setting = [])
    {
        $this->buildConfig($paramsOrView, $setting);
        $tmpFilePath = $this->configToExcel();
        if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($tmpFilePath);
        return new FileHandler($tmpFilePath);
    }

    public function exportToXLSX($paramsOrView = [], $setting = [])
    {
        $this->buildConfig($paramsOrView, $setting);
        $tmpFilePath = $this->configToBigSpreadsheet('xlsx');
        if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($tmpFilePath);
        return new FileHandler($tmpFilePath);
    }

    public function exportToCSVWithSpout($paramsOrView = [], $setting = [])
    {
        // echo "<br>";
        // $start = microtime(true);
        // echo "Export BigCSV: Start memory = " . memory_get_usage() . "<br>";

        $this->buildConfig($paramsOrView, $setting);
        $tmpFilePath = $this->configToBigSpreadsheet('csv');

        // echo "Export BigCSV: End memory = " . memory_get_usage() . "<br>";
        // $time_elapsed_secs = microtime(true) - $start;
        // echo "Export BigCSV time_elapsed_secs = $time_elapsed_secs<br>";
        // exit;

        if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($tmpFilePath);
        return new FileHandler($tmpFilePath);
    }

    public function exportToODS($paramsOrView = [], $setting = [])
    {
        $this->buildConfig($paramsOrView, $setting);
        $tmpFilePath = $this->configToBigSpreadsheet('ods');
        if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($tmpFilePath);
        return new FileHandler($tmpFilePath);
    }

    public function exportToCSV($params = [], $setting = [])
    {
        // echo "exportToCSV<br>";
        // exit;
        $measureTimeMemory = 0;
        if ($measureTimeMemory) {
            $start = microtime(true);
            $startMemory = memory_get_usage();
            echo "Export CSV: Start memory = " . $startMemory / 1000 . " KB<br>";
        }

        $defaultBuffer = 1000; // unit: KB or 1000 bytes
        $options = array();
        if (is_string($params)) {
            $dsName = $params;
            $this->setting($setting);
            $bom = Util::get($this->setting, "BOM", false);
            $buffer = Util::get($this->setting, 'buffer', $defaultBuffer);

            $exportDataStores = [$dsName => $this->report->datastore($dsName)];
            $options = [$dsName => $setting];
        } elseif (is_array($params)) {
            $this->setting($params);
            $bom = Util::get($this->setting, "BOM", false);
            $buffer = Util::get($this->setting, 'buffer', $defaultBuffer);

            $dataStoreNames = Util::get($this->setting, "dataStores", null);
            if (is_string($dataStoreNames)) {
                $dataStoreNames = array_map('trim', explode(',', $dataStoreNames));
            }

            // echo "dataStoreNames = "; print_r($dataStoreNames); echo "<br>";
            // echo "this->dataStoresGenerator = "; print_r($this->dataStoresGenerator); echo "<br>";

            if (!is_array($dataStoreNames)) {
                $exportDataStores = $this->dataStores;
            } else {
                $options = array();
                $exportDataStores = array();
                foreach ($dataStoreNames as $k => $v) {
                    if (is_string($k) && isset($this->dataStores[$k])) {
                        $exportDataStores[$k] = $this->dataStores[$k];
                        $options[$k] = $v;
                    } else if (is_string($k) && isset($this->dataStoresGenerator[$k])) {
                        $exportDataStores[$k] = $this->dataStoresGenerator[$k];
                        $options[$k] = $v;
                    } else if (is_string($v) && isset($this->dataStores[$v])) {
                        $exportDataStores[$v] = $this->dataStores[$v];
                    } else if (is_string($v) && isset($this->dataStoresGenerator[$v])) {
                        $exportDataStores[$v] = $this->dataStoresGenerator[$v];
                    }
                }
            }
        }
        // echo "num datastores = " . count($exportDataStores) . "<br>";


        $bufferSize = $buffer * 1000; // multiplied by 1000 bytes

        $tmpFilePath = $this->getTempFolder() . "/" . Util::getUniqueId() . ".csv";
        $file = fopen($tmpFilePath, 'w') or die('Cannot open file:  ' . $tmpFilePath);
        $content = "";
        $bufferCount = 0;

        foreach ($exportDataStores as $name => $ds) {
            $option = Util::get($options, $name, []);
            $colMetas = $ds->meta()['columns'];
            $colOptions = Util::get($option, "columns", []);
            // Util::prettyPrint($colMetas); 
            // Util::prettyPrint($colOptions); 
            // exit;
            $optCols = Util::get($option, 'columns', array_keys($colMetas));
            $expColKeys = [];
            $expColLabels = [];
            $i = 0;
            foreach ($optCols as $k => $v) {
                if (is_array($v)) $colKey = $k;
                else if (is_string($v) || is_numeric($v)) $colKey = $v;
                else continue;
                $colMeta = Util::get($colMetas, $colKey, []);
                if (is_array($v)) $colMeta = array_merge($colMeta, $v);
                $label = Util::get($colMeta, 'label', $colKey);
                foreach ($optCols as $k => $v)
                    if (
                        $k === $colKey || $k === $label
                        || $v === $i || $v === $colKey || $v === $label
                    ) {
                        $expColKeys[] = $colKey;
                        $expColLabels[] = $label;
                    }
                $i++;
            }

            foreach ($expColKeys as $colKey) {
                // echo "colKey = $colKey<br>";
                if (isset($colOptions[$colKey]) && is_array($colOptions[$colKey])) {
                    $colMetas[$colKey] = array_merge($colMetas[$colKey], $colOptions[$colKey]);
                }
            }
            $this->colMetas = $colMetas;
            // Util::prettyPrint($colMetas); 
            // exit;

            $settingOrOption = array_merge($this->setting, $option);

            $delimiter = Util::get($settingOrOption, 'separator', ',');
            $delimiter = Util::get($settingOrOption, 'fieldSeparator', $delimiter);
            $delimiter = Util::get($settingOrOption, 'delimiter', $delimiter);
            $delimiter = Util::get($settingOrOption, 'fieldDelimiter', $delimiter);

            $showHeader = Util::get($settingOrOption, "showHeader", true);

            $enclosure = Util::get($settingOrOption, "enclosure");
            if (empty($enclosure)) $enclosure = '';
            if (is_string($enclosure)) $enclosure = [$enclosure, $enclosure];
            $typeEnclosures = Util::get($settingOrOption, "typeEnclosures", []);
            Util::init($typeEnclosures, "unknown", $enclosure);
            Util::init($typeEnclosures, "string", $enclosure);
            Util::init($typeEnclosures, "date", $enclosure);
            Util::init($typeEnclosures, "datetime", $enclosure);
            Util::init($typeEnclosures, "time", $enclosure);
            Util::init($typeEnclosures, "number", ['', '']);
            Util::init($typeEnclosures, "boolean", ['', '']);
            foreach ($typeEnclosures as $tei => $typeEnclosure) {
                if (is_string($typeEnclosure)) {
                    $typeEnclosures[$tei] = [$typeEnclosure, $typeEnclosure];
                }
            }
            $headerEnc = Util::get($settingOrOption, "headerEnclosure", $enclosure);
            if (is_string($headerEnc)) $headerEnc = [$headerEnc, $headerEnc];
            $nullEnc = Util::get($settingOrOption, "nullEnclosure", ['', '']);
            if (is_string($nullEnc)) $nullEnc = [$nullEnc, $nullEnc];
            $nullString = Util::get($settingOrOption, "nullString", false);
            // escape character for enclosure happened in column values
            $enclosureEscape = Util::get($settingOrOption, "enclosureEscape", '');
            $eol = Util::get($settingOrOption, "eol", "\n");

            $useColumnFormat = Util::get($settingOrOption, 'useColumnFormat', 1);
            $useTypeEnclosure = Util::get($settingOrOption, 'useTypeEnclosure', 1);
            $useEnclosureEscape = Util::get($settingOrOption, 'useEnclosureEscape', 1);
            $useCustomColumnEnclosure = Util::get($settingOrOption, 'useCustomColumnEnclosure', 0);
            $useCustomColumnNullString = Util::get($settingOrOption, 'useCustomColumnNullString', 0);
            $useCustomColumnEnclosureEscape = Util::get($settingOrOption, 'useCustomColumnEnclosureEscape', 0);

            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                Util::init($colMeta, 'type', 'string');

                $type = strtolower($colMeta['type']);
                if (!in_array($type, ["string", "number", "boolean", "date", "datetime", "time"])) {
                    $type = "unknown";
                }
                $colMeta['type'] = $type;
                if ($type === 'date') {
                    $defaultFormat = 'Y-m-d';
                } else if ($type === 'datetime') {
                    $defaultFormat = 'Y-m-d H:i:s';
                } else if ($type === 'time') {
                    $defaultFormat = 'H:i:s';
                } else {
                    $defaultFormat = 1;
                }
                Util::init($colMeta, 'format', $defaultFormat);
                Util::init($colMeta, 'displayFormat', null);

                Util::init($colMeta, 'enclosure', $enclosure);
                Util::init($colMeta, 'nullString', $nullString);
                Util::init($colMeta, 'nullEnclosure', $nullEnc);
                Util::init($colMeta, 'enclosureEscape', $enclosureEscape);

                Util::init($colMeta, 'prefix', '');
                Util::init($colMeta, 'suffix', '');
                Util::init($colMeta, 'decimals', 0);

                $decPoint = isset($colMeta['decPoint']) ? $colMeta['decPoint'] : (isset($colMeta['decimalPoint']) ? $colMeta['decimalPoint'] : (isset($colMeta['dec_point']) ? $colMeta['dec_point'] : '.'));
                Util::init($colMeta, 'decPoint', $decPoint);

                $thousandSep = isset($colMeta['thousandSep']) ? $colMeta['thousandSep'] : (isset($colMeta['thousandSeparator']) ? $colMeta['thousandSeparator'] : (isset($colMeta['thousand_sep']) ? $colMeta['thousand_sep'] : ','));
                Util::init($colMeta, 'thousandSep', $thousandSep);

                $colMetas[$colKey] = $colMeta;
            }

            // error_reporting(0);
            // Util::prettyPrint($colMetas);
            // Util::prettyPrint($expColKeys);

            $delimiterLen = strlen($delimiter);

            if ($bom) {
                $bomStr = chr(239) . chr(187) . chr(191);
                $content .= $bomStr;
                $bufferCount += mb_strlen($bomStr, '8bit');
            }

            if ($showHeader) {
                $line = '';
                foreach ($expColKeys as $i => $colKey) {
                    $expColLabel = $expColLabels[$i];
                    if ($useCustomColumnEnclosure) {
                        $colHeaderEnc = Util::get($colMetas, [$colKey, 'headerEnclosure'], $headerEnc);
                    } else {
                        $colHeaderEnc = $headerEnc;
                    }
                    if (is_array($colHeaderEnc)) {
                        $startEnc = $colHeaderEnc[0];
                        $endEnc = $colHeaderEnc[1];
                    } else {
                        $startEnc = $endEnc = $colHeaderEnc;
                    }
                    if ($useCustomColumnEnclosureEscape) {
                        $colEscape = Util::get($colMetas, [$colKey, "enclosureEscape"], $enclosureEscape);
                    } else {
                        $colEscape = $enclosureEscape;
                    }
                    $startEncEcape = !empty($colEscape) ? $colEscape : $startEnc;
                    $endEncEcape = !empty($colEscape) ? $colEscape : $endEnc;
                    if (!empty($startEnc)) {
                        $expColLabel = str_replace($startEnc, $startEncEcape . $startEnc, $expColLabel);
                    }
                    if ($endEncEcape !== $startEncEcape && !empty($endEncEcape)) {
                        $expColLabel = str_replace($endEnc, $endEncEcape . $endEnc, $expColLabel);
                    }
                    $line .= $startEnc . $expColLabel . $endEnc . $delimiter;
                }
                $line = substr($line, 0, -$delimiterLen) . $eol;
                $content .= $line;
                $bufferCount += mb_strlen($line, '8bit');
                if ($bufferCount >= $bufferSize) {
                    fwrite($file, $content);
                    $content = "";
                    $bufferCount = 0;
                }
            }

            // $dsClass = get_class($ds);
            // echo "dsClass = $dsClass<br>";
            // exit;

            // echo "ds->data = "; Util::prettyPrint($ds->data()); echo "<br>";
            // exit;

            $aggregates = Util::get($settingOrOption, "aggregates", []);
            $aggResults = $this->initAggregateResults($aggregates);
            $columnFooters = [];
            $columnFooterTexts = [];
            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                $footerAgg = Util::get($colMeta, "footer");
                $defaultFooterText = "";
                if ($footerAgg) {
                    $columnFooters[$footerAgg . $colKey] = [$footerAgg, $colKey];
                    if (isset($colMeta["footerFormat"])) {
                        $columnFooters[$footerAgg . $colKey]["format"] = $colMeta["footerFormat"];
                    }
                    $defaultFooterText = "@" . $footerAgg . $colKey;
                }
                $columnFooterTexts[$colKey] = Util::get($colMeta, "footerText", $defaultFooterText);
            }
            $columnFooterResults = $this->initAggregateResults($columnFooters);
            $hasFooter = count($columnFooters) > 0;
            // echo "columnFooters = "; var_dump($columnFooters); exit;

            $dataGen = $ds->getRowGenerator();
            // echo "dataGen = "; var_dump($dataGen); echo "<br>";
            $rowCount = 0;
            // echo "rowCount init = 0<br>";
            foreach ($dataGen as $row) {
                // continue;
                // echo "rowCount = $rowCount<br>";
                // echo 'row = '; var_dump($row); echo '<br>';
                $line = '';
                foreach ($expColKeys as $colKey) {
                    $colMeta = $colMetas[$colKey];

                    if (isset($row[$colKey])) {
                        $value = $useColumnFormat ?
                            $this->format($row[$colKey], $colMeta) : $row[$colKey];
                        // $formattedValue = $row[$colKey];

                        if ($useTypeEnclosure) {
                            $colTypeEnc = $useCustomColumnEnclosure ?
                                $colMeta['enclosure'] : $typeEnclosures[$colMeta['type']];
                            $startEnd = $colTypeEnc[0];
                            $endEnc = $colTypeEnc[1];
                        } else {
                            $startEnd = $enclosure[0];
                            $endEnc = $enclosure[1];
                        }

                        if ($useEnclosureEscape) {
                            $colEscape = $useCustomColumnEnclosureEscape ?
                                $colMeta['enclosureEscape'] : $enclosureEscape;
                            $startEncEcape = !empty($colEscape) ? $colEscape : $startEnd;
                            $endEncEcape = !empty($colEscape) ? $colEscape : $endEnc;
                            if (!empty($startEncEcape)) {
                                $value = str_replace($startEnd, $startEncEcape . $startEnd, $value);
                            }
                            if ($endEncEcape !== $startEncEcape && !empty($endEncEcape)) {
                                $value = str_replace($endEnc, $endEncEcape . $endEnc, $value);
                            }
                        }

                        $line .= $startEnd . $value . $endEnc . $delimiter;
                        // echo "line = $line<br><br>";

                    } else {
                        $colNullString = $useCustomColumnNullString ? $colMeta['nullString'] : $nullString;

                        if ($useCustomColumnEnclosure) {
                            $startNullEnc = $colMeta['nullEnclosure'][0];
                            $endNullEnc = $colMeta['nullEnclosure'][1];
                        } else {
                            $startNullEnc = $nullEnc[0];
                            $endNullEnc = $nullEnc[1];
                        }

                        $line .= $startNullEnc . $colNullString . $endNullEnc . $delimiter;
                        // echo "line = $line<br><br>";
                    }
                }
                $line = substr($line, 0, -$delimiterLen) . $eol;
                $content .= $line;
                $bufferCount += mb_strlen($line, '8bit');
                if ($bufferCount >= $bufferSize) {
                    // if ($measureTimeMemory) {
                    //     $endMemory = memory_get_usage();
                    //     echo 'Peak memory usage = ' . ($endMemory - $startMemory) / 1000 . ' KB <br>';
                    // }
                    fwrite($file, $content);
                    $content = '';
                    $bufferCount = 0;
                }

                $this->aggregateRow($row, $aggregates, $aggResults);
                $this->aggregateRow($row, $columnFooters, $columnFooterResults);

                $rowCount++;
            }
            $aggResults = $this->finalizeAggregateResults($aggResults, $aggregates, $rowCount);
            $columnFooterResults = $this->finalizeAggregateResults($columnFooterResults, $columnFooters, $rowCount);
            // echo "columnFooterResults = "; var_dump($columnFooterResults); exit;

            if ($hasFooter) {
                $line = '';
                foreach ($expColKeys as $colKey) {
                    $colMeta = $colMetas[$colKey];
                    $footerAgg = Util::get($colMeta, "footer");
                    $footerText = Util::get($columnFooterTexts, $colKey, "");
                    if ($footerAgg) {
                        $footerText = str_replace("@value", "@" . $footerAgg . $colKey, $footerText);
                    }
                    foreach ($aggResults as $aggName => $aggValue) {
                        $footerText = str_replace("@" . $aggName, $aggValue, $footerText);
                    }
                    foreach ($columnFooterResults as $aggName => $aggValue) {
                        $footerText = str_replace("@" . $aggName, $aggValue, $footerText);
                    }
                    $line .= $startEnd . $footerText . $endEnc . $delimiter;
                }
                $line = substr($line, 0, -$delimiterLen) . $eol;
                $content .= $line;
            }

            if ($measureTimeMemory) {
                echo "rowCount = $rowCount<br>";
            }
        }

        fwrite($file, $content);
        fclose($file);

        if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($tmpFilePath);

        // exit;

        if ($measureTimeMemory) {
            echo "bufferSize = " . $bufferSize / 1000 . " KB<br>";
            $endMemory = memory_get_usage();
            echo "Export CSV: End memory = " . $endMemory / 1000 . " KB<br>";
            echo "Export memory usage = " . ($endMemory - $startMemory) / 1000 . " KB <br>";
            $time_elapsed_secs = microtime(true) - $start;
            echo "Export CSV time_elapsed_secs = $time_elapsed_secs<br><br>";
            // echo "tmpFilePath = $tmpFilePath <br>";
            // unlink($tmpFilePath);
            exit;
        }

        return new FileHandler($tmpFilePath);
    }

    protected function initAggregateResults($aggregates)
    {
        $aggResults = [];
        foreach ($aggregates as $aggName => $agg) {
            $op = Util::get($agg, "operator", Util::get($agg, 0));
            $colKey = Util::get($agg, "field", Util::get($agg, 1));
            $initAggValue = null;
            switch ($op) {
                case "count":
                    $initAggValue = 0;
                    break;
                case "sum":
                    $initAggValue = 0;
                    break;
                case "avg":
                    $initAggValue = 0;
                    break;
                case "min":
                    $initAggValue = PHP_INT_MAX;
                    break;
                case "max":
                    $initAggValue = PHP_INT_MIN;
                    break;
            }
            $aggResults[$aggName] = $initAggValue;
        }
        return $aggResults;
    }

    protected function aggregateRow($row, $aggregates, &$aggResults)
    {
        foreach ($aggregates as $aggName => $agg) {
            $op = Util::get($agg, "operator", Util::get($agg, 0));
            $colKey = Util::get($agg, "field", Util::get($agg, 1));
            switch ($op) {
                case "count":
                    $aggResults[$aggName] += 1;
                    break;
                case "sum":
                    $aggResults[$aggName] += Util::get($row, $colKey, 0);
                    break;
                case "avg":
                    $aggResults[$aggName] += Util::get($row, $colKey, 0);
                    break;
                case "min":
                    $aggResults[$aggName] = min($aggResults[$aggName], Util::get($row, $colKey, PHP_INT_MAX));
                    break;
                case "max":
                    $$aggResults[$aggName] = max($aggResults[$aggName], Util::get($row, $colKey, PHP_INT_MIN));
                    break;
            }
        }
    }

    protected function finalizeAggregateResults($aggResults, $aggregates, $rowCount)
    {
        foreach ($aggregates as $aggName => $agg) {
            $aggValue = $aggResults[$aggName];
            $op = Util::get($agg, "operator", Util::get($agg, 0));
            if ($op === "avg") {
                $aggValue = $aggValue / $rowCount;
            }

            $colKey = Util::get($agg, "field", Util::get($agg, 1));
            $colMeta = Util::get($this->colMetas, $colKey, []);
            $format = Util::get($agg, "format");
            if (is_callable($format)) {
                $aggValue = $format($aggValue, $colMeta);
            } else if (is_array($format)) {
                $format["type"] = Util::get($colKey, "type", "number");
                $aggValue = Util::format($aggValue, $format);
            }
            $aggResults[$aggName] = $aggValue;
        }
        return $aggResults;
    }

    protected function registerAutoDeleteFile($path)
    {
        ignore_user_abort(true);
        $realpath = realpath($path);
        register_shutdown_function(function () use ($realpath) {
            if (is_file($realpath)) {
                unlink($realpath);
            }
        });
    }

    public function format($value, $meta)
    {
        if ($meta['format'] === false) {
            return $value;
        }

        switch ($meta['type']) {
            case 'string':
                $prefix = $meta['prefix'];
                $suffix = $meta['suffix'];
                return $prefix . $value . $suffix;
                break;
            case 'number':
                $decimals = $meta['decimals'];
                $dec_point = $meta['decPoint'];
                $thousand_sep = $meta['thousandSep'];
                $prefix = $meta['prefix'];
                $suffix = $meta['suffix'];
                return $prefix
                    . number_format($value, $decimals, $dec_point, $thousand_sep)
                    . $suffix;
                break;
            case 'datetime':
                // no break
            case 'date':
                // no break
            case 'time':
                $dateFormat = $meta['format'];
                $displayFormat = $meta['displayFormat'];
                if ($displayFormat && $value) {
                    if ($fvalue = \DateTime::createFromFormat($dateFormat, $value)) {
                        return $fvalue->format($displayFormat);
                    }
                }
                break;
            case 'array':
                return json_encode($value);
                break;
        }

        if (gettype($value) === 'array') {
            return json_encode($value);
        }

        return $value;
    }

    public function exportToJSON($params = [], $setting = [])
    {
        $measureTimeMemory = 0;
        if ($measureTimeMemory) {
            $start = microtime(true);
            $startMemory = memory_get_usage();
            echo "Export CSV: Start memory = " . $startMemory / 1000 . " KB<br>";
        }

        $options = array();
        if (is_string($params)) {
            $dsName = $params;
            $this->setting($setting);
            $bom = Util::get($this->setting, "BOM", false);
            $buffer = Util::get($this->setting, 'buffer', $defaultBuffer);

            $exportDataStores = [$dsName => $this->report->datastore($dsName)];
            $options = [$dsName => $setting];
        } elseif (is_array($params)) {
            $this->setting($params);
            $bom = Util::get($this->setting, "BOM", false);

            $dataStoreNames = Util::get($this->setting, "dataStores", null);
            if (is_string($dataStoreNames))
                $dataStoreNames = array_map('trim', explode(',', $dataStoreNames));
            if (!is_array($dataStoreNames))
                $exportDataStores = $this->dataStores;
            else {
                $options = array();
                $exportDataStores = array();
                foreach ($dataStoreNames as $k => $v) {
                    if (isset($this->dataStores[$k])) {
                        $exportDataStores[$k] = $this->dataStores[$k];
                        $options[$k] = $v;
                    } else if (is_string($v) && isset($this->dataStores[$v]))
                        $exportDataStores[$v] = $this->dataStores[$v];
                }
            }
        }

        $tmpFilePath = $this->getTempFolder() . "/" . Util::getUniqueId() . ".json";
        $file = fopen($tmpFilePath, 'wa') or die('Cannot open file:  ' . $tmpFilePath);

        foreach ($exportDataStores as $name => $ds) {
            fwrite($file, $ds->toJson());
        }
        fclose($file);

        if ($measureTimeMemory) {
            $endMemory = memory_get_usage();
            echo "Export CSV: End memory = " . $endMemory / 1000 . " KB<br>";
            echo "Final memory usage = " . ($endMemory - $startMemory) / 1000 . " KB <br>";
            $time_elapsed_secs = microtime(true) - $start;
            echo "Export CSV time_elapsed_secs = $time_elapsed_secs<br>";
            exit;
        }

        if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($tmpFilePath);
        return new FileHandler($tmpFilePath);
    }

    protected function getTempFolder()
    {
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
            // $path = dirname(__FILE__);
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            if (!is_dir(realpath($path) . "/tmp")) {
                mkdir(realpath($path) . "/tmp");
            }
            return realpath($path) . "/tmp";
        }
        return sys_get_temp_dir();
    }
}

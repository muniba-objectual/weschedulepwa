<?php

/**
 * This file contains class to handle generated file.
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */

namespace koolreport\excel;

use \koolreport\core\Utility;

class FileHandler
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function mime_type($filename)
    {
        $dotpos = strrpos($filename, ".");
        $ext = strtolower(substr($filename, $dotpos + 1));
        $map = array(
            "xls" => "application/vnd.ms-excel",
            "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "csv" => "text/plain",
            "txt" => "text/plain",
        );
        return Utility::get($map, $ext);
    }

    protected function registerAutoDeleteFile()
    {
    }

    public function toBrowser($filename, $openOnBrowser = false)
    {
        // ignore_user_abort(true);
        $disposition = "attachment";
        if (gettype($openOnBrowser) == "string") {
            $disposition = $openOnBrowser;
        } else if ($openOnBrowser) {
            $disposition = "inline";
        }

        $source = realpath($this->path);

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: " . $this->mime_type($filename));
        header("Content-Disposition: $disposition; filename=\"$filename\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($source));

        readfile($this->path);
        // register_shutdown_function('unlink', $this->path);
        // unlink($this->path);
        // if (connection_aborted()) {
        // unlink($this->path);
        // }
        return $this;
    }

    public function saveAs($filename)
    {
        if (copy($this->path, $filename)) {
            return $this;
        } else {
            throw new \Exception("Could not save file $filename");
            return false;
        }
    }
}

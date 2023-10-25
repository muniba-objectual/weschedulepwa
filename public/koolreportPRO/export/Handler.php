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

namespace koolreport\export;

use \JonnyW\PhantomJs\Client;
use \koolreport\core\Utility as Util;
use \daandesmedt\PHPHeadlessChrome\HeadlessChrome;

class Handler
{
    protected $phantomjs;
    protected $sourceFile;
    protected $report;
    protected $view;
    protected $resourceWaiting = 1000;
    protected $useLocalTempFolder = false;
    protected $autoDeleteLocalTempFile = false;
    protected $autoDeleteTempFile = false;
    protected $serverLocalAddress;
    
    public function __construct($report, $view)
    {
        $this->report = $report;
        $this->view = $view;
    }

    public function settings($settings)
    {
        $phantomjs = Util::get($settings, "phantomjs");
        if ($phantomjs) {
            $this->phantomjs = $phantomjs;
        }
        $resourceWaiting = Util::get($settings, "resourceWaiting");
        if ($resourceWaiting) {
            $this->resourceWaiting = $resourceWaiting;
        }
        $this->useLocalTempFolder = Util::get($settings, "useLocalTempFolder", false);
        $this->autoDeleteLocalTempFile = Util::get($settings, "autoDeleteLocalTempFile", false);
        $defaultAutoDeleteTempFile = $this->useLocalTempFolder ? $this->autoDeleteLocalTempFile : false;
        $this->autoDeleteTempFile = Util::get($settings, "autoDeleteTempFile", $defaultAutoDeleteTempFile);
        $this->serverLocalAddress = Util::get($settings, "serverLocalAddress");
        return $this;
    }

    protected function runPhantom($script, $source, $output, $params)
    {
        if (!$this->phantomjs) {
            $this->phantomjs = realpath(dirname(__FILE__))."/bin/phantomjs";
            if (!is_file($this->phantomjs)) {
                $this->phantomjs.=".exe";
                if (!is_file($this->phantomjs)) {
                    throw new \Exception("Could not find phantomjs executed file in bin folder");
                }
            }
            if (!is_executable($this->phantomjs)) {
                throw new \Exception("Please set executable permission for phantomjs");
            }
        }

        $command = $this->phantomjs." --ignore-ssl-errors=true $script $source $output $params";
        // echo "command = <br>" . str_replace(" ", "<br>", $command) . "<br>"; exit;
        // echo "command = $command<br>"; exit;
        $result = shell_exec($command);
        // echo str_replace("<", "&lt", $result); exit;

        if (strpos($result, ";")===false) {
            throw new \Exception("Could not execute phantomjs");
        }
        $result = explode(";", $result);
        if ($result[0]=="0") {
            throw new \Exception($result[1]);
            return false;
        } else {
            return true;
        }
    }

    protected function clearDirectory($dir)
    {
        $di = new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
        $ri = new \RecursiveIteratorIterator($di, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ( $ri as $file ) {
            $file->isDir() ?  
                rmdir($file->getPathname()) : unlink($file->getPathname());
        }
    }

    protected function registerAutoDeleteFile($path)
    {
        ignore_user_abort(true);
        $realpath = realpath($path);
        register_shutdown_function(function() use ($realpath) {
            if (is_file($realpath)) {
                unlink($realpath);
            }
        });        
    }

    protected function saveTempContent($path = null, $ext = "tmp")
    {
        $content = $this->report->render($this->view, true);
        if (! isset($path)) {
            $path = $this->getTempFolder() . "/";
        }
        // if ($this->useLocalTempFolder && $this->autoDeleteLocalTempFile) {
        //     $this->clearDirectory($path);            
        // }
        $source = $path . Util::getUniqueId().".$ext";

        $protocol = $this->getIsSecureConnection()?"https":"http";

        $url = $this->getFullUrl();
        $url = substr($url, 0, strrpos($url, "/"));
        $content = preg_replace_callback(
            '~<link([^>]+)href=["\']([^>]*)["\']~',
            function ($matches) use ($url) {
                $href = $matches[2];
                $isAbsolutePath = substr($href, 0, 1) === "/" ||
                    substr($href, 0, 4) === "http";
                if (! $isAbsolutePath) {
                    $href = $url . "/" . $href;
                }
                return "<link $matches[1] href='$href'";
            },
            $content
        );

        $content = preg_replace_callback(
            '~<script([^>]+)src=["\']([^>]*)["\']~',
            function ($matches) use ($url) {
                $href = $matches[2];
                $isAbsolutePath = substr($href, 0, 1) === "/" ||
                    substr($href, 0, 4) === "http";
                if (! $isAbsolutePath) {
                    $href = $url . "/" . $href;
                }
                return "<script $matches[1] src='$href'";
            },
            $content
        );

        // echo htmlentities($content);

        if (file_put_contents($source, $content)) {
            return $source;
        } else {
            throw new \Exception("Could not save content to temporary folder");
            return false;
        }
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
            // if (!is_dir(realpath(dirname(__FILE__))."/tmp")) {
            //     mkdir(realpath(dirname(__FILE__))."/tmp");
            // }
            // return realpath(dirname(__FILE__))."/tmp";
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            if(!is_dir(realpath($path)."/tmp"))
            {
                mkdir(realpath($path)."/tmp");
            }
            return realpath($path)."/tmp";
        }
        return sys_get_temp_dir();
    }
    
    
    /*
     * params = array(
     *      "height"=>123, //"cm,in",
     *      "width"=>123,
     *      "format"=>"A4",
     *      "orientation"=>"portrait",
     *      "header"=>array(
     *          "height"=>"1cm",
     *          "contents"=>"{pageNum}/{numPages}"
     *      ),
     *      "footer"=>array(
     *          "height"=>"1cm",
     *          "contents"=>"{pageNum}/{numPages}"
     *      ),
     *      "headerCallback" => "function(headerContent, pageNum, numPages){
                if (pageNum == 1) return '';
                return headerContent;
            }",
     * 
     *  )
     */

    protected function getIsSecureConnection()
    {
        return isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on')===0 || $_SERVER['HTTPS']==1)
            || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https')===0;
    }

    protected function getFullUrl()
    {
        $protocol = $this->getIsSecureConnection()?"https":"http";
        $host = isset($this->serverLocalAddress) ? $this->serverLocalAddress : Util::get($_SERVER, "HTTP_HOST");
        $http_host = (!empty($host))?"$protocol://".$host:"$protocol://localhost";
        $uri = $_SERVER["REQUEST_URI"];
        return $http_host.$uri;
    }

    public function pdf($params=array())
    {
        $nodeBinary = Util::get($params, 'nodeBinary', null);
        $chromeBinary = Util::get($params, 'chromeBinary', null);
        // $pdf = Util::get($params, 'pdf', []);
        
        if (is_string($nodeBinary)) {
            // echo "nodeBinary = "; echo($nodeBinary); echo "<br>";
            if (! file_exists($nodeBinary) && ! file_exists($nodeBinary . ".exe")) {
                $nodeBinary = __DIR__ . "/" . $nodeBinary;
            }
            // echo "nodeBinary = "; echo($nodeBinary); echo "<br>";
            
            $tmpFolder = $this->getTempFolder();
            // $tmpHtmlFile = $this->saveTempContent("", "html");
            $tmpHtmlFile = $this->saveTempContent(null, "html");
            $url = $this->getFullUrl();
            $url = substr($url, 0, strrpos($url, "/"));
            $tmpPDFFile = Util::getUniqueId().".pdf";
            $params['path'] = $tmpFolder . "/" . $tmpPDFFile;
            $config = [
                // "url" => $url . "/" . $tmpHtmlFile,
                "url" => "file://" . $tmpHtmlFile,
                // "url" => $tmpHtmlFile,
                "nodeBinary" => $nodeBinary,
                "chromeBinary" => $chromeBinary,
                "pdf" => $params,
                // "goto" => [
                //     "waitUntil" => "load", //'domcontentloaded', 'networkidle0', 'networkidle2'
                // ],
                // "httpUrl" => $this->getFullUrl()
            ];
            // echo " * "; print_r($config); echo "<br>";
            // exit();
            $browser = new \Its404\PhpPuppeteer\Browser();
            // $browser->isDebug = true;
            $result = $browser->pdf($config);
            if (isset($result['returnVal'])&& $result['returnVal'] == 0) {
                return new File($tmpFolder . "/" . $tmpPDFFile);
            } else {
                echo "Failed to generate PDF";
                var_dump($result['output']);
            }
        } elseif (is_string($chromeBinary)) {
            $tmpFolder = $this->getTempFolder();
            $tmpHtmlFile = $this->saveTempContent("", "html");
            $url = $this->getFullUrl();
            $url = substr($url, 0, strrpos($url, "/"));
            $tmpPDFFile = Util::getUniqueId().".pdf";

            $headlessChromer = new HeadlessChrome();
            $headlessChromer->setBinaryPath($chromeBinary);
            $headlessChromer->setUrl($url . "/" . $tmpHtmlFile);
            $headlessChromer->setOutputDirectory($tmpFolder);
            $headlessChromer->toPDF($tmpPDFFile);
            unlink($tmpHtmlFile);
            return new File($tmpFolder . "/" . $tmpPDFFile);
        }

        if (! isset($chromeBinary) && ! isset($nodeBinary)) {
            if ($params==array()) {
                $params = array(
                    "format"=>"A4",
                    "orientation"=>"portrait",
                    "margin"=>"1in",
                );
            }
            $script = realpath(dirname(__FILE__))."/pdf/pdf.js";
            $source = $this->saveTempContent();
            if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($source);
            $params["expectedLocation"] = $this->getFullUrl();
            $params["resourceWaiting"] = $this->resourceWaiting;
            // echo "export params = "; print_r($params); echo "<br>";
            // exit;
            if (! isset($params['width']) || ! isset($params['height'])) {
                Util::init($params, 'format', 'A4');
            }
            
            $output = $this->getTempFolder()."/".Util::getUniqueId().".pdf";
            if ($source) {
                if ($this->runPhantom($script, $source, $output, base64_encode(json_encode($params)))) {
                    if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($output);
                    return new File($output);
                }
            }
        }
    }
    
    protected function image($type, $params)
    {
        //base on the filename extension to export PNG,JPG,BMP,TIFF
        $script = realpath(dirname(__FILE__))."/image/image.js";
        $source = $this->saveTempContent();
        $useHttp = false;
        if (isset($params["useHttp"])) {
            $useHttp = $params["useHttp"];
            unset($params["useHttp"]);
        }
        $params["expectedLocation"] = $this->getFullUrl($useHttp);
        $params["resourceWaiting"] = $this->resourceWaiting;
        
        $output = $this->getTempFolder()."/".Util::getUniqueId().".$type";
        if ($source) {
            if ($this->runPhantom($script, $source, $output, base64_encode(json_encode($params)))) {
                if ($this->autoDeleteTempFile) $this->registerAutoDeleteFile($output);
                return new File($output);
            }
        }
    }
    /*
     * $params =array(
     *      "width":"1212px",
     *      "height":"1233px",
     * )
     *
     */
    public function jpg($params=array())
    {
        return $this->image('jpg', $params);
    }
    public function gif($params=array())
    {
        return $this->image('gif', $params);
    }
    public function bmp($params=array())
    {
        return $this->image('bmp', $params);
    }
    public function ppm($params=array())
    {
        return $this->image('ppm', $params);
    }
    public function png($params=array())
    {
        return $this->image('png', $params);
    }
}

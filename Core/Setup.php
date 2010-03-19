<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\Core;

//include the Loging Framework
include_once("Log.php");
include_once(dirname(__FILE__)."/SwiftriverCoreService.php");
//include everything else
$directories = array(
    dirname(__FILE__)."/DAL/",
    dirname(__FILE__)."/ObjectModel/",
    dirname(__FILE__)."/PreProcessing/",
    dirname(__FILE__)."/ServiceAPI/ServiceAPIParsers/",
    dirname(__FILE__)."/Modules/SwiftriverServiceWrapper/",
    dirname(__FILE__)."/Modules/SISPS/",
);
foreach($directories as $dir) {
    $dirItterator = new \RecursiveDirectoryIterator($dir);
    $iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
    foreach($iterator as $file) {
        if($file->isFile()) {
            $filePath = $file->getPathname();
            if(strpos($filePath, ".php")) {
                include_once($filePath);
            }
        }
    }
}

class Setup {
    public static function GetLogger() {
        $config = Setup::Configuration();
        $logger = &\Log::singleton('file', $config["CachingDirectory"]."/log.log" , '    ');
        return $logger;
    }
    
    public static function Configuration() {
        return array (
            "SiSPSDirectory" => dirname(__FILE__)."/Modules/SiSPS",
            "ModulesDirectory" => dirname(__FILE__)."/Modules",
            "CachingDirectory" => dirname(__FILE__)."/Cache",
        );
    }
}
?>

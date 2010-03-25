<?php
namespace Swiftriver\Core;
class Setup {
    public static function GetLogger() {
        $logger = &\Log::singleton('file', Setup::Configuration()->CachingDirectory."/log.log" , '   ');
        return $logger;
    }

    /**
     * @return Configuration\ConfigurationHandlers\CoreConfigurationHandler
     */
    public static function Configuration() {
        return new Configuration\ConfigurationHandlers\CoreConfigurationHandler(dirname(__FILE__)."/Configuration/ConfigurationFiles/CoreConfiguration.xml");
    }
}
//include the Loging Framework
include_once("Log.php");

//Include the config framework
$dirItterator = new \RecursiveDirectoryIterator(dirname(__FILE__)."/Configuration/ConfigurationHandlers/");
$iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
foreach($iterator as $file) {
    if($file->isFile()) {
        $filePath = $file->getPathname();
        if(strpos($filePath, ".php")) {
            include_once($filePath);
        }
    }
}

//Include some specific files
include_once(dirname(__FILE__)."/SwiftriverCoreService.php");
include_once(dirname(__FILE__)."/ServiceAPI/ServiceAPIClasses/ServiceAPIBase.php");

//include everything else
$directories = array(
    dirname(__FILE__)."/DAL/",
    dirname(__FILE__)."/ObjectModel/",
    dirname(__FILE__)."/PreProcessing/",
    dirname(__FILE__)."/ServiceAPI/ServiceAPIClasses/",
    Setup::Configuration()->ModulesDirectory."/SiSW/",
    Setup::Configuration()->ModulesDirectory."/SISPS/",
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


?>

<?php
namespace Swiftriver\Core;
class Setup {
    private static $configuration;
    private static $dalConfiguration;

    public static function GetLogger() {
        $logger = &\Log::singleton('file', Setup::Configuration()->CachingDirectory."/log.log" , '   ');
        return $logger;
    }

    /**
     * @return Configuration\ConfigurationHandlers\CoreConfigurationHandler
     */
    public static function Configuration() {
        if(isset(self::$configuration))
            return self::$configuration;
        self::$configuration = new Configuration\ConfigurationHandlers\CoreConfigurationHandler(dirname(__FILE__)."/Configuration/ConfigurationFiles/CoreConfiguration.xml");
        return self::$configuration;
    }

    /**
     * @return Configuration\ConfigurationHandlers\DALConfigurationHandler
     */
    public static function DALConfiguration() {
        if(isset(self::$dalConfiguration))
            return self::$dalConfiguration;
        self::$dalConfiguration = new Configuration\ConfigurationHandlers\DALConfigurationHandler(dirname(__FILE__)."/Configuration/ConfigurationFiles/DALConfiguration.xml");
        return self::$dalConfiguration;
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

//Include all the DAL Data Context Files
foreach(Setup::DALConfiguration()->DataContextIncludeDirectories as $dir) {
    $directory = Setup::Configuration()->ModulesDirectory.$dir;
    if(!file_exists($directory))
        continue;

    $dirItterator = new \RecursiveDirectoryIterator($directory);
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

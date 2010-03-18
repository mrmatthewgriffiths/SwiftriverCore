<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\Core;

//include the Loging Framework
include_once("Log.php");
//initialise the logger
$logger = &\Log::singleton('syslog', \LOG_SYSLOG, 'Swiftriver Core');
include_once(dirname(__FILE__)."/PreProcessing/PreProcessor.php");
include_once(dirname(__FILE__)."/PreProcessing/IPreProcessingStep.php");
include_once(dirname(__FILE__)."/DAL/ContentRepository.php");

include_once(dirname(__FILE__)."/ObjectModel/Tag.php");
include_once(dirname(__FILE__)."/Modules/SwiftriverServiceWrapper/ServiceWrapper.php");


class Setup {
    public static function Configuration() {
        return array (
            "SiSPSDirectory" => dirname(__FILE__)."/../SiSPS",
            "ModulesDirectory" => dirname(__FILE__)."/Modules",
            "CachingDirectory" => dirname(__FILE__)."/Cache",
        );
    }
}
?>

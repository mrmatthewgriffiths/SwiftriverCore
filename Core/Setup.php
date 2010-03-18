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

class Setup {
    public static function Configuration() {
        return array (
            "SiSPSDirectory" => dirname(__FILE__)."/Modules/SiSPS",
            "ModulesDirectory" => dirname(__FILE__)."/Modules",
        );
    }
}
?>

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
?>

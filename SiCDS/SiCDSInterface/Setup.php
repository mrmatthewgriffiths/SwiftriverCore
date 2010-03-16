<?php
namespace  Swiftriver\SiCDS\SiCDSInterface;
$serviceUri = 'http://test2';

class Setup {
    public static function Modules_Directory(){
        return dirname(__FILE__)."/../../Swiftriver_core/Modules";
    }

    public static function Swiftriver_Core_Directory() {
        return dirname(__FILE__)."/../../Swiftriver_core";
    }
}
?>

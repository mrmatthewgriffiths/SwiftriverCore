<?php
namespace  Swiftriver\SiCDS\SiCDSInterface;
$serviceUri = 'http://test2';

class Setup {
    public static function Modules_Directory(){
        return dirname(__FILE__)."/../../Core/Modules";
    }

    public static function Swiftriver_Core_Directory() {
        return dirname(__FILE__)."/../../Core";
    }
}
?>

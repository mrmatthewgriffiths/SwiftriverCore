<?php
namespace Swiftriver\TagTheNetInterface;
class Setup {
    public static function Configuration() {
        return array (
            "ServiceUri" => "",
            "SwiftriverCoreDirectory" => dirname(__FILE__)."/../Core",
            "SwiftriverModulesDirectory" => dirname(__FILE__)."/../Core/Modules",
        );
    }
}
?>

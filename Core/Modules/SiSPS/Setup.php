<?php
namespace Swiftriver\Core\Modules\SiSPS;

//include all required files:
$dirItterator = new \RecursiveDirectoryIterator(dirname(__FILE__));
$iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
foreach($iterator as $file) {
    if($file->isFile()) {
        $fileName = $file->getPathname();
        if(strpos($fileName, "ParserFactory.php") ||
           strpos($fileName, "Parser.php")
        )
            include_once($fileName);
    }
}

class Setup {
    public static function Modules_Directory(){
        return dirname(__FILE__)."/../Core/Modules";
    }
    public static function Caching_Directory(){
        return dirname(__FILE__)."/../Core/Cache";
    }
}

?>

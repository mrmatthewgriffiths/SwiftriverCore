<?php
/**
 * The TestParser class is used to facilitate the unit tests
 * in the ParserFactoryTests class
 */
namespace Swiftriver\Core\Modules\SiSPS\Parsers;
class TestParser implements IParser {
    public function GetAndParse($parameters) {
        $item = new \Swiftriver\Core\ObjectModel\Content();
        $item->SetId("testId");
        return array($item);
    }
}
?>,

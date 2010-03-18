<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class SiLCCTest extends \PHPUnit_Framework_TestCase  {
    public function testTheSiLCCWebService() {
        include_once(dirname(__FILE__)."/../Modules/SwiftriverServiceWrapper/ServiceWrapper.php");
        $service = new \Swiftriver\SiSW\ServiceWrapper("http://silccapi.com/silcctag");
        $json = $service->MakePOSTRequest(array("data" => "something"), 10);
        $this->assertEquals(true, isset($json));
    }
}
?>

<?php
namespace Swiftriver\Core;
require_once 'PHPUnit/Framework.php';
class ServiceAPIBaseTests extends \PHPUnit_Framework_TestCase {
    public function testCheckAPIKey() {
        include_once(dirname(__FILE__)."/../../../Setup.php");
        $object = new ServiceAPI\ServiceAPIClasses\ServiceAPIBase();
        $return = $object->CheckKey("test");
        $this->assertEquals(true, isset($return));
    }
}
?>

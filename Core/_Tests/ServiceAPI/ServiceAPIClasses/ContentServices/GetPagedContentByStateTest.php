<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class GetPagedContentByStateTest extends \PHPUnit_Framework_TestCase  {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../../../Setup.php");
        $this->object = new ServiceAPI\ServiceAPIClasses\ContentServices\GetPagedContentByState();
    }

    public function test() {
        $this->object->RunService('{"state":10,"pagesize":20,"pagestart":0}');
    }
}
?>

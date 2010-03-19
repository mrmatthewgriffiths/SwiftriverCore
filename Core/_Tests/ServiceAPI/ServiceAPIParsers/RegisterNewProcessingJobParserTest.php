<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class RegisterNewProcessingJobParserTest extends \PHPUnit_Framework_TestCase  {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../../Setup.php");
        $this->object = new \Swiftriver\Core\ServiceAPI\ServiceAPIParsers\RegisterNewProcessingJobParser();
    }

    public function test() {
        $json = '[{"type":"Test","updatePeriod":"5","parameters":[{"test":"test"}]}]';
        $channel = $this->object->ParseIncommingJSON($json);
        $this->assertEquals(true, isset($channel));
        $this->assertEquals("Test", $channel->GetType());
        $this->assertEquals(5, $channel->GetUpdatePeriod());
        $params = $channel->GetParameters();
        $this->assertEquals(true, is_array($params));
        $this->assertEquals("test", $params["test"]);
    }
}
?>

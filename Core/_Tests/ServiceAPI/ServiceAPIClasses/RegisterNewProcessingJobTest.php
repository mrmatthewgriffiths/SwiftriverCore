<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class RegisterNewProcessingJobTest extends \PHPUnit_Framework_TestCase  {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../../Setup.php");
        $this->object = new \Swiftriver\Core\ServiceAPI\ServiceAPIClasses\RegisterNewProcessingJob();
    }

    public function testParseIncommingJSON() {
        $json = '[{"type":"Test","updatePeriod":"5","parameters":[{"test":"test"}]}]';
        $channel = $this->object->ParseIncommingJSON($json);
        $this->assertEquals(true, isset($channel));
        $this->assertEquals("Test", $channel->GetType());
        $this->assertEquals(5, $channel->GetUpdatePeriod());
        $params = $channel->GetParameters();
        $this->assertEquals(true, is_array($params));
        $this->assertEquals("test", $params["test"]);
    }
    
    public function testParseIncommingJSONWithBadJSON() {
        $json = 'this is bad json and will not pass the parser';
        $channel = $this->object->ParseIncommingJSON($json);
        $this->assertEquals(false, isset($channel));
    }

    public function testRunServiceWithBadJSON() {
        $json = 'this is bad json and will not pass the parser';
        $message = $this->object->RunService($json);
        $this->assertEquals(true, strpos($message, "error") != 0);
    }

    public function testRunServiceWithGoodJSON() {
        $json = '[{"type":"Test","updatePeriod":"5","parameters":[{"test":"test"}]}]';
        $message = $this->object->RunService($json);
        $this->assertEquals(true, strpos($message, "OK") != 0);
    }
}
?>

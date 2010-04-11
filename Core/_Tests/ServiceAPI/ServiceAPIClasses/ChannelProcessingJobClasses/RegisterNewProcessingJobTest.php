<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class RegisterNewProcessingJobTest extends \PHPUnit_Framework_TestCase  {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../../../Setup.php");
        $this->object = new ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses\RegisterNewProcessingJob();
    }

    public function testRunServiceWithBadJSON() {
        $json = 'this is bad json and will not pass the parser';
        $message = $this->object->RunService($json);
        $this->assertEquals(true, strpos($message, "error") != 0);
    }

    public function testRunServiceWithGoodJSON() {
        $json = '{"type":"RSS","updatePeriod":1,"parameters":{"feedUrl":"http://feeds.feedburner.com/white_african"}}';
        $message = $this->object->RunService($json);
        $this->assertEquals(true, strpos($message, "OK") != 0);
    }
}
?>

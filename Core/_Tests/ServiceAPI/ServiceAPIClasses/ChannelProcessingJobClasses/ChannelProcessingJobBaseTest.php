<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class ChannelProcessingJobBaseTest extends \PHPUnit_Framework_TestCase  {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../../../Setup.php");
        $this->object = new ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses\ChannelProcessingJobBase();
    }

    public function testParseJSONToChannel() {
        $json = '{"type":"Test","updatePeriod":"5","parameters":[{"key":"test","value":"test"}]}';
        $channel = $this->object->ParseJSONToChannel($json);
        $this->assertEquals(true, isset($channel));
        $this->assertEquals("Test", $channel->GetType());
        $this->assertEquals(5, $channel->GetUpdatePeriod());
        $params = $channel->GetParameters();
        $this->assertEquals(true, is_array($params));
        $this->assertEquals("test", $params["test"]);
    }

    public function testParseJSONToChannelWithBadJSON() {
        $json = 'this is bad json and will not pass the parser';
        $channel = $this->object->ParseJSONToChannel($json);
        $this->assertEquals(false, isset($channel));
    }

    public function testParseChannelsToJSON() {
        $channel = new ObjectModel\Channel();
        $channel->SetType("Test");
        $channel->SetUpdatePeriod(5);
        $channel->SetParameters(array("one_k" => "one_v", "two_k" => "two_v"));
        $json = $this->object->ParseChannelsToJSON(array($channel));
    }
}
?>

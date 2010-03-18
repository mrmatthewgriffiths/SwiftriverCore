<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class StartPreProcessingJobParserTest extends \PHPUnit_Framework_TestCase  {
    public function test() {
        include_once(dirname(__FILE__)."/../../../ServiceAPI/ServiceAPIParsers/StartPreProcessingJobParser.php");
        include_once(dirname(__FILE__)."/../../../ObjectModel/Channel.php");
        $parser = new \Swiftriver\Core\ServiceAPI\ServiceAPIParsers\StartPreProcessingJobParser();
        $json = '[{"type":"Test","parameters":[{"test":"test"}]}]';
        $channel = $parser->ParseIncommingJSON($json);
        $this->assertEquals(true, isset($channel));
        $this->assertEquals("Test", $channel->GetType());
        $params = $channel->GetParameters();
        $this->assertEquals(true, is_array($params));
        $this->assertEquals("test", $params["test"]);
    }
}
?>

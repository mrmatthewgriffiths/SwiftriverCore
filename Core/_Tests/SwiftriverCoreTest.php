<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__).'/../SwiftriverCoreService.php';

class SwiftriverCoreTest extends \PHPUnit_Framework_TestCase {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../ObjectModel/Channel.php");
        include_once(dirname(__FILE__)."/../ObjectModel/Content.php");
        include_once(dirname(__FILE__)."/../SwiftriverCoreService.php");
        $this->object = new SwiftriverCore();
    }

    public function testGetAndParserContentWithAppfricaBlog() {
        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetType("RSS");
        $channel->SetParameters(array("feedUrl" => "http://feeds.feedburner.com/Appfrica?format=xml"));
        $content = $this->object->GetAndParserContent($channel);
        $this->assertEquals(true, isset($content));
    }

    public function testRunCorePreProcessingForNewContent() {
        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetType("RSS");
        $channel->SetParameters(array("feedUrl" => "http://feeds.feedburner.com/Appfrica?format=xml"));
        $this->object->RunCorePreProcessingForNewContent($channel);
    }
}
?>

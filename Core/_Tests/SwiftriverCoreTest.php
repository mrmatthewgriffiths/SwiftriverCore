<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class SwiftriverCoreTest extends \PHPUnit_Framework_TestCase {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../Setup.php");
        $this->object = new SwiftriverCore();
    }

    public function testGetAndParserContentWithAppfricaBlog() {
        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetType("RSS");
        $channel->SetParameters(array("feedUrl" => "http://feeds.feedburner.com/Appfrica?format=xml"));
        $content = $this->object->GetAndParserContent($channel);
        $this->assertEquals(true, isset($content));
    }
}
?>

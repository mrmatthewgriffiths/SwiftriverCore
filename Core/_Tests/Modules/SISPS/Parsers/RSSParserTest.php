<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

/**
 * Test class for ParserFactory.
 * Generated by PHPUnit on 2010-03-13 at 09:23:18.
 */
class RSSParserTest extends \PHPUnit_Framework_TestCase {
    /**
     * Include the SiSPS Setup
     */
    protected function setUp() {
        include_once(dirname(__FILE__)."/../../../../Setup.php");
    }

    /**
     * Tests that given the an array of parameters containing a
     * valid feedUrl, the RSSParser can correctly extract an
     * array of content Items.
     */
    public function testThatTheRSSParserCanExtractContentItemsFromTheAppfricaBlog() {
        $parser = new \Swiftriver\Core\Modules\SiSPS\Parsers\RSSParser();
        $content = $parser->GetAndParse(
                array(
                    "feedUrl" => "http://feeds.feedburner.com/Appfrica?format=xml"
                ),
                mktime(0, 0, 0, 1, 1, 1970)
        );
        $this->assertEquals(true, isset($content));
        $this->assertEquals(true, is_array($content));
        foreach($content as $item) {
            $this->assertEquals(true, isset($item));
            $title = $item->GetTitle();
            $link = $item->GetLink();
            $text = $item->GetText();
            $this->assertEquals(true, isset($title));
            $this->assertEquals(true, isset($link));
            $this->assertEquals(true, isset($text));
            $this->assertEquals(true, is_array($text));
        }
    }
}
?>

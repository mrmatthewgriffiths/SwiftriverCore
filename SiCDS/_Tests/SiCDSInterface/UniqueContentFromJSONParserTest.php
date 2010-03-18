<?php
namespace Swiftriver\SiCDS\SiCDSInterface;
require_once 'PHPUnit/Framework.php';

class ContentFromJSONParserTest extends \PHPUnit_Framework_TestCase {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../SiCDSInterface/Setup.php");
        include_once(\Swiftriver\SiCDS\SiCDSInterface\Setup::Swiftriver_Core_Directory()."/PreProcessing/IPreProcessingStep.php");
        require_once dirname(__FILE__).'/../../SiCDSInterface/UniqueContentFromJSONParser.php';
        $this->object = new UniqueContentFromJSONParser();
    }

    public function testWithNullArgs() {
        $this->assertEquals(null, $this->object->Parse(null));
    }

    public function testWithEmptyStringArgs() {
        $this->assertEquals(null, $this->object->Parse(""));
    }

    public function testWithEmptyJSONArgs() {
        $this->assertEquals(null, $this->object->Parse("[]"));
    }

    public function testWithMalformedJSON() {
        $this->assertEquals(null, $this->object->Parse("[{this-is-not-good-json"));
    }

    public function testWithValidJSONButMissinData() {
        $this->assertEquals(null, $this->object->Parse('[{"id":"testId"}]'));
    }

    public function testWithOnlyOneId() {
        $ids = $this->object->Parse('[{"id":"testId","result":"unique"}]');
        $this->assertEquals(true, isset($ids));
        $this->assertEquals(true, is_array($ids));
        $this->assertEquals(1, count($ids));
        $this->assertEquals("testId", $ids[0]);
    }

    public function testWithTwoIds() {
        $ids = $this->object->Parse('[{"id":"testId","result":"unique"},{"id":"testId2","result":"unique"}]');
        $this->assertEquals(true, isset($ids));
        $this->assertEquals(true, is_array($ids));
        $this->assertEquals(2, count($ids));
        $this->assertEquals("testId", $ids[0]);
        $this->assertEquals("testId2", $ids[1]);
    }

    public function testWithTwoIdsButOnlyOneUnique() {
        $ids = $this->object->Parse('[{"id":"testId","result":"duplicate"},{"id":"testId2","result":"unique"}]');
        $this->assertEquals(true, isset($ids));
        $this->assertEquals(true, is_array($ids));
        $this->assertEquals(1, count($ids));
        $this->assertEquals("testId2", $ids[0]);
    }

    public function testWithTwoIdsButBothDuplicate() {
        $ids = $this->object->Parse('[{"id":"testId","result":"duplicate"},{"id":"testId2","result":"duplicate"}]');
        $this->assertEquals(true, isset($ids));
        $this->assertEquals(true, is_array($ids));
        $this->assertEquals(0, count($ids));
    }
}
?>

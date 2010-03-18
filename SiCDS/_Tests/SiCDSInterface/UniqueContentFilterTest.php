<?php
namespace Swiftriver\SiCDS\SiCDSInterface;
require_once 'PHPUnit/Framework.php';

class UniqueContentFilterTest extends \PHPUnit_Framework_TestCase {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../SiCDSInterface/Setup.php");
        include_once(\Swiftriver\SiCDS\SiCDSInterface\Setup::Swiftriver_Core_Directory()."/ObjectModel/Content.php");
        require_once dirname(__FILE__).'/../../SiCDSInterface/UniqueContentFilter.php';
        $this->object = new UniqueContentFilter();
    }

    public function testFilterWithOneReturnExpected() {
        $contentItems = array();
        for($i = 1; $i < 10; $i++) {
            $item = new \SwiftRiver\Core\ObjectModel\Content();
            $item->SetId("testId".$i);
            $contentItems[] = $item;
        }
        $uniqueIds = array("testId2");
        $uniqueContent = $this->object->Filter( $uniqueIds, $contentItems);
        $this->assertEquals(true, isset($uniqueContent));
        $this->assertEquals(true, is_array($uniqueContent));
        $this->assertEquals(1, count($uniqueContent));
        $this->assertEquals("testId2", $uniqueContent[0]->GetId());
    }
}
?>

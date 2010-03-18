<?php
namespace Swiftriver\SiCDS\SiCDSInterface;
require_once 'PHPUnit/Framework.php';

class ServiceEngineTest extends \PHPUnit_Framework_TestCase {
    private $object;
    protected function setUp() {
        include_once(dirname(__FILE__)."/../../SiCDService/ServiceEngine.php");
        $this->object = new \Swiftriver\SiCDS\SiCDService\ServiceEngine();
    }

    public function testServiceEngineRespondsCorrectly() {
        $jsonToService =
            '[{"id":"id1","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id2","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id3","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id4","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id5","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id6","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id7","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id8","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id9","difs":[{"type":"testType","value":"testValue"}]},'.
            '{"id":"id10","difs":[{"type":"testType","value":"testValue"}]}]';
        $jsonFromService = $this->object->Run($jsonToService);
        $this->assertEquals(
                '[{"id":"id1","result":"unique"},'.
                '{"id":"id2","result":"unique"},'.
                '{"id":"id3","result":"unique"},'.
                '{"id":"id4","result":"unique"},'.
                '{"id":"id5","result":"unique"},'.
                '{"id":"id6","result":"unique"},'.
                '{"id":"id7","result":"unique"},'.
                '{"id":"id8","result":"unique"},'.
                '{"id":"id9","result":"unique"},'.
                '{"id":"id10","result":"unique"}]'
                , $jsonFromService);
    }
}
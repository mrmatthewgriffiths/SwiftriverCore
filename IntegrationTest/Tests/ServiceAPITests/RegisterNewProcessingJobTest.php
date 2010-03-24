<?php
namespace Swiftriver\IntegrationTests;

require_once 'PHPUnit/Framework.php';

class RegisterNewProcessingJobTest extends \PHPUnit_Framework_TestCase {
    public function testWithNoJSON() {
        include_once(dirname(__FILE__)."/../../ServiceWrapper.php");
        $uri = "http://local.swiftcore.com/ServiceAPI/RegisterNewProcessingJob.php";
        $service = new ServiceWrapper($uri);
        $json = $service->MakePOSTRequest(array(), 10);
        $this->assertEquals(true, strpos($json, "error") != 0);
    }

    public function testWithBadJSON() {
        include_once(dirname(__FILE__)."/../../ServiceWrapper.php");
        $uri = "http://local.swiftcore.com/ServiceAPI/RegisterNewProcessingJob.php";
        $service = new ServiceWrapper($uri);
        $json = $service->MakePOSTRequest(array("data" => "[]"), 10);
        $this->assertEquals(true, strpos($json, "error") != 0);
    }

    public function testWithGoodJson() {
        include_once(dirname(__FILE__)."/../../ServiceWrapper.php");
        $uri = "http://local.swiftcore.com/ServiceAPI/RegisterNewProcessingJob.php";
        $service = new ServiceWrapper($uri);
        $json = $service->MakePOSTRequest(array("data" => '[{"type":"Test","updatePeriod":"5","parameters":[{"test":"test"}]}]'), 10);
        $this->assertEquals(true, strpos($json, "error") == false);
    }
}
?>

<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class RegisterNewProcessingJobTest extends \PHPUnit_Framework_TestCase {
    public function testWithNoJSON() {
        include_once(dirname(__FILE__)."/../../../Core/Setup.php");
        $uri = "http://local.swiftcore.com/ServiceAPI/RegisterNewProcessingJob.php";
        $service = new \Swiftriver\Core\Modules\SiSW\ServiceWrapper($uri);
        $json = $service->MakePOSTRequest(array(), 10);
        $this->assertEquals(true, strpos($json, "error") != 0);
    }

    public function testWithBadJSON() {
        include_once(dirname(__FILE__)."/../../../Core/Setup.php");
        $uri = "http://local.swiftcore.com/ServiceAPI/RegisterNewProcessingJob.php";
        $service = new \Swiftriver\Core\Modules\SiSW\ServiceWrapper($uri);
        $json = $service->MakePOSTRequest(array("data" => "[]"), 10);
        $this->assertEquals(true, strpos($json, "error") != 0);
    }

}
?>

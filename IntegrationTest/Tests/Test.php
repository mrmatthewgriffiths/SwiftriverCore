<?php
namespace Swiftriver\IntegartionTests;

require_once 'PHPUnit/Framework.php';

class SwiftriverCoreTest extends \PHPUnit_Framework_TestCase {
    public function test() {
        include_once(dirname(__FILE__)."/../../Core/Modules/SwiftriverServiceWrapper/ServiceWrapper.php");
        $uri = "http://local.swiftcore.com/ServiceAPI/StartPreProcessingJob.php";
        $service = new \Swiftriver\SiSW\ServiceWrapper($uri);
        $json = '[{"type":"RSS","parameters":[{"feedUrl":"http://feeds.feedburner.com/Appfrica?format=xml"}]}]';
        $service->MakePOSTRequest(array("data" => $json), 10);
    }
}
?>

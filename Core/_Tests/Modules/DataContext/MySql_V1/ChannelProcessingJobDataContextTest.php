<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class ChannelProcessingJobDataContextTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        include_once(dirname(__FILE__)."/../../../../Setup.php");
        $dirItterator = new \RecursiveDirectoryIterator(dirname(__FILE__)."/../../../../Modules/DataContext/MySql_V1/");
        $iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
        foreach($iterator as $file) {
            if($file->isFile()) {
                $filePath = $file->getPathname();
                if(strpos($filePath, ".php")) {
                    include_once($filePath);
                }
            }
        }
    }

    public function test() {
        $channel = new ObjectModel\Channel();
        $channel->SetType("test");
        $channel->SetUpdatePeriod(5);
        $channel->SetParameters(array("feedUrl" => "http://something", "something" => "elshdjsh87d7f76&^&*^SHGGT^&"));
        Modules\DataContext\MySql_V1\DataContext::AddNewChannelProgessingJob($channel);
    }
}

?>

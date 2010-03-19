<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class ChannelProcessingJobRepository extends \PHPUnit_Framework_TestCase {

    public function testSave() {
        include_once(dirname(__FILE__)."/../../DAL/ChannelProcessingJobRepository.php");
        include_once(dirname(__FILE__)."/../../ObjectModel/Channel.php");
        include_once(dirname(__FILE__)."/../../Setup.php");
        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetType("RSS");
        $channel->SetParameters(array("feedUrl" => "http://feeds.feedburner.com/Appfrica?format=xml"));
        $repository = new \Swiftriver\Core\DAL\ChannelProcessingJobRepository();
        $repository->Save($channel);
    }

}
?>
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
        Modules\DataContext\MySql_V1\DataContext::ActivateChannelProcessingJob($channel);
        $channel = Modules\DataContext\MySql_V1\DataContext::SelectNextDueChannelProcessingJob(time());
        $this->assertEquals(true, isset($channel));
        $channels = Modules\DataContext\MySql_V1\DataContext::ListAllChannelProcessingJobs();
        $found = false;
        foreach($channels as $c) {
            if($c->GetId() == $channel->GetId())
                $found = true;
        }
        $this->assertEquals(true, $found);
        Modules\DataContext\MySql_V1\DataContext::DeactivateChannelProcessingJob($channel);
        Modules\DataContext\MySql_V1\DataContext::RemoveChannelProcessingJob($channel);
        $channels = Modules\DataContext\MySql_V1\DataContext::ListAllChannelProcessingJobs();
        $found = false;
        foreach($channels as $c) {
            if($c->GetId() == $channel->GetId())
                $found = true;
        }
        $this->assertEquals(false, $found);
    }

    public function testRedbean() {
        $c1 = new ObjectModel\Content();
        $c1->SetId("testid1");
        $c1->SetTitle("testtitle1");
        $c1->SetLink("testlink");
        $c1->SetText(array("id1text1", "id1text2"));
        $c1->SetTags(array(new ObjectModel\Tag("id1tag1", "who"), new ObjectModel\Tag("di1tag2", "what")));
        $dif1 = new ObjectModel\DuplicationIdentificationField("unique_tweet_id", "d87f8d7fdsg7dfgdfgfd89g7as");
        $dif2 = new ObjectModel\DuplicationIdentificationField("tweet_text", "jdhjsdfy jhfjdsf ksjhf kdjf ksdjfhsd ");
        $c1->SetDifs(array(new ObjectModel\DuplicationIdentificationFieldCollection("collection1", array($dif1, $dif2))));
        Modules\DataContext\MySql_V1\DataContext::SaveContent(array($c1));
    }
}

?>

<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class ContentDataContextTest extends \PHPUnit_Framework_TestCase {

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

    public function testRedbean() {
        $c1 = new ObjectModel\Content();
        $c1->SetId("testid1");
        $c1->SetTitle("testtitle1");
        $c1->SetLink("testlink");
        $c1->SetText(array("id1text1", "id1text2"));
        $c1->SetTags(array(new ObjectModel\Tag("id1tag1", "who"), new ObjectModel\Tag("id1tag2", "what")));
        $dif1 = new ObjectModel\DuplicationIdentificationField("unique_tweet_id", "d87f8d7fdsg7dfgdfgfd89g7as");
        $dif2 = new ObjectModel\DuplicationIdentificationField("tweet_text", "jdhjsdfy jhfjdsf ksjhf kdjf ksdjfhsd ");
        $c1->SetDifs(array(new ObjectModel\DuplicationIdentificationFieldCollection("collection1", array($dif1, $dif2))));
        $s = new ObjectModel\Source("thisisatestidforatestsource");
        $s->SetScore(10);
        $c1->SetSource($s);
        Modules\DataContext\MySql_V1\DataContext::SaveContent(array($c1));

        $cOutArray = Modules\DataContext\MySql_V1\DataContext::GetContent(array($c1->GetId()));
        $this->assertEquals(true, isset($cOutArray));
        $this->assertEquals(true, is_array($cOutArray));
        $this->assertEquals(1, count($cOutArray));

        $content = $cOutArray[0];
        $this->assertEquals("testid1", $content->GetId());
        $this->assertEquals("testtitle1", $content->GetTitle());
        $this->assertEquals("testlink", $content->GetLink());
        $text = $content->GetText();
        $this->assertEquals("id1text1", $text[0]);
        $this->assertEquals("id1text2", $text[1]);
        $tags = $content->GetTags();
        $this->assertEquals(true, isset($tags));
        $this->assertEquals(true, is_array($tags));
        $this->assertEquals(2, count($tags));
        $tag1 = $tags[0];
        $this->assertEquals("id1tag1", $tag1->GetText());
        $this->assertEquals("who", $tag1->GetType());
        $tag2 = $tags[1];
        $this->assertEquals("id1tag2", $tag2->GetText());
        $this->assertEquals("what", $tag2->GetType());
        $difCollections = $content->GetDifs();
        $this->assertEquals(true, isset($difCollections));
        $this->assertEquals(true, is_array($difCollections));
        $this->assertEquals(1, count($difCollections));
        $difCollection = $difCollections[0];
        $this->assertEquals(true, isset($difCollection));
        $this->assertEquals("collection1", $difCollection->GetName());
        $difs = $difCollection->GetDifs();
        $this->assertEquals(true, isset($difs));
        $this->assertEquals(true, is_array($difs));
        $this->assertEquals(2, count($difs));
        $d1 = $difs[0];
        $this->assertEquals("unique_tweet_id", $d1->GetType());
        $this->assertEquals("d87f8d7fdsg7dfgdfgfd89g7as", $d1->GetValue());
        $d2 = $difs[1];
        $this->assertEquals("tweet_text", $d2->GetType());
        $this->assertEquals("jdhjsdfy jhfjdsf ksjhf kdjf ksdjfhsd ", $d2->GetValue());
        $source = $content->GetSource();
        $this->assertEquals(true, isset($source));
        $this->assertEquals(10, $source->GetScore());
        $sId = $source->GetId();
        $this->assertEquals(true, isset($sId));

        Modules\DataContext\MySql_V1\DataContext::DeleteContent(array($content));
        $contentArray = Modules\DataContext\MySql_V1\DataContext::GetContent(array($content->GetId()));
        $this->assertEquals(true, isset($contentArray));
        $this->assertEquals(0, count($contentArray));

    }
}

?>

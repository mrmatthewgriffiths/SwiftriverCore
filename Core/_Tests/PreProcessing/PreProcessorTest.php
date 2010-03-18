<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class PreProcessorTest extends \PHPUnit_Framework_TestCase  {
    public function testPreProcessorWithTagTheNet() {
        include_once(dirname(__FILE__)."/../../PreProcessing/PreProcessor.php");
        include_once(dirname(__FILE__)."/../../PreProcessing/IPreProcessingStep.php");
        include_once(dirname(__FILE__)."/../../ObjectModel/Content.php");
        include_once(dirname(__FILE__)."/../../ObjectModel/Tag.php");
        $tagTheNetDir = dirname(__FILE__)."/../../../TagTheNetInterface";
        $preProcessor = new \Swiftriver\Core\PreProcessing\PreProcessor($tagTheNetDir);
        $content = new \Swiftriver\Core\ObjectModel\Content();
        $content->SetTitle("test bit of content");
        $content->SetText(array("In 1972, a crack commando unit was sent to prison by a military court for a crime they didn't commit. They promptly escaped from a maximum security stockade to the Los Angeles underground. Today, still wanted by the government, they survive as soldiers of fortune. If you have a problem, if no-one else can help, and if you can find them, maybe you can hire the A-Team."));
        $preProcessor->PreProcessContent(array($content));
    }
}
?>

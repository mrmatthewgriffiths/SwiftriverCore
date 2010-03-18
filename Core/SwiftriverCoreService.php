<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\Core;
class SwiftriverCore {
    /**
     * Constructor Method
     * Includes the setup file
     */
    public function __construct(){
        //include the setup file
        include_once(dirname(__FILE__)."/Setup.php");
    }

    /**
     * Extracts any new content from the Channel described in the
     * $channel parameter. Runs this content throught the configured
     * stack of services and saves the final content items to the
     * data base ready for exdtraction to the web applciation.
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public function RunCorePreProcessingForNewContent($channel) {
        //$logger->log("METHOD[RunCoreProcessingForNewContent] Called", PEAR_LOG_INFO);

        //Get the array of content items from the channel
        $items = $this->GetAndParserContent($channel);

        //Process the content
        $config = Setup::Configuration();
        $preProcessor = new \Swiftriver\Core\PreProcessing\PreProcessor($config["ModulesDirectory"]);
        $processedItems = $preProcessor->PreProcessContent($items);

        //Save the content
        $repo = new \Swiftriver\Core\DAL\ContentRepository();
        $repo->Save($processedItems);
    }

    /**
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    public function GetAndParserContent($channel) {
        $config = Setup::Configuration();
        $SiSPSFile = $config["SiSPSDirectory"]."/SwiftriverSourceParsingService.php";
        include_once($SiSPSFile);
        $service = new \Swiftriver\SiSPS\SwiftriverSourceParsingService();
        $contentItems = $service->FetchContentFromChannel($channel);
        return $contentItems;
    }
}
?>

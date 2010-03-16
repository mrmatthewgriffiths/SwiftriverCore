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
    public function __constructor(){
        //include the setup file
        include_once("Setup.php");
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
        $logger->log("METHOD[RunCoreProcessingForNewContent] Called", PEAR_LOG_INFO);

        //Get the array of content items from the channel
        $items = $this->GetAndParserContent($channel);
    }

    /**
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    private function GetAndParserContent($channel) {
        //TODO: Implement GetAndParserContent
        return $contentItems;
    }
}
?>

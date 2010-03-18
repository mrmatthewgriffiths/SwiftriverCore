<?php
namespace Swiftriver\SiCDS\SiCDSInterface;
class SiCDSPreProcessingStep implements \Swiftriver\Core\PreProcessing\IPreProcessingStep {

    public function __constructor() {
        //include the steup file
        include_once(dirname(__FILE__)."/Setup.php");
    }

    /**
     * This method, converts the relevant bits of the Content
     * items to JSON, sends them to the SiCDS and using the
     * return JSON, only returns content that is unique.
     *
     * @param \Swiftriver\Core\ObjectModel\Content $contentItems
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    public function Process($contentItems) {
        //Get the JSON for the call
        $toJSONParser = new ContentToJSONParser();
        $jsonToService = $toJSONParser->Parse($contentItems);

        //Make the webservice call
        $uri = $serviceUri;
        $interface = new ServiceInterface();
        $jsonFromService = $interface->InterafceWithSiCDS($uri, $jsonToService);

        //Decode the JSON
        $fromJSONParser = new UniqueContentFromJSONParser();
        $uniqueIds = $fromJSONParser->Parse($jsonFromService);

        //Filter out the none unique content
        $filter = new UniqueContentFilter();
        $uniqueContent = $filter->Filter($uniqueIds, $contentItems);

        //return the unique content
        return $uniqueContent;
    }
}
?>

<?php
namespace Swiftriver\TagTheNetInterface;
class TagTheNetPreProcessingStep implements \Swiftriver\Core\PreProcessing\IPreProcessingStep {
    /**
     * Constructor method to include the setup file
     */
    public function __construct() {
        //include the steup file
        include_once(dirname(__FILE__)."/Setup.php");
    }

    /**
     * This method, converts the relevant bits of the Content
     * items to JSON, sends them to the TheThe.net service and
     * using the return JSON, adds tags to the content.
     *
     * @param \Swiftriver\Core\ObjectModel\Content[] $contentItems
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    public function Process($contentItems) {
        $taggedContentItems = array();
        foreach($contentItems as $item) {
            $urlParser = new TextForUrlParser($item);
            $text = $urlParser->GetUrlText();
            $service = new ServiceInterface();
            $json = $service->InterafceWithService("http://tagthe.net/api/", $text);
            $jsonParser = new ContentFromJSONParser($item, $json);
            $taggedContent = $jsonParser->GetTaggedContent();
            $taggedContentItems[] = $taggedContent;
        }
        return $taggedContentItems;
    }

}
?>

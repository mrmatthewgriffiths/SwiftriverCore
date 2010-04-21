<?php
namespace Swiftriver\PreProcessingSteps;
class TagTheNetPreProcessingStep implements \Swiftriver\Core\PreProcessing\IPreProcessingStep {

    /**
     * Given a collection of content items, this method will firstly assertain in what language
     * content is presented. If this differs from the base language set up in the $configuration
     * then all text forthe content will be translated, the original test will be relegated to
     * the second position of the $content->text collection and the translation into the
     * base language will be placed at position 0 in the $content->text collection.
     * Each piece of content that comes into this method, can expect to be returned with this
     * pattern - ie: the $content->text[0] LanguageSpecificText class being in the base
     * language and (if applicable) the original LanguageSpecificText class beign at
     * $content->text[1]
     *
     * @param \Swiftriver\Core\ObjectModel\Content[] $contentItems
     * @param \Swiftriver\Core\Configuration\ConfigurationHandlers\CoreConfigurationHandler $configuration
     * @param \Log $logger
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    public function Process($contentItems, $configuration, $logger) {
        $translatedContent = array();
        $baseLanguageCode = $configuration->BaseLanguageCode;
        foreach($contentItems as $content) {

        }
    }
}
?>

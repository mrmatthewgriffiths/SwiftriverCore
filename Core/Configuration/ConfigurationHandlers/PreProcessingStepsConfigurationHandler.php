<?php
namespace Swiftriver\Core\Configuration\ConfigurationHandlers;
class PreProcessingStepsConfigurationHandler extends BaseConfigurationHandler {

    /**
     * The ordered collection of pre preocessing steps
     * @var \Swiftriver\Core\ObjectModel\PreProcessingStepEntry[]
     */
    public $PreProcessingSteps;

    public function __construct($configurationFilePath) {
        $xml = simplexml_load_file($configurationFilePath);
        $this->PreProcessingSteps = array();
        $steps = $xml->preProcessingSteps;
        if(isset($steps) && $steps != null && is_array($steps)) {
            foreach($steps->step as $step) {
                $this->PreProcessingSteps[] =
                        new \Swiftriver\Core\ObjectModel\PreProcessingStepEntry(
                            $step->className,
                            $step->filePath);
            }
        }
    }
}
?>

<?php
namespace Swiftriver\Core\PreProcessing;
class PreProcessor {
    private $preProcessingSteps;

    public function __construct($modulesDirectory) {
        $this->preProcessingSteps = array();
        $dirItterator = new \RecursiveDirectoryIterator($modulesDirectory);
        $iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
        foreach($iterator as $file) {
            if($file->isFile()) {
                $filePath = $file->getPathname();
                if(strpos($filePath, "PreProcessingStep")) {
                    include_once($filePath);
                    $className = str_replace(".php", "", $file->getFilename());
                    $className = "\\Swiftriver\\PreProcessingSteps\\".$className;
                    $this->preProcessingSteps[] = new $className();
                }
            }
        }
    }

    public function PreProcessContent($content) {
        if(isset($this->preProcessingSteps) && count($this->preProcessingSteps) > 0) {
            foreach($this->preProcessingSteps as $preProcessingStep) {
                $content = $preProcessingStep->Process($content);
            }
        }
        return $content;
    }
}
?>

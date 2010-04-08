<?php
namespace Swiftriver\Core\PreProcessing;
class PreProcessor {
    private $preProcessingSteps;

    public function __construct($modulesDirectory = null) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::PreProcessing::PreProcessor::__construct [Method invoked]", \PEAR_LOG_DEBUG);
        if($modulesDirectory == null) {
            $modulesDirectory = \Swiftriver\Core\Setup::Configuration()->ModulesDirectory;
        }
        $logger->log("Core::PreProcessing::PreProcessor::__construct [Begining to look for PreProcessing Steps in the Modules Directory]", \PEAR_LOG_DEBUG);
        $this->preProcessingSteps = array();
        $dirItterator = new \RecursiveDirectoryIterator($modulesDirectory);
        $iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
        foreach($iterator as $file) {
            if($file->isFile()) {
                $filePath = $file->getPathname();
                $fileName = $file->getFilename();
                if(strpos($fileName, "PreProcessingStep")) {
                    $logger->log("Core::PreProcessing::PreProcessor::__construct [Found $fileName]", \PEAR_LOG_DEBUG);
                    include_once($filePath);
                    $logger->log("Core::PreProcessing::PreProcessor::__construct [Included $fileName]", \PEAR_LOG_DEBUG);
                    $className = str_replace(".php", "", $fileName);
                    $className = "\\Swiftriver\\PreProcessingSteps\\".$className;
                    $this->preProcessingSteps[] = new $className();
                    $logger->log("Core::PreProcessing::PreProcessor::__construct [Added $className to PreProcessing Steps]", \PEAR_LOG_DEBUG);
                }
            }
        }
        $logger->log("Core::PreProcessing::PreProcessor::__construct [Method finished]", \PEAR_LOG_DEBUG);
    }

    public function PreProcessContent($content) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::PreProcessing::PreProcessor::PreProcessContent [Method invoked]", \PEAR_LOG_DEBUG);
        if(isset($this->preProcessingSteps) && count($this->preProcessingSteps) > 0) {
            foreach($this->preProcessingSteps as $preProcessingStep) {
                $className = get_class($preProcessingStep);
                $logger->log("Core::PreProcessing::PreProcessor::PreProcessContent [START: Run PreProcessing for $className]", \PEAR_LOG_DEBUG);
                $content = $preProcessingStep->Process($content);
                $logger->log("Core::PreProcessing::PreProcessor::PreProcessContent [END: Run PreProcessing for $className]", \PEAR_LOG_DEBUG);
            }
        } else {
            $logger->log("Core::PreProcessing::PreProcessor::PreProcessContent [No PreProcessing Steps found to run]", \PEAR_LOG_DEBUG);
        }
        $logger->log("Core::PreProcessing::PreProcessor::PreProcessContent [Method finished]", \PEAR_LOG_DEBUG);
        return $content;
    }
}
?>

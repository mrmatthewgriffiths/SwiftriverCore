<?php
namespace Swiftriver\Core\EventDistribution;
class EventDistributor {
    private $eventHandlers;
    
    public function __construct($modulesDirectory = null) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::PreProcessing::PreProcessor::__construct [Method invoked]", \PEAR_LOG_DEBUG);
        
        $logger->log("Core::PreProcessing::PreProcessor::__construct [START: Adding configured pre processors]", \PEAR_LOG_DEBUG);
        
        $this->eventHandlers = \Swiftriver\Core\Setup::PreProcessingStepsConfiguration()->PreProcessingSteps;
        
        $logger->log("Core::PreProcessing::PreProcessor::__construct [END: Adding configured pre processors]", \PEAR_LOG_DEBUG);

        $logger->log("Core::PreProcessing::PreProcessor::__construct [Method finished]", \PEAR_LOG_DEBUG);
    }

    public function RaiseAndDistributeEvent($event) {
        
    }
}
?>

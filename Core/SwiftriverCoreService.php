<?php
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

    public function RegisterNewProcessingJob($channel) {
        //Setup the logger
        $logger = Setup::GetLogger();
        $logger->log("Core::SwiftriverCore::RegisterNewProcessingJob [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::SwiftriverCore::RegisterNewProcessingJob [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        //Construct a new repository
        $repository = new \Swiftriver\Core\DAL\ChannelProcessingJobRepository();

        $logger->log("Core::SwiftriverCore::RegisterNewProcessingJob [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::SwiftriverCore::RegisterNewProcessingJob [START: Saving Processing Job]", \PEAR_LOG_DEBUG);

        //Add the channel processign job to the repository
        $repository->Save($channel);

        $logger->log("Core::SwiftriverCore::RegisterNewProcessingJob [END: Saving Processing Job]", \PEAR_LOG_DEBUG);
        $logger->log("Core::SwiftriverCore::RegisterNewProcessingJob [Method finished]", \PEAR_LOG_INFO);
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
        $logger = Setup::GetLogger();
        $logger->log("Core::SwiftriverCore::RunCorePreProcessingForNewContent[Method invocation]", PEAR_LOG_INFO);
        
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
        $SiSPSFile = $config->ModulesDirectory."/SiSPS/SwiftriverSourceParsingService.php";
        include_once($SiSPSFile);
        $service = new \Swiftriver\Core\Modules\SiSPS\SwiftriverSourceParsingService();
        $contentItems = $service->FetchContentFromChannel($channel);
        return $contentItems;
    }
}
?>

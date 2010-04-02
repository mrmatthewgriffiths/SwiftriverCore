<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class RunNextProcessingJob extends ChannelProcessingJobBase {
    /**
     * Selects the next due processing job and runs it through the core
     *
     * @return string $json
     */
    public function RunService() {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        //Construct a new repository
        $channelRepository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Fetching next processing Job]", \PEAR_LOG_DEBUG);

        //Get the next due channel processign job
        $channel = $channelRepository->SelectNextDueChannelProcessingJob();
        if($channel == null) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [INFO: No processing jobs due]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Fetching next processing Job]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatMessage("OK");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Fetching next processing Job]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Get and parse content]", \PEAR_LOG_DEBUG);

        $SiSPS = new \Swiftriver\Core\Modules\SiSPS\SwiftriverSourceParsingService();
        $rawContent = $SiSPS->FetchContentFromChannel($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Get and parse content]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Running core processing]", \PEAR_LOG_DEBUG);

        $preProcessor = new \Swiftriver\Core\PreProcessing\PreProcessor();
        $processedContent = $preProcessor->PreProcessContent($rawContent);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Parsing channel processing jobs to JSON]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Save content to the data store]", \PEAR_LOG_DEBUG);

        $contentRepository = new \Swiftriver\Core\DAL\Repositories\ContentRepository();
        $contentRepository->SaveContent($processedContent);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Save content to the data store]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Mark channel processing job as complete]", \PEAR_LOG_DEBUG);

        $channelRepository->MarkChannelProcessingJobAsComplete($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Mark channel processing job as complete]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);

        return parent::FormatMessage("OK");
    }
}
?>

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

        try {
            //Construct a new repository
            $channelRepository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Fetching next processing Job]", \PEAR_LOG_DEBUG);

        try {
            //Get the next due channel processign job
            $channel = $channelRepository->SelectNextDueChannelProcessingJob(time());
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }


        if($channel == null) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [INFO: No processing jobs due]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Fetching next processing Job]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatMessage("OK");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Fetching next processing Job]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Get and parse content]", \PEAR_LOG_DEBUG);

        try {
            $SiSPS = new \Swiftriver\Core\Modules\SiSPS\SwiftriverSourceParsingService();
            $rawContent = $SiSPS->FetchContentFromChannel($channel);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }


        if(!isset($rawContent) || !is_array($rawContent) || count($rawContent) < 1) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Get and parse content]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [No content found.]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatMessage("OK");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Get and parse content]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Running core processing]", \PEAR_LOG_DEBUG);

        try {
            $preProcessor = new \Swiftriver\Core\PreProcessing\PreProcessor();
            $processedContent = $preProcessor->PreProcessContent($rawContent);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Running core processing]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Save content to the data store]", \PEAR_LOG_DEBUG);

        try {
            $contentRepository = new \Swiftriver\Core\DAL\Repositories\ContentRepository();
            $contentRepository->SaveContent($processedContent);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Save content to the data store]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [START: Mark channel processing job as complete]", \PEAR_LOG_DEBUG);

        try {
            $channelRepository->MarkChannelProcessingJobAsComplete($channel);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [END: Mark channel processing job as complete]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RunNextProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);

        return parent::FormatMessage("OK");
    }
}
?>

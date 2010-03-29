<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class DeactivateChannelProcessingJob extends ChannelProcessingJobBase {
    /**
     * Deactivates the channel processing job
     *
     * @param string $json
     * @return string $json
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        //Parse the JSON input
        $channel = parent::ParseJSONToChannel($json);

        if(!isset($channel)) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [ERROR: Method ParseIncommingJSON returned null]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [ERROR: Registering new processing job with Core]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("There were errors in you JSON. Please review the API documentation and try again.");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        //Construct a new repository
        $repository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [START: Deactivating Processing Job]", \PEAR_LOG_DEBUG);

        //Deactivatre the channel processing job
        $repository->DeactivateChannelProcessingJob($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [END: Deactivating Processing Job]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }
}
?>
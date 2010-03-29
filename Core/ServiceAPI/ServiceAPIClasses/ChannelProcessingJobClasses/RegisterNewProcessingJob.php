<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class RegisterNewProcessingJob extends ChannelProcessingJobBase {
    /**
     * Adds the pre processing job to the DAL
     *
     * @param string $json
     * @return string $json
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        //Parse the JSON input
        $channel = parent::ParseJSONToChannel($json);

        if(!isset($channel)) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [ERROR: Method ParseIncommingJSON returned null]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [ERROR: Registering new processing job with Core]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("There were errors in you JSON. Please review the API documentation and try again.");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        //Construct a new repository
        $repository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [START: Saving Processing Job]", \PEAR_LOG_DEBUG);

        //Add the channel processign job to the repository
        $repository->AddNewChannelProgessingJob($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [END: Saving Processing Job]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }
}
?>

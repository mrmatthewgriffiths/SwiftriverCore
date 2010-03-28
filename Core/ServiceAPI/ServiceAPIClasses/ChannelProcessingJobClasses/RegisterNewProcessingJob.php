<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class RegisterNewProcessingJob extends ChannelProcessingJobBase {
    /**
     * Adds the pre processing job to the DAL
     *
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

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [START: Registering new processing job with Core]", \PEAR_LOG_DEBUG);

        $core = new \Swiftriver\Core\SwiftriverCore();
        $core->RegisterNewProcessingJob($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RegisterNewProcessingJob::RunService [END: Registering new processing job with Core]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }
}
?>

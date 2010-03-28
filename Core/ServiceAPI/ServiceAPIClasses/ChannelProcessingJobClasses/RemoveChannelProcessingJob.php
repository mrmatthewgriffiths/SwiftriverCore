<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class RemoveChannelProcessingJob extends ChannelProcessingJobBase {
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        //Parse the JSON input
        $channel = parent::ParseJSONToChannel($json);

        if(!isset($channel)) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [ERROR: Method ParseIncommingJSON returned null]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [ERROR: Registering new processing job with Core]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("There were errors in you JSON. Please review the API documentation and try again.");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [START: Removing channel processing job from the core]", \PEAR_LOG_DEBUG);

        $core = new \Swiftriver\Core\SwiftriverCore();
        $core->RegisterNewProcessingJob($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [END: Removing channel processing job from the core]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");    }
}
?>

<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses;
class RegisterNewProcessingJob extends ServiceAPIBase {

    /**
     * Parses the json in to a channel object
     *
     * @param string $json
     * @return \Swiftriver\Core\ObjectModel\Channel
     */
    public function ParseIncommingJSON($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [Calling json_decode]", \PEAR_LOG_DEBUG);

        $data = json_decode($json, true);
        if(!isset($data) || !$data) {
            $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [ERROR: json_decode could not decode the JSON, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [Extracting data from the JSON objects]", \PEAR_LOG_DEBUG);

        $data = $data[0];
        if(!isset($data) || !$data) {
            $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [ERROR: No objects present at data[0], returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [Extracting values from the data]", \PEAR_LOG_DEBUG);

        $type = $data["type"];
        $updatePeriod = $data["updatePeriod"];
        $parameters = $data["parameters"][0];
        if(!isset($type) || !isset($updatePeriod) || !isset($parameters) || !is_array($parameters)) {
            $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [ERROR: either the 'type', 'updatePeriod' or 'parameters array' could not be found, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [Constructing Channel object]", \PEAR_LOG_DEBUG);

        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetType($type);
        $channel->SetUpdatePeriod($updatePeriod);
        $channel->SetParameters($parameters);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::ParseIncommingJSON [Method finished]", \PEAR_LOG_INFO);

        return $channel;
    }

    /**
     * Adds the pre processing job to the DAL
     *
     * @return string $json
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        //Parse the JSON input
        $channel = $this->ParseIncommingJSON($json);

        if(!isset($channel)) {
            $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [ERROR: Method ParseIncommingJSON returned null]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [ERROR: Registering new processing job with Core]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("There were errors in you JSON. Please review the API documentation and try again.");
        }

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [START: Registering new processing job with Core]", \PEAR_LOG_DEBUG);

        $core = new \Swiftriver\Core\SwiftriverCore();
        $core->RegisterNewProcessingJob($channel);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [END: Registering new processing job with Core]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }
}
?>

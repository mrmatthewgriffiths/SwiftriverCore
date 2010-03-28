<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class ChannelProcessingJobBase extends \Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ServiceAPIBase {
    /**
     * Parses the json in to a channel object
     *
     * @param string $json
     * @return \Swiftriver\Core\ObjectModel\Channel
     */
    public function ParseJSONToChannel($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Calling json_decode]", \PEAR_LOG_DEBUG);

        $data = json_decode($json, true);
        if(!isset($data) || !$data) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [ERROR: json_decode could not decode the JSON, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Extracting data from the JSON objects]", \PEAR_LOG_DEBUG);

        $data = $data[0];
        if(!isset($data) || !$data) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [ERROR: No objects present at data[0], returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Extracting values from the data]", \PEAR_LOG_DEBUG);

        $type = $data["type"];
        $updatePeriod = $data["updatePeriod"];
        $parameters = $data["parameters"][0];
        if(!isset($type) || !isset($updatePeriod) || !isset($parameters) || !is_array($parameters)) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [ERROR: either the 'type', 'updatePeriod' or 'parameters array' could not be found, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Constructing Channel object]", \PEAR_LOG_DEBUG);

        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetType($type);
        $channel->SetUpdatePeriod($updatePeriod);
        $channel->SetParameters($parameters);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Method finished]", \PEAR_LOG_INFO);

        return $channel;
    }
}
?>

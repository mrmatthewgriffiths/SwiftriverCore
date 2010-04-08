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

        $data = json_decode($json);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Extracting data from the JSON objects]", \PEAR_LOG_DEBUG);

        if(!isset($data) || !$data) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [ERROR: There was an error decoding the JSON string, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Extracting values from the data]", \PEAR_LOG_DEBUG);

        $type = $data->type;
        $updatePeriod = $data->updatePeriod;
        $active = $data->active;
        $parameters = $data->parameters;
        if(!isset($type) || !isset($updatePeriod) || !isset($parameters)) {
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [ERROR: either the 'type', 'updatePeriod' or 'parameters array' could not be found, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Constructing Channel object]", \PEAR_LOG_DEBUG);

        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->type = $type;
        $channel->updatePeriod = $updatePeriod;
        $channel->active = $active;

        $params = array();
        foreach($parameters as $key => $value) {
            $params[$key] = $value;
        }
        
        $channel->parameters = $params;

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Method finished]", \PEAR_LOG_INFO);

        return $channel;
    }

    /**
     *
     * @param \Swiftriver\Core\ObjectModel\Channel[] $channels
     * @return string
     */
    public function ParseChannelsToJSON($channels) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseChannelsToJSON [Method invoked]", \PEAR_LOG_INFO);

        //$logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseChannelsToJSON [Calling json_decode]", \PEAR_LOG_DEBUG);
        $json = '{"channels":[';
        
        if(isset($channels) && is_array($channels) && count($channels) > 0) {
            foreach($channels as $channel) {
                $json .= json_encode($channel).",";
                /*
                $active = ($channel->active) ? 'true' : 'false';
                                $json .= '{"type":"'.$channel->type.'",'.
                          '"updatePeriod":"'.$channel->updatePeriod.'",'.
                          '"active":"'.$active.'",'.
                          '"parameters":[';
                $parameters = $channel->parameters;
                foreach(array_keys($parameters) as $key) {
                    $json .= '{"key":"'.$key.'","value":"'.$parameters[$key].'"},';
                }
                $json = rtrim($json, ",").']},';
                */
            }
        }
        
        
        $json = rtrim($json, ",").']}';

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseChannelsToJSON [Method finsihed]", \PEAR_LOG_INFO);

        return $json;
    }
}
?>

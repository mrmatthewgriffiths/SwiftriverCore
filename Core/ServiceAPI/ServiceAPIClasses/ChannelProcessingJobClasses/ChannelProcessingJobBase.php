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

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [START: Creating new Channel from the ChannelFactory]", \PEAR_LOG_DEBUG);

        try {
            //Try and get a channel from the factory
            $channel = \Swiftriver\Core\ObjectModel\ObjectFactories\ChannelFactory::CreateChannel($json);
        } catch (Exception $e) {
            //If exception, get the mesasge
            $message = $e->getMessage();

            //and log it
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [$message]", \PEAR_LOG_ERR);

            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [Method finished]", \PEAR_LOG_INFO);

            return null;
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseJSONToChannel [END: Creating new Channel from the ChannelFactory]", \PEAR_LOG_DEBUG);

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
            }
        }
        
        $json = rtrim($json, ",").']}';

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ChannelProcessingJobBase::ParseChannelsToJSON [Method finsihed]", \PEAR_LOG_INFO);

        return $json;
    }
}
?>

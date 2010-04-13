<?php
namespace Swiftriver\Core\ObjectModel\ObjectFactories;
class ChannelFactory {
    public static function CreateChannel($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Calling json_decode]", \PEAR_LOG_DEBUG);

        $data = json_decode($json);

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Extracting data from the JSON objects]", \PEAR_LOG_DEBUG);

        if(!isset($data) || !$data) {
            throw new \InvalidArgumentException("There was an error in the JSON. No Channel can be constructed.");
        }

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Extracting values from the data]", \PEAR_LOG_DEBUG);

        $type = $data->type;
        $updatePeriod = $data->updatePeriod;
        $active = $data->active;
        $parameters = $data->parameters;
        if(!isset($type) || !isset($updatePeriod) || !isset($parameters)) {
            throw new \Exception("One for the required fields was not present in the JSON. No Channel can be constructed.");
        }

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Constructing Channel object]", \PEAR_LOG_DEBUG);

        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->type = $type;
        $channel->updatePeriod = $updatePeriod;
        $channel->active = $active;

        $params = array();
        foreach($parameters as $key => $value) {
            $params[$key] = $value;
        }

        $channel->parameters = $params;

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Method finished]", \PEAR_LOG_INFO);

        return $channel;
    }
}
?>
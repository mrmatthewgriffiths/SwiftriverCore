<?php
namespace Swiftriver\Core\ObjectModel\ObjectFactories;
class ChannelFactory {
    public static function CreateChannel($json = null) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Method invoked]", \PEAR_LOG_DEBUG);

        //If JOSN is null, build a new channel object
        if($json == null) {
            $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [JSON was null so new channel being created]", \PEAR_LOG_DEBUG);

            //Get a new ID
            $id = md5(uniqid(rand(), true));

            //Create a new channel object
            $channel = new \Swiftriver\Core\ObjectModel\Channel();

            //Set the ID
            $channel->id = $id;

            $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Method finished]", \PEAR_LOG_DEBUG);

            return $channel;
        }

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Calling json_decode]", \PEAR_LOG_DEBUG);

        $data = json_decode($json);

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Extracting data from the JSON objects]", \PEAR_LOG_DEBUG);

        if(!isset($data) || !$data) {
            throw new \InvalidArgumentException("There was an error in the JSON. No Channel can be constructed.");
        }

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Extracting values from the data]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Constructing Channel object]", \PEAR_LOG_DEBUG);

        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->id = ($data->id == null) ? md5(uniqid(rand(), true)) : $data->id;
        $channel->type = $data->type;
        $channel->updatePeriod = $data->updatePeriod;
        $channel->active = $data->active;
        $channel->lastSucess = $data->lastSucess;

        $params = array();
        foreach($data->parameters as $key => $value) {
            $params[$key] = $value;
        }

        $channel->parameters = $params;

        $logger->log("Core::ObjectModel::ObjectFactories::ChannelFactory::CreateChannel [Method finished]", \PEAR_LOG_DEBUG);

        return $channel;
    }
}
?>
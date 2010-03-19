<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIParsers;
class RegisterNewProcessingJobParser {
    /**
     * Parses the json in to a channel object
     *
     * @param string $json
     * @return \Swiftriver\Core\ObjectModel\Channel
     */
    public function ParseIncommingJSON($json) {
        $data = json_decode($json, true);
        if(!isset($data) || !$data)
            return null;

        $data = $data[0];
        if(!isset($data) || !$data)
            return null;

        $type = $data["type"];
        $updatePeriod = $data["updatePeriod"];
        $parameters = $data["parameters"][0];
        if(!isset($type) || !isset($updatePeriod) || !isset($parameters) || !is_array($parameters))
            return null;

        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetType($type);
        $channel->SetUpdatePeriod($updatePeriod);
        $channel->SetParameters($parameters);
        return $channel;
    }
}
?>

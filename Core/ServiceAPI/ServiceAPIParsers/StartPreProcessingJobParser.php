<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIParsers;
class StartPreProcessingJobParser {
    /**
     * Parses the json in to a channel object
     *
     * @param string $json
     * @return \Swiftriver\Core\ObjectModel\Channel
     */
    public function ParseIncommingJSON($json) {
        $data = json_decode($json, true);
        $data = $data[0];
        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $channel->SetStype($data["type"]);
        $channel->SetParameters($data["parameters"][0]);
        return $channel;
    }
}
?>

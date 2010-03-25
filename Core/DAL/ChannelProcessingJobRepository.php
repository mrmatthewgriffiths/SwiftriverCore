<?php
namespace Swiftriver\Core\DAL;
class ChannelProcessingJobRepository {
    public function Save($channel) {
        $config = \Swiftriver\Core\Setup::Configuration();
        $file = fopen($config->CachingDirectory."/DALCache_ChannelProcessingJobRepository.txt", "w");
        fwrite($file, '[{"type":"'.$channel->GetType().'","parameters":['.json_encode($channel->GetParameters()).']}]');
        fclose($file);
    }
}
?>

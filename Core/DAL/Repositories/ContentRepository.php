<?php
namespace Swiftriver\Core\DAL\Repositories;
class ContentRepository {
    public function Save($content) {
        $config = \Swiftriver\Core\Setup::Configuration();
        $file = fopen($config->CachingDirectory."/DALCache_ContentRepository.txt", "w");
        foreach($content as $item) {
            $json = '[{"title":"'.$item->GetTitle().'","text":[';
            foreach($item->GetText() as $text) {
                $json .= '{"'.$text.'"}';
            }
            $json .= ']';
            $tags = $item->GetTags();
            if(isset($tags)) {
                $json .=  ',"tags":[';
                foreach($tags as $tag)  {
                    $json .= '{"'.$tag->GetType().'":"'.$tag->GetText().'"}';
                }
                $json .= ']';
            }
            $json .= '}]';
            fwrite($file, $json.PHP_EOL);
        }
        fclose($file);
    }
}
?>
<?php
namespace  Swiftriver\TagTheNetInterface;
class ServiceInterface {
    /**
     * Given a valid servive URI and a valid string of text
     * this service wraps the TagThe.Net taggin service
     *
     * @param string $uri
     * @param string $json
     * @return string
     */
    public function InterafceWithService($uri, $text) {
        $config = \Swiftriver\Core\Setup::Configuration();
        include_once($config->ModulesDirectory."/SiSW/ServiceWrapper.php");
        $uri = str_replace("?view=json", "", $uri);
        $uri = $uri."?view=json&text=".$text;
        $service = new \Swiftriver\Core\Modules\SiSW\ServiceWrapper($uri);
        $jsonFromService = $service->MakeGETRequest();
        return $jsonFromService;
    }
}
?>

<?php
namespace  Swiftriver\SiCDS\SiCDSInterface;
class ServiceInterface {
    /**
     * Given a valid servive URI and a valid string of JSON,
     * this method communcates with the SiCDS and returns a
     * list of all unique ID's
     *
     * @param string $uri
     * @param string $json
     * @return string
     */
    public function InterafceWithSiCDS($uri, $json) {
        include_once(Setup::Modules_Directory()."/SwiftriverServiceWrapper.php");
        $service = new \Swiftriver\SiSW\ServiceWrapper($uri);
        $jsonFromService = $service->MakePOSTRequest(array("data" => $json), 5);
        return $jsonFromService;
    }
}
?>

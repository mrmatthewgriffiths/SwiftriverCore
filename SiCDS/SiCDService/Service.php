<?php
namespace Swiftriver\SiCDS\SiCDService;
class Service {
    public function __construct() {
        include_once(dirname(__FILE__)."/ServiceEngine.php");
    }

    /**
     * This is a very early version of this service that just 
     * Extracts all the ID from the submitted data and then
     * returns them in a list (in essence saying that everything
     * is unique).
     * 
     * @param $_POST[] $postData 
     */
    public function RunService($postData) {
        //Extract the JSON from the postData
        $json = $postData["data"];
        $engine = new ServiceEngine();
        $returnData = $engine->Run($json);
        return $returnData;
    }
}
header('Content-type: application/json');
if(!isset($_POST) || count($_POST) != 1 || !isset($_POST["data"])) {
    echo '[{"error":"The request to this service did not contain the required post data \'data\'"}]';
} else {
    $service = new Service();
    $json = $service->RunService();
    echo $json;
}
?>

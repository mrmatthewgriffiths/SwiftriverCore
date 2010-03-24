<?php
namespace Swiftriver\Core\ServiceAPI;
header('Content-type: application/json');
if(!isset($_POST["data"])) {
    echo '[{"error":"The request to this service did not contain the required post data \'data\'"}]';
    die();
} else {
    include_once(dirname(__FILE__)."/../Setup.php");
    $service = new ServiceAPIClasses\RegisterNewProcessingJob();
    $json = $service->RunService($_POST["data"]);
    echo $json;
    die();
}
?>

<?php
namespace Swiftriver\SiCDS\SiCDService;
class ServiceEngine {
    /**
     * Mockup of the Service engine
     */
    public function Run($json) {
        $data = json_decode($json, true);
        //[{"id":"testId","result":"unique"},{"id":"testId2","result":"unique"}]
        $returnData = '[';
        foreach($data as $item) {
            $returnData .= '{"id":"'.$item["id"].'","result":"unique"},';
        }
        $returnData = rtrim($returnData, ",") . "]";
        return $returnData;
    }
}
?>

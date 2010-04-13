<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ContentServices;
class ContentServicesBase extends \Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ServiceAPIBase {

    public function ParseJSONToPagedContentByStateParameters($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Calling Json_decode]", \PEAR_LOG_DEBUG);

        $object = json_decode($json);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Extracting required values]", \PEAR_LOG_DEBUG);

        if(!isset($object) || !$object) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [ERROR: There was an error decoding the JSON string, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $state = (int) $object->state;
        $pagestart = (int) $object->pagestart;
        $pagesize = (int) $object->pagesize;

        if(!isset($state) || !isset($pagestart) || !isset($pagesize)) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [ERROR: One of the required properties (state, pagesize, pagestart) was missing from the JSON or what not an int, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        //TODO: Extract optional properties such as order by

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Method finished]", \PEAR_LOG_INFO);

        return array("state" => $state, "pagesize" => $pagesize, "pagestart" => $pagestart);
    }

    public function ParseContentToJSON($content) {
        if(!isset($content) || !is_array($content) || count($content) < 1) {
            return "[]";
        }

        $json = "[";
        foreach($content as $item) {
            $json .= json_encode($item).",";
        }
        $json = rtrim($json, ",")."]";
        return $json;
    }
}
?>

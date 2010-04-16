<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ContentServices;
class ContentServicesBase extends \Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ServiceAPIBase {

    public function ParseJSONToPagedContentByStateParameters($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Method invoked]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Calling Json_decode]", \PEAR_LOG_DEBUG);

        $object = json_decode($json);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Extracting required values]", \PEAR_LOG_DEBUG);

        if(!isset($object) || !$object) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [ERROR: There was an error decoding the JSON string, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        $state = (string) $object->state;
        $pagestart = (int) $object->pagestart;
        $pagesize = (int) $object->pagesize;

        if(!isset($state) || !isset($pagestart) || !isset($pagesize)) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [ERROR: One of the required properties (state, pagesize, pagestart) was missing from the JSON or what not an int, returning null]", \PEAR_LOG_DEBUG);
            return null;
        }

        //TODO: Extract optional properties such as order by

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToPagedContentByStateParameters [Method finished]", \PEAR_LOG_DEBUG);

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

    public function ParseJSONToContentID($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [Method invoked]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [START: Decoding the JSON]", \PEAR_LOG_DEBUG);

        //call json decode on the json
        $object = json_decode($json);

        //check that the decode worked ok
        if(!$object || $object == null) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [The JSON did not decode correctly]", \PEAR_LOG_ERR);
            throw new \InvalidArgumentException("The JSON supplied did not descode.");
        }

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [END: Decoding the JSON]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [START: Extracting required data]", \PEAR_LOG_DEBUG);

        //Extract the required field ID
        $id = $object->id;

        //Check that the id is set and is a string
        if(!$id || !isset($id) || $id == null || !is_string($id)) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [The JSON did not conatin the required field 'id']", \PEAR_LOG_ERR);
            throw new \InvalidArgumentException("The JSON supplied did not containt the required string field 'id'.");
        }

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [END: Extracting required data]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToContentID [Method finished]", \PEAR_LOG_DEBUG);
        
        //return the id
        return $id;
    }

    public function ParseJSONToMarkerID($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [Method invoked]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [START: Decoding the JSON]", \PEAR_LOG_DEBUG);

        //call json decode on the json
        $object = json_decode($json);

        //check that the decode worked ok
        if(!$object || $object == null) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [The JSON did not decode correctly]", \PEAR_LOG_ERR);
            throw new \InvalidArgumentException("The JSON supplied did not descode.");
        }

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [END: Decoding the JSON]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [START: Extracting required data]", \PEAR_LOG_DEBUG);

        //Extract the required field ID
        $id = $object->markerId;

        //Check that the id is set and is a string
        if(!$id || !isset($id) || $id == null || !is_string($id)) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [The JSON did not conatin the required field 'id']", \PEAR_LOG_ERR);
            throw new \InvalidArgumentException("The JSON supplied did not containt the required string field 'markerId'.");
        }

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [END: Extracting required data]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToMarkerID [Method finished]", \PEAR_LOG_DEBUG);

        //return the id
        return $id;
    }

    public function ParseJSONToInacurateReason($json) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [Method invoked]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [START: Decoding the JSON]", \PEAR_LOG_DEBUG);

        //call json decode on the json
        $object = json_decode($json);

        //check that the decode worked ok
        if(!$object || $object == null) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [The JSON did not decode correctly]", \PEAR_LOG_ERR);
            throw new \InvalidArgumentException("The JSON supplied did not descode.");
        }

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [END: Decoding the JSON]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [START: Extracting required data]", \PEAR_LOG_DEBUG);

        //Extract the required field ID
        $reason = $object->reason;

        //Check that the id is set and is a string
        if(!$reason || !isset($reason) || $reason == null || !is_string($reason)) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [The JSON did not conatin the required field 'id']", \PEAR_LOG_ERR);
            throw new \InvalidArgumentException("The JSON supplied did not containt the required string field 'reason'.");
        }

        //check that this is a recognised reason
        if(!\Swiftriver\Core\StateTransition\StateController::IsValidInacurateReason($reason)) {
            $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [The JSON did not conatin a valid reason]", \PEAR_LOG_ERR);
            throw new \InvalidArgumentException("The JSON supplied did not containt a valid 'reason'.");
        }

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [END: Extracting required data]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::ContentServicesBase::ParseJSONToInacurateReason [Method finished]", \PEAR_LOG_DEBUG);

        //return the id
        return $reason;
    }
}
?>

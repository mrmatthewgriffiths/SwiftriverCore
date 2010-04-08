<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ContentServices;
class GetPagedContentByState extends ContentServicesBase {
    /**
     * Given a JSON string describing the pagination and state
     * required, this method will return a set of content items
     *
     * @param string $json
     * @return string
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $parameters = parent::ParseJSONToPagedContentByStateParameters($json);

        if(!isset($parameters)) {
            $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [ERROR: Method ParseJSONToPagedContentByStateParameters returned null]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [ERROR: Getting paged content by state]", \PEAR_LOG_INFO);
            parent::FormatErrorMessage("There was an error in the JSON supplied, please consult the API documentation and try again.");
        }

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [START: Constructing Content repository]", \PEAR_LOG_DEBUG);

        $repository = new \Swiftriver\Core\DAL\Repositories\ContentRepository();

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [END: Constructing Content repository]", \PEAR_LOG_DEBUG);

        $state = $parameters["state"];
        $pagestart = $parameters["pagestart"];
        $pagesize = $parameters["pagesize"];

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [START: Querying repository with supplied parameters - state: $state, pagesize: $pagesize, pagestart: $pagestart]", \PEAR_LOG_DEBUG);

        $results = $repository->GetPagedContentByState($state, $pagesize, $pagestart);

        if(!isset($results) || !is_array($results) || !isset($results["totalCount"]) || !isset($results["contentItems"]) || !is_numeric($results["totalCount"]) || $results["totalCount"] < 1) {
            $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [No results were returned from the repository]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [END: Querying repository with supplied parameters]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [Method finished]", \PEAR_LOG_INFO);
            return '{"totalcount":"0"}';
        }

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [END: Querying repository with supplied parameters]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [START: Parsing content to JSON]", \PEAR_LOG_DEBUG);

        $contentJson = parent::ParseContentToJSON($results["contentItems"]);

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [END: Parsing content to JSON]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [START: Constructing return JSON]", \PEAR_LOG_DEBUG);

        $returnJson = '{"totalcount":"'.$results["totalCount"].'","contentitems":'.$contentJson.'}';

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [END: Constructing return JSON]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::GetPagedContentByState::RunService [Method finished]", \PEAR_LOG_INFO);

        return $returnJson;
    }
}
?>

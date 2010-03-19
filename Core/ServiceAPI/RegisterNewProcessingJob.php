<?php
namespace Swiftriver\Core\ServiceAPI;
header('Content-type: application/json');
if(!isset($_POST) || count($_POST) != 1 || !isset($_POST["data"])) {
    echo '[{"error":"The request to this service did not contain the required post data \'data\'"}]';
    die();
} else {
    $service = new RegisterNewProcessingJob($_POST["data"]);
    $json = $service->RunService();
    echo $json;
    die();
}

include_once(dirname(__FILE__)."/../Setup.php");
class RegisterNewProcessingJob extends ServiceAPIBase {
    /**
     * The JSON that has been sent to this service
     * @var string
     */
    private $json;

    /**
     * Constructor method expecting a string of JSON
     * @param string $json
     */
    public function __construct($json) {
        $this->json = $json;
    }

    /**
     * Adds the pre processing job to the DAL
     *
     * @return string $json
     */
    public function RunService() {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [Method invocation]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        //Parse the JSON input
        $parser = new \Swiftriver\Core\ServiceAPI\ServiceAPIParsers\RegisterNewProcessingJobParser();
        $channel = $parser->ParseIncommingJSON($this->json);

        if(!isset($channel)) {
            $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [ERROR: Parsing the JSON input]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [ERROR: Registering new processing job with Core]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("There were errors in you JSON. Please review the API documentation and try again.");
        }

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [START: Registering new processing job with Core]", \PEAR_LOG_DEBUG);

        $core = new \Swiftriver\Core\SwiftriverCore();
        $core->RegisterNewProcessingJob($channel);

        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [END: Registering new processing job with Core]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }

}
?>

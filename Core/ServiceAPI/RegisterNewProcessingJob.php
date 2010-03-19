<?php
namespace Swiftriver\Core\ServiceAPI;
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
        include_once(dirname(__FILE__)."/../Setup.php");
        $this->json = $json;
    }

    /**
     * Addes the pre processing job to the DAL
     *
     * @return string $json
     */
    public function RunService() {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::RegisterNewProcessingJob::RunService [Method invocation]", PEAR_LOG_INFO);
        $parser = new \Swiftriver\Core\ServiceAPI\ServiceAPIParsers\RegisterNewProcessingJobParser();
        $channel = $parser->ParseIncommingJSON($this->json);
        $core = new \Swiftriver\Core\SwiftriverCore();
        $core->RunCorePreProcessingForNewContent($channel);
        return parent::FormatMessage("OK");
    }

}
header('Content-type: application/json');
if(!isset($_POST) || count($_POST) != 1 || !isset($_POST["data"])) {
    echo '[{"error":"The request to this service did not contain the required post data \'data\'"}]';
} else {
    $service = new StartPreProcessingJob($_POST["data"]);
    $json = $service->RunService();
    echo $json;
}
?>

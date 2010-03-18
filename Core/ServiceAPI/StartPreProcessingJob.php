<?php
namespace Swiftriver\Core\ServiceAPI;
class StartPreProcessingJob {
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
     * Runs the PreProcessing of content as configured in the
     * SwiftriverCore Configuration
     *
     * @return string $json
     */
    public function RunService() {
        include_once(dirname(__FILE__)."/ServiceAPIParsers/StartPreProcessingJobParser.php");
        $parser = new \Swiftriver\Core\ServiceAPI\ServiceAPIParsers\StartPreProcessingJobParser();
        $channel = $parser->ParseIncommingJSON($this->json);
        include_once(dirname(__FILE__)."/../SwiftriverCoreService.php");
        $core = new \Swiftriver\Core\SwiftriverCore();
        $core->RunCorePreProcessingForNewContent($channel);
    }

    /**
     * Returns the given error in standard JSON format
     * @param string $error
     * @return string
     */
    public function FormatErrorMessage($error) {
        return '[{"error":"'.str_replace('"', '\'', $error).'"}]';
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

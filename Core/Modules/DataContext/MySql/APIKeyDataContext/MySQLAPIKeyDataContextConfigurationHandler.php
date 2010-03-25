<?php
namespace Swiftriver\Core\Modules\DataContext\MySql\APIKeyDataContext;
class MySQLAPIKeyDataContextConfigurationHandler extends \Swiftriver\Core\Configuration\ConfigurationHandlers\BaseConfigurationHandler {

    /**
     * @var string
     */
    public $DataBaseUrl;

    /**
     * @var string
     */
    public $UserName;

    /**
     * @var string
     */
    public $Password;

    /**
     * @var string
     */
    public $Database;

    public function __construct($configurationFilePath) {
        $xml = simplexml_load_file($configurationFilePath);
        foreach($xml->properties->property as $property) {
            switch((string) $property["name"]) {
                case "DataBaseUrl" :
                    $this->DataBaseUrl = $property["value"];
                    break;
                case "UserName" :
                    $this->UserName = $property["value"];
                    break;
                case "Password" :
                    $this->Password = $property["value"];
                    break;
                case "Database" :
                    $this->Database = $property["value"];
                    break;
            }
        }
    }
}
?>

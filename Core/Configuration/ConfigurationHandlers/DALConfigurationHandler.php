<?php
namespace Swiftriver\Core\Configuration\ConfigurationHandlers;
class DALConfigurationHandler extends BaseConfigurationHandler {

    public $APIKeyDataContextType;

    public function __construct($configurationFilePath) {
        $xml = simplexml_load_file($configurationFilePath);
        foreach($xml->properties->property as $property) {
            switch((string) $property["name"]) {
                case "APIKeyDataContextType" :
                    $this->APIKeyDataContextType = $property["value"];
                    break;
            }
        }
    }
}
?>

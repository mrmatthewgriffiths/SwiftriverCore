<?php
namespace Swiftriver\Core\Configuration\ConfigurationHandlers;
class CoreConfigurationHandler extends BaseConfigurationHandler {

    public $ModulesDirectory;

    public $CachingDirectory;

    public $BaseLanguageCode;

    public function __construct($configurationFilePath) {
        $xml = simplexml_load_file($configurationFilePath);
        foreach($xml->properties->property as $property) {
            switch((string) $property["name"]) {
                case "ModulesDirectory" :
                    $this->ModulesDirectory = dirname(__FILE__)."/../..".$property["value"];
                    break;
                case "CachingDirectory" :
                    $this->CachingDirectory = dirname(__FILE__)."/../..".$property["value"];
                    break;
                case "BaseLanguageCode" :
                    $this->BaseLanguageCode = (string) $property["value"];
                    break;
            }
        }
    }
}
?>

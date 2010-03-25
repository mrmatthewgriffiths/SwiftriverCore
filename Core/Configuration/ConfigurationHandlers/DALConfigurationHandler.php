<?php
namespace Swiftriver\Core\Configuration\ConfigurationHandlers;
class DALConfigurationHandler extends BaseConfigurationHandler {

    public $APIKeyDataContextType;

    public $DataContextIncludeDirectories;

    public function __construct($configurationFilePath) {
        $this->DataContextIncludeDirectories = array();
        $xml = simplexml_load_file($configurationFilePath);
        foreach($xml->properties->property as $property) {
            switch((string) $property["name"]) {
                case "APIKeyDataContextType" :
                    $this->APIKeyDataContextType = $property["value"];
                    break;
            }
            
            //If the property name ends in Path then we should include all the 
            //files under that path.
            if(strpos($property["name"], "Path") !=0) {
                $this->DataContextIncludeDirectories[] = $property["value"];
            }
        }
    }
}
?>

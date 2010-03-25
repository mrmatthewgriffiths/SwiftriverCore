<?php
namespace Swiftriver\Core;
require_once 'PHPUnit/Framework.php';
class DALConfigurationHandlerTest extends \PHPUnit_Framework_TestCase {
    public function testWithMockConfig() {
        include_once(dirname(__FILE__)."/../../../Setup.php");
        $config = new Configuration\ConfigurationHandlers\DALConfigurationHandler(dirname(__FILE__)."/MockDALConfiguration.xml");
        $this->assertEquals(true, $config->APIKeyDataContextType == "\\SomeTestClass");
        $this->assertEquals(true, isset($config->DataContextIncludeDirectories));
        $this->assertEquals(true, is_array($config->DataContextIncludeDirectories));
        $this->assertEquals(1, count($config->DataContextIncludeDirectories));
    }
}
?>

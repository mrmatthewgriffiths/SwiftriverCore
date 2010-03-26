<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class APIKeyRepositoryTest extends \PHPUnit_Framework_TestCase {
    public function setUp(){
        include_once(dirname(__FILE__)."/../../../Setup.php");
        include_once(dirname(__FILE__)."/MockDataContext.php");
    }

    public function testAddRegisteredAPIKey() {
        $repo = new DAL\Repositories\APIKeyRepository("\Swiftriver\Core\MockDataContext");
        $this->assertEquals(true, $repo->AddRegisteredAPIKey("test"));
    }

    public function testRemoveRegisteredAPIKey() {
        $repo = new DAL\Repositories\APIKeyRepository("\Swiftriver\Core\MockDataContext");
        $this->assertEquals(true, $repo->RemoveRegisteredAPIKey("test"));
    }

    public function testIsRegisterdCoreAPIKey() {
        $repo = new DAL\Repositories\APIKeyRepository("\Swiftriver\Core\MockDataContext");
        $this->assertEquals(true, $repo->IsRegisterdCoreAPIKey("test"));
    }

}
?>

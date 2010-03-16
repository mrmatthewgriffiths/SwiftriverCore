<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__).'/../SwiftriverCoreService.php';

class SwiftriverCoreTest extends \PHPUnit_Framework_TestCase {
    private $object;

    protected function setUp() {
        $this->object = new SwiftriverCore;
    }

    public function test() {
        
    }
}
?>

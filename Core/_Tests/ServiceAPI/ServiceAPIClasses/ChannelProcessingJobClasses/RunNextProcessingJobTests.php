<?php
namespace Swiftriver\Core;

require_once 'PHPUnit/Framework.php';

class RunNextProcessingJobTests extends \PHPUnit_Framework_TestCase  {
    private $object;

    protected function setUp() {
        include_once(dirname(__FILE__)."/../../../../Setup.php");
        $this->object = new ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses\RunNextProcessingJob();
    }

    public function test() {
        $this->object->RunService();
    }
}
?>

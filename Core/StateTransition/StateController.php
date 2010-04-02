<?php
namespace Swiftriver\Core\StateTransition;
class StateController {

    /**
     * public list of all states
     * @var array
     */
    public $States;

    /**
     * The content
     * @var \Swiftriver\Core\ObjectModel\Content $content
     */
    private $content;

    /**
     * Construct a new state controller
     * @param \Swiftriver\Core\ObjectModel\Content $content $content
     */
    public function __construct($content) {
        $this->content = $content;
        $this->States = array(
            0 => "new",
        );
    }

    /**
     * Given a content ite,
     * @return string
     */
    public function GetCurrentState() {
        $state = $this->content->GetState();
        if(!isset($state) || !is_numeric($state) || $state >= count($this->States))
            $state = 0;
        return $this->States[$state];
    }
}
?>

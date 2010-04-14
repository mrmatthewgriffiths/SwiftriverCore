<?php
namespace Swiftriver\Core\StateTransition;
class StateController {

    /**
     * the default state of a content item
     * @var int
     */
    public static $defaultState = "new_content";

    /**
     * public list of all states
     * @var array
     */
    private static $states = array(
        "new_content"
    );
}
?>

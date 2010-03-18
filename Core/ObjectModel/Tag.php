<?php
namespace Swiftriver\Core\ObjectModel;
class Tag {
    /**
     * The type of the tag. eg: Location, Person etc.
     * @var string
     */
    var $type = "General";

    /**
     * The text of the tag.
     * @var string
     */
    var $text;

    public function __construct($text, $type = "General") {
        $this->type = $type;
        $this->text = $text;
    }

    /**
     * Gets the type of this tag.
     * @return string
     */
    public function GetType() { return $this->type; }

    /**
     * Gets the text of this tag
     * @return string
     */
    public function GetText() { return $this->text; }
}
?>
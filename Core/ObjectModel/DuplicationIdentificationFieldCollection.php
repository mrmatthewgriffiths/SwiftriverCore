<?php
namespace Swiftriver\Core\ObjectModel;
class DuplicationIdentificationFieldCollection {
    /**
     * The collection of DIFs
     * @var DuplicationIdentificationField[]
     */
    private $difs;

    /**
     * the name of this collection
     * @var string
     */
    private $name;

    /**
     * Builds a new DIFC with a collection of DIFs
     * @param DuplicationIdentificationField[] $difs
     */
    public function __construct($name, $difs) {
        $this->name = $name;
        $this->difs = $difs;
    }

    /**
     * Gets the array of duplication identification fields
     * @return DuplicationIdentificationField[]
     */
    public function GetDifs() {
        return $this->difs;
    }

    /**
     * Returns the name of this collection
     * @return string
     */
    public function GetName() {
        return $this->name;
    }
}
?>

<?php
namespace Swiftriver\Core\ObjectModel;
class DuplicationIdentificationFieldCollection {
    /**
     * The collection of DIFs
     * @var DuplicationIdentificationField[]
     */
    private $difs;

    /**
     * Builds a new DIFC with a collection of DIFs
     * @param DuplicationIdentificationField[] $difs
     */
    public function __construct($difs) {
        $this->difs = $difs;
    }

    /**
     * Gets the array of duplication identification fields
     * @return DuplicationIdentificationField[]
     */
    public function GetDifs() {
        return $this->difs;
    }
}
?>

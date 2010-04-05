<?php
namespace Swiftriver\Core\ObjectModel;
class Source {
    /**
     * The genuine unique ID of this source
     * @var string
     */
    private $id;

    /**
     * The trust score for this source
     * @var int
     */
    private $score;

    /**
     * Use this object by passing in some thing that
     * will uniquely identify the source, such as the
     * feed uri for an RSS feed or the twitter id for
     * a tweet
     * @param string $idString
     */
    public function __construct($idString) {
        $this->id = hash("md5", $idString);
    }

    /**
     * Gets the genuine unique id of this source
     * @return string
     */
    public function GetId() {
        return $this->id;
    }

    /**
     * Returns the current trust score for this source,
     * returns null if the source has not been scored before.
     * @return int or null
     */
    public function GetScore() {
        return $this->score;
    }

    /**
     * Sets the current trust score for this source
     * @param int $score
     */
    public function SetScore($score) {
        $this->score = $score;
    }
}
?>

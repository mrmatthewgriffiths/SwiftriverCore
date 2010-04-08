<?php
namespace Swiftriver\Core\ObjectModel;
class Source {
    /**
     * The genuine unique ID of this source
     * @var string
     */
    public $id;

    /**
     * The trust score for this source
     * @var int
     */
    public $score;

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
}
?>

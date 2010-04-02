<?php
/**
 * Duplication Identification Fields’ (DIFs) are a
 * Swiftriver standard mechanism for helping to
 * identify duplicated data.  Populating these fields is
 * the responsibility of the parser associated with the
 * channel  type. For example, if the  channel  is twitter
 * then the unique_tweet_id can be used as one DIF so
 * can the content of the tweet parsed to remove
 * common additions – such as r/t. 
 */
namespace Swiftriver\Core\ObjectModel;
class DuplicationIdentificationField {
    
    /**
     * The type of this DIF
     * @var string
     */
    private $type;
    
    /**
     * The value of this DIF
     * @var string
     */
    private $value;

    public function  __construct($type, $value) {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Sets the type of this dif
     * @param string $typeIn
     */
    public function SetType($typeIn){ $this->type = $typeIn; }
    
    /**
     * Sets the value of this dif
     * @param string $valueIn
     */
    public function SetValue($valueIn){ $this->value = $valueIn; }

    /**
     * Returns the type of this DIF
     * @return string
     */
    public function GetType() { return $this->type; }
    
    /**
     * Returns the value of this DIF
     * @return string
     */
    public function GetValue() { return $this->value; }
}
?>

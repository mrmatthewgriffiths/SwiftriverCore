<?php
namespace Swiftriver\Core\ObjectModel;
class Channel {
    
    /**
     * The type of the Channel
     * 
     * For example, parameters may be:
     *  array (
     *      "type" -> "email",
     *      "connectionString" -> "someConnectionString"
     *  );
     * @var string 
     */
    private $type; //type = string

    /**
     * Parameters used to update the channel with new content;
     * @var array(string)
     */
    private $parameters; //type = array(array(string))

    /**
     * Gets the type of the channel
     * @return string
     */
    public function GetType() { return $this->type; }

    /**
     * Gets the multi dimentional array of parameters for updating
     * the channel from source.
     * @return array(array(string))
     */
    public function GetParameters() { return $this->parameters; }

    /**
     * Sets the type of this Channel
     * @param string $typeIn
     */
    public function SetStype($typeIn) { $this->type = $typeIn; }

    /**
     * Sets the parameters array for this channel
     * @param array(string $parametersIn
     */
    public function SetParameters($parametersIn) { $this->parameters = $parametersIn; }
}
?>

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
    private $type; 

    /**
     * Parameters used to update the channel with new content;
     * @var array(string)
     */
    private $parameters; 

    /**
     * The period in minutes that the channel should be updated
     * @return int
     */
    private $updatePreiod;

    /**
     * Gets the type of the channel
     * @return string
     */
    public function GetType() { return $this->type; }

    /**
     * Gets the multi dimentional array of parameters for updating
     * the channel from source.
     * @return string[]
     */
    public function GetParameters() { return $this->parameters; }

    /**
     * Gets the update period in minutes for the channel
     * @return int
     */
    public function GetUpdatePeriod() { return $this->updatePreiod; }

    /**
     * Sets the type of this Channel
     * @param string $type
     */
    public function SetType($type) { $this->type = $type; }

    /**
     * Sets the parameters array for this channel
     * @param array(string $parameters
     */
    public function SetParameters($parameters) { $this->parameters = $parameters; }

    /**
     * Sets the update period in munites for the channel
     * @param int $updatePeriod
     */
    public function SetUpdatePeriod($updatePeriod) { $this->updatePreiod = $updatePeriod; }
}
?>

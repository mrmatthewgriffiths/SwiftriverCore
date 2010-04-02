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
     * If this job is currently active or not
     * @var bool
     */
    private $active;

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
    public function GetParameters() { return isset($this->parameters) ? $this->parameters : array(); }

    /**
     * Gets the update period in minutes for the channel
     * @return int
     */
    public function GetUpdatePeriod() { return $this->updatePreiod; }

    /**
     * Gets the active switch for this channel
     * @return bool
     */
    public function GetActive() { return $this->active; }

    /**
     * Gets the unique data store Id for this channel processing job, this
     * is made up of the type and parameters written to a string
     * @return string
     */
    public function GetId() { 
        $id = $this->type;
        foreach(array_keys($this->parameters) as $key) {
            $id .= $key.$this->parameters[$key];
        }
        return $id;
    }
   
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

    /**
     * Sets the active flag for this content
     * @param bool $active
     */
    public function SetActive($active) { $this->active = $active; }
}
?>

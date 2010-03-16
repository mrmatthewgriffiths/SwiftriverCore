<?php
namespace Swiftriver\SiCDS\SiCDSInterface;
class UniqueContentFromJSONParser {
    
    /**
     * Given a string of JSON returned from the SiCDS, this method
     * returns all the Id's of content that is unique.
     * 
     * @param string $json
     * @return string[] 
     */
    public function Parse($json) {
        //Validity Chaecks
        if(!isset($json)) //null
            return null;
        if($json == "") //empty string
            return null;
        if($json == "[]") //empty JSON
            return null;

        //decode the JSON string
        $objects = json_decode($json, true);

        //Check for malformed JSON
        if(!isset($objects))
            return null;

        //Setup the return array
        $uniqueIds = array();

        //Loop through the $object array
        foreach($objects as $object) {
            //Validation checks
            if(!isset($object))
                return null;
            if(!is_array($object))
                return null;

            //Extract the object values
            $id = $object["id"];
            $result = $object["result"];

            //More validity checking
            if(!isset($id) || !isset($result))
                return null;

            //check the result
            if($result != "unique")
                continue;

            //Add the id to the return array
            $uniqueIds[] = $id;
        }

        return $uniqueIds;
    }
}
?>

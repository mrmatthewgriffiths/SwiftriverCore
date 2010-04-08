<?php
namespace Swiftriver\SiCDS\SiCDSInterface;
class ContentToJSONParser {
    
    /**
     * Given an array for Content, this method returns a standard 
     * JSON representation of them.
     * 
     * @param \Swiftriver\Core\ObjectModel\Content[] $contentItems
     * @return string 
     */
    public function Parse($contentItems) {
        //Validity checks
        if(!isset($contentItems))
            return null;
        if(!is_array($contentItems))
            return null;
        if(count($contentItems) < 1)
            return null;

        //create the array to hold the JSON'ed objects
        $dataToSend = array();

        //Loop through all the content items
        foreach($contentItems as $item) {
            //The array to hold the JSON'ed difs
            $difs = array();

            //Exctract the difs from the content
            $itemDifs = $item->difs;

            //If none, skip this content Item
            if(!isset($itemDifs))
                continue;

            //Loop through the Difs of the Content
            foreach($itemDifs as $dif) {
                //JSON'ise the Dif
                $jsonDif = array(
                    'type' => $dif->type,
                    'value' => $dif->value
                );

                //Add the JSON'ed diff to the array
                $difs[] = $jsonDif;
            }

            //Add the content ID and the JSON'ed Diffs to the array
            $dataToSend[] = array(
                'id' => $item->id,
                'difs' => $difs);
        }

        //If none of the content items had difs
        if(count($dataToSend) < 1)
            return null;

        //Convert the array to JSON
        $json = json_encode($dataToSend);

        //Return the JSON string
        return $json;
    }
}
?>

<?php
namespace Swiftriver\SiCDS\SiCDSInterface;
class UniqueContentFilter {
    /**
     * Given a list of unique ID's and the associated content, this
     * mehtod returns only the content that has matching ID's in the
     * unique ids array.
     *
     * @param strig[] $uniqueIds
     * @param \Swiftriver\Core\ObjectModel\Content[] $contentItems
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    public function Filter($uniqueIds, $contentItems) {
        //set up the return array
        $uniqueContent = array();

        //Loop through the two array looking for unique content
        foreach($contentItems as $item) {
            foreach($uniqueIds as $id) {
                if($item->id == $id) {
                    $uniqueContent[] = $item;
                }
            }
        }

        //return the unique content
        return $uniqueContent;
    }
}
?>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\SiSPS\Parsers;
class RSSParser implements IParser {
    /**
     * Implementation of IParser::GetAndParse
     * @param string[][] $parameters
     * Required Parameter Values =
     *  'feedUrl' = The url to the RSS feed
     */
    public function GetAndParse($parameters) {

        //Extract the required variables
        $feedUrl = $parameters["feedUrl"];
        if(!isset($feedUrl) || ($feedUrl == ""))
            return null;

        //Include the Simple Pie Framework to get and parse feeds
        include_once \Swiftriver\SiSPS\Setup::Modules_Directory()."/SimplePie/simplepie.inc";

        //Construct a new SimplePie Parsaer
        $feed = new \SimplePie();

        //Set the caching directory
        $feed->set_cache_location(\Swiftriver\SiSPS\Setup::Caching_Directory());

        //Pass the feed URL to the SImplePie object
        $feed->set_feed_url($feedUrl);

        //Run the SimplePie
        $feed->init();

        //Create the Content array
        $contentItems = array();

        //Loop throught the Feed Items
        foreach($feed->get_items() as $feedItem) {
            //Extract all the relevant feedItem info
            $title = $feedItem->get_title();
            $description = $feedItem->get_description();
            $contentLink = $feedItem->get_permalink();

            //Create a new Content item
            $item = new \Swiftriver\Core\ObjectModel\Content();

            //Fill the COntenty Item
            $item->SetTitle($title);
            $item->SetLink($contentLink);
            $item->SetText(array($description));

            //Add the item to the Content array
            $contentItems[] = $item;
        }

        //return the content array
        return $contentItems;
    }
}
?>

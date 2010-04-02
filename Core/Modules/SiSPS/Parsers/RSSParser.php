<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\Core\Modules\SiSPS\Parsers;
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

        //Create the source that will be used by all the content items
        //Passing in the feed uri which can be used to uniquly
        //identify the source of the content
        $source = new \Swiftriver\Core\ObjectModel\Source($feedUrl);

        //Include the Simple Pie Framework to get and parse feeds
        
        $config = \Swiftriver\Core\Setup::Configuration();
        include_once $config->ModulesDirectory."/SimplePie/simplepie.inc";

        //Construct a new SimplePie Parsaer
        $feed = new \SimplePie();

        //Set the caching directory
        $feed->set_cache_location($config->CachingDirectory);

        //Pass the feed URL to the SImplePie object
        $feed->set_feed_url($feedUrl);

        //Run the SimplePie
        $feed->init();

        //Create the Content array
        $contentItems = array();

        //Loop throught the Feed Items
        foreach($feed->get_items() as $feedItem) {
            //Extract all the relevant feedItem info
            $id = \Swiftriver\Core\ObjectModel\Content::GenerateUniqueId();
            $title = $feedItem->get_title();
            $description = $feedItem->get_description();
            $contentLink = $feedItem->get_permalink();

            //Create a new Content item
            $item = new \Swiftriver\Core\ObjectModel\Content();

            //Fill the COntenty Item
            $item->SetId($id);
            $item->SetTitle($title);
            $item->SetLink($contentLink);
            $item->SetText(array($description));
            $item->SetSource($source);

            //Add the item to the Content array
            $contentItems[] = $item;
        }

        //return the content array
        return $contentItems;
    }
}
?>
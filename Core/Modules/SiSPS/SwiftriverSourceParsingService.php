<?php
/* 
 * SiSPS\SwiftriverSourceParsingService is the main
 * interface class to the Source Parsing Componet if
 * Swiftriver. This class is designed to take in
 * instructions regarding a channel and return all content
 * items that can be selected from that channel.
 */
namespace Swiftriver\Core\Modules\SiSPS;
class SwiftriverSourceParsingService {
    /**
     * This method will take the information prvided in the
     * instance of a Swiftriver\Core\ObjectModel\Channel object
     * and will make a call to the channel to fetch and content
     * that can be fetched and then parse the content into an array
     * of Swiftriver\Core\ObjectModel\Content items
     *
     * @param Swiftriver\Core\ObjectModel\Channel $channel
     * @return Swiftriver\Core\ObjectModel\Content[] $contentItems
     */
    public function FetchContentFromChannel($channel) {
        //get the type of the channel
        $channelType = $channel->GetType();

        //Get a Parser from the ParserFactory based on the channel type
        $factory = ParserFactory::GetParser($channelType);

        //Extract the parameters from the channel object
        $parameters = $channel->GetParameters();

        //Get and parse all avaliable content items from the parser
        $contentItems = $factory->GetAndParse($parameters, $channel->GetLastSucess());

        //Return the content items
        return $contentItems;
    }
}
?>

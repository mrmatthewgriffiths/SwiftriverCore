<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\Core\Modules\SiSPS\Parsers;
interface IParser{
    /**
     * Given a set of parameters, this method should
     * fetch content from a channel and parse each
     * content into the Swiftriver object model :
     * Content Item.
     *
     * @param array $parameters
     * @return Swiftriver\Core\ObjectModel\Content[] contentItems
     */
    public function GetAndParse($parameters); 
}
?>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Swiftriver\Core\Modules\SiSPS\Parsers;
interface IParser{
    /**
     * 
     * @param array $parameters
     * @return Swiftriver\Core\ObjectModel\Content[] contentItems
     */
    public function GetAndParse($parameters); //returns array(Content)
}
?>

<?php
/**
 * ParserFactory is responciable for returning 
 * an instance of an object that implements the
 * IParser interface.
 */
namespace Swiftriver\Core\Modules\SiSPS;
class ParserFactory{
    /**
     * Expects a string reprosenting the class
     * name of an object that implements the
     * SiSPS\IParser interface. The param $type
     * must not include the word 'Parser'. For
     * example, supplying the $type Email will
     * return an instance of the EmailParser
     * object.
     *
     * @param string $type
     * @return SiSPS\Parsers\IParser $parser
     */
    public static function GetParser($type) {
        //Append the word Parser to the type
        $type = $type."Parser";

        //If the class is not defined, return null
        $type = "\\Swiftriver\\Core\\Modules\\SiSPS\\Parsers\\".$type;
        if(!class_exists($type))
            return null;
        
        //Finally, return a new Parser
        return new $type();
    }
}
?>

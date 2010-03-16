<?php
/**
 * ParserFactory is responciable for returning 
 * an instance of an object that implements the
 * IParser interface.
 */
namespace Swiftriver\SiSPS;
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

        //Bool to tell us if the file exists
        $foundParser = false;
        
        //The current directory
        $currentDir = dirname(__FILE__);

        //Environment specific directory seporator
        $dirSlash = "/";
        if(!strpos($currentDir, "/"))
            $dirSlash = "\\";

        //First see if the type is a core Parser
        $fileName = $currentDir.$dirSlash."Parsers".$dirSlash.$type.".php";
        if(file_exists($fileName))
            $foundParser = true;
        
        //Then see if the type is an extension Parser
        if(!$foundParser){
            $fileName = $currentDir.$dirSlash."Parsers".$dirSlash."Extensions".$dirSlash.$type.".php";
            if(file_exists($fileName))
                $foundParser = true;
        }
        
        //If no file is found matching the type, return null
        if(!$foundParser)
            return null;
        
        //Include the parser source file
        include_once($fileName);
        
        //If the class is not defined, return null
        $type = "Swiftriver\\SiSPS\\Parsers\\".$type;
        if(!class_exists($type))
            return null;
        
        //Finally, return a new Parser
        return new $type();
    }
}
?>

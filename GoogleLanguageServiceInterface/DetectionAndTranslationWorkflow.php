<?php
namespace Swiftriver\GoogleLanguageServiceInterface;
class DetectionAndTranslationWorkflow {
    /**
     *
     * @var \Swiftriver\Core\ObjectModel\Content;
     */
    private $content;

    /**
     * The Uri for the refering swift instance
     * @var string uir of the referer
     */
    private $referer;

    /**
     * The ISO 639-1 two letter language code
     * ref: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     * @var string
     */
    private $baseLanguageCode;

    /**
     * Constructor for this workflow
     * @param \Swiftriver\Core\ObjectModel\Content $content
     * @param string $referer
     * @param string $baseLanguageCode
     */
    public function __construct($content, $referer, $baseLanguageCode) {
        $this->content = $content;
        $this->referer = $referer;
        $this->baseLanguageCode = $baseLanguageCode;
    }

    /**
     * When executed this method will firtly attempt to identify the language
     * that the contents text is in. If this can not be done then the workflow
     * mark the language as unknow and return the content. If a language is
     * identifed as the same as the base language, the text is marked with the
     * language code and the content is returned. If the language is identified
     * as something other than the base language, then translations is attempted
     * and the translated text in the base language is added at position 0 to the
     * content text collection while the original text is stored at position 1
     *
     * @return \Swiftriver\Core\ObjectModel\Content
     */
    public function RunWorkflow() {
        //Get the first and only entry in the language specific text array
        $languageSpecificText = reset($this->content->text);

        //Try to detect and if required translate the text
        try {
            //extract the text to use for language detection
            $textForDetection = $this->ExtractTextForLanguageDetection($languageSpecificText);

            //If no text then throw and exception
            if($textForDetection == null) {
                throw new \Exception("No text could be extracted for language detection");
            }

            //Get an new instance of the detection interface
            $interface = new LanguageDetectionInterface(
                    $textForDetection,
                    $this->referer);

            //get the detected language code from the interafce
            $languageCode = $interface->GetLanguageCode();

            //set the language code
            $languageSpecificText->languageCode = $languageCode;

            //If the language IS the base language
            if(strtolower($languageCode) == strtolower($this->baseLanguageCode)) {
                //set the language specific text as the first in the collection
                $this->content->text[0] = $languageSpecificText;

                //return the content - no translation required
                return $this->content;
            }

            //ELSE we need to translate

            //Set up the variables to hold the translated content
            $title = "";
            $textArray = array();

            //get the translation interafce
            $interface = new TranslationInterface(
                    $languageSpecificText->languageCode,
                    $this->baseLanguageCode,
                    $this->referer);

            //first translate the title
            $title = $interface->Translate($languageSpecificText->title);

            //then loop through the text, translating it
            if(isset($languageSpecificText->text) && is_array($languageSpecificText->text)) {
                foreach($languageSpecificText->text as $text) {
                    $textArray[] = $interface->Translate($text);
                }
            }

            //once we have the translated text, create a new language specific text instance
            $baseLanguageSpecificText = new \Swiftriver\Core\ObjectModel\LanguageSpecificText(
                    $this->baseLanguageCode,
                    $title,
                    $textArray);

            //Set this as the first in the contents collection of language specific text
            $this->content->text[0] = $baseLanguageSpecificText;

            //reset the source language text to the second position
            $this->content->text[1] = $languageSpecificText;

            //return the content
            return $this->content;
        }
        catch (Exception $e) {
            //if there was an exception throw then mark the text as uknown
            $languageSpecificText->languageCode = "unknown";

            //set it back to the content
            $this->content->text[0] = $languageSpecificText;

            //return the content without translation
            return $this->content;
        }
    }

    private function ExtractTextForLanguageDetection($languageSpecificText) {
        //set the return value
        $return = "";

        //if the title is set add it to the return text
        if(isset($languageSpecificText->title) &&
           $languageSpecificText->title != null &&
           $languageSpecificText->title > "") {
            $return .= $languageSpecificText->title;
        }

        //look for text that can be added to the return text
        if(isset($languageSpecificText->text) && is_array($languageSpecificText->text)) {
            foreach($languageSpecificText->text as $text) {
                if(isset($text) && $text != null && $text > "") {
                    $return .= $text;
                }
            }
        }

        //if the return text is null or empty then return null
        if($return == "") {
            return null;
        }

        //if the string is over 500 chars then chop it
        if(strlen($return) > 500) {
            $return = substr($return, 0, 500);
        }

        //finally return the string
        return $return;
    }
}
?>

<?php
namespace Swiftriver\GoogleLanguageServiceInterface;
class TranslationInterface {
    private $sourceLangCode;
    private $requiredLangCode;
    private $referer;

    public function __construct($sourceLangCode, $requiredLangCode, $referer) {
        $this->sourceLangCode = $sourceLangCode;
        $this->requiredLangCode = $requiredLangCode;
        $this->referer = $referer;
    }

    public function Translate($text) {
        $context = stream_context_create(
            array(
                'http' => array(
                    "Referer: ".$this->referer."\r\n",
                ),
            ));
        $text = urlencode($text);
        $languagePair = "$this->sourceLangCode%7C$this->requiredLangCode";
        $uri = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=$text&langpair=$languagePair";
        $returnData = file_get_contents($uri, false, $context);
        $object = json_decode($returnData);
        return $object->responseData->translatedText;
    }
}
?>

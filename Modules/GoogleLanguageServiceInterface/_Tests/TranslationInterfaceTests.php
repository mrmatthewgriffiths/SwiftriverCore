<?php
namespace Swiftriver\GoogleLanguageServiceInterface\Tests;
require_once 'PHPUnit/Framework.php';

class TranslationInterfaceTests extends \PHPUnit_Framework_TestCase {

    public function testTranslateFromEnglishToFrench() {
        include_once(dirname(__FILE__)."/../TranslationInterface.php");
        $referer = "tests.swiftriver.com";
        $textEn = "In 1972, a crack commando unit was sent to prison by a military court for a crime they didn't commit. They promptly escaped from a maximum security stockade to the Los Angeles underground.";
        $textFr = "";
        $interface = new \Swiftriver\GoogleLanguageServiceInterface\TranslationInterface(
                "en",
                "fr",
                $referer);
        $translatedText = $interface->Translate($textEn);
        $this->assertEquals(
                true,
                strpos(
                    " ".$translatedText,
                    "En 1972, un commando de crack a été envoyé en prison par un tribunal militaire pour un crime"
                ) != 0);
    }
}
?>

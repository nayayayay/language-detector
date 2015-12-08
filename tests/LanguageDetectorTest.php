<?php
require './vendor/autoload.php';

use ChibiFR\LanguageDetector\Detector;

class LanguageDetectorTest extends PHPUnit_Framework_TestCase
{
    public function testFindFrenchLanguage()
    {
        $lg = new Detector();
        $this->assertEquals([
            'language' => 'french',
            'reliable' => 1
        ], $lg->detectLanguage(
            'Bonjour, je m\'appelle Toto et je vis en France. Comment allez-vous ? A bientôt !'
        ));
    }

    public function testNotReliableWithUnknownLanguage()
    {
        $lg = new Detector();
        $this->assertEquals([
            'language' => 'english',
            'reliable' => 0
        ], $lg->detectLanguage('A a a.'));
    }
}

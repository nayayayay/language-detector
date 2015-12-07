<?php
namespace ChibiFR\LanguageDetector;

/**
 * Represents a language from a /src/languages/[a-z\-].php file.
 * It is used by the LanguageDetector to easily manage each language name and words.
 *
 * Class Language
 * @package ChibiFR
 */
class Language
{
    /**
     * @var string The name of this language.
     */
    protected $language;
    /**
     * @var array The words known for this language.
     */
    protected $words = [];

    /**
     * Language constructor.
     * @param $language
     * @throws InvalidLanguageNameException if the provided language name does not
     *     exist in the languages directory.
     */
    public function __construct($language)
    {
        $this->language = $language;
        $languagePath = __DIR__.'/languages/'.$language.'.php';
        if (!file_exists($languagePath)) {
            throw new InvalidLanguageNameException(
                "The language $language was not found at $languagePath"
            );
        } else {
            $this->words = (include __DIR__.'/languages/'.$language.'.php');
        }
    }

    /**
     * @return string The name of the language for this instance.
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return array The words set in the dictionary file for this language.
     */
    public function getWords()
    {
        return $this->words;
    }
}

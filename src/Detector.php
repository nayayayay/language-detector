<?php
namespace ChibiFR\LanguageDetector;

class Detector
{
    protected $languages = [];
    protected $text = '';
    protected $language = '';
    protected $reliable = 0;

    public function __construct()
    {
        // Get the languages directory path
        $languages = scandir(__DIR__.'/languages');

        foreach($languages as $language) {
            // Prevent from scanning . and .. directories
            if (!preg_match('#^\.#', $language)) {
                // Retrieve the language name from the filename
                $current = preg_replace('#\.php#i', '', $language);
                // Create a new Language for the current iterated language
                try {
                    $this->languages[$current] = new Language($current);
                } catch (InvalidLanguageNameException $e) {
                    die($e->getMessage());
                }
            }
        }
    }

    /**
     * Search for the language of given $text.
     *
     * @param string $text The text to get the language of.
     * @return array Result of the detection : key language contains the language,
     * key reliable contains an int as 1 if reliable, 0 if not.
     */
    public function detectLanguage($text)
    {
        $found = [];

        // If the tested language uses characters (not latin words)
        if ((str_word_count($text) / 2) > substr_count($text, ' ') && strlen($text) != mb_strlen($text)) {
            // Split at each character
            $this->text = $this->removeSpecialChars($text);
            preg_match_all('#.#u', $this->text, $matches);
            $splitText = $matches[0];
        } else {
            // Split at each word
            $this->text = strtolower($this->removeSpecialChars($text));
            $splitText = explode(' ', $this->text);
        }

        // Count the words found for each known language
        foreach ($this->languages as $currentLanguage) {
            $found[$currentLanguage->getLanguage()] = 0;
            foreach ($splitText as $word) {
                if (in_array($word, $currentLanguage->getWords())) {
                    $found[$currentLanguage->getLanguage()] += 1;
                }
            }
        }

        // Find the max words count and its language name
        $max = max($found);
        $best = array_search($max, $found);
        unset($found[$best]);

        // Prepare the return value and check the reliability.
        if (array_search($max, $found) || str_word_count($this->text) < 7) {
            $this->language = $best;
            $this->reliable = 0;
        } else {
            $this->language = $best;
            $this->reliable = 1;
        }

        return [
            'language' => $this->language,
            'reliable' => $this->reliable
        ];
    }

    /**
     * Remove the special chars (punctuation, currency symbols, special characters, numbers,
     * ...) from the given $text.
     *
     * @param string $text The text the remove the special chars of.
     * @return string The text with special chars removed.
     */
    protected function removeSpecialChars($text)
    {
        $specialChars = [
            '.', ',', ';', '?', '!',
            '"', '\'', '\\', '<', '>',
            '(', ')', '_', '#', '@', '§',
            '€', '$', '®', '©', '◊', '~',
            ':', '°', '&', '≤', '%', '£',
            '0', '1', '2', '3', '4', '5',
            '6', '7', '8', '9', '‡', '{', '}',
            '[', ']'
        ];

        return str_replace($specialChars, '', $text);
    }

    /**
     * @return array Each language the LanguageDetector instance knows as Language
     * class instances.
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @return string The (last) text analysed.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string The language of the (last) text analysed.
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return int 1 if language found is reliable, 0 if not.
     */
    public function isReliable()
    {
        return $this->reliable;
    }
}

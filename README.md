## Language Detector

A PHP package that detects the language from a string and can learn new languages.

## Installation

To install this package, make sure you have [composer](https://getcomposer.org/).
Then, require it:
```
composer require chibifr/language-detector
```

## Teach a new language

To teach a new language to the Language Detector, simply add a file to the src/languages directory
named "your-newly-added-language.php". This file should return an array of words or characters of
the language you are teaching the LanguageDetector.

This file should look like:
```php
<?php
// Your file should simple return an array of words/characters.
return [
    'word1',
    'word2',
    'word3',
    'word4',
    'etc'
];
```

**Should I add words or characters?**

Good question bro/sis! Here is the answer: if your language does not use latin latters, add characters,
if it does, then add words.
 
More you add words, more the LanguageDetector will be efficient (but don't add too much, that could slow it down).

## Usage

```php
<?php
// Require the composer's vendor autoload file
require './vendor/autoload.php';

use ChibiFR\LanguageDetector\Detector;

// Create a new Converter object
$lg = new Detector();

// Trying to detect English
$result = $lg->detectLanguage('Hello, my name is FooBar and I live in New York. The weather here is pretty
nice! Anyways, have a good day, people.');

print_r($result) // Will print ['language' => 'english', 'reliable' => 1]

// Trying to detect an unkown language
$result = $lg->detectLanguage('A e i o u.');
print_r($result) // Will print ['language' => 'english', 'reliable' => 0]
// You can then check if the language found is reliable before doing more.
```

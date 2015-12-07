<?php
namespace ChibiFR\LanguageDetector;

/**
 * Class InvalidLanguageNameException
 * @package ChibiFR\LanguageDetector
 */
class InvalidLanguageNameException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

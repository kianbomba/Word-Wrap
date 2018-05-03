<?php
/**
 * Created by PhpStorm.
 * User: kianbomba
 * Date: 2/05/18
 * Time: 9:14 AM
 */

namespace KianBomba;


/**
 * Class Sanitizer
 * @package KianBomba
 */
class Sanitizer
{
    /**
     * @var Sanitizer
     */
    private static $invoker;

    /**
     * Sanitizer constructor.
     */
    private function __construct(){}

    /**
     * @return Sanitizer
     */
    public static function instance(): Sanitizer
    {
        if (is_null(self::$invoker)) self::$invoker = new Sanitizer();
        return self::$invoker;
    }

    /**
     * @param string $input
     * @return string
     */
    public function spaceSanitize(string $input): string
    {
        return (string) preg_replace("/\s+/", " ",$input);
    }
}
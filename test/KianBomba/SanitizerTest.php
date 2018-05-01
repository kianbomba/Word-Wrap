<?php
/**
 * Created by PhpStorm.
 * User: kianbomba
 * Date: 2/05/18
 * Time: 9:44 AM
 */

namespace KianBomba;


use PHPUnit\Framework\TestCase;

class SanitizerTest extends TestCase
{
    public function testSanitizer(): void
    {
        $in = "hello\nworld\tfrom bomba";
        $out = "hello world from bomba";
        $this->assertEquals($out, Sanitizer::instance()->spaceSanitize($in));
    }
}

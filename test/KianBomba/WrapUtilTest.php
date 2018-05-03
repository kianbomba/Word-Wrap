<?php
/**
 * Created by IntelliJ IDEA.
 * User: bomba
 * Date: 27/04/18
 * Time: 6:51 PM
 */
declare(strict_types =1);
namespace KianBomba;


use PHPUnit\Framework\TestCase;

/**
 * Class WrapUtilTest
 * @package KianBomba
 */
class WrapUtilTest extends TestCase
{
    /**
     * @var WrapUtil
     */
    private $helper;

    public function setUp()
    {
        $this->helper = new WrapUtil();
    }

    public function testWrap(): void
    {
        $x = "HelloWorld from kian bomba da superman";
        $expected = "HelloWorld\nfrom kian\nbomba da\nsuperman";

        $this->assertEquals($expected, $this->helper->wrap($x, 10));
    }

    public function testBehaviour(): void
    {
        $x = "Helloworld from kianbomba da supa mida, with zeus";
        $expected = wordwrap($x, 10);
        $this->assertEquals($expected, $this->helper->wrap($x, 10));
    }

    public function testWrap2(): void
    {
        $x = "Helloworld from kianb said by darude sandstorm";
        $exp = "Helloworld\nfrom kianb\nsaid by\ndarude\nsandstorm";
        $this->assertEquals($exp, $this->helper->wrap($x, 10));
    }

    public function testWrap3(): void
    {
        $x = "Hello world from kian bomba";
        $exp = "Hello\nworld\nfrom\nkian\nbomba";
        $this->assertEquals($exp, $this->helper->wrap($x, 3));
    }

    public function testWrapV2(): void
    {
        $x = "hello world";
        $exp = "hello\nworld";
        $this->assertEquals($exp, $this->helper->wrapV2($x, 5));
    }

    public function testWrapV2Case2(): void
    {
        $x = "hello world\nupper";
        $exp = "he\nll\no \nwo\nrl\nd \nup\npe\nr";
        $this->assertEquals($exp, $this->helper->wrapV2($x, 2));
    }

    public function testWrapV2Case3(): void
    {
        $x = "hello world\nfrom the other side";
        $exp = "hello world\nfrom the ot\nher side";
        $this->assertEquals($exp, $this->helper->wrapV2($x, 11));
    }

    public function testWrapV2Case4(): void
    {
        $x = "hello\nworld";
        $exp = "hello\nworld";
        $this->assertEquals($exp, $this->helper->wrapV2($x, 5, false));
    }

    public function testWrapV2Case5(): void
    {
        $x = "hello world\nupper";
        $exp = "he\nll\no \nwo\nrl\nd\n\nup\npe\nr";
        $this->assertEquals($exp, $this->helper->wrapV2($x, 2, false));
    }

    public function testWrapV2Cas6(): void
    {
        $x = "word";
        $exp = "wo\nrd";
        $this->assertEquals($exp, $this->helper->wrapV2($x, 2));
    }

    public function testWrapV2Cas7(): void
    {
        $x = "word";
        $exp ="w\no\nr\nd";
        $this->assertEquals($exp, $this->helper->wrapV2($x, 1));
    }
}

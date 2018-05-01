<?php
/**
 * Created by IntelliJ IDEA.
 * User: bomba
 * Date: 27/04/18
 * Time: 6:25 PM
 */

require_once __DIR__ . "/vendor/autoload.php";

use KianBomba\WrapUtil;


$helper = new WrapUtil();
//$things = $helper->wrap("Helloworld from kian bomba", 10);


$things = $helper->wrapV2("hello world\nabcde", 2);
echo $things;

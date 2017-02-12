<?php

require dirname(__FILE__) . '/SimpleDebug.php';

define('MY_CONSTANT', 1);

$aa = new AA();

$aa->test();

class AA
{
    function test()
    {
        $a = '2333';
        $bb = new BB();
        $aa = 23333;
        $b = 'xxxx';
        // simple_dump($a,



        //     $bb);simple_dump($aa, $b);
        simple_dump($a, $bb, MY_CONSTANT,
            $_GET,
            $_SERVER['REMOTE_ADDR']
            ,
            '~!@#$%^&*(), .'


            )
        ;
    }
}
class BB
{}

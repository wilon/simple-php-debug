<?php

error_reporting(0);

require dirname(__FILE__) . '/SimpleDebug.php';

define('MY_CONSTANT', 1);

$aa = new AA();


$b = 'outfunc';
$ccc = array();

$aa->test();

simple_dump($aa, $ccc); simple_dump($b, $aa);

class AA
{
    function test()
    {
        $a = '2333';
        $bb = new BB();
        $aa = 23333;
        $b = 'xxxx';
        $ccc = 'xhoif"';
        simple_dump (

            $a,
            "xx\n",
            '($a, $b', MY_CONSTANT,

            $bb,
            "        zafai ofoioi we simple_dump () s",
            '

            simple_dump

            () '
            )

        ;

        simple_dump($aa,
            $b
            );simple_dump($aa, $ccc); simple_dump($b, $aa); simple_dump($a, $bb, MY_CONSTANT,
         $bb, MY_CONSTANT,
            // $bb);simple_dump($aa, $b);
            $_GET,
            $_SERVER['REMOTE_ADDR']
            ,
            '~!@#$%^&*(),
             .', ' '


            ) ;simple_dump($aa, $b);


            func($aa, $b);
    }

    public function FunctionName()
    {
        func();
    }
}

class BB
{}

function func()
{
    echo 'composer.json';
}

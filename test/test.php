<?php

require dirname(__FILE__) . '/../src/SimpleDebug.php';

define('MY_CONSTANT', 1);

$aa = new AA();

$b = 'outfunc';
$ccc = array();
(((((((((simple_dump($b  ,(((((((((   $ccc))))))))), $aa))))))))));

$aa->test();

simple_dump($aa, $ccc ); die(simple_dump($b, $aa)); simple_dump($ccc, $aa );

class AA
{
    function test()
    {
        $a = '2333';
        $bb = new BB();
        $aa = 23333;
        $b = 'xxxx';
        $ccc = function ()
        {
            return;
        };
        simple_dump (

            $a,
            "xx\n",
            '($a, $b', MY_CONSTANT,

            $bb,
            "        zafai ofoioi we simple_dump () s",
            function ()
            {
                return;
            }
            )

        ;

        simple_dump($aa,
            $b
            );
        simple_dump($aa, $ccc); simple_dump($b, $aa);
        simple_dump($a, $bb, MY_CONSTANT,
         $bb, MY_CONSTANT,
            // $bb);simple_dump($aa, $b);
            $_GET,
            $_SERVER['REMOTE_ADDR']
            ,
            '~!@#$%^&*(),
             .', ' '


            ) ;
            simple_dump($aa, $b);


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

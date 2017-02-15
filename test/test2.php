<?php

require dirname(__FILE__) . '/../src/SimpleDebug.php';

define('MY_CONSTANT', 1);

$aa = new AA();


$b = 'outfunc';
$ccc = array();

$aa->test();

simple_log('./some.log', $aa, $ccc ); simple_log('./some.log', $b, $aa ); simple_log('./some.log', $ccc, $aa );

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
        simple_log ('./some.log',

            $a,
            "xx\n",
            '($a, $b', MY_CONSTANT,

            $bb,
            "        zafai ofoioi we simple_log './some.log', () s",
            function ()
            {
                return;
            }
            )

        ;

        simple_log('./some.log', $aa,
            $b
            );
        simple_log('./some.log', $aa, $ccc); simple_log('./some.log', $b, $aa);
        simple_log('./some.log', $a, $bb, MY_CONSTANT,
         $bb, MY_CONSTANT,
            // $bb);simple_log('./some.log', $aa, $b);
            $_GET,
            $_SERVER['REMOTE_ADDR']
            ,
            '~!@#$%^&*(),
             .', ' '


            ) ;
            simple_log('./some.log', $aa, $b);


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

<?php

// error_reporting(0);

require dirname(__FILE__) . '/../src/SimpleDebug.php';

define('MY_CONSTANT', 1);

$aa = new AA();

$b = 'outfunc';
$ccc = array(1,2,3);

(simple_dump(implode(',', ((($ccc)))), 'xxxx', $b, explode('u', $b)));

(((((((((simple_dump((((((trim((implode(',', $ccc) . 'xx()(())()(((((())(x')))))))))))))))));

func($aa, $b);
func($aa, $b);
func($aa, $b);

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
            "((()))        zafai ofoioi we simple_dump () s)))))))))))",
            function ()
            {
                return;
            }
            )

        ;



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
    $a = '2333';
        $bb = new BB();
        $aa = 23333;
        $b = 'xxxx';
        $ccc = function ()
        {
            return;
        };
        simple_dump ($a, "xxs", $bb); simple_dump ($b);

}

<?php

require dirname(__FILE__) . '/../src/SimpleDebug.php';

$longStr = 'President Trump’s ouster of national security adviser Michael T. Flynn, and the circumstances leading up to it, have quickly become a major crisis for the fledgling administration, forcing the White House on the defensive and precipitating the first significant breach in relations between Trump and an increasingly restive Republican Congress.';
$htmlStr = '<link rel="search" type="application/opensearchdescription+xml" href="/search.osd?v=1483361432" title="Packagist" /><br>';
$array = pathinfo('C:/test/wilon/index.php');

var_dump($longStr, $htmlStr, $array);

simple_dump($longStr, $htmlStr, $array);
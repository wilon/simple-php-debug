# SimplePHPDebug

Simple PHP Debug, better output on browser and write log.

## Installation & loading

Just add this line to your `composer.json` file:

```json
"wilon/simple-php-debug": "^0.1.4"
```

or

```sh
composer require wilon/simple-php-debug
```

## A Simple Example

```php
<?php

$a = 123;
$b = '23333';

simple_dump($a, $b, $_GET, $_SERVER['REMOTE_ADDR']);

simple_log(dirname(__FILE__) . '/somefile.log', $b, $_GET, $_SERVER['REMOTE_ADDR']);

```
## What's better then var_dump on browser?

```php
<?php

$longStr = 'President Trump’s ouster of national security adviser Michael T. Flynn, and the circumstances leading up to it, have quickly become a major crisis for the fledgling administration, forcing the White House on the defensive and precipitating the first significant breach in relations between Trump and an increasingly restive Republican Congress.';
$htmlStr = '<link rel="search" type="application/opensearchdescription+xml" href="/search.osd?v=1483361432" title="Packagist" /><br>';
$array = pathinfo('C:/test/wilon/index.php');

var_dump($longStr, $htmlStr, $array);

simple_dump($longStr, $htmlStr, $array);

```

![image](https://cloud.githubusercontent.com/assets/7512755/22959116/94ff96a8-f36e-11e6-835e-65d9ebc527cf.png)


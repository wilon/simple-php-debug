# SimpleDebug
Simple PHP Debug, better output and write log.

## Installation & loading

Just add this line to your `composer.json` file:

```json
"wilon/simple-debug": "^0.1.0"
```

or

```sh
composer require wilon/simple-debug
```

## A Simple Example

```php
<?php

$a = 123;
$b = '23333';

simple_dump($a, $b, $_GET, $_SERVER['REMOTE_ADDR']);

simple_log(dirname(__FILE__) . '/somefile.log', $b, $_GET, $_SERVER['REMOTE_ADDR']);

```

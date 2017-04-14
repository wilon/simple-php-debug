<?php

/**
 * simple dump
 *
 * @return
 */
function simple_dump()
{
    if (func_num_args() < 1) {
        throw new Exception('need args');
    }

    // get args name
    $bt = debug_backtrace();
    $args = simpledebug_get_args_info($bt[0]);
    if (PHP_SAPI == 'cli') {
        foreach ($args as $argName => $arg) {
            $argName = isset($argName) ? $argName : 'null';
            echo "\033[1;31m$argName\033[0m",
                ' => ',
                var_dump($arg);
        }
        return;
    }

    // better dump
    ob_start();
    foreach ($args as $argName => $arg) {
        $argName = isset($argName) ? $argName : 'null';
        echo "&wilonlt;span style='color:red'&wilongt;$argName&wilonlt;/span&wilongt;",
            ' => ',
            var_dump($arg);
    }
    echo '<pre style="white-space:pre-wrap;word-wrap:break-word;">' .
        preg_replace(
            array('/\]\=\>\n(\s+)/m','/</m','/>/m', '/&wilonlt;/m', '/&wilongt;/m'),
            array('] => ','&lt;','&gt;', '<', '>'),
            ob_get_clean()
        ) .
        '</pre><br>';
    return;
}

/**
 * simple log
 *
 * @return
 */
function simple_log()
{
    if (func_num_args() < 1) {
        throw new Exception('need args');
    }
    $bt = debug_backtrace();
    $args = simpledebug_get_args_info($bt[0]);
    $file = $bt[0]['args'][0];
    foreach ($args as $argName => $arg) {
        if ($arg === $file) {
            unset($args[$argName]);
        }
    }
    @simpledebug_mkdirs(dirname($file));
    $result['time'] = date('Y-m-d H:i:s');
    $result['data'] = $args;
    $logStr = json_encode($result, JSON_UNESCAPED_UNICODE) . "\n";
    @file_put_contents($file, $logStr, FILE_APPEND);
    return;
}

/**
 * simpledebug get args name
 *
 * @param  array $btUse function debug_backtrace
 * @return array        args names
 */
function simpledebug_get_args_info($btUse)
{
    global $SimpleDebug;

    // code string
    $file = new \SPLFileObject($btUse['file']);
    $codeStr = '';
    $codeArr = array();
    foreach ($file as $lineNum => $line) {
        $codeStr .= $line;
        $codeArr[$lineNum] = trim($line);
    }

    // function token
    $tokensAll = token_get_all($codeStr);
    foreach ($tokensAll as $k => $token) {
        if ($token[0] == T_COMMENT) {
            continue;
        }
        if (isset($token[1]) && trim($token[1]) == '') {
            continue;
        }
        $tokensUse[] = $token;
    }

    // parse token, get function info
    $funcArr = $funcTmp = array();
    foreach ($tokensUse as $k => $token) {
        if (isset($token[1]) && $token[1] == $btUse['function']) {
            $funcTmp = array();
            // $funcTmp['args'] = array();
            $funcTmp['code'] = array();
            $funcTmp['line'] = $token[2];
            $argsKey = 0;
            continue;
        }
        if (isset($funcTmp['code'])) {
            $funcTmp['code'][] = $token;
        }
        if ($token == ',') {
            isset($argsKey) && $argsKey++;
        }
        if ($token == ')' && $tokensUse[$k+1] == ';' && !empty($funcTmp)) {
            $funcArr[] = $funcTmp;
            unset($funcTmp);
        }
    }
    foreach ($funcArr as $k => $func) {
        $funcArr[$k]['args'] = simpledebug_parse_code_token($func['code']);
    }
    // get the function use line
    $funcMark = $funcLine = 0;
    $markArr = array();
    foreach ($funcArr as $func) {
        if ($btUse['line'] < $func['line']) {
            continue;
        }
        $funcLine = $func['line'];
    }
    foreach ($funcArr as $k => $func) {
        if ($funcLine == $func['line']) {
            $markArr[] = $k;
        }
    }

    !isset($SimpleDebug[$funcLine]) && $SimpleDebug[$funcLine] = 0;
    $funcMark = $markArr[$SimpleDebug[$funcLine]];
    $SimpleDebug[$funcLine] = ($SimpleDebug[$funcLine] + 1) % count($markArr);

    // handle args name
    $argsNames = $funcArr[$funcMark]['args'];
    $argsCount = count($btUse['args']);
    foreach ($argsNames as $k => $argName) {
        $argName = trim($argName);
        $argName = rtrim($argName, ',');
        $argName = ltrim($argName, '(');
        $argName = rtrim($argName, ')');
        $argTokenArr = token_get_all('<?php ' . $argName);
        $ln = $rn = 0;
        foreach ($argTokenArr as $argToken) {
            if ($argToken == '(') $ln++;
            if ($argToken == ')') $rn++;
        }
        if (($n = $ln - $rn) > 0) {
            $argName .= str_repeat(')', $n);
        }
        if (!empty($argName)) {
            $result[$argName] = $btUse['args'][$k];
        } else {
            $result[] = $btUse['args'][$k];
        }
    }

    return $result;
}

function simpledebug_parse_code_token($tokenArr)
{
    if ($tokenArr[0] == '(') {
        unset($tokenArr[0]);
    }
    $bracketArr2 = array();
    foreach ($tokenArr as $k => $token) {
        if (is_string($token) && in_array($token, array('(', ')'))) {
            $bracketArr2[$k] = $token;
        }
    }$bracketArr = array();
    foreach ($tokenArr as $k => $token) {
        $c = count($bracketArr);
        if (is_string($token) && $token == '(') {
            $bracketArr[] = array('start' => $k);
            continue;
        }
        if (is_string($token) && $token == ')') {
            for ($i = $c-1; $i >= 0; $i--) {
                if (!array_key_exists('end', $bracketArr[$i])) {
                    $bracketArr[$i]['end'] = $k;
                    break;
                }
            }
            continue;
        }
    }
    $argsKey = 0;
    $argsArr = array();
    foreach ($tokenArr as $k => $token) {
        $inArgs = false;
        foreach ($bracketArr as $bracket) {
            if ($k >= $bracket['start'] && $k <= $bracket['end']) {
                $inArgs = true;
                break;
            }
        }
        if ($inArgs !== true && $token == ',') {
            isset($argsKey) && $argsKey++;
            continue;
        }
        !isset($argsArr[$argsKey]) && $argsArr[$argsKey] = '';
        $argsArr[$argsKey] .= is_string($token) ? $token : ($token[1]);
    }
    return $argsArr;
}

function simpledebug_mkdirs($dir)
{
    return is_dir($dir) ?: mkdirs(dirname($dir)) && mkdir($dir);
}

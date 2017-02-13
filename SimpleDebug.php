<?php

/**
 * better var_dump
 * @return
 */
function simple_dump() {
    if (func_num_args() < 1) {
        throw new Exception('need args');
    }

    global $SimpleDebug;

    // get code file
    $bt = debug_backtrace();
    $btUse = $bt[0];
    !isset($SimpleDebug[$btUse['line']]) && $SimpleDebug[$btUse['line']] = 0;
    $file = new \SPLFileObject($btUse['file']);
    $codeStr = '';
    $codeArr = array();
    foreach ($file as $lineNum => $line) {
        $codeStr .= $line;
        $codeArr[$lineNum] = trim($line);
    }

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
    $funcArr = $funcTmp = array();
    foreach ($tokensUse as $k => $token) {
        if (isset($token[1]) && $token[1] == $btUse['function']) {
            $funcTmp = array();
            $funcTmp['count'] = 0;
            $funcTmp['args'] = array();
            $funcTmp['line'] = $token[2];
            $argsKey = 0;
        } else if (isset($argsKey) && isset($funcTmp['args'])) {
            !isset($funcTmp['args'][$argsKey]) && $funcTmp['args'][$argsKey] = '';
            $funcTmp['args'][$argsKey] .= is_string($token) ? $token : ($token[1]);
        }
        if ($token == ',' && isset($funcTmp['count'])) {
            $funcTmp['count']++;
            isset($argsKey) && $argsKey++;
        }
        if ($token == ')' && $tokensUse[$k+1] == ';' && !empty($funcTmp)) {
            $funcArr[] = $funcTmp;
            unset($funcTmp);
        }
    }

    var_dump($SimpleDebug);
    // foreach ($SimpleDebug as $line => $num) {
    //     if
    // }

    $argsNames = $funcArr[$SimpleDebug]['args'];
    $argsNum = count($btUse['args']);
    foreach ($argsNames as $k => $args) {
        if ($k == 0) {
            $argsNames[$k] = ltrim(rtrim(trim($args), ','), '(');
        } else if ($k == $argsNum - 1) {
            $argsNames[$k] = rtrim(trim($args), ')');
        } else {
            $argsNames[$k] = rtrim(trim($args), ',');
        }
    }

    // dump
    ob_start();
    foreach ($btUse['args'] as $k => &$arg) {
        $key = isset($argsNames[$k]) ? $argsNames[$k] : 'null';
        echo "&wilonlt;span style='color:red'&wilongt;$key&wilonlt;/span&wilongt;",
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

    $SimpleDebug[$btUse['line']]++;
}

function simple_log($file, &$arg0 = null, &$arg1 = null, &$arg2 = null, &$arg3 = null, &$arg4 = null, &$arg5 = null, &$arg6 = null, &$arg7 = null, &$arg8 = null, &$arg9 = null, &$arg10 = null, &$arg11 = null, &$arg12 = null, &$arg13 = null, &$arg14 = null, &$arg15 = null, &$arg16 = null, &$arg17 = null, &$arg18 = null, &$arg19 = null, &$arg20 = null)
{
    $allArgs = array(&$arg0, &$arg1, &$arg2, &$arg3, &$arg4, &$arg5, &$arg6, &$arg7, &$arg8, &$arg9, &$arg10, &$arg11, &$arg12, &$arg13, &$arg14, &$arg15, &$arg16, &$arg17, &$arg18, &$arg19, &$arg20);
    $argsNum = func_num_args();
    $result = array(
            'time' => date('Y-m-d H:i:s'),
        );
    foreach ($allArgs as $k => &$arg) {
        if ($k === $argsNum) {
            break;
        }
        $key = get_variable_name($arg);
        $result[$key] = $arg;
    }
    @simpledebug_mkdirs(dirname($file));
    @file_put_contents($file, json_encode($result) . "\n", FILE_APPEND);
}

function get_var_name(&$var, $scope = NULL)
{
    $scope = $scope ?: $GLOBALS;
    $tmp = $var;
    $var = time() . microtime() . mt_rand();
    $name = array_search($var, $scope, TRUE);
    if ($name === false) {
        $splice = '|%$%|';
        $allVars = simpledebug_array_keys_vals($scope, '', $splice);
        foreach ($allVars as $varName => $varValue) {
            if ($var == $varValue) {
                $keyName = $varName;
                break;
            }
        }
        $keyArr = explode($splice, $keyName);
        foreach ($keyArr as $k => $field) {
            if ($k === 0) {
                $name = $field;
            } else {
                $name .= "['$field']";
            }

        }
    }
    $var = $tmp;
    return $name ? '$' . $name : false;
}


function simpledebug_mkdirs($dir)
{
    return is_dir($dir) ?: mkdirs(dirname($dir)) && mkdir($dir);
}


/*
    $funcLineArr = array();
    $startMark = $endMark = 0;
    $funcCodeArr = array();
    foreach ($tokensAll as $k => $token) {
        if ($token[0] == T_COMMENT) {
            continue;
            // if ($key = array_search(trim($token[1]), $codeArr)) {
                // unset($codeArr[$key]);
            // }
        }
        !isset($funcCodeArr[$startMark]) && $funcCodeArr[$startMark] = '';
        if (isset($token[1]) && $token[1] == $btUse['function']) {
            $startMark++;
            // $funcLineArr[] = $token[2];
        }
        if ($token == ';' && $tokensAll[$k-1] == ')') {
            $endMark++;
            continue;
        }
        if ($endMark !== $startMark) {
            $funcCodeArr[$startMark] .= is_string($token) ? $token : ($token[1]);
        }
    }
    unset($funcCodeArr[0]);
    get use function str
    $funcCodeArr = array();
    $lineEnd = $btUse['line'];
    $lineStart = $funcLineArr[$SimpleDebug] - 1;
    for ($i = $lineEnd; $i >= $lineStart; $i--) {
        if (!array_key_exists($i, $codeArr)) {
            continue;
        }
        $funcCodeArr[] = $codeArr[$i];
    }
    $funcCodeStr = implode('', array_reverse($funcCodeArr));

    parse function str, line has one more this function
    substr($funcCodeStr, -1) == ')' && $funcCodeStr .= ';';
    $funcTokens = token_get_all('<?php ' . $funcCodeStr);
    foreach ($funcTokens as $k => $token) {
        if (isset($token[1]) && trim($token[1]) == '') {
            continue;
        }
        $tokensUse[] = $token;
    }
    $funcArr = $funcTmp = array();
    foreach ($tokensUse as $k => $token) {
        if (isset($token[1]) && $token[1] == $btUse['function']) {
            $funcTmp = array();
            $funcTmp['count'] = 0;
            $funcTmp['args'] = array();
            $argsKey = 0;
            $funcTmp['str'] = '';
        } else if (isset($argsKey)) {
            !isset($funcTmp['args'][$argsKey]) && $funcTmp['args'][$argsKey] = '';
            $funcTmp['args'][$argsKey] .= is_string($token) ? $token : ($token[1]);
        }
        if ($token == ',') {
            $funcTmp['count']++;
            isset($argsKey) && $argsKey++;
        }
        if ($token == ')' && $tokensUse[$k+1] == ';') {
            $funcArr[] = $funcTmp;
        }
    }

    get args names
    $argsNum = count($btUse['args']);
    $argsNames = array();
    foreach ($funcArr as $func) {
        !isset($func['count']) && $func['count'] = 0;
        if ($argsNum == $func['count'] + 1) {
            $argsNames = $func['args'];
            break;
        }
    }

    */
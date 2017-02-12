<?php

function simple_dump() {
    // debug_print_backtrace();
    $bt = debug_backtrace();
    $btUse = $bt[0];
    $file = new \SPLFileObject($btUse['file']);
    $lineEnd = $btUse['line'];
    $codeStr = '';
    foreach ($file as $lineNum => $line) {
        if ($lineNum == $lineEnd) {
            break;
        }
        if (strpos($line, $btUse['function']) !== false) {
            $codeStr .= $line;
            continue;
        }
        if ($codeStr !== '') {
            $codeStr .= $line;
        }
    }
    $matchs = null;
    $argsCommaNum = count($btUse['args']) - 1;
    $preg = "/{$btUse['function']}\(((.*?,){{$argsCommaNum}}.*?)\)/is";
    preg_match($preg, $codeStr, $matchs);
    ob_start();$s=array($codeStr, $matchs);foreach($s as $v){var_dump($v);}die('<pre style="white-space:pre-wrap;word-wrap:break-word;">'.preg_replace(array('/\]\=\>\n(\s+)/m','/</m','/>/m'),array('] => ','&lt;','&gt;'),ob_get_clean()).'');
    $paramNames = array_map('trim', explode(',', $matchs[1]));
    ob_start();
    foreach ($btUse['args'] as $k => &$arg) {
        $key = $paramNames[$k];
        echo "&wilonlt;span style='color:red'&wilongt;$key&wilonlt;/span&wilongt;", ' => ' ,var_dump($arg);
    }
    echo '<pre style="white-space:pre-wrap;word-wrap:break-word;">' .
        preg_replace(
            array('/\]\=\>\n(\s+)/m','/</m','/>/m', '/&wilonlt;/m', '/&wilongt;/m'),
            array('] => ','&lt;','&gt;', '<', '>'),
            ob_get_clean()
        ) .
        '</pre><br>';
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
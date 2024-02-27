<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/get_object_properties.php';
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * var_export2 を html コンテキストに特化させたようなもの
 *
 * 下記のような出力になる。
 * - `<pre class='var_html'> ～ </pre>` で囲まれる
 * - php 構文なのでハイライトされて表示される
 * - Content-Type が強制的に text/html になる
 *
 * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $value 出力する値
 */
function var_html($value)
{
    $var_export = function ($value) {
        $result = var_export($value, true);
        $result = highlight_string("<?php " . $result, true);
        $result = preg_replace('#&lt;\\?php(\s|&nbsp;)#u', '', $result, 1);
        $result = preg_replace('#<br />#u', "\n", $result);
        $result = preg_replace('#>\n<#u', '><', $result);
        return $result;
    };

    $export = function ($value, $parents) use (&$export, $var_export) {
        foreach ($parents as $parent) {
            if ($parent === $value) {
                return '*RECURSION*';
            }
        }
        if (is_array($value)) {
            $count = count($value);
            if (!$count) {
                return '[empty]';
            }

            $maxlen = max(array_map('strlen', array_keys($value)));
            $kvl = '';
            $parents[] = $value;
            foreach ($value as $k => $v) {
                $align = str_repeat(' ', $maxlen - strlen($k));
                $kvl .= $var_export($k) . $align . ' => ' . $export($v, $parents) . "\n";
            }
            $var = "<var style='text-decoration:underline'>$count elements</var>";
            $summary = "<summary style='cursor:pointer;color:#0a6ebd'>[$var]</summary>";
            return "<details style='display:inline;vertical-align:text-top'>$summary$kvl</details>";
        }
        elseif (is_object($value)) {
            $parents[] = $value;
            return get_class($value) . '::' . $export(get_object_properties($value), $parents);
        }
        elseif (is_null($value)) {
            return 'null';
        }
        elseif (is_resourcable($value)) {
            return ((string) $value) . '(' . get_resource_type($value) . ')';
        }
        else {
            return $var_export($value);
        }
    };

    // text/html を強制する（でないと見やすいどころか見づらくなる）
    // @codeCoverageIgnoreStart
    if (!headers_sent()) {
        header_remove('Content-Type');
        header('Content-Type: text/html');
    }
    // @codeCoverageIgnoreEnd

    echo "<pre class='var_html'>{$export($value, [])}</pre>";
}

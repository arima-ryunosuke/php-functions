<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../info/ansi_strip.php';
require_once __DIR__ . '/../info/is_ansi.php';
require_once __DIR__ . '/../strings/mb_monospace.php';
require_once __DIR__ . '/../var/is_empty.php';
require_once __DIR__ . '/../var/is_stringable.php';
require_once __DIR__ . '/../var/var_pretty.php';
// @codeCoverageIgnoreEnd

/**
 * 連想配列の配列を markdown テーブル文字列にする
 *
 * 見出しはキーの和集合で生成され、改行は `<br>` に置換される。
 * 要素が全て数値の場合は右寄せになる。
 *
 * Example:
 * ```php
 * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
 * that("\n" . markdown_table([
 *    ['a' => 'a1', 'b' => 'b1'],
 *    ['b' => 'b2', 'c' => '2'],
 *    ['a' => 'a3', 'c' => '3'],
 * ]))->is("
 * | a   | b   |   c |
 * | --- | --- | --: |
 * | a1  | b1  |     |
 * |     | b2  |   2 |
 * | a3  |     |   3 |
 * ");
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param array $array 連想配列の配列
 * @param array $option オプション配列
 * @return string markdown テーブル文字列
 */
function markdown_table($array, $option = [])
{
    if (!is_array($array) || is_empty($array)) {
        throw new \InvalidArgumentException('$array must be array of hasharray.');
    }

    $option['keylabel'] ??= null;
    $option['context'] ??= (function () {
        $result = 'html';
        if (PHP_SAPI === 'cli') {
            $result = is_ansi(STDOUT) ? 'cli' : 'plain';
        }
        return $result;
    })();
    $option['stringify'] ??= fn($v) => var_pretty($v, ['return' => true, 'context' => $option['context'], 'table' => false, 'counting' => $option['counting'] ?? true]);

    $stringify = fn($v) => strtr(((is_stringable($v) && !is_null($v) && !is_bool($v) ? $v : $option['stringify']($v)) ?? ''), ["\t" => '    ']);
    $is_numeric = function ($v) {
        $v = trim($v);
        if (strlen($v) === 0) {
            return true;
        }
        if (is_numeric($v)) {
            return true;
        }
        return preg_match('#^-?[1-9][0-9]{0,2}(,[0-9]{3})*(\.[0-9]+)?$#', $v);
    };

    $rows = [];
    $defaults = [];
    $numerics = [];
    $lengths = [];
    foreach ($array as $n => $fields) {
        assert(is_array($fields), '$array must be array of hasharray.');
        if ($option['keylabel'] !== null) {
            $fields = [$option['keylabel'] => $n] + $fields;
        }
        if ($option['context'] === 'html') {
            $fields = array_map(fn($v) => (array) str_replace(["\r\n", "\r", "\n"], '<br>', $stringify($v)), $fields);
        }
        else {
            $fields = array_map(fn($v) => preg_split("#\r?\n#u", $stringify($v)), $fields);
        }
        foreach ($fields as $k => $v) {
            $defaults[$k] = '';
            foreach ($v as $i => $t) {
                $e = ansi_strip($t);
                $rows["{$n}_{$i}"][$k] = $t;
                $numerics[$k] = ($numerics[$k] ?? true) && $is_numeric($e);
                $lengths[$k] = max($lengths[$k] ?? 3, mb_monospace(ansi_strip($k)), mb_monospace($e)); // 3 は markdown の最低見出し長
            }
        }
    }

    $linebuilder = function ($fields, $padstr) use ($numerics, $lengths) {
        $line = [];
        foreach ($fields as $k => $v) {
            $ws = str_repeat($padstr, $lengths[$k] - (mb_monospace(ansi_strip($v))));
            $pad = $numerics[$k] ? "$ws$v" : "$v$ws";
            if ($padstr === '-' && $numerics[$k]) {
                $pad[-1] = ':';
            }
            $line[] = $pad;
        }
        return '| ' . implode(' | ', $line) . ' |';
    };

    $result = [];

    $result[] = $linebuilder(array_combine($keys = array_keys($defaults), $keys), ' ');
    $result[] = $linebuilder($defaults, '-');
    foreach ($rows as $fields) {
        $result[] = $linebuilder(array_replace($defaults, $fields), ' ');
    }

    return implode("\n", $result) . "\n";
}

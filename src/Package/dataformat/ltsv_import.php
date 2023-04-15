<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * LTSV 的文字列を配列に変換する
 *
 * escape オプションで「LTSV 的にまずい文字」がその文字でエスケープされる（具体的には "\n" と "\t"）。
 * デフォルトでは "\\" でエスケープされるので、整合性が崩れることはない。
 *
 * decode オプションで「`` で囲まれた値」が来たときのその関数を通して出力される。
 * デフォルトでは json_decode される。
 *
 * エンコード機能はおまけに過ぎない（大抵の場合はそんな機能は必要ない）。
 * ので、この実装は互換性を維持せず変更される可能性がある。
 *
 * Example:
 * ```php
 * // シンプルな実行例
 * that(ltsv_import("label1:value1	label2:value2"))->is([
 *     "label1" => "value1",
 *     "label2" => "value2",
 * ]);
 *
 * // タブや改行文字のエスケープ
 * that(ltsv_import("label1:val\\tue1	label2:val\\nue2"))->is([
 *     "label1" => "val\tue1",
 *     "label2" => "val\nue2",
 * ]);
 *
 * // 配列のデコード
 * that(ltsv_import("label1:value1	label2:`[1,2,3]`"))->is([
 *     "label1" => "value1",
 *     "label2" => [1, 2, 3],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string $ltsvstring LTSV 的文字列
 * @param array $options オプション配列
 * @return array 配列
 */
function ltsv_import($ltsvstring, $options = [])
{
    $options += [
        'escape' => '\\',
        'decode' => fn($v) => json_decode($v, true),
    ];
    $escape = $options['escape'];
    $decode = $options['decode'];

    $map = [];
    if (strlen($escape)) {
        $map["{$escape}\\"] = "\\";
        $map["{$escape}t"] = "\t";
        $map["{$escape}n"] = "\n";
    }

    $result = [];
    foreach (explode("\t", $ltsvstring) as $part) {
        [$label, $value] = explode(':', $part, 2);
        $should_decode = substr($value, 0, 1) === '`' && substr($value, -1, 1) === '`';
        if ($map) {
            $label = strtr($label, $map);
            if (!$should_decode) {
                $value = strtr($value, $map);
            }
        }
        if ($should_decode) {
            $value2 = $decode(substr($value, 1, -1));
            // たまたま ` が付いているだけかも知れないので結果で判定する
            if (!is_stringable($value2)) {
                $value = $value2;
            }
        }
        $result[$label] = $value;
    }
    return $result;
}

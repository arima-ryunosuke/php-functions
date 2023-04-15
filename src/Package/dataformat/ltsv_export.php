<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * 配列を LTSV 的文字列に変換する
 *
 * ラベル文字列に ":" を含む場合は例外を投げる（ラベルにコロンが来るとどうしようもない）。
 *
 * escape オプションで「LTSV 的にまずい文字」がその文字でエスケープされる（具体的には "\n" と "\t"）。
 * デフォルトでは "\\" でエスケープされるので、整合性が崩れることはない。
 *
 * encode オプションで「文字列化できない値」が来たときのその関数を通して出力される（その場合、目印として値の両サイドに ` が付く）。
 * デフォルトでは json_encode される。
 *
 * エンコード機能はおまけに過ぎない（大抵の場合はそんな機能は必要ない）。
 * ので、この実装は互換性を維持せず変更される可能性がある。
 *
 * Example:
 * ```php
 * // シンプルな実行例
 * that(ltsv_export([
 *     "label1" => "value1",
 *     "label2" => "value2",
 * ]))->is("label1:value1	label2:value2");
 *
 * // タブや改行文字のエスケープ
 * that(ltsv_export([
 *     "label1" => "val\tue1",
 *     "label2" => "val\nue2",
 * ]))->is("label1:val\\tue1	label2:val\\nue2");
 *
 * // 配列のエンコード
 * that(ltsv_export([
 *     "label1" => "value1",
 *     "label2" => [1, 2, 3],
 * ]))->is("label1:value1	label2:`[1,2,3]`");
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param array $ltsvarray 配列
 * @param array $options オプション配列
 * @return string LTSV 的文字列
 */
function ltsv_export($ltsvarray, $options = [])
{
    $options += [
        'escape' => '\\',
        'encode' => fn($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    ];
    $escape = $options['escape'];
    $encode = $options['encode'];

    $map = [];
    if (strlen($escape)) {
        $map["\\"] = "{$escape}\\";
        $map["\t"] = "{$escape}t";
        $map["\n"] = "{$escape}n";
    }

    $parts = [];
    foreach ($ltsvarray as $label => $value) {
        if (strpos($label, ':')) {
            throw new \InvalidArgumentException('label contains ":".');
        }
        $should_encode = !is_stringable($value);
        if ($should_encode) {
            $value = "`{$encode($value)}`";
        }
        if ($map) {
            $label = strtr($label, $map);
            if (!$should_encode) {
                $value = strtr($value, $map);
            }
        }
        $parts[] = $label . ':' . $value;
    }
    return implode("\t", $parts);
}

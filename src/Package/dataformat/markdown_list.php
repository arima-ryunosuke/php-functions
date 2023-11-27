<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列を markdown リスト文字列にする
 *
 * Example:
 * ```php
 * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
 * that("\n" . markdown_list([
 *     'dict'        => [
 *         'Key1' => 'Value1',
 *         'Key2' => 'Value2',
 *     ],
 *     'list'        => ['Item1', 'Item2', 'Item3'],
 *     'dict & list' => [
 *         'Key' => 'Value',
 *         ['Item1', 'Item2', 'Item3'],
 *     ],
 * ], ['separator' => ':']))->is("
 * - dict:
 *     - Key1:Value1
 *     - Key2:Value2
 * - list:
 *     - Item1
 *     - Item2
 *     - Item3
 * - dict & list:
 *     - Key:Value
 *         - Item1
 *         - Item2
 *         - Item3
 * ");
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param array $array 配列
 * @param array $option オプション配列
 * @return string markdown リスト文字列
 */
function markdown_list($array, $option = [])
{
    $option += [
        'indent'    => '    ',
        'separator' => ': ',
        'liststyle' => '-',
        'ordered'   => false,
        'indexed'   => null,
    ];

    $f = function ($array, $nest) use (&$f, $option) {
        $spacer = str_repeat($option['indent'], $nest);
        $result = [];
        $seq = 0;
        foreach ($array as $k => $v) {
            $indexed = $option['indexed'] ?? is_int($k) && $k === $seq++;
            if (is_iterable($v)) {
                if (!$indexed) {
                    $result[] = $spacer . $option['liststyle'] . ' ' . $k . $option['separator'];
                }
                $result = array_merge($result, $f($v, $nest + 1));
            }
            else {
                if (!$indexed) {
                    $result[] = $spacer . $option['liststyle'] . ' ' . $k . $option['separator'] . $v;
                }
                elseif (!$option['ordered']) {
                    $result[] = $spacer . $option['liststyle'] . ' ' . $v;
                }
                else {
                    $result[] = $spacer . $seq . '. ' . $v;
                }
            }
        }
        return $result;
    };
    return implode("\n", $f($array, 0)) . "\n";
}

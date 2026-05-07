<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 出力バッファを全部閉じて配列で返す
 *
 * 閉じられないバッファを検出した場合は例外を投げる（この関数の本懐は「すべて閉じる」なので）。
 * 閉じられないバッファを使うことはそうそうないのであまり問題にならない。
 * というよりバッファの仕様が複雑すぎて追いきれない。
 *
 * https://www.php.net/manual/ja/outcontrol.operations-on-buffers.php
 * > PHP_OUTPUT_HANDLER_CLEANABLE を指定すると、 ob_clean() によってバッファの内容を削除できるようになります。
 * > PHP_OUTPUT_HANDLER_CLEANABLE フラグ を指定していなくても、 ob_end_clean() や ob_get_clean() がバッファの内容を削除できなくなるわけではありません。
 *
 * https://www.php.net/manual/ja/function.ob-get-clean.php
 * > PHP_OUTPUT_HANDLER_REMOVABLE を指定して アクティブな出力バッファを開始しないと、 ob_get_clean() は失敗します。
 *
 * 結局のところ PHP_OUTPUT_HANDLER_REMOVABLE が最も重要で、「閉じる」に関わる処理はこれだけを見ればよい。
 * で、消せないバッファに出くわすとその上位バッファの削除を阻害するので、例外を投げるしか方法が無い。
 * が、トップレベルバッファだけは上位バッファが存在しないし、圧縮バッファのような超特殊なコア機能が多いので例外は投げずにスルーする。
 *
 * @package ryunosuke\Functions\Package\outcontrol
 */
function ob_get_clean_all(): array
{
    $result = [];
    foreach (array_reverse(ob_get_status(true)) as $stat) {
        if ($stat['level'] !== 0 && !($stat['flags'] & PHP_OUTPUT_HANDLER_REMOVABLE)) {
            throw new \UnexpectedValueException('detect no removable output buffer'); // @codeCoverageIgnore
        }
        $result[$stat['level']] = ob_get_clean();
    }
    return $result;
}

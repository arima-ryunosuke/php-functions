<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * エラーハンドラを追加する
 *
 * 追加したエラーハンドラが false を返すと標準のエラーハンドラではなく、直近の設定されていたエラーハンドラに移譲される。
 * （直近にエラーハンドラが設定されていなかったら標準ハンドラになる）。
 *
 * 「局所的にエラーハンドラを変更したいけど特定の状況は設定済みハンドラへ流したい」という状況はまれによくあるはず。
 *
 * Example:
 * ```php
 * // @ 付きなら元々のハンドラに移譲、@ なしなら何らかのハンドリングを行う例
 * add_error_handler(function ($errno) {
 *     if (!(error_reporting() & $errno)) {
 *         // この false はマニュアルにある「この関数が FALSE を返した場合は、通常のエラーハンドラが処理を引き継ぎます」ではなく、
 *         // 「さっきまで設定されていたエラーハンドラが処理を引き継ぎます」という意味になる
 *         return false;
 *     }
 *     // do something
 * });
 * // false の扱いが異なるだけでその他の挙動はすべて set_error_handler と同じなので restore_error_handler で戻せる
 * restore_error_handler();
 * ```
 *
 * @package ryunosuke\Functions\Package\errorfunc
 *
 * @param callable $handler エラーハンドラ
 * @param int $error_types エラータイプ
 * @return callable|null 直近に設定されていたエラーハンドラ（未設定の場合は null）
 */
function add_error_handler($handler, $error_types = \E_ALL | \E_STRICT)
{
    $already = set_error_handler(static function () use ($handler, &$already) {
        $result = $handler(...func_get_args());
        if ($result === false && $already !== null) {
            return $already(...func_get_args());
        }
        return $result;
    }, $error_types);
    return $already;
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * js の console に値を吐き出す
 *
 * script タグではなく X-ChromeLogger-Data を使用する。
 * したがってヘッダ送信前に呼ぶ必要がある。
 *
 * @package ryunosuke\Functions\Package\misc
 * @see https://craig.is/writing/chrome-logger/techspecs
 *
 * @param mixed ...$values 出力する値（可変引数）
 */
function console_log(...$values)
{
    // X-ChromeLogger-Data ヘッダを使うので送信済みの場合は不可
    if (headers_sent($file, $line)) {
        throw new \UnexpectedValueException("header is already sent. $file#$line");
    }

    // データ行（最後だけ書き出すので static で保持する）
    static $rows = [];

    // 最終データを一度だけヘッダで吐き出す（replace を false にしても多重で表示してくれないっぽい）
    if (!$rows && $values) {
        // header_register_callback はグローバルで1度しか登録できないのでライブラリ内部で使うべきではない
        // ob_start にコールバックを渡すと ob_end～ の時に呼ばれるので、擬似的に header_register_callback 的なことができる
        ob_start(function () use (&$rows) {
            $header = base64_encode(mb_convert_encoding(json_encode([
                'version' => '1.0.0',
                'columns' => ['log', 'backtrace', 'type'],
                'rows'    => $rows,
            ]), 'UTF-8', 'ISO-8859-1'));
            header('X-ChromeLogger-Data: ' . $header);
            return false;
        });
    }

    foreach ($values as $value) {
        $rows[] = [[$value], null, 'log'];
    }
}

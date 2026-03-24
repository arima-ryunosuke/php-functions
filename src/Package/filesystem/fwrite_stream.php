<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * fwrite の改善版
 *
 * まず https://www.php.net/manual/ja/function.fwrite.php にはこうある。
 * > ネットワークストリームへの書き込みは、 すべての文字列を書き込み終える前に終了する可能性があります。fwrite() の戻り値を確かめるようにしましょう。
 *
 * 次にユーザーノート（https://www.php.net/manual/ja/function.fwrite.php#96951）にはこうある（長いので抜粋）。
 * > This means the example fwrite_stream() code from the docs, as well as all the "helper" functions posted by others in the comments are all broken. You *must* check for a return value of 0 and either abort immediately or track a maximum number of retries.
 *
 * とどのつまり、ネットワークリソースの場合は length 分書きこむとは限らないし 0 を返し続けることもある。
 * これを避けるために「length 分書けるか、0 が来たらリトライする」としたのがこの関数。
 *
 * @package ryunosuke\Functions\Package\filesystem
 */
function fwrite_stream($stream, string $data, ?int $length = null, ?callable $retry = null): int|false
{
    assert(is_resource($stream));

    $chunk = 8192;

    $length ??= strlen($data);
    $length = min($length, strlen($data));

    $retry ??= fn($try) => $try < 3;

    $written = 0;
    $try = 0;

    while ($written < $length) {
        // 例えば 1GB の文字列で 1byte だけ書き込めた場合、999,999,999 のコピーが発生する
        // とんでもないほど無駄なので、chunk を指定して少しずつ書き込む
        // 逆にファイルストリームで無駄になるが…まぁ内部でも同じことやってるだろうし必要なコストとして無視する
        $limit = min($chunk, $length - $written);
        $result = fwrite($stream, substr($data, $written, $limit));

        // ユーザーノートによれば引数不一致以外では false を返さないらしい（ので常に false 返しで良いはずだが念のため）
        if ($result === false) {
            return ($written > 0) ? $written : false; // @codeCoverageIgnore
        }

        if ($result === 0) {
            if (!$retry(++$try)) {
                // 標準関数に合わせるため例外ではなくエラーとしている
                trigger_error("Failed to write to stream", E_USER_WARNING);
                return false;
            }

            continue;
        }

        $written += $result;
        $try = 0;
    }

    return $written;
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ストリームに文字列を書き込む
 *
 * 基本的に fseek+ftruncate+fwrite するだけのユーティリティ関数。
 * ただし、末尾のヌル文字は発生させない実装となっている。
 * 言い換えれば「指定オフセット以降を指定文字列にする」（その方が実用に近いだろう）。
 *
 * $offset は nullable で、
 * - null: seek しない
 * - 正数: SEEK_SET で seek する
 * - 負数: SEEK_END で seek する
 * という動作になる（要するに正数で先頭から、負数で末尾から、ということ）。
 * その仕様上、「本当に末尾に追加」はできない（言わば -0 だが 0 と区別できない）ので適宜呼び元で設定しておくこと。
 *
 * Example:
 * ```php
 * $fn = tempnam(sys_get_temp_dir(), 'tmp');
 * $fp = fopen($fn, 'w+');
 * // この時点で中身は hogera になる
 * stream_put_contents($fp, 'hogera');
 * that(file_get_contents($fn))->is('hogera');
 * // 4バイト目から書き込むので hogefuga になる（ra が消える）
 * stream_put_contents($fp, 'fuga', 4);
 * that(file_get_contents($fn))->is('hogefuga');
 * // 先頭からより少ない文字を書き込んでも後ろは維持されないし末尾にヌル文字も付かない（piyo になる）
 * stream_put_contents($fp, 'piyo', 0);
 * that(file_get_contents($fn))->is('piyo');
 * ```
 *
 * @package ryunosuke\Functions\Package\stream
 * @return ?int 書き込んだバイト数（失敗時 null）
 */
function stream_put_contents($stream, string $contents, ?int $offset = null): ?int
{
    if ($offset !== null) {
        $whence = $offset >= 0 ? SEEK_SET : SEEK_END;
        if (fseek($stream, $offset, $whence) === -1) {
            return null;
        }
    }

    if (($return = fwrite($stream, $contents)) === false) {
        return null;
    }

    // この辺の返り値は見ない（これらが失敗しようと「書き込んだバイト数」という返り値に変わりはないから。ただ notice くらいは出した方がいいような気もする）
    ftruncate($stream, ftell($stream));
    // 勝手に flush/sync するより呼び元で制御した方が効率がいいだろうのでいったんコメントアウト
    //fflush($stream);
    //fsync($stream);

    return $return;
}

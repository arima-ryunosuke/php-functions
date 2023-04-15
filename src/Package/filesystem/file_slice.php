<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * file の行範囲を指定できる板
 *
 * 原則 file をベースに作成しているが、一部独自仕様がある。
 *
 * - 結果配列は行番号がキーになる
 *   - あくまで行番号なので 1 オリジン
 *   - スキップされた行は歯抜けになる
 * - FILE_SKIP_EMPTY_LINES の動作が FILE_IGNORE_NEW_LINES ありきではない
 *   - file における FILE_SKIP_EMPTY_LINES の単独指定は意味を成さないっぽい
 *     - FILE_IGNORE_NEW_LINES しないと空文字ではなく改行文字が含まれるので空判定にならないようだ
 *   - この関数はその動作を撤廃しており、単独で FILE_SKIP_EMPTY_LINES を指定しても空行が飛ばされる動作になっている
 * - $end_line に負数を指定すると行番号の直指定となる
 *   - `file_slice($filename, 120, -150)` で 120行目から150行目までを読む
 *   - 負数なのは気持ち悪いが、範囲指定のハイフン（120-150）だと思えば割と自然
 *
 * 使用用途としては
 *
 * 1. 巨大ファイルの前半だけ読みたい
 * 2. 1行だけサクッと読みたい
 *
 * が挙げられる。
 *
 * 1 は自明（file は全行読む）だが、終端付近を読む場合は file の方が若干速い。
 * ただし、期待値としてはこの関数の方が格段に低い（file は下手すると何十倍も遅い）。
 *
 * 2 は典型的には「1行目だけ読みたい」場合、fopen+fgets+fclose(finally)という手順を踏む必要があり煩雑になる。
 * この関数を使えばサクッと取得することができる。
 *
 * Example:
 * ```php
 * // 適当にファイルを用意（奇数行は行番号、偶数行は空行）
 * $testpath = sys_get_temp_dir() . '/file_slice.txt';
 * file_put_contents($testpath, implode("\n", array_map(fn($n) => $n % 2 ? $n : "", range(1, 20))));
 * // 3行目から4行を返す
 * that(file_slice($testpath, 3, 4))->is([
 *     3 => "3\n",
 *     4 => "\n",
 *     5 => "5\n",
 *     6 => "\n",
 * ]);
 * // 3行目から6行目までを返す
 * that(file_slice($testpath, 3, -6))->is([
 *     3 => "3\n",
 *     4 => "\n",
 *     5 => "5\n",
 *     6 => "\n",
 * ]);
 * // 改行文字や空行を含めない（キーは保持される）
 * that(file_slice($testpath, 3, 4, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))->is([
 *     3 => "3",
 *     5 => "5",
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename ファイル名
 * @param int $start_line 開始行。1 オリジン
 * @param ?int $length 終了行。null を指定すると最後まで読む。負数にすると行番号直指定になる
 * @param int $flags file と同じフラグ定数（FILE_IGNORE_NEW_LINES, etc）
 * @param ?resource $context file と同じ context 指定
 * @return array 部分行
 */
function file_slice($filename, $start_line = 1, $length = null, $flags = 0, $context = null)
{
    $FILE_USE_INCLUDE_PATH = !!($flags & FILE_USE_INCLUDE_PATH);
    $FILE_IGNORE_NEW_LINES = !!($flags & FILE_IGNORE_NEW_LINES);
    $FILE_SKIP_EMPTY_LINES = !!($flags & FILE_SKIP_EMPTY_LINES);

    assert($start_line > 0, '$start_line must be positive number. because it means line number.');

    if ($length === null) {
        $end_line = null;
    }
    elseif ($length > 0) {
        $end_line = $start_line + $length;
    }
    elseif ($length < 0) {
        $end_line = -$length + 1;
    }

    $fp = fopen($filename, 'r', $FILE_USE_INCLUDE_PATH, $context);
    try {
        $result = [];
        for ($i = 1; ($line = fgets($fp)) !== false; $i++) {
            if (isset($end_line) && $i >= $end_line) {
                break;
            }
            if ($i >= $start_line) {
                if ($FILE_IGNORE_NEW_LINES) {
                    $line = rtrim($line);
                }
                if ($FILE_SKIP_EMPTY_LINES && trim($line) === '') {
                    continue;
                }
                $result[$i] = $line;
            }
        }
        return $result;
    }
    finally {
        fclose($fp);
    }
}

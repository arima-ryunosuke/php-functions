<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../funchand/call_safely.php';
require_once __DIR__ . '/../strings/starts_with.php';
require_once __DIR__ . '/../strings/str_array.php';
// @codeCoverageIgnoreEnd

/**
 * 連想配列の配列を CSV 的文字列に変換する
 *
 * CSV ヘッダ行は全連想配列のキーの共通項となる。
 * 順番には依存しないが、余計な要素があってもそのキーはヘッダには追加されないし、データ行にも含まれない。
 * ただし、オプションで headers が与えられた場合はそれを使用する。
 * この headers オプションに連想配列を与えるとヘッダ文字列変換になる（[key => header] で「key を header で吐き出し」となる）。
 * 数値配列を与えると単純に順序指定での出力指定になるが、ヘッダ行が出力されなくなる。
 *
 * callback オプションが渡された場合は「あらゆる処理の最初」にコールされる。
 * つまりヘッダの読み換えや文字エンコーディングの変換が行われる前の状態でコールされる。
 * また、 false を返すとその要素はスルーされる。
 *
 * output オプションにリソースを渡すとそこに対して書き込みが行われる（fclose はされない）。
 *
 * Example:
 * ```php
 * // シンプルな実行例
 * $csvarrays = [
 *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],             // 普通の行
 *     ['c' => 'C2', 'a' => 'A2', 'b' => 'B2'],             // 順番が入れ替わっている行
 *     ['c' => 'C3', 'a' => 'A3', 'b' => 'B3', 'x' => 'X'], // 余計な要素が入っている行
 * ];
 * that(csv_export($csvarrays))->is("a,b,c
 * A1,B1,C1
 * A2,B2,C2
 * A3,B3,C3
 * ");
 *
 * // ヘッダを指定できる
 * that(csv_export($csvarrays, [
 *     'headers' => ['a' => 'A', 'c' => 'C'], // a と c だけを出力＋ヘッダ文字変更
 * ]))->is("A,C
 * A1,C1
 * A2,C2
 * A3,C3
 * ");
 *
 * // ヘッダ行を出さない
 * that(csv_export($csvarrays, [
 *     'headers' => ['a', 'c'], // a と c だけを出力＋ヘッダ行なし
 * ]))->is("A1,C1
 * A2,C2
 * A3,C3
 * ");
 *
 * // structure:true で配列も扱える
 * that(csv_export([
 *     ['scalar' => '123', 'list' => ['list11', 'list12'], 'hash' => ['a' => 'hash1A', 'b' => 'hash1B']],
 *     ['scalar' => '456', 'list' => ['list21', 'list22'], 'hash' => ['a' => 'hash2A', 'b' => 'hash2B']],
 * ], [
 *     'structure' => true,
 * ]))->is("scalar,list[],list[],hash[a],hash[b]
 * 123,list11,list12,hash1A,hash1B
 * 456,list21,list22,hash2A,hash2B
 * ");
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param array $csvarrays 連想配列の配列
 * @param array $options オプション配列。fputcsv の第3引数以降もここで指定する
 * @return string|int CSV 的文字列。output オプションを渡した場合は書き込みバイト数
 */
function csv_export($csvarrays, $options = [])
{
    $options += [
        'delimiter' => ',',
        'enclosure' => '"',
        'escape'    => '\\',
        'encoding'  => mb_internal_encoding(),
        'headers'   => null,
        'structure' => false,
        'callback'  => null, // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
        'output'    => null,
    ];

    $output = $options['output'];

    if ($output) {
        $fp = $options['output'];
    }
    else {
        $fp = fopen('php://temp', 'rw+');
    }
    try {
        $size = call_safely(function ($fp, $csvarrays, $delimiter, $enclosure, $escape, $encoding, $headers, $structure, $callback) {
            $size = 0;
            $mb_internal_encoding = mb_internal_encoding();
            if ($structure) {
                foreach ($csvarrays as $n => $array) {
                    $query = strtr(http_build_query($array, ''), ['%5B' => '[', '%5D' => ']']);
                    $csvarrays[$n] = array_map('rawurldecode', str_array(explode('&', $query), '=', true));
                }
            }
            if (!$headers) {
                $tmp = [];
                foreach ($csvarrays as $array) {
                    // この関数は積集合のヘッダを出すと定義してるが、構造化の場合は和集合で出す
                    if ($structure) {
                        $tmp += $array;
                    }
                    else {
                        $tmp = array_intersect_key($tmp ?: $array, $array);
                    }
                }
                $keys = array_keys($tmp);
                if ($structure) {
                    $tmp = [];
                    for ($i = 0, $l = count($keys); $i < $l; $i++) {
                        $key = $keys[$i];
                        if (isset($tmp[$key])) {
                            continue;
                        }
                        $tmp[$key] = true;
                        $p = strrpos($key, '[');
                        if ($p !== false) {
                            $plain = substr($key, 0, $p + 1);
                            for ($j = $i + 1; $j < $l; $j++) {
                                if (starts_with($keys[$j], $plain)) {
                                    $tmp[$keys[$j]] = true;
                                }
                            }
                        }
                    }
                    $keys = array_keys($tmp);
                }
                $headers = is_array($headers) ? $keys : array_combine($keys, $keys);
            }
            if (!is_hasharray($headers)) {
                $headers = array_combine($headers, $headers);
            }
            else {
                $headerline = $headers;
                if ($encoding !== $mb_internal_encoding) {
                    mb_convert_variables($encoding, $mb_internal_encoding, $headerline);
                }
                if ($structure) {
                    $headerline = array_map(fn($header) => preg_replace('#\[\d+]$#imu', '[]', $header), $headerline);
                }
                $size += fputcsv($fp, $headerline, $delimiter, $enclosure, $escape);
            }
            $default = array_fill_keys(array_keys($headers), '');

            foreach ($csvarrays as $n => $array) {
                if ($callback) {
                    if ($callback($array, $n) === false) {
                        continue;
                    }
                }
                $row = array_intersect_key(array_replace($default, $array), $default);
                if ($encoding !== $mb_internal_encoding) {
                    mb_convert_variables($encoding, $mb_internal_encoding, $row);
                }
                $size += fputcsv($fp, $row, $delimiter, $enclosure, $escape);
            }
            return $size;
        }, $fp, $csvarrays, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['structure'], $options['callback']);
        if ($output) {
            return $size;
        }
        rewind($fp);
        return stream_get_contents($fp);
    }
    finally {
        if (!$output) {
            fclose($fp);
        }
    }
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../errorfunc/set_error_exception_handler.php';
require_once __DIR__ . '/../iterator/iterator_join.php';
require_once __DIR__ . '/../iterator/iterator_map.php';
require_once __DIR__ . '/../iterator/iterator_split.php';
require_once __DIR__ . '/../strings/mb_monospace.php';
require_once __DIR__ . '/../strings/starts_with.php';
require_once __DIR__ . '/../strings/str_array.php';
require_once __DIR__ . '/../strings/str_putcsv.php';
require_once __DIR__ . '/../var/is_stringable.php';
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
 * @param iterable $csvarrays 連想配列の配列
 * @param array $options オプション配列。fputcsv の第3引数以降もここで指定する
 * @return \Generator|string|int CSV 的文字列。output オプションを渡した場合は書き込みバイト数
 */
function csv_export($csvarrays, $options = [])
{
    $options += [
        'delimiter' => ',',
        'enclosure' => '"',
        'escape'    => '\\',
        'encoding'  => ini_get('default_charset'),
        'scrub'     => 'TRANSLIT',
        'null'      => "",
        'initial'   => '', // "\xEF\xBB\xBF"
        'headers'   => null,
        'structure' => false,
        'align'     => null,
        'callback'  => null, // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
        'output'    => null,
        'generator' => false,
    ];

    $positions = [];
    $str_putcsv = function ($array, $delimiter, $enclosure, $escape, $eol, $encoding, $null, $align) use (&$positions) {
        if (strlen($null)) {
            foreach ($array as $k => $v) {
                if ($v === null) {
                    $array[$k] = $null;
                }
            }
        }

        if ($align) {
            $fields = [];
            $position = 0;

            $array = array_values(array_map(function ($value) use ($delimiter, $enclosure, $escape, $encoding, $null) {
                $value = str_putcsv([$value], $delimiter, $enclosure, $escape);

                $lines = preg_split('@\\r\\n|\\n@u', $value);
                $first = $lines[array_key_first($lines)];
                $last = $lines[array_key_last($lines)];

                return [$value, $lines, $first, $last];
            }, $array));

            $column = 0;
            foreach ($array as $i => [$value, $lines, $first, $last]) {
                $delimiter_length = $column * strlen($delimiter);
                $padding_length = ($positions[$i] ?? 0) - $position - $delimiter_length;
                if ($padding_length > 0) {
                    if (($value[0] ?? '') !== '"') {
                        $value = '"' . $value . '"';
                    }
                    $value = str_repeat(' ', min($align, $padding_length)) . $value;
                }
                $fields[] = $value;

                $positions[$i] = max($positions[$i] ?? 0, $position + $delimiter_length);
                if (count($lines) > 1) {
                    $position = mb_monospace($last, [], $encoding);
                    $column = 0;
                }
                else {
                    $position += mb_monospace($value, [], $encoding);
                }
                $column++;
            }

            return implode($delimiter, $fields) . $eol;
        }

        return str_putcsv($array, $delimiter, $enclosure, $escape) . $eol;
    };

    $restore = set_error_exception_handler();
    try {
        $generate = function ($csvarrays, $delimiter, $enclosure, $escape, $encoding, $null, $initial, $headers, $structure, $align, $callback) use ($str_putcsv) {
            $eol = "\n"; // いつの間にか $eol 引数が生えていたがこの関数自体の対応はしていないので暫定で決め打ちにしてある

            if (!is_array($csvarrays)) {
                [$csvarrays, $csvarrays2] = iterator_split($csvarrays, [1], true);
            }

            if ($structure) {
                foreach ($csvarrays as $n => $array) {
                    $query = strtr(http_build_query($array, ''), ['%5B' => '[', '%5D' => ']']);
                    $csvarrays[$n] = array_map('rawurldecode', str_array(explode('&', $query), '=', true));
                }
            }
            if (is_stringable($initial) && strlen($initial)) {
                yield $initial;
            }
            elseif (is_array($initial) && $initial) {
                yield $str_putcsv($initial, $delimiter, $enclosure, $escape, $eol, $encoding, $null, $align);
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
                if ($callback) {
                    if ($callback($headers, null) === false) {
                        goto BODY;
                    }
                }

                $headerline = $headers;
                if ($structure) {
                    $headerline = array_map(fn($header) => preg_replace('#\[\d+]$#imu', '[]', $header), $headerline);
                }
                yield $str_putcsv($headerline, $delimiter, $enclosure, $escape, $eol, $encoding, $null, $align);
            }

            BODY:

            $default = array_fill_keys(array_keys($headers), '');

            if (isset($csvarrays2)) {
                $csvarrays = iterator_join([$csvarrays, $csvarrays2]);
            }

            foreach ($csvarrays as $n => $array) {
                if ($callback) {
                    if ($callback($array, $n) === false) {
                        continue;
                    }
                }
                $row = array_intersect_key(array_replace($default, $array), $default);
                yield $str_putcsv($row, $delimiter, $enclosure, $escape, $eol, $encoding, $null, $align);
            }
        };

        $generator = $generate($csvarrays, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['null'], $options['initial'], $options['headers'], $options['structure'], $options['align'], $options['callback']);

        $default_charset = ini_get('default_charset');

        if ($options['generator']) {
            if ($default_charset !== $options['encoding']) {
                $generator = iterator_map(function ($fields) use ($options, $default_charset) {
                    mb_convert_variables($options['encoding'], $default_charset, $fields);
                    return $fields;
                }, $generator);
            }
            return $generator;
        }

        if ($options['output']) {
            $fp = $options['output'];
        }
        else {
            $fp = fopen('php://temp', 'rw+');
        }

        if ($default_charset !== $options['encoding']) {
            // import とは違い、吐き出すときは明確なエラーだろうので TRANSLIT も IGNORE もしない
            stream_filter_append($fp, "convert.iconv.$default_charset/{$options['encoding']}" . (strlen($options['scrub']) ? "//{$options['scrub']}" : ""), STREAM_FILTER_WRITE);
        }

        $size = 0;
        foreach ($generator as $fields) {
            $size += fwrite($fp, $fields);
        }

        if ($options['output']) {
            return $size;
        }
        rewind($fp);
        return stream_get_contents($fp);
    }
    finally {
        $restore();
        if (!$options['output'] && isset($fp)) {
            fclose($fp);
        }
    }
}

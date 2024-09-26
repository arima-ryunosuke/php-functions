<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_flatten.php';
require_once __DIR__ . '/../array/array_map_recursive.php';
require_once __DIR__ . '/../array/array_pickup.php';
require_once __DIR__ . '/../array/is_indexarray.php';
require_once __DIR__ . '/../funchand/call_safely.php';
require_once __DIR__ . '/../url/parse_query.php';
// @codeCoverageIgnoreEnd

/**
 * CSV 的文字列を連想配列の配列に変換する
 *
 * 1行目をヘッダ文字列とみなしてそれをキーとした連想配列の配列を返す。
 * ただし、オプションで headers が与えられた場合はそれを使用する。
 * この headers オプションはヘッダフィルタも兼ねる（[n => header] で「n 番目フィールドを header で取り込み」となる）。
 * 入力にヘッダがありかつ headers に連想配列が渡された場合はフィルタ兼読み換えとなる（Example を参照）。
 *
 * structure オプションが渡された場合は query like なヘッダーで配列になる。
 *
 * callback オプションが渡された場合は「あらゆる処理の最後」にコールされる。
 * つまりヘッダの読み換えや文字エンコーディングの変換が行われた後の状態でコールされる。
 * また、 false を返すとその要素はスルーされる。
 *
 * メモリ効率は意識しない（どうせ配列を返すので意識しても無駄）。
 *
 * Example:
 * ```php
 * // シンプルな実行例
 * that(csv_import("
 * a,b,c
 * A1,B1,C1
 * A2,B2,C2
 * A3,B3,C3
 * "))->is([
 *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],
 *     ['a' => 'A2', 'b' => 'B2', 'c' => 'C2'],
 *     ['a' => 'A3', 'b' => 'B3', 'c' => 'C3'],
 * ]);
 *
 * // ヘッダを指定できる
 * that(csv_import("
 * A1,B1,C1
 * A2,B2,C2
 * A3,B3,C3
 * ", [
 *     'headers' => [0 => 'a', 2 => 'c'], // 1がないので1番目のフィールドを読み飛ばしつつ、0, 2 は "a", "c" として取り込む
 * ]))->is([
 *     ['a' => 'A1', 'c' => 'C1'],
 *     ['a' => 'A2', 'c' => 'C2'],
 *     ['a' => 'A3', 'c' => 'C3'],
 * ]);
 *
 * // ヘッダありで連想配列で指定するとキーの読み換えとなる（指定しなければ読み飛ばしも行える）
 * that(csv_import("
 * a,b,c
 * A1,B1,C1
 * A2,B2,C2
 * A3,B3,C3
 * ", [
 *     'headers' => ['a' => 'hoge', 'c' => 'piyo'], // a は hoge, c は piyo で読み込む。 b は指定がないので飛ばされる
 * ]))->is([
 *     ['hoge' => 'A1', 'piyo' => 'C1'],
 *     ['hoge' => 'A2', 'piyo' => 'C2'],
 *     ['hoge' => 'A3', 'piyo' => 'C3'],
 * ]);
 *
 * // structure:true で配列も扱える
 * that(csv_import("
 * scalar,list[],list[],hash[a],hash[b]
 * 123,list11,list12,hash1A,hash1B
 * 456,list21,list22,hash2A,hash2B
 * ", [
 *     'structure' => true,
 * ]))->is([
 *     ['scalar' => '123', 'list' => ['list11', 'list12'], 'hash' => ['a' => 'hash1A', 'b' => 'hash1B']],
 *     ['scalar' => '456', 'list' => ['list21', 'list22'], 'hash' => ['a' => 'hash2A', 'b' => 'hash2B']],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string|resource $csvstring CSV 的文字列。ファイルポインタでも良いが終了後に必ず閉じられる
 * @param array $options オプション配列。fgetcsv の第3引数以降もここで指定する
 * @return array 連想配列の配列
 */
function csv_import($csvstring, $options = [])
{
    $options += [
        'delimiter' => ',',
        'enclosure' => '"',
        'escape'    => '\\',
        'encoding'  => ini_get('default_charset'),
        'initial'   => [],
        'headers'   => [],
        'headermap' => null,
        'structure' => false,
        'grouping'  => null,
        'callback'  => null, // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
    ];

    // 文字キーを含む場合はヘッダーありの読み換えとなる
    if (is_array($options['headers']) && count(array_filter(array_keys($options['headers']), 'is_string')) > 0) {
        $options['headermap'] = $options['headers'];
        $options['headers'] = null;
    }

    if (is_resource($csvstring)) {
        $fp = $csvstring;
    }
    else {
        $fp = fopen('php://temp', 'r+b');
        fwrite($fp, $csvstring);
        rewind($fp);
    }

    try {
        return call_safely(function ($fp, $delimiter, $enclosure, $escape, $encoding, $initial, $headers, $headermap, $structure, $grouping, $callback) {
            $default_charset = ini_get('default_charset');
            if ($default_charset !== $encoding) {
                // https://www.php.net/manual/ja/function.iconv.php
                // > TRANSLIT が機能したとしたら、 どう動くかはシステムの iconv() の実装 (ICONV_IMPL を参照) に依存します。
                // > 実装によっては、//TRANSLIT を無視することが知られています。
                // > よって、to_encoding において無効な文字に対しては、 変換処理は失敗するかもしれません。
                // とのことで失敗すると feof は true になり fgetcsv は false を返すようになり ftell も進まない
                // となると変換失敗したことを知る術がなく、全てを捨てざるを得ない
                // ので IGNORE にしている（エラーを検知しつつも処理は継続させるのが理想だったけど…）
                stream_filter_append($fp, "convert.iconv.$encoding/$default_charset//IGNORE", STREAM_FILTER_READ);
            }

            foreach ($initial as $rule => $count) {
                for ($i = 0; $i < $count; $i++) {
                    if ($rule === 'byte') {
                        fgetc($fp);
                    }
                    elseif ($rule === 'line') {
                        fgets($fp);
                    }
                    elseif ($rule === 'csv') {
                        fgetcsv($fp, 0, $delimiter, $enclosure, $escape);
                    }
                }
            }

            $result = [];
            $n = -1;
            while ($row = fgetcsv($fp, 0, $delimiter, $enclosure, $escape)) {
                if ($row === [null]) {
                    continue;
                }
                if (!$headers) {
                    $headers = $row;
                    continue;
                }

                $n++;
                if ($structure) {
                    $query = [];
                    foreach ($headers as $i => $header) {
                        $query[] = rawurlencode($header) . "=" . rawurlencode($row[$i]);
                    }
                    $row = parse_query(implode('&', $query), '&', PHP_QUERY_RFC3986);
                    // csv の仕様上、空文字を置かざるを得ないが、数値配列の場合は空にしたいことがある
                    $row = array_map_recursive($row, function ($v) {
                        if (is_array($v) && is_indexarray($v)) {
                            return array_values(array_filter($v, function ($v) {
                                if (is_array($v)) {
                                    $v = implode('', array_flatten($v));
                                }
                                return strlen($v);
                            }));
                        }
                        return $v;
                    }, true, true);
                }
                else {
                    $row = array_combine($headers, array_intersect_key($row, $headers));
                }
                if ($headermap) {
                    $row = array_pickup($row, $headermap);
                }
                if ($callback) {
                    if ($callback($row, $n) === false) {
                        continue;
                    }
                }

                if ($grouping !== null) {
                    foreach ($row as $column => $value) {
                        $parts = explode($grouping, $column, 2);
                        if (count($parts) === 1) {
                            array_unshift($parts, "");
                        }
                        $result[$parts[0]][$n][$parts[1]] = $value;
                    }
                }
                else {
                    $result[] = $row;
                }
            }

            if ($grouping !== null) {
                foreach ($result as $g => $rows) {
                    $result[$g] = array_values(array_unique($rows, SORT_REGULAR));
                }
            }

            return $result;
        }, $fp, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['initial'], $options['headers'], $options['headermap'], $options['structure'], $options['grouping'], $options['callback']);
    }
    finally {
        fclose($fp);
    }
}

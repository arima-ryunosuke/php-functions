<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_pickup.php';
require_once __DIR__ . '/../array/is_indexarray.php';
require_once __DIR__ . '/../errorfunc/set_error_exception_handler.php';
require_once __DIR__ . '/../filesystem/tmpname.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * XML SpreadSheet 的文字列を連想配列の配列に変換する
 *
 * 厳密な形式チェックは特に行わないが、xml としての体裁や最低限 Workbook/Worksheet だけはチェックされる。
 *
 * Example:
 * ```php
 * // このような xml を読み込ませると
 * $rows = xmlss_import(<<<XMLSS
 * <?xml version="1.0"?>
 * <?mso-application progid="Excel.Sheet"?>
 * <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">
 *  <Worksheet ss:Name="Sheet1">
 *   <Table ss:ExpandedColumnCount="3">
 *    <Row>
 *     <Cell><Data ss:Type="String">id</Data></Cell>
 *     <Cell><Data ss:Type="String">name</Data></Cell>
 *     <Cell><Data ss:Type="String">flag</Data></Cell>
 *    </Row>
 *    <Row>
 *     <Cell><Data ss:Type="Number">1</Data></Cell>
 *     <Cell><Data ss:Type="String">hoge</Data></Cell>
 *     <Cell><Data ss:Type="Boolean">1</Data></Cell>
 *    </Row>
 *    <Row>
 *     <Cell><Data ss:Type="Number">2</Data></Cell>
 *     <Cell><Data ss:Type="String">fuga</Data></Cell>
 *     <Cell><Data ss:Type="Boolean">1</Data></Cell>
 *    </Row>
 *    <Row>
 *     <Cell><Data ss:Type="Number">3</Data></Cell>
 *     <Cell><Data ss:Type="String">piyo</Data></Cell>
 *     <Cell><Data ss:Type="Boolean"></Data></Cell>
 *    </Row>
 *   </Table>
 *  </Worksheet>
 * </Workbook>
 * XMLSS, [
 *     'method' => 'sax',
 * ]);
 * // このような配列を返す
 * that($rows)->is([
 *     ['id' => 1, 'name' => 'hoge', 'flag' => true],
 *     ['id' => 2, 'name' => 'fuga', 'flag' => true],
 *     ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ]);
 *  ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string|resource $xmlssstring XML SpreadSheet 的文字列。ファイルポインタでも良い
 * @param array $options オプション配列
 * @return array|iterable 連想配列の配列
 */
function xmlss_import($xmlssstring, array $options = [])
{
    $options += [
        'generate' => false, // true にすると Generator で返す
        'method'   => 'sax', // 'dom' | 'sax'
        'libxml'   => LIBXML_BIGLINES | LIBXML_COMPACT, // libxml の open 定数
        'strict'   => false, // 厳密モード（false の方がやや高速に動くが変なデータに出くわしたときにおかしなことになる可能性がある）
        'sheet'    => null,  // 読み込むシート名 or シート番号（0 ベース）（未指定時は最初のシート）
        'initial'  => 0,     // 読み飛ばす最初の行数
        'headers'  => null,  // ヘッダーマップ（CSV と同じ）
        'callback' => null,  // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
        'type'     => function ($type, $value) {
            // 実質的に DateTime 専用で DateTime を使わないなら指定する意味は全くない
            switch ($type) {
                case 'String':
                    return $value;
                case 'Boolean':
                    return (bool) $value;
                case 'Number':
                    return +$value;
                case 'DateTime':
                    return new (function_configure('datetime.class'))($value);
                default:
                    throw new \UnexpectedValueException('Unknown type: ' . $type); // @codeCoverageIgnore
            }
        },
        'limit'    => null,  // 正味のデータ行の最大値（超えた場合はそこで処理を終了する。例外が飛んだりはしない）
    ];

    // dom: 平均的には速いが、バカでかい xml の場合に全部読むことになるのでメモリ効率が悪いし速度も落ちる
    // sax: 平均的には遅いが、バカでかい xml の場合でも現実的なメモリで実行できるし範囲が狭いなら速度も上がる
    // もっとも、基本的には sax の方が優れており dom は php<8.4 未満でリソースを扱いたい時くらいしか出番がない（ので将来的に削除するかも）

    $methods = [
        'dom' => function ($xmlssstring) use ($options) {
            if (is_resource($xmlssstring)) {
                $xmlssstring = stream_get_contents($xmlssstring);
            }
            $document = new \DOMDocument();
            $document->loadXML($xmlssstring, $options['libxml']);

            $workbook = $document->getElementsByTagName('Workbook')[0];
            $worksheets = $workbook->getElementsByTagName('Worksheet');
            if ($worksheets->length === 0) {
                throw new \UnexpectedValueException('Worksheet is not found');
            }

            foreach ($worksheets as $i => $sheet) {
                if ($options['sheet'] === null || $options['sheet'] === $i || $options['sheet'] === $sheet->getAttribute('ss:Name')) {
                    $table = $sheet->getElementsByTagName('Table')[0];
                    $rowCount = $table->getAttribute('ss:ExpandedRowCount');
                    $rowCount = strlen($rowCount) ? +$rowCount : null;
                    $colCount = $table->getAttribute('ss:ExpandedColumnCount');
                    $colCount = strlen($colCount) ? +$colCount : null;
                    // getElementsByTagName した NodeList を foreach で回すと尋常じゃなく遅い（文字通りの List で毎回先頭から辿ってる？）
                    //$rows = $table->getElementsByTagName('Row');
                    $n = 0;
                    foreach ($table->childNodes as $row) {
                        if ($row->nodeName !== 'Row') {
                            continue;
                        }
                        // <Row> が終わればそれで十分で RowCount を見る必要はないがデータ行より少なく設定されている xml があるかもしれないので念のため見る
                        if ($rowCount !== null && $n++ >= $rowCount) {
                            break; // @codeCoverageIgnore
                        }

                        $tuple = array_pad([], $colCount, null);
                        foreach ($row->getElementsByTagName('Cell') as $c => $cell) {
                            $data = $cell->getElementsByTagName('Data')[0];
                            $ssIndex = $cell->getAttribute('ss:Index');
                            $col = strlen($ssIndex) ? $ssIndex - 1 : $c;
                            $ssType = $data->getAttribute('ss:Type');
                            $tuple[$col] = $options['type']($ssType, $data->textContent);
                        }

                        yield $tuple;
                    }
                    break;
                }
            }
        },
        'sax' => function ($xmlssstring) use ($options) {
            // <8.4 だと無駄極まりないが対応していない以上どうしようもない
            // xml_parser なら <8.4 でも対応できるけどあれはインターフェースがややこしすぎるので使いたくない
            if (is_resource($xmlssstring)) {
                if (version_compare(PHP_VERSION, '8.4') >= 0) {
                    /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                    $reader = \XMLReader::fromStream($xmlssstring, null, $options['libxml']); // @codeCoverageIgnore
                }
                else {
                    // ただかなり効率が悪くなるのでファイルの場合は小細工する
                    $meta = stream_get_meta_data($xmlssstring);
                    if ($meta['stream_type'] === 'STDIO' && ftell($xmlssstring) === 0) {
                        $reader = new \XMLReader();
                        $reader->open($meta['uri'], null, $options['libxml']);
                    }
                    else {
                        $tmpname = tmpname();
                        stream_copy_to_stream($xmlssstring, fopen($tmpname, 'w'));
                        $reader = new \XMLReader();
                        $reader->open($tmpname, null, $options['libxml']);
                    }
                }
            }
            else {
                if (version_compare(PHP_VERSION, '8.4') >= 0) {
                    /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                    $reader = \XMLReader::fromString($xmlssstring); // @codeCoverageIgnore
                }
                else {
                    $tmpname = tmpname();
                    file_put_contents($tmpname, $xmlssstring);
                    $reader = new \XMLReader();
                    $reader->open($tmpname, null, $options['libxml']);
                }
            }

            $sheetNo = 0;
            $inSheet = false;
            $parents = [];
            $tuple = null;
            $context = null;
            while ($reader->read()) {
                if ($reader->nodeType === \XMLReader::ELEMENT) {
                    if ($reader->localName === 'Worksheet' && (!$options['strict'] || $parents === ['Workbook'])) {
                        if ($options['sheet'] === null || $options['sheet'] === $sheetNo || $options['sheet'] === $reader->getAttribute('ss:Name')) {
                            $inSheet = true;
                        }
                        $sheetNo++;
                    }

                    if ($inSheet) {
                        if ($reader->localName === 'Table' && (!$options['strict'] || $parents === ['Workbook', 'Worksheet'])) {
                            $rowCount = $reader->getAttribute('ss:ExpandedRowCount');
                            $colCount = $reader->getAttribute('ss:ExpandedColumnCount');
                            $context = (object) [
                                'rowIndex' => 0,
                                'colIndex' => 0,
                                'rowCount' => $rowCount !== null ? +$rowCount : null,
                                'colCount' => $colCount !== null ? +$colCount : null,
                            ];
                        }
                        if ($reader->localName === 'Row' && (!$options['strict'] || $parents === ['Workbook', 'Worksheet', 'Table'])) {
                            // <Row> が終わればそれで十分で RowCount を見る必要はないがデータ行より少なく設定されている xml があるかもしれないので念のため見る
                            if ($context->rowCount !== null && $context->rowIndex++ >= $context->rowCount) {
                                break; // @codeCoverageIgnore
                            }

                            $context->colIndex = 0;
                            $tuple = array_pad([], $context->colCount, null);
                        }
                        if ($reader->localName === 'Cell' && (!$options['strict'] || $parents === ['Workbook', 'Worksheet', 'Table', 'Row'])) {
                            $ssIndex = $reader->getAttribute('ss:Index') ?? '';
                            $context->col = strlen($ssIndex) ? $ssIndex - 1 : $context->colIndex;
                            $context->colIndex++;
                        }
                        if ($reader->localName === 'Data' && (!$options['strict'] || $parents === ['Workbook', 'Worksheet', 'Table', 'Row', 'Cell'])) {
                            $ssType = $reader->getAttribute('ss:Type');
                            $tuple[$context->col] = $options['type']($ssType, $reader->readString());
                        }
                    }

                    // 空タグは END_ELEMENT が呼ばれない
                    if ($options['strict'] && !$reader->isEmptyElement) {
                        $parents[] = $reader->localName;
                    }
                }

                if ($reader->nodeType === \XMLReader::END_ELEMENT) {
                    if ($options['strict']) {
                        array_pop($parents);
                    }

                    if ($reader->localName === 'Worksheet' && (!$options['strict'] || $parents === ['Workbook'])) {
                        if ($inSheet) {
                            break;
                        }
                    }

                    if ($inSheet) {
                        if ($reader->localName === 'Row' && (!$options['strict'] || $parents === ['Workbook', 'Worksheet', 'Table'])) {
                            yield $tuple;
                        }
                    }
                }
            }

            if ($inSheet === false) {
                throw new \UnexpectedValueException('Worksheet is not found');
            }

            $reader->close();
        },
    ];

    $restore = set_error_exception_handler();
    try {
        $generator = (function () use ($methods, $options, $xmlssstring) {
            $mapping = false;
            if (is_array($options['headers'])) {
                if (is_indexarray($options['headers'])) {
                    $headers = $options['headers'];
                }
                else {
                    $mapping = true;
                }
            }

            $count = 0;
            foreach ($methods[$options['method']]($xmlssstring) as $n => $row) {
                if ($n < $options['initial']) {
                    continue;
                }

                if (!isset($headers)) {
                    $headers = $row;
                }
                else {
                    $row = array_combine($headers, array_intersect_key($row, $headers));
                    if ($mapping) {
                        $row = array_pickup($row, $options['headers']);
                    }

                    if ($options['callback']) {
                        if ($options['callback']($row, $n) === false) {
                            continue;
                        }
                    }

                    yield $row;
                }

                if ($options['limit'] !== null && $count++ >= $options['limit']) {
                    break;
                }
            }
        })();

        if ($options['generate']) {
            return $generator;
        }
        return iterator_to_array($generator);
    }
    finally {
        $restore();
    }
}

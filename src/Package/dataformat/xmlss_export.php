<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_unset.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../iterator/iterator_join.php';
require_once __DIR__ . '/../iterator/iterator_split.php';
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 連想配列の配列を XML SpreadSheet 的文字列に変換する
 *
 * 単純に入出力に足る最低限の xml を返す（かつ1シートのみ）。
 *
 * Example:
 * ```php
 * $xmlss = xmlss_export([
 *     ['id' => 1, 'name' => 'hoge', 'flag' => true],
 *     ['id' => 2, 'name' => 'fuga', 'flag' => true],
 *     ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ], [
 *     'xml'   => ['style' => ['Default' => ['Name' => null]]],
 *     'break' => "\n",
 * ]);
 * // 実際はスタイルやコメント、幅などに対応しているが長くなるので割愛
 * that($xmlss)->is(<<<XMLSS
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
 * XMLSS,);
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param iterable $xmlssarrays 連想配列の配列
 * @param array $options オプション配列
 * @return string|int XML SpreadSheet 的文字列。output オプションを渡した場合は書き込みバイト数
 */
function xmlss_export($xmlssarrays, array $options = [])
{
    $options += [
        'xml'      => [],     // xml ss としての設定
        'initial'  => '',     // 先頭文字列
        'headers'  => null,   // ヘッダーマップ（CSV と同じ）
        'indent'   => 1,      // インデント数
        'break'    => "\r\n", // 改行文字
        'callback' => null,   // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
        'type'     => function ($value, $key, $row) {
            switch (true) {
                default:
                    return 'String';
                case is_bool($value):
                    return 'Boolean';
                case is_int($value) || is_float($value):
                    return 'Number';
                // 標準の DateTimeInterface は __toString がないのであまり意味はない（主に継承クラス用。せっかく excel に型があるのだし）
                case $value instanceof \DateTimeInterface:
                    return 'DateTime';
            }
        },
        'output'   => null,   // 書き込まれるリソース（指定すると返り値がバイト数になる）
    ];
    // 詳細は https://learn.microsoft.com/en-us/previous-versions/office/developer/office-xp/aa140066(v=office.10)
    $options['xml'] = array_replace_recursive([
        'declaration' => '<?mso-application progid="Excel.Sheet"?>',
        'document'    => [
            'Author'     => null,
            'LastAuthor' => null,
            'Created'    => null,
            'Version'    => null,
        ],
        'style'       => [
            'Default' => [
                'Name'         => 'Normal',
                'Parent'       => null,
                'Alignment'    => [
                    'Horizontal'   => null, // "Automatic", "Left", "Center", "Right", "Fill", "Justify", "CenterAcrossSelection", "Distributed", "JustifyDistributed"
                    'Indent'       => null, // Unsigned Long
                    'ReadingOrder' => null, // "RightToLeft", "LeftToRight", "Context"
                    'Rotate'       => null, // Double
                    'ShrinkToFit'  => null, // Boolean
                    'Vertical'     => null, // "Automatic", "Top", "Bottom", "Center", "Justify", "Distributed", "JustifyDistributed"
                    'VerticalText' => null, // Boolean
                    'WrapText'     => null, // Boolean
                ],
                'Borders'      => [
                    'Left'          => [
                        'Color'     => null, // String
                        'LineStyle' => null, // "None", "Continuous", "Dash", "Dot", "DashDot", "DashDotDot", "SlantDashDot", "Double"
                        'Weight'    => null, // Double
                    ],
                    'Top'           => [/*ditto*/],
                    'Right'         => [/*ditto*/],
                    'Bottom'        => [/*ditto*/],
                    'DiagonalLeft'  => [/*ditto*/],
                    'DiagonalRight' => [/*ditto*/],
                ],
                'Font'         => [
                    'FontName'      => null, // String
                    'Bold'          => null, // Boolean
                    'Color'         => null, // String
                    'Italic'        => null, // Boolean
                    'Outline'       => null, // Boolean
                    'Shadow'        => null, // Boolean
                    'StrikeThrough' => null, // Boolean
                    'Underline'     => null, // "None", "Single", "Double", "SingleAccounting", "DoubleAccounting"
                    'VerticalAlign' => null, // "None", "Subscript" "Superscript"
                    'Size'          => null, // Double
                ],
                'Interior'     => [
                    'Color'        => null, // String
                    'Pattern'      => null, // "None", "Solid", "Gray75", "Gray50", "Gray25", "Gray125", "Gray0625", "HorzStripe", "VertStripe", "ReverseDiagStripe", DiagStripe", "DiagCross", "ThickDiagCross", "ThinHorzStripe", "ThinVertStripe", "ThinReverseDiagStripe", "ThinDiagStripe", "ThinHorzCross", "ThinDiagCross"
                    'PatternColor' => null, // String
                ],
                'NumberFormat' => [
                    'Format' => null, // String
                ],
            ],
            // ditto with StyleID
        ],
        'sheet'       => [
            'Name'        => 'Sheet1', // String
            'RightToLeft' => null,     // Boolean
            'Options'     => [
                'Panes' => [
                    [
                        'Number'         => null, // 実質的に 3 固定？（これが無いと Active が効かない）
                        'ActiveRow'      => null, // Unsigned Long
                        'ActiveCol'      => null, // Unsigned Long
                        'RangeSelection' => null, // String | Array
                    ],
                ],
            ],
        ],
        'table'       => [
            'DefaultColumnWidth' => null, // Double
            'DefaultRowHeight'   => null, // Double
            'LeftCell'           => null, // Unsigned Long
            'TopCell'            => null, // Unsigned Long
            'StyleID'            => null, // ID Reference
        ],
        'column'      => [
            [
                'AutoFitWidth' => null, // Boolean
                'Hidden'       => null, // Boolean
                'Index'        => null, // Unsigned Long
                'Span'         => null, // Unsigned Long
                'Width'        => null, // Double
                'StyleID'      => null, // ID Reference
            ],
            // ditto with HeaderID
        ],
        'comment'     => [
            [
                'Author'     => null, // String
                'ShowAlways' => null, // Boolean
                'Data'       => null, // String
            ],
            // ditto with HeaderID
        ],
        'row'         => [
            'AutoFitHeight' => null, // Boolean
            'Hidden'        => null, // Boolean
            'Index'         => null, // Unsigned Long
            'Span'          => null, // Unsigned Long
            'Height'        => null, // Double
            'StyleID'       => null, // ID Reference
        ],
    ], $options['xml']);

    if ($options['output']) {
        $fp = $options['output'];
    }
    else {
        $fp = fopen('php://temp', 'rw+');
    }

    $indent = fn($n) => str_repeat(' ', $options['indent'] * $n);
    $break = $options['break'];
    $escape = function ($value) {
        // タグを埋め込みたいこともあるのでオブジェクトはエスケープしない（DateTimeInterface だけは特別扱い）
        if (is_object($value) && !$value instanceof \DateTimeInterface) {
            return $value;
        }
        return filter_var((string) $value, FILTER_SANITIZE_SPECIAL_CHARS);
    };
    $filter = function ($array) use (&$filter) {
        return array_filter($array, function ($v) use ($filter) {
            if (is_array($v)) {
                return $filter($v);
            }
            else {
                return $v !== null;
            }
        });
    };
    $toRange = function ($range) {
        if (!is_array($range)) {
            return $range;
        }

        $row = $range[0] ?? null;
        $col = $range[1] ?? null;
        if (!is_array($row) && !is_array($col)) {
            return "R{$row}C{$col}";
        }
        if (is_array($row) && is_null($col)) {
            return "R{$row[0]}C{$row[1]}";
        }
        if (is_array($row) && is_array($col)) {
            return "R{$row[0]}C{$row[1]}:R{$col[0]}C{$col[1]}";
        }
        throw new \UnexpectedValueException(json_encode($range) . ' is invalid RangeSelection'); // @codeCoverageIgnore
    };

    $size = 0;
    $write = function ($string) use ($fp, &$size) {
        $size += fwrite($fp, (string) $string);
    };

    // DOM だとストリーミングがつらいので文字列ベースでやる

    $tag = function (string $name, ?int $level, array $attributes, string $prefix, bool $single = false) use ($write, $indent, $break, $escape, $filter) {
        if (!preg_match('#^[-_a-z]([-_a-z0-9])*$#i', $name)) {
            throw new \UnexpectedValueException("$name is not a valid tag"); // @codeCoverageIgnore
        }
        $name = ucfirst($name);

        $whitespace = $level === null ? '' : "{$break}{$indent($level)}";

        $write("{$whitespace}<$name");
        foreach ($filter($attributes) as $aname => $avalue) {
            $aname = implode(':', array_filter([$prefix, $aname], 'strlen'));
            $write(" $aname=\"{$escape($avalue)}\"");
        }

        if ($single) {
            $write('/>');
            return '';
        }

        $write('>');
        return "{$whitespace}</$name>";
    };
    $row = function ($fields, $comments) use ($write, $options, $indent, $break, $tag, $escape) {
        $tRow = $tag('Row', 3, $options['xml']['row'] ?? [], 'ss');

        $n = 0;
        foreach ($fields as $key => $data) {
            // 属性がないし超絶コールされるので $tag(...) は使わない（目に見えて速度が落ちる）
            $write("{$break}{$indent(4)}<Cell>");
            $type = $options['type']($data, $key, $fields);
            $write("<Data ss:Type=\"{$type}\">{$escape($data)}</Data>");
            if (($comment = ($comments[$key] ?? $comments[$n] ?? null)) !== null) {
                $text = array_unset($comment, 'Data');
                if ($text !== null) {
                    $tComment = $tag('Comment', null, $comment, 'ss', false);
                    $write("<Data>{$escape($text)}</Data>");
                    $write($tComment);
                }
            }
            $write('</Cell>');
            $n++;
        }

        $write($tRow);
    };

    set_error_handler(static function ($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            return false;
        }
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    });
    try {
        if (!is_array($xmlssarrays)) {
            [$xmlssarrays, $xmlssarrays2] = iterator_split($xmlssarrays, [1], true);
        }

        $headers = $options['headers'];
        if (!$headers) {
            $tmp = [];
            foreach ($xmlssarrays as $array) {
                $tmp = array_intersect_key($tmp ?: $array, $array);
            }
            $keys = array_keys($tmp);
            $headers = is_array($headers) ? $keys : array_combine($keys, $keys);
        }
        if (!is_hasharray($headers)) {
            $headers = array_combine($headers, $headers);
        }

        if (isset($xmlssarrays2)) {
            $xmlssarrays = iterator_join([$xmlssarrays, $xmlssarrays2]);
        }

        $stack = [];

        // declaration
        $write('<?xml version="1.0"?>');
        if (strlen($options['xml']['declaration'] ?? '')) {
            $write($break . $options['xml']['declaration']);
        }

        // Workbook
        $stack[] = $tag('Workbook', 0, [
            ''     => 'urn:schemas-microsoft-com:office:spreadsheet',
            'o'    => 'urn:schemas-microsoft-com:office:office',
            'x'    => 'urn:schemas-microsoft-com:office:excel',
            'ss'   => 'urn:schemas-microsoft-com:office:spreadsheet',
            'html' => 'http://www.w3.org/TR/REC-html40',
        ], 'xmlns');

        // DocumentProperties
        if ($document = $filter($options['xml']['document'])) {
            $stack[] = $tag('DocumentProperties', 1, [
                '' => 'urn:schemas-microsoft-com:office:office',
            ], 'xmlns');
            foreach ($document as $name => $value) {
                $write("{$break}{$indent(2)}");
                $stack[] = $tag($name, null, [], 'ss');
                $write($escape($value));
                $write(array_pop($stack));
            }
            $write(array_pop($stack));
        }

        // Styles
        if ($styles = $filter($options['xml']['style'])) {
            $stack[] = $tag('Styles', 1, [], 'ss');
            foreach ($styles as $id => $attributes) {
                if ($attributes = $filter($attributes)) {
                    $stack[] = $tag('Style', 2, [
                        'ID'     => $id,
                        'Name'   => array_unset($attributes, 'Name'),
                        'Parent' => array_unset($attributes, 'Parent'),
                    ], 'ss');
                    foreach ($attributes as $style => $values) {
                        // Borders だけネスト構造になっている
                        if ($style === 'Borders') {
                            $stack[] = $tag($style, 3, [], 'ss');
                            foreach ($values as $style2 => $values2) {
                                if ($values2 = $filter($values2)) {
                                    $tag('Border', 4, ['Position' => $style2] + $values2, 'ss', true);
                                }
                            }
                            $write(array_pop($stack));
                        }
                        else {
                            $tag($style, 3, $values, 'ss', true);
                        }
                    }
                    $write(array_pop($stack));
                }
            }
            $write(array_pop($stack));
        }

        // Worksheet
        $woptions = array_unset($options['xml']['sheet'], 'Options', []);
        $stack[] = $tag('Worksheet', 1, $options['xml']['sheet'], 'ss');

        // WorksheetOptions
        // 実質的に指定することは皆無なのでかなり適当
        if ($woptions = $filter($woptions)) {
            $stack[] = $tag('WorksheetOptions', 2, [
                '' => 'urn:schemas-microsoft-com:office:excel',
            ], 'xmlns');
            foreach ($woptions as $name => $woption) {
                $stack[] = $tag($name, 3, [], 'ss');
                if ($name === 'Panes') {
                    foreach ($filter($woption) as $value) {
                        $stack[] = $tag('Pane', 4, [], 'ss');
                        foreach ($filter($value) as $k => $v) {
                            $write("{$break}{$indent(5)}");
                            $stack[] = $tag($k, null, [], 'ss');
                            if ($k === 'RangeSelection') {
                                $v = is_array($v) ? implode(',', array_map($toRange, $v)) : $v;
                            }
                            $write($escape($v));
                            $write(array_pop($stack));
                        }
                        $write(array_pop($stack));
                    }
                }
                $write(array_pop($stack));
            }
            $write(array_pop($stack));
        }

        // Table
        // ExpandedColumnCount は準必須だが ExpandedRowCount は別になくても大丈夫
        //$options['table']['ExpandedRowCount'] = count($xmlssarrays);
        $options['xml']['table']['ExpandedColumnCount'] = count($headers);
        $stack[] = $tag('Table', 2, $options['xml']['table'], 'ss');

        // Column
        foreach ($filter($options['xml']['column']) as $column) {
            $tag('Column', 3, $column, 'ss', true);
        }

        // Rows

        if (!is_empty($options['initial'])) {
            $row((array) $options['initial'], []);
        }

        if ($headers && (!$options['callback'] || $options['callback']($headers, null) !== false)) {
            $row($headers, $options['xml']['comment']);
        }

        $default = array_fill_keys(array_keys($headers), '');
        foreach ($xmlssarrays as $n => $array) {
            if ($options['callback']) {
                if ($options['callback']($array, $n) === false) {
                    continue;
                }
            }
            $row(array_intersect_key(array_replace($default, $array), $default), []);
        }

        // Closing
        while ($stack) {
            $write(array_pop($stack));
        }

        if ($options['output']) {
            return $size;
        }
        rewind($fp);
        return stream_get_contents($fp);
    }
    finally {
        restore_error_handler();
        if (!$options['output']) {
            fclose($fp);
        }
    }
}

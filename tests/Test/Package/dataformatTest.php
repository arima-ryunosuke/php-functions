<?php

namespace ryunosuke\Test\Package;

use Concrete;
use function ryunosuke\Functions\Package\array_remove;
use function ryunosuke\Functions\Package\css_selector;
use function ryunosuke\Functions\Package\csv_export;
use function ryunosuke\Functions\Package\csv_import;
use function ryunosuke\Functions\Package\file_list;
use function ryunosuke\Functions\Package\html_attr;
use function ryunosuke\Functions\Package\html_strip;
use function ryunosuke\Functions\Package\html_tag;
use function ryunosuke\Functions\Package\ini_export;
use function ryunosuke\Functions\Package\ini_import;
use function ryunosuke\Functions\Package\json_export;
use function ryunosuke\Functions\Package\json_import;
use function ryunosuke\Functions\Package\ltsv_export;
use function ryunosuke\Functions\Package\ltsv_import;
use function ryunosuke\Functions\Package\markdown_list;
use function ryunosuke\Functions\Package\markdown_table;
use function ryunosuke\Functions\Package\paml_export;
use function ryunosuke\Functions\Package\paml_import;
use function ryunosuke\Functions\Package\xmlss_export;
use function ryunosuke\Functions\Package\xmlss_import;
use const ryunosuke\Functions\Package\JSON_BARE_AS_STRING;
use const ryunosuke\Functions\Package\JSON_CLOSURE;
use const ryunosuke\Functions\Package\JSON_COMMENT_PREFIX;
use const ryunosuke\Functions\Package\JSON_ES5;
use const ryunosuke\Functions\Package\JSON_ESCAPE_SINGLE_QUOTE;
use const ryunosuke\Functions\Package\JSON_FLOAT_AS_STRING;
use const ryunosuke\Functions\Package\JSON_INDENT;
use const ryunosuke\Functions\Package\JSON_INLINE_LEVEL;
use const ryunosuke\Functions\Package\JSON_INLINE_SCALARLIST;
use const ryunosuke\Functions\Package\JSON_INT_AS_STRING;
use const ryunosuke\Functions\Package\JSON_MAX_DEPTH;
use const ryunosuke\Functions\Package\JSON_OBJECT_HANDLER;
use const ryunosuke\Functions\Package\JSON_TEMPLATE_LITERAL;
use const ryunosuke\Functions\Package\JSON_TRAILING_COMMA;

class dataformatTest extends AbstractTestCase
{
    function test_css_selector()
    {
        that(css_selector('tagname.c1#hoge.c2[target=hoge\[\]][href="http://hoge[]"][hidden][!readonly]{color:#123!important;height:45.6em;}'))->is([
            ''         => 'tagname',
            'id'       => 'hoge',
            'class'    => ['c1', 'c2'],
            'href'     => 'http://hoge[]',
            'target'   => 'hoge[]',
            'hidden'   => true,
            'readonly' => false,
            'style'    => [
                'color'  => '#123!important',
                'height' => '45.6em',
            ],
        ]);

        that(self::resolveFunction('css_selector'))('a#id#id')->wasThrown('#id is multiple');
        that(self::resolveFunction('css_selector'))('[a=1][a=2]')->wasThrown('[a] is dumplicated');
        that(self::resolveFunction('css_selector'))('#id[id=id]')->wasThrown('[id] is dumplicated');
        that(self::resolveFunction('css_selector'))('{width}')->wasThrown('[width] is empty');
    }

    function test_csv_encoding()
    {
        $DATADIR = __DIR__ . '/files/csv';

        $utf8array = [
            ['Ａ' => 'あ', 'Ｂ' => 'い', 'Ｃ' => 'う', 'Ｄ' => 'え', 'Ｅ' => 'お'],
            ['Ａ' => 'か', 'Ｂ' => 'き', 'Ｃ' => 'く', 'Ｄ' => 'け', 'Ｅ' => 'こ'],
        ];
        $sjisstring = require "$DATADIR/sjisstring.php";
        $sjisstring12345 = require "$DATADIR/sjisstring12345.php";
        $sjisstring5C = require "$DATADIR/sjisstring5C.php";
        $sjisstringnohead = require "$DATADIR/sjisstringnohead.php";

        that(csv_export($utf8array, ['encoding' => 'SJIS']))->is($sjisstring);
        that(csv_import($sjisstring, ['encoding' => 'SJIS']))->is($utf8array);

        that(csv_export($utf8array, [
            'encoding' => 'SJIS',
            'headers'  => [
                'Ａ' => '１',
                'Ｂ' => '２',
                'Ｃ' => '３',
                'Ｄ' => '４',
                'Ｅ' => '５',
            ],
        ]))->is($sjisstring12345);
        that(csv_import($sjisstringnohead, [
            'encoding' => 'SJIS',
            'headers'  => [
                'Ａ',
                'Ｂ',
                'Ｃ',
                'Ｄ',
                'Ｅ',
            ],
        ]))->is($utf8array);
        that(csv_import($sjisstring5C, [
            'encoding' => 'cp932',
        ]))->is([
            [
                "あ" => "―",
                "い" => "ソ",
                "う" => "Ы",
                "え" => "Ⅸ",
                "お" => "噂",
            ],
            [
                "あ" => "浬",
                "い" => "欺",
                "う" => "圭",
                "え" => "構",
                "お" => "蚕",
            ],
            [
                "あ" => "十",
                "い" => "申",
                "う" => "曾",
                "え" => "箪",
                "お" => "貼",
            ],
            [
                "あ" => "能",
                "い" => "表",
                "う" => "暴",
                "え" => "予",
                "お" => "禄",
            ],
            [
                "あ" => "兔",
                "い" => "喀",
                "う" => "媾",
                "え" => "彌",
                "お" => "拿",
            ],
            [
                "あ" => "杤",
                "い" => "歃",
                "う" => "濬",
                "え" => "畚",
                "お" => "秉",
            ],
            [
                "あ" => "綵",
                "い" => "臀",
                "う" => "藹",
                "え" => "觸",
                "お" => "軆",
            ],
            [
                "あ" => "鐔",
                "い" => "饅",
                "う" => "鷭",
                "え" => "纊",
                "お" => "犾",
            ],
            [
                "あ" => "偆",
                "い" => "砡",
                "う" => "du",
                "え" => "mm",
                "お" => "y",
            ],
        ]);

        that(self::resolveFunction('csv_import'))($sjisstring5C, [
            'encoding' => 'sjis',
            'scrub'    => '',
        ])->wasThrown('invalid multibyte sequence');
        that(self::resolveFunction('csv_export'))([['a' => '㈱']], [
            'encoding' => 'sjis',
            'scrub'    => '',
        ])->wasThrown('invalid multibyte sequence');
    }

    function test_csv_export()
    {
        $csvarrays = [
            // スタンダード
            ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'],
            // 順番が入れ替わっている
            ['c' => 'c2', 'b' => 'b2', 'a' => 'a2'],
            // 余計な項目がある
            ['c' => 'c3', 'b' => 'b3', 'a' => 'a3', 'x' => 'X'],
        ];

        that(csv_export($csvarrays))->is("a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
");

        // headers 指定
        that(csv_export($csvarrays, ['headers' => ['a' => 'A', 'c' => 'C']]))->is("A,C
a1,c1
a2,c2
a3,c3
");

        // headers 指定（数値）
        that(csv_export($csvarrays, ['headers' => ['a', 'c']]))->is("a1,c1
a2,c2
a3,c3
");

        // headers 指定（空配列）
        that(csv_export([], ['headers' => ['a' => 'A', 'c' => 'C']]))->is("A,C
");

        // headers 指定（空ジェネレータ）
        that(csv_export((function () { yield from []; })(), ['headers' => ['a' => 'A', 'c' => 'C']]))->is("A,C
");

        // headers 指定（数値+空配列）
        that(csv_export([], ['headers' => ['a', 'c']]))->is("");

        // headers 指定（数値+空ジェネレータ）
        that(csv_export((function () { yield from []; })(), ['headers' => ['a', 'c']]))->is("");

        // headers 指定（空）
        that(csv_export($csvarrays, ['headers' => []]))->is("a1,b1,c1
a2,b2,c2
a3,b3,c3
");

        // BOM 指定
        that(csv_export($csvarrays, ['initial' => "\xEF\xBB\xBF"]))->is("\xEF\xBB\xBFa,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
");

        // 冒頭指定
        that(csv_export($csvarrays, ['initial' => ['a is A', '', 'c is C']]))->is('"a is A",,"c is C"
a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
');

        // callback
        that(csv_export($csvarrays, [
            'callback' => function (&$row, $n) {
                if ($n === null) {
                    $row['b'] = strtoupper($row['b']);
                    return;
                }
                else {
                    $row['b'] = strtoupper($row['b']);
                    return $n !== 1;
                }
            },
        ]))->is("a,B,c
a1,B1,c1
a3,B3,c3
");
        that(csv_export($csvarrays, [
            'callback' => function (&$row, $n) {
                if ($n === null) {
                    return false;
                }
                else {
                    $row['b'] = strtoupper($row['b']);
                    return $n !== 1;
                }
            },
        ]))->is("a1,B1,c1
a3,B3,c3
");

        // output 指定
        $receiver = fopen('php://memory', 'r+b');
        that(csv_export($csvarrays, ['output' => $receiver]))->is(33);
        rewind($receiver);
        that(stream_get_contents($receiver))->is("a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
");

        // fputcsv 引数
        $csvarrays[0]['c'] = " c\n";
        that(csv_export($csvarrays, ['delimiter' => ' ', 'enclosure' => "'"]))->is("a b c
a1 b1 ' c
'
a2 b2 c2
a3 b3 c3
");

        // 構造化
        $csvarrays = [
            ['scalar' => '1', 'list' => ['a1', 'b1'], 'hash' => ['x' => 'x1', 'y' => 'y1'], 'nest' => ['p1' => ['11', '12'], 'p2' => ['%', '14']]],
            ['scalar' => '2', 'list' => ['a2', 'b2'], 'hash' => ['x' => 'x2', 'y' => 'y2'], 'nest' => ['p1' => ['21', '22'], 'p2' => ['#', '24']]],
            ['scalar' => '3', 'list' => ['a3', 'b3'], 'hash' => ['x' => 'x3', 'y' => 'y3'], 'nest' => ['p1' => ['31', '32'], 'p2' => ['&', '34']]],
        ];
        that(csv_export($csvarrays, ['structure' => true]))->is("scalar,list[],list[],hash[x],hash[y],nest[p1][],nest[p1][],nest[p2][],nest[p2][]
1,a1,b1,x1,y1,11,12,%,14
2,a2,b2,x2,y2,21,22,#,24
3,a3,b3,x3,y3,31,32,&,34
");

        // 構造化（ジャグ）
        $csvarrays = [
            ['scalar' => '1', 'list' => ['a1'], 'hash' => ['x' => 'x1', 'y' => 'y1'], 'nest' => ['p1' => ['11'], 'p2' => ['%', '14']]],
            ['scalar' => '2', 'list' => ['a2', 'b2'], 'hash' => ['x' => 'x2', 'y' => 'y2'], 'nest' => ['p1' => ['21', '22'], 'p2' => ['#', '24']]],
            ['scalar' => '3', 'list' => ['a3', 'b3', 'c3'], 'hash' => ['x' => 'x3', 'y' => 'y3'], 'nest' => ['p1' => ['31', '32', '33'], 'p2' => ['&', '34']]],
        ];
        that(csv_export($csvarrays, ['structure' => true]))->is("scalar,list[],list[],list[],hash[x],hash[y],nest[p1][],nest[p1][],nest[p1][],nest[p2][],nest[p2][]
1,a1,,,x1,y1,11,,,%,14
2,a2,b2,,x2,y2,21,22,,#,24
3,a3,b3,c3,x3,y3,31,32,33,&,34
");

        // 構造化（空文字）
        $csvarrays = [
            ['scalar' => '1', 'list' => [], 'hash' => ['x' => 'x1', 'y' => 'y1'], 'nest' => ['p1' => ['11'], 'p2' => []]],
            ['scalar' => '1', 'list' => ['a2', 'b2'], 'hash' => ['x' => 'x1', 'y' => 'y1'], 'nest' => ['p1' => [], 'p2' => ['22']]],
        ];
        that(csv_export($csvarrays, ['structure' => true]))->is("scalar,hash[x],hash[y],nest[p1][],list[],list[],nest[p2][]
1,x1,y1,11,,,
1,x1,y1,,a2,b2,22
");

        // Generator
        that(csv_export((function () {
            yield 1 => ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'];
            yield 2 => ['a' => 'a2', 'b' => 'b2', 'c' => 'c2'];
            yield 3 => ['a' => 'a3', 'b' => 'b3', 'c' => 'c3'];
        })(), [
            'callback'        => function (&$row, $n) {
                $row = array_merge(['prefix'], $row, ['suffix']);
                $row['b'] = strtoupper($row['b']);
            },
            'callback_header' => true,
        ]))->is("prefix,a,B,c,suffix
prefix,a1,B1,c1,suffix
prefix,a2,B2,c2,suffix
prefix,a3,B3,c3,suffix
");
    }

    function test_csv_import()
    {
        that(csv_import('a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
'))->is([
            ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a2', 'b' => 'b2', 'c' => 'c2'],
            ['a' => 'a3', 'b' => 'b3', 'c' => 'c3'],
        ]);

        // 空行とクオート
        that(csv_import('a,b,c
"a1,x",b1,c1

a3,b3,"c3
x"
'))->is([
            ['a' => 'a1,x', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'b3', 'c' => "c3\nx"],
        ]);

        // ファイルポインタ
        file_put_contents(self::$TMPDIR . '/test.csv', 'a,b,c
"a1,x",b1,c1

a3,b3,"c3
x"
');
        that(csv_import(fopen(self::$TMPDIR . '/test.csv', 'r')))->is([
            ['a' => 'a1,x', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'b3', 'c' => "c3\nx"],
        ]);

        // headers 指定（数値）
        that(csv_import('
a1,b1,c1
a2,b2,c2
', ['headers' => ['A', 2 => 'C']]))->is([
            ['A' => 'a1', 'C' => 'c1'],
            ['A' => 'a2', 'C' => 'c2'],
        ]);

        // headers 指定（キーマップ）
        that(csv_import('
A,B,C
a1,b1,c1
a2,b2,c2
', ['headers' => ['C' => 'xC', 'A' => 'xA', 'unknown' => 'x']]))->is([
            ['xA' => 'a1', 'xC' => 'c1'],
            ['xA' => 'a2', 'xC' => 'c2'],
        ]);

        // 読み飛ばし（csv）
        that(csv_import('"a is A",,"c is C"
a,b,c
a1,b1,c1
a2,b2,c2
', ['initial' => ['csv' => 1]]))->is([
            ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a2', 'b' => 'b2', 'c' => 'c2'],
        ]);
        // 読み飛ばし（line）
        that(csv_import('summary1
summary2
a,b,c
a1,b1,c1
a2,b2,c2
', ['initial' => ['line' => 2]]))->is([
            ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a2', 'b' => 'b2', 'c' => 'c2'],
        ]);
        // 読み飛ばし（byte）
        that(csv_import('xyza,b,c
a1,b1,c1
a2,b2,c2
', ['initial' => ['byte' => 2]]))->is([
            ['za' => 'a1', 'b' => 'b1', 'c' => 'c1'],
            ['za' => 'a2', 'b' => 'b2', 'c' => 'c2'],
        ]);

        // limit
        that(csv_import("a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
a4,b4,c4
", ['limit' => 3]))->is([
            [
                "a" => "a1",
                "b" => "b1",
                "c" => "c1",
            ],
            [
                "a" => "a2",
                "b" => "b2",
                "c" => "c2",
            ],
            [
                "a" => "a3",
                "b" => "b3",
                "c" => "c3",
            ],
        ]);

        // コールバック指定
        that(csv_import('a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
', [
            'callback' => function (&$row, $n) {
                $row['b'] = strtoupper($row['b']);
                return $n !== 1;
            },
        ]))->is([
            ['a' => 'a1', 'b' => 'B1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'B3', 'c' => 'c3'],
        ]);

        // 構造化
        that(csv_import('scalar,list[],list[],hash[x],hash[y],nest[p1][],nest[p1][],nest[p2][],nest[p2][]
1,a1,b1,x1,y1,11,12,%,14
2,a2,b2,x2,y2,21,22,#,24
3,a3,b3,x3,y3,31,32,&,34
', ['structure' => true]))->is([
            ['scalar' => '1', 'list' => ['a1', 'b1'], 'hash' => ['x' => 'x1', 'y' => 'y1'], 'nest' => ['p1' => ['11', '12'], 'p2' => ['%', '14']]],
            ['scalar' => '2', 'list' => ['a2', 'b2'], 'hash' => ['x' => 'x2', 'y' => 'y2'], 'nest' => ['p1' => ['21', '22'], 'p2' => ['#', '24']]],
            ['scalar' => '3', 'list' => ['a3', 'b3'], 'hash' => ['x' => 'x3', 'y' => 'y3'], 'nest' => ['p1' => ['31', '32'], 'p2' => ['&', '34']]],
        ]);

        // 構造化（ジャグ）
        that(csv_import('scalar,list[],list[],list[],hash[x],hash[y],nest[p1][],nest[p1][],nest[p1][],nest[p2][],nest[p2][]
1,a1,,,x1,y1,11,,,%,14
2,a2,b2,,x2,y2,21,22,,#,24
3,a3,b3,c3,x3,y3,31,32,33,&,34
', ['structure' => true]))->is([
            ['scalar' => '1', 'list' => ['a1'], 'hash' => ['x' => 'x1', 'y' => 'y1'], 'nest' => ['p1' => ['11'], 'p2' => ['%', '14']]],
            ['scalar' => '2', 'list' => ['a2', 'b2'], 'hash' => ['x' => 'x2', 'y' => 'y2'], 'nest' => ['p1' => ['21', '22'], 'p2' => ['#', '24']]],
            ['scalar' => '3', 'list' => ['a3', 'b3', 'c3'], 'hash' => ['x' => 'x3', 'y' => 'y3'], 'nest' => ['p1' => ['31', '32', '33'], 'p2' => ['&', '34']]],
        ]);

        // 構造化（空文字）
        that(csv_import('scalar,list[],list[],hash[x],hash[y],nest[0][p1],nest[0][p2],nest[1][p1],nest[1][p2]
,,,,,,,,
', ['structure' => true]))->is([
            ['scalar' => '', 'list' => [], 'hash' => ['x' => '', 'y' => ''], 'nest' => []],
        ]);

        // グルーピング
        that(csv_import("A.hoge,B.hoge,B.fuga,A.fuga,other[],other[]
Ahoge,Bhoge1,Bfuga1,Afuga,other11,other12
Ahoge,Bhoge2,Bfuga2,Afuga,other21,other22
", ['grouping' => '.', 'structure' => true]))->is([
            "A" => [
                [
                    "hoge" => "Ahoge",
                    "fuga" => "Afuga",
                ],
            ],
            "B" => [
                [
                    "hoge" => "Bhoge1",
                    "fuga" => "Bfuga1",
                ],
                [
                    "hoge" => "Bhoge2",
                    "fuga" => "Bfuga2",
                ],
            ],
            ""  => [
                [
                    "other" => ["other11", "other12"],
                ],
                [
                    "other" => ["other21", "other22"],
                ],
            ],
        ]);

        // 要素数が合わないと例外
        that(self::resolveFunction('csv_import'))("a,b,c\nhoge")->wasThrown('csv#0: array_combine()');
    }

    function test_html_attr()
    {
        $attrs = [
            'ignore',
            'camelCase' => '<value>',
            'checked'   => true,
            'disabled'  => false,
            'readonly'  => null,
            'srcset'    => [
                'hoge.jpg 1x',
                'fuga.jpg 2x',
            ],
            'content'   => [
                'width' => 'device-width',
                'scale' => '1.0',
            ],
            'class'     => ['hoge', 'fuga'],
            'style'     => [
                'color'           => 'red',
                'backgroundColor' => 'white',
                'margin'          => [1, 2, 3, 4],
                'opacity:0.5',
            ],
            'data-'     => [
                'direct',
                'camelCase' => 123,
                'hoge'      => false,
                'fuga'      => "fuga",
                'piyo'      => ['a' => 'A'],
            ],
        ];

        that(html_attr($attrs, null))->is([
            0                 => 'ignore',
            'camel-case'      => '<value>',
            'checked'         => true,
            'disabled'        => false,
            'srcset'          => 'hoge.jpg 1x,fuga.jpg 2x',
            'content'         => 'width=device-width,scale=1.0',
            'class'           => 'hoge fuga',
            'style'           => 'color:red;background-color:white;margin:1 2 3 4;opacity:0.5',
            'data-0'          => 'direct',
            'data-camel-case' => 123,
            'data-hoge'       => 'false',
            'data-fuga'       => 'fuga',
            'data-piyo'       => '{"a":"A"}',
        ]);

        that(html_attr($attrs, "\n"))->is(<<<ATTRS
camel-case="&lt;value&gt;"
checked
srcset="hoge.jpg 1x,fuga.jpg 2x"
content="width=device-width,scale=1.0"
class="hoge fuga"
style="color:red;background-color:white;margin:1 2 3 4;opacity:0.5"
data-0="direct"
data-camel-case="123"
data-hoge="false"
data-fuga="fuga"
data-piyo="{&quot;a&quot;:&quot;A&quot;}"
ATTRS
        );

        that(html_attr([
            'camelCase' => 'hoge[]',
            'data'      => 'hoge',
            'data-'     => 'fuga',
            'data-name' => 'name',
        ], [
            'quote'     => "'",
            'chaincase' => false,
            'separator' => "\n",
        ]))->is(<<<ATTRS
camelCase='hoge[]'
data='hoge'
data-='fuga'
data-name='name'
ATTRS
        );

        that(html_attr([
            'arrayarray' => [
                new class() implements \IteratorAggregate {
                    public function getIterator(): \Traversable { return new \ArrayIterator(['text/html', 'charset=UTF-8']); }
                },
            ],
            'stringable' => new class() {
                public function __toString(): string { return 'string'; }
            },
            'iterable'   => new class() implements \IteratorAggregate {
                public function getIterator(): \Traversable { yield 'a' => 'A'; }
            },
            'both'       => new class() implements \IteratorAggregate {
                public function __toString(): string { return 'string'; }

                public function getIterator(): \Traversable { yield 'a' => 'A'; }
            },
        ], null))->is([
            'arrayarray' => 'text/html;charset=UTF-8',
            'stringable' => 'string',
            'iterable'   => 'a=A',
            'both'       => 'string',
        ]);

        that(self::resolveFunction('html_attr'))(['ho ge' => 'hoge'])->wasThrown('invalid charactor');
    }

    function test_html_strip()
    {
        $html = '
test
<!-- comment -->
ryunosuke-function
<div>
    <!-- comment -->
    <strong
        id   = "strong1"
        class= "hoge fuga piyo"
    >
        <? $multiline ?>
        <br>
        <?php foreach($array as $k=>$v) {
            echo $k, $v;
        }
        ?>
    </strong>
    <pre>
      line1
        line2
          line3
    </pre>
    <textarea>
      line1
        line2
          line3
    </textarea>
    <script>
      var a = 0;
      if (a >= 0)
        alert(a);
    </script>
    <style>
      body {
        color: black
      }
      span, div {
        background: red;
      }
    </style>
    <strong
        id=\'strong2\'
        class="hoge fuga piyo"
    >
    
    <span id="<?= $id ?>" class=\'<?= $class ?>\'>
    asd
</span>
        line1
line2

line3
    </strong>
</div>

';
        that(html_strip($html))->is('test ryunosuke-function <div><strong id="strong1" class="hoge fuga piyo"> <? $multiline ?>
 <br><?php foreach($array as $k=>$v) {
            echo $k, $v;
        }
        ?>
 </strong><pre>
      line1
        line2
          line3
    </pre><textarea>
      line1
        line2
          line3
    </textarea><script>
      var a = 0;
      if (a >= 0)
        alert(a);
    </script><style>
      body {
        color: black
      }
      span, div {
        background: red;
      }
    </style><strong id="strong2" class="hoge fuga piyo"> <span id="<?= $id ?>" class="<?= $class ?>">asd </span>line1 line2 line3 </strong></div>');

        that(html_strip("\n<div> \n </div>\n"))->is('<div></div>');
        that(html_strip("<h1>   Hello \r\n	<span> World!</span>	  </h1>"))->is('<h1>Hello <span>World!</span></h1>');

        that(html_strip('<hoge> a  b  c </hoge>', [
            'ignore-tags' => ['hoge'],
        ]))->is('<hoge> a  b  c </hoge>');
        that(html_strip('<hoge> a  b  c </hoge>', [
            'ignore-tags' => [],
        ]))->is('<hoge>a b c</hoge>');

        that(html_strip('<span id="<?= $id ?>"><?= $content ?></span>', [
            'escape-phpcode' => false,
        ]))->is('<span id="&lt;?= $id ?&gt;">= $content ?&gt;</span>');
        that(html_strip('<span id="<?= $id ?>"><?= $content ?></span>', [
            'escape-phpcode' => true,
        ]))->is('<span id="<?= $id ?>"><?= $content ?></span>');

        that(html_strip(' <!-- C1 --> a <!-- C2 --> b <!-- C3 --> ', [
            'html-comment' => true,
        ]))->is('a b');
        that(html_strip(' <!-- C1 --> a <!-- C2 --> b <!-- C3 --> ', [
            'html-comment' => false,
        ]))->is('<!-- C1 -->a <!-- C2 -->b <!-- C3 -->');

        @that(html_strip('<span>&</span>', [
            'error-level' => E_USER_NOTICE,
        ]))->is('<span>&amp;</span>');
        that(error_get_last()['message'])->contains('htmlParseEntityRef');
    }

    function test_html_strip_sep()
    {
        // くっつくはずのない文字がくっつくのはまずいのでテストで担保
        $htmls = [
            // plain
            "<div>A B</div>"                                        => 'A B',
            // spaceA
            "<div>A <x>B</x></div>"                                 => 'A B',
            "<div><x>A </x>B</div>"                                 => 'A B',
            "<div><x>A </x><x>B</x></div>"                          => 'A B',
            // spaceB
            "<div>A<x> B</x></div>"                                 => 'A B',
            "<div><x>A</x> B</div>"                                 => 'A B',
            "<div><x>A</x><x> B</x></div>"                          => 'A B',
            // spaceAB
            "<div>A <x> B</x></div>"                                => 'A B',
            "<div><x>A </x> B</div>"                                => 'A B',
            "<div><x>A </x><x> B</x></div>"                         => 'A B',
            // doubleAB
            "<div> A <x> B </x></div>"                              => 'A B',
            "<div><x> A </x> B </div>"                              => 'A B',
            "<div><x> A </x><x> B </x></div>"                       => 'A B',
            // nest
            "<div>A<x> B<y> C<z> D</z></y></x></div>"               => 'A B C D',
            "<div>A <x>B <y>C <z>D</z></y></x></div>"               => 'A B C D',
            "<div> A <x> B <y> C <z> D </z> C </y> B </x> A </div>" => 'A B C D C B A',
        ];
        foreach ($htmls as $html => $expected) {
            $text = trim(dom_import_simplexml(simplexml_load_string(html_strip($html)))->textContent);
            that($text)->as("$html\n▼▼▼▼▼\n$text")->is($expected);
        }
    }

    function test_html_tag()
    {
        that(html_tag('a.c1#hoge.c2[target=hoge\[\]][href="http://hoge"][hidden][!readonly]{width:123px;;;height:456px}'))->is(
            '<a id="hoge" class="c1 c2" style="width:123px;height:456px" target="hoge[]" href="http://hoge" hidden></a>'
        );
        that(html_tag(['a.c1#hoge.c2[href="http://hoge"]' => '<b>bold</b>']))->is(
            '<a id="hoge" class="c1 c2" href="http://hoge">&lt;b&gt;bold&lt;/b&gt;</a>'
        );
        that(html_tag([
            'a.c1#hoge.c2[href="http://hoge"]' => [
                'b' => '<bold>',
            ],
        ]))->is(
            '<a id="hoge" class="c1 c2" href="http://hoge"><b>&lt;bold&gt;</b></a>'
        );
        that(html_tag([
            'a.c1#hoge.c2[href="http://hoge"]' => [
                'b' => [
                    '<plain1>',
                    't' => '<thin>',
                    '<plain2>',
                ],
            ],
        ]))->is(
            '<a id="hoge" class="c1 c2" href="http://hoge"><b>&lt;plain1&gt;<t>&lt;thin&gt;</t>&lt;plain2&gt;</b></a>'
        );

        that(html_tag([
            "\ndiv\n#hoge" => [
                "\n  b"   => 'plain1',
                "\n  b\n" => 'plain2',
            ],
            "span"         => 'plain',
        ]))->is(
            '
<div id="hoge">
  <b>plain1</b>
  <b>plain2</b>
</div>
<span>plain</span>'
        );

        that(self::resolveFunction('html_tag'))('#id.class')->wasThrown('tagname is empty');
    }

    function test_ini_export()
    {
        $iniarray = [
            'simple'    => [
                'a'     => 'A',
                'b'     => 'B',
                'quote' => "\"\0\\'",
            ],
            'array'     => [
                'x' => ['A', 'B', 'C'],
            ],
            'hasharray' => [
                'y' => [
                    'a' => 'A',
                    'b' => 'B',
                ],
            ],
        ];

        that(ini_export($iniarray, ['process_sections' => false]))->is('simple[a] = "A"
simple[b] = "B"
simple[quote] = "\"\\0\\\\\'"
x[] = "A"
x[] = "B"
x[] = "C"
y[a] = "A"
y[b] = "B"
');

        that(ini_export($iniarray, ['process_sections' => true]))->is('[simple]
a = "A"
b = "B"
quote = "\"\\0\\\\\'"

[array]
x[] = "A"
x[] = "B"
x[] = "C"

[hasharray]
y[a] = "A"
y[b] = "B"
');
    }

    function test_ini_import()
    {
        that(ini_import('a = "A"
b = "B"
quote = "\"\000\\\\\'"
x[] = "A"
x[] = "B"
x[] = "C"
y[a] = "A"
y[b] = "B"
', ['process_sections' => false]))->is([
            'a'     => 'A',
            'b'     => 'B',
            'quote' => '"\000\\\'',
            'x'     => ['A', 'B', 'C'],
            'y'     => [
                'a' => 'A',
                'b' => 'B',
            ],
        ]);

        that(ini_import('[simple]
a = "A"
b = "B"
quote = "\"\000\\\\\'"

[array]
x[] = "A"
x[] = "B"
x[] = "C"

[hasharray]
y[a] = "A"
y[b] = "B"
', ['process_sections' => true]))->is([
            'simple'    => [
                'a'     => 'A',
                'b'     => 'B',
                'quote' => '"\000\\\'',
            ],
            'array'     => [
                'x' => ['A', 'B', 'C'],
            ],
            'hasharray' => [
                'y' => [
                    'a' => 'A',
                    'b' => 'B',
                ],
            ],
        ]);
    }

    function test_json_export()
    {
        // デフォルトオプション
        that(json_export([123.0, 'あ']))->is('[123.0,"あ"]');

        // オプション指定（上書き）
        that(json_export([123.0, 'あ'], [
            JSON_UNESCAPED_UNICODE      => false,
            JSON_PRESERVE_ZERO_FRACTION => false,
            JSON_PRETTY_PRINT           => true,
        ]))->is("[\n    123,\n    \"\u3042\"\n]");

        // JSON_INDENT
        that(json_export(['a' => 1, ['b' => 2]], [
            JSON_PRETTY_PRINT => true,
            JSON_INDENT       => "\t",
        ]))->is('{
	"a": 1,
	"0": {
		"b": 2
	}
}');
        that(json_export(['a' => 1, ['b' => 2]], [
            JSON_PRETTY_PRINT => true,
            JSON_INDENT       => 8,
        ]))->is('{
        "a": 1,
        "0": {
                "b": 2
        }
}');

        // JSON_INLINE_SCALARLIST
        that(json_export(['a' => 1, ['b' => 2, ['c' => [1, 2, 3], 'd' => [7, [], 9]]]], [
            JSON_PRETTY_PRINT      => true,
            JSON_INLINE_SCALARLIST => true,
        ]))->is('{
    "a": 1,
    "0": {
        "b": 2,
        "0": {
            "c": [1, 2, 3],
            "d": [
                7,
                [],
                9
            ]
        }
    }
}');

        // JSON_INLINE_LEVEL
        $array = [
            'a1' => ['a', 'A'],
            'a2' => [
                'b1' => ['b', 'B'],
                'b2' => [
                    'c1' => ['c', 'C'],
                    'c2' => [
                        'x' => [7 => 'X'],
                        'y' => [8 => 'Y'],
                        'z' => [9 => 'Z'],
                    ],
                ],
            ],
        ];
        that(json_export($array, [
            JSON_PRETTY_PRINT => true,
            JSON_INLINE_LEVEL => 1,
        ]))->is('{
    "a1": ["a", "A"],
    "a2": {"b1": ["b", "B"], "b2": {"c1": ["c", "C"], "c2": {"x": {"7": "X"}, "y": {"8": "Y"}, "z": {"9": "Z"}}}}
}');
        that(json_export($array, [
            JSON_PRETTY_PRINT => true,
            JSON_INLINE_LEVEL => 2,
        ]))->is('{
    "a1": [
        "a",
        "A"
    ],
    "a2": {
        "b1": ["b", "B"],
        "b2": {"c1": ["c", "C"], "c2": {"x": {"7": "X"}, "y": {"8": "Y"}, "z": {"9": "Z"}}}
    }
}');
        that(json_export($array, [
            JSON_PRETTY_PRINT => true,
            JSON_INLINE_LEVEL => 3,
        ]))->is('{
    "a1": [
        "a",
        "A"
    ],
    "a2": {
        "b1": [
            "b",
            "B"
        ],
        "b2": {
            "c1": ["c", "C"],
            "c2": {"x": {"7": "X"}, "y": {"8": "Y"}, "z": {"9": "Z"}}
        }
    }
}');
        that(json_export($array, [
            JSON_PRETTY_PRINT => true,
            JSON_INLINE_LEVEL => 'a2.b2.c2',
        ]))->is('{
    "a1": [
        "a",
        "A"
    ],
    "a2": {
        "b1": [
            "b",
            "B"
        ],
        "b2": {
            "c1": [
                "c",
                "C"
            ],
            "c2": {"x": {"7": "X"}, "y": {"8": "Y"}, "z": {"9": "Z"}}
        }
    }
}');
        that(json_export($array, [
            JSON_PRETTY_PRINT => true,
            JSON_INLINE_LEVEL => 'a2.b2.c2.y',
        ]))->is('{
    "a1": [
        "a",
        "A"
    ],
    "a2": {
        "b1": [
            "b",
            "B"
        ],
        "b2": {
            "c1": [
                "c",
                "C"
            ],
            "c2": {
                "x": {
                    "7": "X"
                },
                "y": {"8": "Y"},
                "z": {
                    "9": "Z"
                }
            }
        }
    }
}');
        that(json_export($array, [
            JSON_PRETTY_PRINT => true,
            JSON_INLINE_LEVEL => ['a2.b1', 'a2.b2.c2.y'],
        ]))->is('{
    "a1": [
        "a",
        "A"
    ],
    "a2": {
        "b1": ["b", "B"],
        "b2": {
            "c1": [
                "c",
                "C"
            ],
            "c2": {
                "x": {
                    "7": "X"
                },
                "y": {"8": "Y"},
                "z": {
                    "9": "Z"
                }
            }
        }
    }
}');
        that(json_export($array, [
            JSON_PRETTY_PRINT      => true,
            JSON_INLINE_LEVEL      => 'a2.b2.c2.y',
            JSON_INLINE_SCALARLIST => true,
        ]))->is('{
    "a1": ["a", "A"],
    "a2": {
        "b1": ["b", "B"],
        "b2": {
            "c1": ["c", "C"],
            "c2": {
                "x": {
                    "7": "X"
                },
                "y": {"8": "Y"},
                "z": {
                    "9": "Z"
                }
            }
        }
    }
}');

        // JSON_CLOSURE
        that(json_export(['a' => fn() => '[1,2,3]', 'f' => fn() => 'function () {}'], [
            JSON_PRETTY_PRINT => true,
            JSON_CLOSURE      => true,
        ]))->is('{
    "a": [1,2,3],
    "f": function () {}
}');
    }

    function test_json_export5()
    {
        $array = [
            'empty-list'  => [],
            'empty-empty' => [[]],
            'scalar-list' => [1, 2, 3, 'a', 'b', 'c'],
            'nest-hash'   => [
                'nest-hash' => [
                    'nest-hash' => [
                        'list-list' => [7, [8, [9]]],
                        'hash-list' => [
                            ['id' => 1, 'name' => 'x'],
                            ['id' => 2, 'name' => 'y'],
                            ['id' => 3, 'name' => 'z'],
                        ],
                        'list-hash' => [
                            'id'   => [1, 2, 3],
                            'name' => ['x', 'y', 'z'],
                        ],
                        'hash-hash' => [
                            'a' => ['id' => 1, 'name' => 'x'],
                            'b' => ['id' => 2, 'name' => 'y'],
                            'c' => ['id' => 3, 'name' => 'z'],
                        ],
                    ],
                ],
            ],
        ];
        $json = '{
  "empty-list": [],
  "empty-empty": [
    [],
  ],
  "scalar-list": [1, 2, 3, "a", "b", "c"],
  "nest-hash": {
    "nest-hash": {
      "nest-hash": {
        "list-list": [
          7,
          [
            8,
            [9],
          ],
        ],
        "hash-list": [
          {
            id: 1,
            name: "x",
          },
          {
            id: 2,
            name: "y",
          },
          {
            id: 3,
            name: "z",
          },
        ],
        "list-hash": {
          id: [1, 2, 3],
          name: ["x", "y", "z"],
        },
        "hash-hash": {
          a: {
            id: 1,
            name: "x",
          },
          b: {
            id: 2,
            name: "y",
          },
          c: {
            id: 3,
            name: "z",
          },
        },
      },
    },
  },
}';

        $es5_opt = [
            JSON_ES5               => true,
            JSON_INDENT            => "  ",
            JSON_TRAILING_COMMA    => true,
            JSON_COMMENT_PREFIX    => '#',
            JSON_INLINE_SCALARLIST => true,
            JSON_PRETTY_PRINT      => true,
        ];

        that(json_export($array, $es5_opt))->is($json);
        that(json_import($json))->is($array); // 戻せることを担保

        // JSON_PRETTY_PRINT なコメント
        that($json = json_export([
            '#comment-a'   => "this is line comment1\nthis is line comment2",
            'a'            => 'A',
            '#comment-b'   => ['this is block comment1', 'this is block comment2'],
            'b'            => 'B',
            'c'            => 'C',
            '#comment-end' => 'this is comment',
        ], [
                JSON_PRETTY_PRINT   => true,
                JSON_TRAILING_COMMA => false,
            ] + $es5_opt))->is('{
  // this is line comment1
  // this is line comment2
  a: "A",
  /*
    this is block comment1
    this is block comment2
  */
  b: "B",
  c: "C"
  // this is comment
}');
        that(json_import($json))->isArray(); // コメントがあるので戻せないが、エラーにならないことは担保

        // JSON_PRETTY_PRINT でないコメント
        that($json = json_export([
            '#comment-a'   => "this is line comment1\nthis is line comment2",
            'a'            => 'A',
            '#comment-b'   => ['this is block comment1', 'this is block comment2'],
            'b'            => 'B',
            'c'            => 'C',
            '#comment-end' => 'this is comment',
        ], [
                JSON_PRETTY_PRINT   => false,
                JSON_TRAILING_COMMA => true,
            ] + $es5_opt))->is('{/*this is line comment1
this is line comment2*/a:"A",/*this is block comment1this is block comment2*/b:"B",c:"C",/*this is comment*/}');
        that(json_import($json))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']); // 戻せることを担保

        // コメントが混在していてもインデックス配列になる
        that($json = json_export([
            '#comment-a'   => "this is line comment1\nthis is line comment2",
            'A',
            '#comment-b'   => ['this is block comment1', 'this is block comment2'],
            'B',
            'C',
            '#comment-end' => 'this is comment',
        ], [
                JSON_PRETTY_PRINT   => true,
                JSON_TRAILING_COMMA => false,
            ] + $es5_opt))->is('[
  // this is line comment1
  // this is line comment2
  "A",
  /*
    this is block comment1
    this is block comment2
  */
  "B",
  "C"
  // this is comment
]');
        that(json_import($json))->is(['A', 'B', 'C']); // 戻せることを担保

        // コメントのみの配列
        that($json = json_export([
            '#comment-a'   => "this is line comment1\nthis is line comment2",
            '#comment-b'   => ['this is block comment1', 'this is block comment2'],
            '#comment-end' => 'this is comment',
        ], [
                JSON_PRETTY_PRINT => true,
            ] + $es5_opt))->is('[
  // this is line comment1
  // this is line comment2
  /*
    this is block comment1
    this is block comment2
  */
  // this is comment
]');
        that(json_import($json))->is([]); // 戻せることを担保

        // 雑多なもの
        that(json_export([], $es5_opt))->is('[]');
        that(json_export((object) [], $es5_opt))->is('{}');
        that(json_export([true, false, null, NAN, -INF, +INF], $es5_opt))->is('[true, false, null, NaN, -Infinity, +Infinity]');
        that(json_export([
            'empty-list'  => [],
            'empty-hash'  => (object) [],
            'empty-empty' => [[]],
        ], [JSON_FORCE_OBJECT => true] + $es5_opt))->is('{
  "empty-list": {},
  "empty-hash": {},
  "empty-empty": {
    "0": {},
  },
}');
        that(json_export([
            new class implements \JsonSerializable {
                public function jsonSerialize(): array
                {
                    return [];
                }
            },
            new class implements \JsonSerializable {
                public function jsonSerialize(): array
                {
                    return ['a' => 'A', 'b' => 'B'];
                }
            },
            (object) ['a' => 'A', 'b' => 'B'],
        ], $es5_opt))->is('[
  [],
  {
    a: "A",
    b: "B",
  },
  {
    a: "A",
    b: "B",
  },
]');

        that(json_export([
            'a' => ['b' => ['c' => "aaa\nzzz"]],
        ], [JSON_TEMPLATE_LITERAL => true] + $es5_opt))->is('{
  a: {
    b: {
      c: `aaa
zzz`,
    },
  },
}');

        that(json_export([
            'datetime' => (new \DateTime('2014/12/24 00:00:00'))->setTime(12, 34, 56, 123456),
            'gmp'      => gmp_init('123456789012345678901234567890'),
        ], [JSON_OBJECT_HANDLER => null] + $es5_opt))->is('{
  datetime: new Date(1419392096123),
  gmp: 123456789012345678901234567890n,
}');

        // depth
        that(self::resolveFunction('json_export'))([[[[[[]]]]]], [
            JSON_ES5       => true,
            JSON_MAX_DEPTH => 3,
        ])->wasThrown('Maximum stack depth exceeded');
    }

    function test_json_import()
    {
        // デフォルトオプション
        that(json_import('[123.0,"あ"]'))->is([123.0, "あ"]);

        // オプション指定（上書き）
        that(json_import('{"a":123.0,"b":"あ"}', [
            JSON_OBJECT_AS_ARRAY => false,
        ]))->is((object) ['a' => 123.0, 'b' => "あ"]);

        // デフォルトでは json5 も試行する
        that(json_import('{a: 123.0, b: "あ",}', []))->is(['a' => 123.0, 'b' => "あ"]);

        // 試行しないモードだとコケる
        that(self::resolveFunction('json_import'))('{a: 123.0, b: "あ",}', [
            JSON_ES5 => false,
        ])->wasThrown('Syntax error');

        // depth
        that(self::resolveFunction('json_import'))('[[[[[[]]]]]]', [JSON_MAX_DEPTH => 3])->wasThrown('Maximum stack depth exceeded');
    }

    function test_json_import5()
    {
        that(json_import('[0]', [JSON_ES5 => true]))->isSame([0]);
        that(json_import('{"foo": true}', [JSON_ES5 => true, JSON_OBJECT_AS_ARRAY => false]))->is((object) ['foo' => true]);

        that(json_import('123456789', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => true]))->isInt();
        that(json_import('-123456789', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => true]))->isInt();
        that(json_import('123456789', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => false]))->isInt();
        that(json_import('-123456789', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => false]))->isInt();

        that(json_import('123456789', [JSON_ES5 => true, JSON_INT_AS_STRING => true]))->isString();
        that(json_import('-123456789', [JSON_ES5 => true, JSON_INT_AS_STRING => true]))->isString();
        that(json_import('1234.56789', [JSON_ES5 => true, JSON_INT_AS_STRING => true]))->isFloat();
        that(json_import('-1234.56789', [JSON_ES5 => true, JSON_INT_AS_STRING => true]))->isFloat();

        that(json_import('123456789', [JSON_ES5 => true, JSON_FLOAT_AS_STRING => true]))->isInt();
        that(json_import('-123456789', [JSON_ES5 => true, JSON_FLOAT_AS_STRING => true]))->isInt();
        that(json_import('1234.56789', [JSON_ES5 => true, JSON_FLOAT_AS_STRING => true]))->isString();
        that(json_import('-1234.56789', [JSON_ES5 => true, JSON_FLOAT_AS_STRING => true]))->isString();

        that(json_import('12345678901234567890', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => false]))->isFloat();
        that(json_import('-12345678901234567890', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => false]))->isFloat();

        that(json_import('12345678901234567890', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => true]))->isString();
        that(json_import('-12345678901234567890', [JSON_ES5 => true, JSON_BIGINT_AS_STRING => true]))->isString();

        that(json_import('"a\n\tz"', [JSON_ES5 => true, JSON_ESCAPE_SINGLE_QUOTE => false]))->is("a\n\tz");
        that(json_import('\'a\n\tz\'', [JSON_ES5 => true, JSON_ESCAPE_SINGLE_QUOTE => false]))->is('a\n\tz');
        that(json_import(<<<'TEXT'
        {
           path1: "C:\path\to\file",
           path2: 'C:\path\to\file',
        }
        TEXT, [JSON_ES5 => true, JSON_ESCAPE_SINGLE_QUOTE => false]))->is([
            "path1" => "C:\\path\to\file",
            "path2" => "C:\\path\\to\\file",
        ]);

        that(json_import('{a: A, abc: A B C, xyz: [X, Y, Z]}', [JSON_ES5 => true, JSON_BARE_AS_STRING => true]))->is([
            "a"   => "A",
            "abc" => "A B C",
            "xyz" => ["X", "Y", "Z"],
        ]);

        that(json_import('`
            1
              2
                3
        `', [JSON_ES5 => true, JSON_TEMPLATE_LITERAL => true]))->is("    1\n      2\n        3");

        that(json_import('`1
            2
            3
        `', [JSON_ES5 => true, JSON_TEMPLATE_LITERAL => true]))->is("1
            2
            3
        ");

        that(array_map(fn($dt) => $dt->format('Y-m-d\TH:i:s.uP'), json_import('{
            Ymd:        2014-12-24,
            YmdTHis:    2014-12-24T12:34:56,
            YmdTHis.u:  2014-12-24T12:34:56.789,
            YmdTHisP:   2014-12-24T12:34:56+01:00,
            YmdTHis.uP: 2014-12-24T12:34:56.789+01:00,
            Ymd His:    2014-12-24 12:34:56,
            Ymd His.u:  2014-12-24 12:34:56.789,
            Ymd HisP:   2014-12-24 12:34:56+01:00,
            Ymd His.uP: 2014-12-24 12:34:56.789+01:00,
        }', [JSON_ES5 => true])))->is([
            "Ymd"        => "2014-12-24T00:00:00.000000+09:00",
            "YmdTHis"    => "2014-12-24T12:34:56.000000+09:00",
            "YmdTHis.u"  => "2014-12-24T12:34:56.789000+09:00",
            "YmdTHisP"   => "2014-12-24T12:34:56.000000+01:00",
            "YmdTHis.uP" => "2014-12-24T12:34:56.789000+01:00",
            "Ymd His"    => "2014-12-24T12:34:56.000000+09:00",
            "Ymd His.u"  => "2014-12-24T12:34:56.789000+09:00",
            "Ymd HisP"   => "2014-12-24T12:34:56.000000+01:00",
            "Ymd His.uP" => "2014-12-24T12:34:56.789000+01:00",
        ]);

        that(json_import(chr(0xC2) . chr(0xA0) . ' 3 ', [JSON_ES5 => true]))->isSame(3);
        that(json_import(chr(0xA0) . ' 3 ', [JSON_ES5 => true]))->isSame(3);
        that(json_import('0xff', [JSON_ES5 => true]))->isSame(255);
        that(json_import('+NaN', [JSON_ES5 => true]))->isNan();
    }

    function test_json_import5_error()
    {
        that(self::resolveFunction('json_import'))('syntax error', [JSON_THROW_ON_ERROR => false])->isNull();

        that(self::resolveFunction('json_import'))('123,456')->wasThrown("Mismatch");
        that(self::resolveFunction('json_import'))('{')->wasThrown("Mismatch ']'");
        that(self::resolveFunction('json_import'))('[')->wasThrown("Mismatch '['");
        that(self::resolveFunction('json_import'))('[1')->wasThrown("Mismatch '['");
        that(self::resolveFunction('json_import'))('{{}')->wasThrown("Mismatch ']'");
        that(self::resolveFunction('json_import'))('[}')->wasThrown("Mismatch '}'");
        that(self::resolveFunction('json_import'))(']]')->wasThrown("Mismatch ']'");
        that(self::resolveFunction('json_import'))('[1] dummy')->wasThrown("Unexpected array value ']'");
        that(self::resolveFunction('json_import'))('{[1]: 1}')->wasThrown("Unexpected object key '[1]'");
        that(self::resolveFunction('json_import'))('{aaa: [1] ccc}')->wasThrown("Unexpected object value '}'");
        that(self::resolveFunction('json_import'))('{aaa bbb}')->wasThrown("Missing object key 'aaa'");
        that(self::resolveFunction('json_import'))('{,}')->wasThrown("Missing element");
        that(self::resolveFunction('json_import'))('[,]')->wasThrown("Missing element");
        that(self::resolveFunction('json_import'))('{a:1,,b:2}')->wasThrown("Missing element");
        that(self::resolveFunction('json_import'))('[1,,2]')->wasThrown("Missing element");

        that(self::resolveFunction('json_import'))('/* ccc')->wasThrown("at line"); // for both php 7.4 and 8.1
        that(self::resolveFunction('json_import'))('/# ccc')->wasThrown("Mismatch '['");
        that(self::resolveFunction('json_import'))('{123 : 456}')->wasThrown("Bad identifier");

        that(self::resolveFunction('json_import'))('"" \'\'')->wasThrown("Bad string");
        that(self::resolveFunction('json_import'))('08')->wasThrown("Octal literal");
        that(self::resolveFunction('json_import'))('0xxxx')->wasThrown("Bad hex number");
        that(self::resolveFunction('json_import'))('+true')->wasThrown("Bad number");
        that(self::resolveFunction('json_import'))('+Indigo')->wasThrown("Bad number");
        that(self::resolveFunction('json_import'))('hoge')->wasThrown("Bad value");
        that(self::resolveFunction('json_import'))('NotANumber')->wasThrown("Bad value");

        that(self::resolveFunction('json_import'))('[[1]]', [JSON_MAX_DEPTH => 2])->wasThrown('Maximum stack');
        that(self::resolveFunction('json_import'))('{"foo": {"bar": "baz"}}', [JSON_MAX_DEPTH => 2])->wasThrown('Maximum stack');
    }

    function test_json_import5_misc()
    {
        $files = file_list(__DIR__ . '/files/json5', ['extension' => 'json5']);
        foreach ($files as $file) {
            $data = explode('////////// EXPECTED OUTPUT: //////////', file_get_contents($file));
            $json = $data[0];
            $expected1 = trim($data[1] ?? '');
            $expected2 = trim($data[2] ?? '');

            try {
                if ($expected1) {
                    $message = <<<MESSAGE
                    file: $file
                    json: $json
                    expected: $expected1
                    MESSAGE;
                    that(serialize(json_import($json, [JSON_ES5 => true, JSON_OBJECT_AS_ARRAY => false])))->as($message)->isSame($expected1);
                }
                if ($expected2) {
                    $message = <<<MESSAGE
                    file: $file
                    json: $json
                    expected: $expected2
                    MESSAGE;
                    that(serialize(json_import($json, [JSON_ES5 => true, JSON_OBJECT_AS_ARRAY => true])))->as($message)->isSame($expected2);
                }
            }
            catch (\Throwable $t) {
                $this->fail($message . "\n$t");
            }
        }
    }

    function test_ltsv_export()
    {
        that(ltsv_export(['a' => 'A', 'b' => 'B', 'c' => 'C']))->is("a:A	b:B	c:C");
        that(ltsv_export(["a\ta" => "a", "b" => "b\tb", "c\\t" => 'C\\C']))->is('a\ta:a	b:b\tb	c\\\\t:C\\\\C');
        that(ltsv_export(["a\ta" => "a", "b" => "b\tb"], ['escape' => '%']))->is("a%ta:a	b:b%tb");
        that(ltsv_export(["a\ta" => "a", "b" => "b\tb"], ['escape' => '']))->is("a	a:a	b:b	b");

        that(ltsv_export(['a' => ['x', 'y'], 'b' => 'B']))->is('a:`["x","y"]`	b:B');
        that(ltsv_export(['a' => new Concrete('hoge'), 'b' => 'B']))->is('a:hoge	b:B');

        that(self::resolveFunction('ltsv_export'))(['a:a' => 'A'])->wasThrown('label contains ":"');
    }

    function test_ltsv_import()
    {
        that(ltsv_import("a:A	b:B	c:C"))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        that(ltsv_import('a\ta:a	b:b\tb	c\\\\t:C\\\\C'))->is(["a\ta" => "a", "b" => "b\tb", "c\\t" => 'C\\C']);

        that(ltsv_import('a:`["x","y"]`	b:B'))->is(['a' => ['x', 'y'], 'b' => 'B']);
        that(ltsv_import('a:`xyz`	b:B'))->is(['a' => '`xyz`', 'b' => 'B']);
    }

    function test_markdown_list()
    {
        that("\n" . markdown_list(['A', 'B', 'C' => [1, 2, 3]]))->is("
- A
- B
- C: 
    - 1
    - 2
    - 3
");

        that("\n" . markdown_list(['a' => 'A', 'b' => 'B', 'ls' => [1, 2, 3]]))->is("
- a: A
- b: B
- ls: 
    - 1
    - 2
    - 3
");

        that("\n" . markdown_list(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [1, 2, 3]]))->is("
- a: A
- b: B
- ls: LS
    - 1
    - 2
    - 3
");

        that("\n" . markdown_list(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [10 => 1, 20 => 2, 30 => 3]]))->is("
- a: A
- b: B
- ls: LS
    - 10: 1
    - 20: 2
    - 30: 3
");

        that("\n" . markdown_list(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [1, 'a' => 2, 3]], [
                'indent'    => "\t",
                'separator' => ' = ',
                'liststyle' => '*',
                'ordered'   => true,
            ]))->is("
* a = A
* b = B
* ls = LS
	1. 1
	* a = 2
	2. 3
"
        );

        that("\n" . markdown_list(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [1, 'a' => 2, 3]], [
                'indent'    => "\t",
                'separator' => ' = ',
                'liststyle' => '*',
                'ordered'   => true,
                'indexed'   => false,
            ]))->is("
* a = A
* b = B
* ls = LS
* 0 = 
	* 0 = 1
	* a = 2
	* 1 = 3
"
        );
    }

    function test_markdown_table()
    {
        that("\n" . markdown_table([['a' => 'xx']]))->is("
| a   |
| --- |
| xx  |
");

        that("\n" . markdown_table([['a' => '99', 'b' => '123,456.789'], ['a' => '999', 'b' => '-123.456'], ['a' => '', 'b' => '']]))->is("
|   a |           b |
| --: | ----------: |
|  99 | 123,456.789 |
| 999 |    -123.456 |
|     |             |
");

        that("\n" . markdown_table([['a' => 'aa'], ['b' => "b\nb"]]))->is("
| a   | b   |
| --- | --- |
| aa  |     |
|     | b   |
|     | b   |
");

        that("\n" . markdown_table([['a' => 'あ'], ['b' => 'い']]))->is("
| a   | b   |
| --- | --- |
| あ  |     |
|     | い  |
");

        that("\n" . markdown_table(['x' => ['a' => 'xx']], [
                'keylabel' => 'key',
            ]))->is("
| key | a   |
| --- | --- |
| x   | xx  |
");

        that("\n" . markdown_table(["1\n2\n3" => ['a' => "a1\na2"], "4\n5" => ['a' => "a3\na4\na5"]], [
                'keylabel' => 'key',
                'context'  => 'plain',
            ]))->is("
| key | a   |
| --: | --- |
|   1 | a1  |
|   2 | a2  |
|   3 |     |
|   4 | a3  |
|   5 | a4  |
|     | a5  |
");

        that("\n" . markdown_table(["1\n2\n3" => ['a' => "a1\na2"], "4\n5" => ['a' => ["a3", "a4", 'x' => "a9"]]], [
                'keylabel' => 'key',
                'context'  => 'plain',
            ]))->is('
| key | a          |
| --: | ---------- |
|   1 | a1         |
|   2 | a2         |
|   3 |            |
|   4 | {          |
|   5 |   0: "a3", |
|     |   1: "a4", |
|     |   x: "a9", |
|     | }          |
');

        that(self::resolveFunction('markdown_table'))('')->wasThrown('must be array of hasharray');
    }

    function test_paml_export()
    {
        that(paml_export([
            "null"    => null,
            "bool1"   => false,
            "bool2"   => true,
            "int"     => 123,
            "double"  => 3.14,
            "string1" => "xyz",
            "string2" => '[x, "y", z]',
        ]))->isSame('null: null, bool1: false, bool2: true, int: 123, double: 3.14, string1: "xyz", string2: "[x, \\"y\\", z]"');

        that(paml_export([
            "array" => [1, 2, "3"],
            "nest"  => [
                "a" => [
                    "b" => [
                        "c" => ["X"],
                    ],
                ],
            ],
        ], [
            'trailing-comma' => true,
            'pretty-space'   => false,
        ]))->isSame('array:[1,2,"3",],nest:{a:{b:{c:["X",],},},},');
    }

    function test_paml_import()
    {
        that(paml_import('null1:null,bool1: false, bool2:true , int: 123, double: 3.14, string1:xyz,string2:"[x, \"y\", \'z\']"'))->isSame([
            "null1"   => null,
            "bool1"   => false,
            "bool2"   => true,
            "int"     => 123,
            "double"  => 3.14,
            "string1" => "xyz",
            "string2" => '[x, "y", \'z\']',
        ]);

        that(paml_import("hash:[1,2,'a,b,', \"c,d,\",x:'X','y:Y',\"z:Z\", 4]"))->isSame([
            "hash" => [1, 2, 'a,b,', 'c,d,', 'x' => 'X', 'y:Y', 'z:Z', 4],
        ]);

        that(paml_import('d:\'a\\nz\', s:"a\\\\nz"'))->isSame([
            'd' => 'a\\nz',
            's' => "a\\nz",
        ]);

        that(paml_import('e: E_ERROR, ao: ArrayObject::STD_PROP_LIST'))->isSame([
            "e"  => E_ERROR,
            "ao" => \ArrayObject::STD_PROP_LIST,
        ]);

        that(paml_import('E_ERROR, \\ArrayObject::STD_PROP_LIST'))->isSame([
            0 => E_ERROR,
            1 => \ArrayObject::STD_PROP_LIST,
        ]);

        that(paml_import('"E_ERROR", "ArrayObject::STD_PROP_LIST"'))->isSame([
            0 => 'E_ERROR',
            1 => 'ArrayObject::STD_PROP_LIST',
        ]);

        that(paml_import('ArrayObject::class, class:\\ArrayObject::CLASS'))->isSame([
            0       => 'ArrayObject',
            'class' => 'ArrayObject',
        ]);

        that(paml_import('array:[1,2,"3"], nest:[a: [b: [c: [X]]]]'))->isSame([
            "array" => [1, 2, "3"],
            "nest"  => [
                "a" => [
                    "b" => [
                        "c" => ["X"],
                    ],
                ],
            ],
        ]);

        that(paml_import("a:A,\nb:B,array:[1,\n2,\n\"3\\n4\",\n],object:{1,\n2,\n\"3\\n4\",\n}"))->is([
            'a'      => 'A',
            'b'      => 'B',
            "array"  => [1, 2, "3\n4"],
            "object" => (object) [1, 2, "3\n4"],
        ]);

        that(paml_import("a:A,\nb:B,array:[1,\n2,\n\"3\\n4\",\n],object:{1,\n2,\n\"3\\n4\",\n}", [
            'stdclass' => false,
        ]))->is([
            'a'      => 'A',
            'b'      => 'B',
            "array"  => [1, 2, "3\n4"],
            "object" => [1, 2, "3\n4"],
        ]);

        that(paml_import('empty_array1:[], empty_array2:{}, empty_string1:,empty_string2:""'))->is([
            "empty_array1"  => [],
            "empty_array2"  => (object) [],
            "empty_string1" => '',
            "empty_string2" => '',
        ]);

        that(paml_import('"a":\'A\', "{b}":"B"'))->is([
            'a'   => 'A',
            '{b}' => 'B',
        ]);

        that(paml_import('`1 | 2 | 4 | 8`, x: `1 * 2 * 4 * 8`', [
            'expression' => false,
        ]))->is([
            0   => '`1 | 2 | 4 | 8`',
            'x' => '`1 * 2 * 4 * 8`',
        ]);

        that(paml_import('`1 | 2 | 4 | 8`, x: `1 * 2 * 4 * 8`', [
            'expression' => true,
        ]))->is([
            0   => 15,
            'x' => 64,
        ]);

        that(paml_import('ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC', [
            'expression' => true,
        ]))->is([
            0 => \ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PUBLIC,
        ]);

        that(paml_import('  '))->isSame([]);
        that(paml_import(' xxx '))->isSame(['xxx']);
        that(paml_import(',,'))->isSame(['', '']);
        that(paml_import('array:[1,2,"3",]', [
            'trailing-comma' => true,
        ]))->isSame([
            "array" => [1, 2, "3"],
        ]);
        that(paml_import('array:[1,2,"3",]', [
            'trailing-comma' => false,
        ]))->isSame([
            "array" => [1, 2, "3", ""],
        ]);
    }

    function test_paml_transport()
    {
        $string = file_get_contents(__DIR__ . '/files/paml/text.paml');
        $array = paml_import($string);
        that($array)->isSame([
            'text'   => 'this is raw string',
            'break'  => 'this
is
break
string',
            'quote1' => 'a
z',
            'quote2' => 'a\nz',
        ]);
        $exported = paml_export($array);
        that($exported)->isSame('text: "this is raw string", break: "this\nis\nbreak\nstring", quote1: "a\nz", quote2: "a\\\\nz"');
        that(paml_import($exported))->isSame($array);
    }

    function test_xmlss_import_excel()
    {
        $expected = [
            [
                'id'   => '式',
                'data' => '3',
            ],
            [
                'id'   => '参照',
                'data' => '3',
            ],
            [
                'id'   => '日付',
                'data' => new \DateTimeImmutable('2024-12-24T00:00:00.000'),
            ],
            [
                'id'   => '装飾',
                'data' => 'redboldstrike',
            ],
            [
                'id'   => '空白後',
                'data' => 'plain',
            ],
            [
                'id'   => 'データ9',
                'data' => 'data9',
            ],
        ];

        $arrays = xmlss_import(fopen(__DIR__ . '/files/xmlss/book.xml', 'r'), [
            'method' => 'dom',
            'sheet'  => 'Sheet2',
            'limit'  => 6,
        ]);
        that($arrays)->is($expected);
        $arrays = xmlss_import(fopen(__DIR__ . '/files/xmlss/book.xml', 'r'), [
            'method' => 'sax',
            'sheet'  => 'Sheet2',
            'limit'  => 6,
        ]);
        that($arrays)->is($expected);
    }

    function test_xmlss_import_invalid()
    {
        that(self::resolveFunction('xmlss_import'))('<invalid', [
            'method' => 'dom',
        ])->wasThrown('Start Tag invalid');
        that(self::resolveFunction('xmlss_import'))('<invalid', [
            'method' => 'sax',
        ])->wasThrown('Start Tag invalid');

        that(self::resolveFunction('xmlss_import'))('<Workbook></Workbook>', [
            'method' => 'dom',
        ])->wasThrown('Worksheet is not found');
        that(self::resolveFunction('xmlss_import'))('<Workbook></Workbook>', [
            'method' => 'sax',
        ])->wasThrown('Worksheet is not found');
    }

    function test_xmlss_export()
    {
        $string = xmlss_export([], [
            'xml'   => [
                'document' => [
                    'Author'  => null,
                    'Created' => null,
                    'Version' => null,
                ],
                'style'    => [
                    'Default' => [
                        'Name'   => null,
                        'Parent' => null,
                    ],
                ],
                'sheet'    => [
                    'Name'    => 'SheetName',
                    'Options' => [
                        'Panes' => [
                            [
                                'ActiveRow'      => null,
                                'ActiveCol'      => null,
                                'RangeSelection' => null,
                            ],
                        ],
                    ],
                ],
                'table'    => [
                    'DefaultColumnWidth' => null,
                    'DefaultRowHeight'   => null,
                    'StyleID'            => null,
                ],
                'column'   => [
                    [
                        'AutoFitWidth' => null,
                        'Width'        => null,
                    ],
                    [
                        'StyleID' => null,
                    ],
                ],
                'comment'  => [
                    [
                        'ShowAlways' => null,
                        'Data'       => null,
                    ],
                ],
                'row'      => [
                    'Height'  => null,
                    'StyleID' => null,
                ],
            ],
            'break' => "\n",
        ]);
        that($string)->is(<<<XML
<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">
 <Worksheet ss:Name="SheetName">
  <Table ss:ExpandedColumnCount="0">
  </Table>
 </Worksheet>
</Workbook>
XML,);

        $rows = [
            ['id' => 1, 'name' => '<hoge>', 'create_at' => '2024-12-24'],
            ['id' => 2, 'name' => "fu\nga", 'create_at' => '2024-12-25'],
            ['id' => 3, 'name' => 'あいう', 'create_at' => '2024-12-26'],
        ];

        $receiver = fopen('php://memory', 'r+b');
        $size = xmlss_export($rows, [
            'xml'     => [
                'document' => [
                    'Author'  => 'arima',
                    'Created' => '2024-12-24T12:34:56Z',
                    'Version' => '14.0',
                ],
                'style'    => [
                    's1' => [
                        'Name'         => 'Custom',
                        'Alignment'    => [
                            'WrapText' => 1,
                        ],
                        'Borders'      => [
                            'Top' => [
                                'Color'     => '#0000ff',
                                'LineStyle' => 'Continuous',
                                'Weight'    => 1,
                            ],
                        ],
                        'Font'         => [
                            'Bold'      => true,
                            'Color'     => '#ff0000',
                            'Underline' => "Single",
                            'Size'      => 24,
                        ],
                        'Interior'     => [
                            'Color'   => '#00ff00',
                            'Pattern' => "Solid",
                        ],
                        'NumberFormat' => [
                            'Format' => '@',
                        ],
                    ],
                    's2' => [
                        'Parent' => 's1',
                    ],
                ],
                'sheet'    => [
                    'Name'    => 'SheetName',
                    'Options' => [
                        'Panes' => [
                            [
                                'Number'         => 3,
                                'ActiveRow'      => 1,
                                'ActiveCol'      => 2,
                                'RangeSelection' => ['R1C2', [3, 4], [[5, 6]], [[7, 8], [9, 10]]],
                            ],
                        ],
                    ],
                ],
                'table'    => [
                    'DefaultColumnWidth' => 11,
                    'DefaultRowHeight'   => 22,
                    'StyleID'            => "s1",
                ],
                'column'   => [
                    [
                        'AutoFitWidth' => true,
                        'Width'        => 400,
                    ],
                    [
                        'StyleID' => "s1",
                    ],
                ],
                'comment'  => [
                    [
                        'ShowAlways' => true,
                        'Data'       => 'comment',
                    ],
                ],
                'row'      => [
                    'Height'  => 12,
                    'StyleID' => "s1",
                ],
            ],
            'initial' => 'initial header',
            'break'   => "\n",
            'output'  => $receiver,
        ]);
        rewind($receiver);
        $string = stream_get_contents($receiver);
        that($size)->isSame(strlen($string));
        that($string)->is(<<<XML
<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>arima</Author>
  <Created>2024-12-24T12:34:56Z</Created>
  <Version>14.0</Version>
 </DocumentProperties>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
  </Style>
  <Style ss:ID="s1" ss:Name="Custom">
   <Alignment ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Top" ss:Color="#0000ff" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:Bold="1" ss:Color="#ff0000" ss:Underline="Single" ss:Size="24"/>
   <Interior ss:Color="#00ff00" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="@"/>
  </Style>
  <Style ss:ID="s2" ss:Parent="s1">
  </Style>
 </Styles>
 <Worksheet ss:Name="SheetName">
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>1</ActiveRow>
     <ActiveCol>2</ActiveCol>
     <RangeSelection>R1C2,R3C4,R5C6,R7C8:R9C10</RangeSelection>
    </Pane>
   </Panes>
  </WorksheetOptions>
  <Table ss:DefaultColumnWidth="11" ss:DefaultRowHeight="22" ss:StyleID="s1" ss:ExpandedColumnCount="3">
   <Column ss:AutoFitWidth="1" ss:Width="400"/>
   <Column ss:StyleID="s1"/>
   <Row ss:Height="12" ss:StyleID="s1">
    <Cell><Data ss:Type="String">initial header</Data></Cell>
   </Row>
   <Row ss:Height="12" ss:StyleID="s1">
    <Cell><Data ss:Type="String">id</Data><Comment ss:ShowAlways="1"><Data>comment</Data></Comment></Cell>
    <Cell><Data ss:Type="String">name</Data></Cell>
    <Cell><Data ss:Type="String">create_at</Data></Cell>
   </Row>
   <Row ss:Height="12" ss:StyleID="s1">
    <Cell><Data ss:Type="Number">1</Data></Cell>
    <Cell><Data ss:Type="String">&#60;hoge&#62;</Data></Cell>
    <Cell><Data ss:Type="String">2024-12-24</Data></Cell>
   </Row>
   <Row ss:Height="12" ss:StyleID="s1">
    <Cell><Data ss:Type="Number">2</Data></Cell>
    <Cell><Data ss:Type="String">fu&#10;ga</Data></Cell>
    <Cell><Data ss:Type="String">2024-12-25</Data></Cell>
   </Row>
   <Row ss:Height="12" ss:StyleID="s1">
    <Cell><Data ss:Type="Number">3</Data></Cell>
    <Cell><Data ss:Type="String">あいう</Data></Cell>
    <Cell><Data ss:Type="String">2024-12-26</Data></Cell>
   </Row>
  </Table>
 </Worksheet>
</Workbook>
XML,);
    }

    function test_xmlss_transport_style()
    {
        $rows = [
            ['id' => 1, 'name' => '<hoge>', 'create_at' => '2024-12-24'],
            ['id' => 2, 'name' => "fu\nga", 'create_at' => '2024-12-25'],
            ['id' => 3, 'name' => 'あいう', 'create_at' => '2024-12-26'],
        ];

        $string = xmlss_export($rows, [
            'xml'     => [
                'style'  => [
                    's1' => [
                        'Name'      => 'Custom',
                        'Alignment' => [
                            'WrapText' => 1,
                        ],
                        'Borders'   => [
                            'Top'   => [
                                'LineStyle' => 'Continuous',
                                'Weight'    => 1,
                            ],
                            'Right' => [
                                'LineStyle' => null,
                                'Weight'    => null,
                            ],
                        ],
                    ],
                ],
                'column' => [
                    [
                        'Width' => 400,
                    ],
                    [
                        'StyleID' => "s1",
                    ],
                ],
            ],
            'initial' => 'initial header',
        ]);
        that($string)->contains('<Style ss:ID="Default" ss:Name="Normal">');
        that($string)->contains('<Style ss:ID="s1" ss:Name="Custom">');
        that($string)->contains('<Alignment ss:WrapText="1"/>');
        that($string)->contains('<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>');
        that($string)->notContains('ss:Position="Right"');

        $arrays = xmlss_import($string, [
            'method'  => 'dom',
            'initial' => 1,
        ]);
        that($arrays)->is($rows);
        $arrays = xmlss_import($string, [
            'method'  => 'sax',
            'initial' => 1,
        ]);
        that($arrays)->is($rows);
    }

    function test_xmlss_transport_type()
    {
        $datetime = new class('2024-12-24') extends \DateTimeImmutable {
            public function __toString(): string
            {
                return $this->format(self::ATOM);
            }
        };
        $rows = [
            ['id' => 1, 'name' => '<hoge>', 'create_at' => $datetime->modify('+1 day'), 'status' => true],
            ['id' => 2, 'name' => "fu\nga", 'create_at' => $datetime->modify('+2 day'), 'status' => true],
            ['id' => 3, 'name' => 'あいう', 'create_at' => $datetime->modify('+3 day'), 'status' => false],
        ];

        $string = xmlss_export($rows, [
            // stub
        ]);
        that($string)->contains('<Data ss:Type="Number">3</Data>');
        that($string)->contains('<Data ss:Type="String">あいう</Data>');
        that($string)->contains('<Data ss:Type="DateTime">2024-12-27T00:00:00+09:00</Data>');
        that($string)->contains('<Data ss:Type="Boolean"></Data></Cell>');

        $generator = xmlss_import($string, [
            'method'   => 'dom',
            'generate' => true,
        ]);
        that($generator)->isInstanceOf(\Generator::class);
        $arrays = iterator_to_array($generator);
        that($arrays)->is($rows);
        that($arrays[0]['id'])->isInt();
        that($arrays[0]['name'])->isString();
        that($arrays[0]['create_at'])->isInstanceOf(\DateTimeInterface::class);
        that($arrays[0]['status'])->isBool();
        $generator = xmlss_import($string, [
            'method'   => 'sax',
            'generate' => true,
        ]);
        that($generator)->isInstanceOf(\Generator::class);
        $arrays = iterator_to_array($generator);
        that($arrays)->is($rows);
        that($arrays[0]['id'])->isInt();
        that($arrays[0]['name'])->isString();
        that($arrays[0]['create_at'])->isInstanceOf(\DateTimeInterface::class);
        that($arrays[0]['status'])->isBool();
    }

    function test_xmlss_transport_headers()
    {
        $rows = [
            ['id' => 1, 'name' => '<hoge>', 'create_at' => '2024-12-24'],
            ['id' => 2, 'name' => "fu\nga", 'create_at' => '2024-12-25'],
            ['id' => 3, 'name' => 'あいう', 'create_at' => '2024-12-26'],
        ];

        $string = xmlss_export(new \ArrayIterator($rows), [
            'initial' => 'initial header',
            'headers' => ['id' => 'ID', 'name' => 'NAME'],
        ]);
        that($string)->contains('<Cell><Data ss:Type="String">ID</Data></Cell>');
        that($string)->contains('<Cell><Data ss:Type="String">NAME</Data></Cell>');

        $arrays = xmlss_import($string, [
            'method'  => 'dom',
            'initial' => 1,
            'headers' => ['ID' => 'id', 'NAME' => 'name'],
        ]);
        that($arrays)->is(array_map(fn($row) => array_remove($row, 'create_at'), $rows));
        $arrays = xmlss_import($string, [
            'method'  => 'sax',
            'initial' => 1,
            'headers' => ['id2', 'name2'],
        ]);
        that($arrays)->is([
            ['id2' => 'ID', 'name2' => 'NAME'],
            ['id2' => 1, 'name2' => '<hoge>'],
            ['id2' => 2, 'name2' => "fu\nga"],
            ['id2' => 3, 'name2' => 'あいう'],
        ]);
    }

    function test_xmlss_transport_comment()
    {
        $rows = [
            ['id' => 1, 'name' => '<hoge>', 'create_at' => '2024-12-24'],
            ['id' => 2, 'name' => "fu\nga", 'create_at' => '2024-12-25'],
            ['id' => 3, 'name' => 'あいう', 'create_at' => '2024-12-26'],
        ];

        $string = xmlss_export(new \ArrayIterator($rows), [
            'xml' => [
                'comment' => [
                    'id' => [
                        'Author'     => 'id',
                        'ShowAlways' => true,
                        'Data'       => "foo\nbar",
                    ],
                    2    => [
                        'Author'     => 'create_at',
                        'ShowAlways' => 0,
                        'Data'       => new class {
                            public function __toString(): string
                            {
                                return '<Font>data</Font>';
                            }
                        },
                    ],
                ],
            ],
        ]);
        that($string)->contains('<Comment ss:Author="id" ss:ShowAlways="1"><Data>foo&#10;bar</Data></Comment>');
        that($string)->contains('<Comment ss:Author="create_at" ss:ShowAlways="0"><Data><Font>data</Font></Data></Comment>');

        $arrays = xmlss_import($string, [
            'method' => 'dom',
        ]);
        that($arrays)->is($rows);
        $arrays = xmlss_import($string, [
            'method' => 'sax',
            'strict' => true,
        ]);
        that($arrays)->is($rows);
    }

    function test_xmlss_transport_callback()
    {
        $rows = [
            ['id' => 1, 'name' => '<hoge>', 'create_at' => '2024-12-24'],
            ['id' => 2, 'name' => "fu\nga", 'create_at' => '2024-12-25'],
            ['id' => 3, 'name' => 'あいう', 'create_at' => '2024-12-26'],
        ];

        $receiver = fopen('php://memory', 'r+b');
        $size = xmlss_export($rows, [
            'headers'  => ['id', 'name'],
            'callback' => function ($row, $n) {
                if ($n === null) {
                    return false;
                }
                if ($n === 1) {
                    return false;
                }
                return true;
            },
            'output'   => $receiver,
        ]);
        that($size)->isInt();

        rewind($receiver);
        $arrays = xmlss_import($receiver, [
            'method'   => 'dom',
            'headers'  => ['id', 'name'],
            'callback' => function (&$row, $n) {
                if ($n === 0) {
                    return false;
                }
                $row['id_name'] = $row['id'] . $row['name'];
            },
        ]);
        that($arrays)->is([
            ['id' => 3, 'name' => 'あいう', 'id_name' => '3あいう'],
        ]);
        rewind($receiver);
        $arrays = xmlss_import($receiver, [
            'method'   => 'sax',
            'headers'  => ['id', 'name'],
            'callback' => function (&$row, $n) {
                if ($n === 0) {
                    return false;
                }
                $row['id_name'] = $row['id'] . $row['name'];
            },
        ]);
        that($arrays)->is([
            ['id' => 3, 'name' => 'あいう', 'id_name' => '3あいう'],
        ]);
    }
}

<?php

namespace ryunosuke\Test\Package;

class StringsTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_strcat()
    {
        // 単なる結合演算子の関数版
        $this->assertEquals('abc', (strcat)('a', 'b', 'c'));

        // __toString() も活きるはず（implode してるだけだが念のため）
        $e = new \Exception();
        $this->assertEquals("a{$e}z", (strcat)('a', $e, 'z'));
    }

    function test_concat()
    {
        $this->assertSame((concat)('prefix-', 'middle', '-suffix'), 'prefix-middle-suffix');
        $this->assertSame((concat)('', 'middle', '-suffix'), '');
        $this->assertSame((concat)('prefix-', '', '-suffix'), '');
        $this->assertSame((concat)('prefix-', 'middle', ''), '');
    }

    function test_split_noempty()
    {
        // 空文字は空配列と規定している
        $this->assertEquals([], (split_noempty)('hoge', ''));
        $this->assertEquals([], (split_noempty)(',', ',, ,'));

        // 両サイド
        $this->assertEquals(['a'], (split_noempty)(',', ' a '));

        // trim しない
        $this->assertEquals([' A', ' ', ' B ', 'C '], (split_noempty)(',', " A,, , B ,C ", false));

        // trim 文字が与えられる
        $this->assertEquals([' A', 'B '], (split_noempty)(',', " A,\tB ", "\t"));

        // 結果はただの配列になる
        $this->assertEquals(['A', 'B', 'C'], (split_noempty)(',', 'A,,B,,,C'));
    }

    function test_multiexplode()
    {
        $target = 'one|two|three|four';

        // 配列だと複数文字列で分割
        $this->assertEquals(['one', 'two', 'three', 'four'], (multiexplode)(['|'], $target));
        $this->assertEquals(['', 'ne|tw', '|three|f', 'ur'], (multiexplode)(['o'], $target));
        $this->assertEquals(['', 'ne', 'tw', '', 'three', 'f', 'ur',], (multiexplode)(['|', 'o'], $target));

        // 負数は前詰めで返す
        $this->assertEquals(['one|two|three|four'], (multiexplode)('|', $target, -0));
        $this->assertEquals(['one|two|three|four'], (multiexplode)('|', $target, -1));
        $this->assertEquals(['one|two|three', 'four'], (multiexplode)('|', $target, -2));
        $this->assertEquals(['one|two', 'three', 'four'], (multiexplode)('|', $target, -3));
        $this->assertEquals(['one', 'two', 'three', 'four'], (multiexplode)('|', $target, -999));

        // ただの文字列・正数の挙動は素の explode と変わらない
        $this->assertEquals(['one|two|three|four'], (multiexplode)('|', $target, 0));
        $this->assertEquals(['one|two|three|four'], (multiexplode)('|', $target, 1));
        $this->assertEquals(['one', 'two|three|four'], (multiexplode)('|', $target, 2));
        $this->assertEquals(['one', 'two', 'three|four'], (multiexplode)('|', $target, 3));
        $this->assertEquals(['one', 'two', 'three', 'four'], (multiexplode)('|', $target, 999));

        // 上記の複合
        $this->assertEquals(['a,b c|d'], (multiexplode)([',', ' ', '|'], 'a,b c|d', -1));
        $this->assertEquals(['a,b c', 'd'], (multiexplode)([',', ' ', '|'], 'a,b c|d', -2));
        $this->assertEquals(['a,b', 'c', 'd'], (multiexplode)([',', ' ', '|'], 'a,b c|d', -3));
        $this->assertEquals(['a', 'b', 'c', 'd'], (multiexplode)([',', ' ', '|'], 'a,b c|d', -4));
    }

    function test_quoteexplode()
    {
        $this->assertEquals([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            "'e,f'"
        ], (quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', ['[' => ']', '"' => '"', "'" => "'"], '\\'));

        $this->assertEquals([
            'a',
            'b',
            'c',
            "'d e\tf'"
        ], (quoteexplode)([" ", "\t"], "a b\tc 'd e\tf'"));

        $this->assertEquals((quoteexplode)(',', 'a,b,{e,f}', ['{' => '}']), [
            'a',
            'b',
            '{e,f}',
        ]);

        $this->assertEquals([
            'a',
            '"x---y"',
            '["y" --- "z"]',
            'c\---d',
            "'e---f'"
        ], (quoteexplode)('---', 'a---"x---y"---["y" --- "z"]---c\\---d---\'e---f\'', ['[' => ']', '"' => '"', "'" => "'"], '\\'));

        $this->assertEquals([
            'a',
            '"b c"',
            "'d e'"
        ], (quoteexplode)(' ', 'a "b c" \'d e\'', '"\''));

        $this->assertEquals([
            'a"bc"',
        ], (quoteexplode)(' ', 'a"bc"', '"'));

        $this->assertEquals([
            'a"bc "',
            '',
        ], (quoteexplode)(' ', 'a"bc " ', '"'));
    }

    function test_str_equals()
    {
        $this->assertTrue((str_equals)('abcdef', 'abcdef'));
        $this->assertTrue((str_equals)('abcdef', 'ABCDEF', true));

        // unmatch type
        $this->assertFalse((str_equals)("123", 123));
        $this->assertFalse((str_equals)("", null));

        // null byte
        $this->assertTrue((str_equals)("abc\0def", "abc\0def"));
        $this->assertFalse((str_equals)("abc\0def", "abc\0xyz"));
        $this->assertFalse((str_equals)("abc\0def", "abc\0xyz", true));

        // stringable object
        $ex = new \Exception('hoge');
        $this->assertTrue((str_equals)($ex, $ex));
    }

    function test_str_contains()
    {
        // single
        $this->assertTrue((str_contains)('abcdef', 'cd'));
        $this->assertFalse((str_contains)('abcdef', 'xx'));

        // single int
        $this->assertTrue((str_contains)('12345', 5));
        $this->assertFalse((str_contains)('12345', 9));

        // empty
        $this->assertFalse((str_contains)('', ''));
        $this->assertFalse((str_contains)('abcdef', ''));

        // single case_insensitivity
        $this->assertTrue((str_contains)('abcdef', 'CD', true));
        $this->assertFalse((str_contains)('abcdef', 'XX', true));

        // multi or
        $this->assertTrue((str_contains)('abcdef', ['cd', 'XX'], false, false));
        $this->assertFalse((str_contains)('abcdef', ['XX', 'YY'], false, false));

        // multi and
        $this->assertTrue((str_contains)('abcdef', ['cd', 'ef'], false, true));
        $this->assertFalse((str_contains)('abcdef', ['cd', 'XX'], false, true));

        // multi case_insensitivity
        $this->assertTrue((str_contains)('abcdef', ['CD', 'XX'], true, false));
        $this->assertFalse((str_contains)('abcdef', ['XX', 'YY'], true, false));
        $this->assertTrue((str_contains)('abcdef', ['CD', 'EF'], true, true));
        $this->assertFalse((str_contains)('abcdef', ['CD', 'XX'], true, true));

        // stringable object
        $this->assertTrue((str_contains)(new \Concrete('abcdef'), new \Concrete('cd')));
        $this->assertFalse((str_contains)(new \Concrete('abcdef'), new \Concrete('xx')));
        $this->assertTrue((str_contains)(new \Concrete('abcdef'), new \Concrete('CD'), true, false));
        $this->assertFalse((str_contains)(new \Concrete('abcdef'), new \Concrete('XX'), true));
    }

    function test_str_chop()
    {
        $this->assertEquals("MMMzzz", (str_chop)('aaaMMMzzz', 'aaa'));
        $this->assertEquals("aaaMMM", (str_chop)('aaaMMMzzz', null, 'zzz'));
        $this->assertEquals("MMM", (str_chop)('aaaMMMzzz', 'aaa', 'zzz'));
        $this->assertEquals("aaaMMMzzz", (str_chop)('aaaMMMzzz', 'aaaa', 'zzzz'));
        $this->assertEquals(" aaaMMMzzz ", (str_chop)(' aaaMMMzzz ', 'aaa', 'zzz'));
        $this->assertEquals("aaaMMMzzz", (str_chop)('aaaMMMzzz', 'AAA', 'ZZZ'));
        $this->assertEquals("MMM", (str_chop)('aaaMMMzzz', 'AAA', 'ZZZ', true));
        $this->assertEquals("\naaazzz", (str_chop)("\naaazzz", 'aaa'));
        $this->assertEquals("aaazzz\n", (str_chop)("aaazzz\n", null, 'zzz'));
        $this->assertEquals("aaazzz", (str_chop)("\naaazzz\n", "\n", "\n"));
        $this->assertEquals('#^.\\$', (str_chop)('[#^.\\$]', "[", "]"));

        $this->assertEquals("MMMzzz", (str_lchop)('aaaMMMzzz', 'aaa'));
        $this->assertEquals("aaaMMM", (str_rchop)('aaaMMMzzz', 'zzz'));
    }

    function test_str_putcsv()
    {
        // シンプル
        $this->assertEquals("1,2,3", (str_putcsv)([1, 2, 3]));
        $this->assertEquals("1\t2\t3", (str_putcsv)([1, 2, 3], "\t"));
        $this->assertEquals("1,`,`,3", (str_putcsv)([1, ",", 3], ",", '`'));
        $this->assertEquals("1,`\t`,`@``", (str_putcsv)([1, "\t", '@`'], ",", '`', "@"));
        // コンプレックス
        $this->assertEquals("1,2,3\n4,5,6", (str_putcsv)([[1, 2, 3], [4, 5, 6]]));
        $this->assertEquals("1,2,3\n4,5,6", (str_putcsv)(new \ArrayIterator([[1, 2, 3], [4, 5, 6]])));
        $this->assertEquals("1,2,3\n4,5,6", (str_putcsv)((function () {
            yield [1, 2, 3];
            yield [4, 5, 6];
        })()));

        $this->assertException('single character', str_putcsv, [], 'aa');
    }

    function test_str_subreplace()
    {
        $string = 'xxxxx';

        // empty
        $this->assertEquals('xxxxx', (str_subreplace)($string, 'x', []));
        // string
        $this->assertEquals('Xxxxx', (str_subreplace)($string, 'x', 'X'));
        // all
        $this->assertEquals('X1X2X3X4X5', (str_subreplace)($string, 'x', ['X1', 'X2', 'X3', 'X4', 'X5']));
        // 3rd
        $this->assertEquals('xxX3xx', (str_subreplace)($string, 'x', [2 => 'X3']));
        // 1st, 4th
        $this->assertEquals('X1xX3xx', (str_subreplace)($string, 'x', [0 => 'X1', 2 => 'X3']));
        $this->assertEquals('X1xX3xx', (str_subreplace)($string, 'x', [2 => 'X3', 0 => 'X1']));
        // overlap
        $this->assertEquals('xxxZxxx', (str_subreplace)($string, 'x', [0 => 'xxx', 1 => 'Z']));
        // negative
        $this->assertEquals('xxxxZ', (str_subreplace)($string, 'x', [-1 => 'Z']));
        $this->assertEquals('Zxxxx', (str_subreplace)($string, 'x', [-5 => 'Z']));
        // notfound
        $this->assertEquals('xxxxx', (str_subreplace)($string, 'z', ['Z']));
        // case insensitivity
        $this->assertEquals('i1xxxx', (str_subreplace)($string, 'X', ['i1'], true));
        $this->assertEquals('xxxxi5', (str_subreplace)($string, 'X', [-1 => 'i5'], true));
        // multibyte
        $this->assertEquals('ああかああ', (str_subreplace)('あああああ', 'あ', [2 => 'か']));
        // no number
        $this->assertException("key must be integer", str_subreplace, $string, 'x', ['s' => '']);
        // out od range
        $this->assertException("'x' of 5th.", str_subreplace, $string, 'x', [5 => 'nodef']);
        $this->assertException("'x' of -6th.", str_subreplace, $string, 'x', [-6 => 'nodef']);
    }

    function test_str_submap()
    {
        $string = 'hello, world';

        // empty
        $this->assertEquals('hello, world', (str_submap)($string, []));
        // only 1
        $this->assertEquals('helLo, world', (str_submap)($string, [
            'l' => [
                1 => 'L',
            ],
        ]));
        // multiple
        $this->assertEquals('helLo1, wo2rld', (str_submap)($string, [
            'l' => [
                1 => 'L',
            ],
            'o' => [
                'o1',
                'o2',
            ],
        ]));
        // overlap
        $this->assertEquals('world, WORLD', (str_submap)($string, [
            'hello' => 'world',
            'world' => 'WORLD',
        ]));
        // negative
        $this->assertEquals('helLo, wOrld', (str_submap)($string, [
            'l' => [
                -2 => 'L',
            ],
            'o' => [
                -1 => 'O',
            ],
        ]));
        // notfound
        $this->assertEquals('hello, world', (str_submap)($string, ['xxx' => 'XXX']));
        // case insensitivity
        $this->assertEquals('H, world', (str_submap)($string, [
            'HELLO' => 'H',
        ], true));
        // multibyte
        $this->assertEquals('へろーわ棒るど', (str_submap)('へろーわーるど', ['ー' => [1 => '棒']]));
        // no number
        $this->assertException("key must be integer", str_submap, $string, ['w' => ['' => '']]);
        // out od range
        $this->assertException("'l' of 3th.", str_submap, $string, ['l' => [3 => 'nodef']]);
        $this->assertException("'l' of -4th.", str_submap, $string, ['l' => [-4 => 'nodef']]);
    }

    function test_str_between()
    {
        ////////// 0123456789A1234567891B23456789C123456789D
        $string = '{simple}, "{enclose}", \\{{escape\\}}';
        $n = 0;
        $this->assertSame('simple', (str_between)($string, '{', '}', $n));
        $this->assertSame(8, $n);
        $this->assertSame('escape\\}', (str_between)($string, '{', '}', $n));
        $this->assertSame(35, $n);
        $this->assertSame(false, (str_between)($string, '{', '}', $n));
        $this->assertSame(35, $n);

        // ずっとエスケープ中なので見つからない
        $string = '"{a}{b}{c}{d}{e}{f}{g}"';
        $n = 0;
        $this->assertSame(false, (str_between)($string, '{', '}', $n));

        // from to が複数文字の場合
        $string = '{{name}}, {{hobby}}';
        $n = 0;
        $this->assertSame('name', (str_between)($string, '{{', '}}', $n));
        $this->assertSame('hobby', (str_between)($string, '{{', '}}', $n));
        $this->assertSame(false, (str_between)($string, '{{', '}}', $n));

        // 中身が空の場合
        $string = '{{}} {{}} {{}}';
        $n = 0;
        $this->assertSame('', (str_between)($string, '{{', '}}', $n));
        $this->assertSame('', (str_between)($string, '{{', '}}', $n));
        $this->assertSame('', (str_between)($string, '{{', '}}', $n));
        $this->assertSame(false, (str_between)($string, '{{', '}}', $n));

        // くっついている場合
        $string = '{{first}}{{second}}{{third}}';
        $n = 0;
        $this->assertSame('first', (str_between)($string, '{{', '}}', $n));
        $this->assertSame('second', (str_between)($string, '{{', '}}', $n));
        $this->assertSame('third', (str_between)($string, '{{', '}}', $n));
        $this->assertSame(false, (str_between)($string, '{{', '}}', $n));

        // 開始終了が一致していない場合
        $string = '{first}}}}}} and {second}';
        $n = 0;
        $this->assertSame('first', (str_between)($string, '{', '}', $n));
        $this->assertSame('second', (str_between)($string, '{', '}', $n));
        $this->assertSame(false, (str_between)($string, '{', '}', $n));

        // 開始終了に包含関係がある場合
        $this->assertSame('first', (str_between)('!first!!', '!', '!!'));
        $this->assertSame('first', (str_between)('!!first!', '!!', '!'));
        $this->assertSame('first', (str_between)('!!first!!', '!!', '!!'));

        // enclosure も escape もしない単純な場合
        $n = 0;
        $this->assertSame('first', (str_between)('{first}"{second}"\\{third\\}', '{', '}', $n, null, null));
        $this->assertSame('second', (str_between)('{first}"{second}"\\{third\\}', '{', '}', $n, null, null));
        $this->assertSame('third\\', (str_between)('{first}"{second}"\\{third\\}', '{', '}', $n, null, null));

        // ネストしている場合
        $this->assertSame('nest1{nest2{nest3}}', (str_between)('{nest1{nest2{nest3}}}', '{', '}'));
    }

    function test_str_ellipsis()
    {
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', 0));
        $this->assertSame('1...7890', (str_ellipsis)('1234567890', 8, '...', 1));
        $this->assertSame('12...890', (str_ellipsis)('1234567890', 8, '...', 2));
        $this->assertSame('123...90', (str_ellipsis)('1234567890', 8, '...', 3));
        $this->assertSame('1234...0', (str_ellipsis)('1234567890', 8, '...', 4));
        $this->assertSame('12345...', (str_ellipsis)('1234567890', 8, '...', 5));
        $this->assertSame('12345...', (str_ellipsis)('1234567890', 8, '...', 6));
        $this->assertSame('12345...', (str_ellipsis)('1234567890', 8, '...', 7));
        $this->assertSame('12345...', (str_ellipsis)('1234567890', 8, '...', 8));
        $this->assertSame('12345...', (str_ellipsis)('1234567890', 8, '...', 9));
        $this->assertSame('12345...', (str_ellipsis)('1234567890', 8, '...', 10));
        $this->assertSame('12345...', (str_ellipsis)('1234567890', 8, '...', 11));
        $this->assertSame('1234...0', (str_ellipsis)('1234567890', 8, '...', -1));
        $this->assertSame('123...90', (str_ellipsis)('1234567890', 8, '...', -2));
        $this->assertSame('12...890', (str_ellipsis)('1234567890', 8, '...', -3));
        $this->assertSame('1...7890', (str_ellipsis)('1234567890', 8, '...', -4));
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', -5));
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', -6));
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', -7));
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', -8));
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', -9));
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', -10));
        $this->assertSame('...67890', (str_ellipsis)('1234567890', 8, '...', -11));

        $this->assertSame('12...890', (str_ellipsis)('1234567890', 8, '...', null));
        $this->assertSame('12...90', (str_ellipsis)('1234567890', 7, '...', null));

        $this->assertSame('１２・・・８９０', (str_ellipsis)('１２３４５６７８９０', 8, '・・・', null));
        $this->assertSame('１２・・・９０', (str_ellipsis)('１２３４５６７８９０', 7, '・・・', null));

        $this->assertSame('...', (str_ellipsis)('1234567890', 1, '...', null));
        $this->assertSame('1234567890', (str_ellipsis)('1234567890', 1000, '...', null));
    }

    function test_starts_with()
    {
        $this->assertTrue((starts_with)('abcdef', 'abc'));
        $this->assertFalse((starts_with)('abcdef', 'ABC'));
        $this->assertFalse((starts_with)('abcdef', 'xbc'));

        $this->assertTrue((starts_with)('abcdef', 'abc', true));
        $this->assertTrue((starts_with)('abcdef', 'ABC', true));
        $this->assertFalse((starts_with)('abcdef', 'xbc', true));

        $this->assertTrue((starts_with)('abcdef', ['a', 'X']));
        $this->assertTrue((starts_with)('abcdef', ['abc', 'XXX']));
        $this->assertFalse((starts_with)('abcdef', ['XXX']));
        $this->assertFalse((starts_with)('abcdef', []));

        $this->assertFalse((starts_with)('', 's'));
    }

    function test_ends_with()
    {
        $this->assertTrue((ends_with)('abcdef', 'def'));
        $this->assertFalse((ends_with)('abcdef', 'DEF'));
        $this->assertFalse((ends_with)('abcdef', 'xef'));

        $this->assertTrue((ends_with)('abcdef', 'def', true));
        $this->assertTrue((ends_with)('abcdef', 'DEF', true));
        $this->assertFalse((ends_with)('abcdef', 'xef', true));

        $this->assertTrue((ends_with)('abcdef', ['f', 'X']));
        $this->assertTrue((ends_with)('abcdef', ['def', 'XXX']));
        $this->assertFalse((ends_with)('abcdef', ['XXX']));
        $this->assertFalse((ends_with)('abcdef', []));

        $this->assertFalse((ends_with)('', 's'));
    }

    function test_camel_case()
    {
        $this->assertEquals('', (camel_case)(''));
        $this->assertEquals('thisIsAPen', (camel_case)('this-is-a-pen', '-'));
        $this->assertEquals('thisIsAPen', (camel_case)('this_is_a_pen'));
        $this->assertEquals('thisIsAPen', (camel_case)('_this_is_a_pen_'));
    }

    function test_pascal_case()
    {
        $this->assertEquals('', (pascal_case)(''));
        $this->assertEquals('ThisIsAPen', (pascal_case)('this-is-a-pen', '-'));
        $this->assertEquals('ThisIsAPen', (pascal_case)('this_is_a_pen'));
        $this->assertEquals('ThisIsAPen', (pascal_case)('_this_is_a_pen_'));
    }

    function test_snake_case()
    {
        $this->assertEquals('', (snake_case)(''));
        $this->assertEquals('this-is-a-pen', (snake_case)('ThisIsAPen', '-'));
        $this->assertEquals('this_is_a_pen', (snake_case)('ThisIsAPen'));
        $this->assertEquals('a_b_c', (snake_case)('ABC'));
        $this->assertEquals('a_b_c_', (snake_case)('_ABC_'));
    }

    function test_chain_case()
    {
        $this->assertEquals('', (chain_case)(''));
        $this->assertEquals('this_is_a_pen', (chain_case)('ThisIsAPen', '_'));
        $this->assertEquals('this-is-a-pen', (chain_case)('ThisIsAPen'));
        $this->assertEquals('a-b-c', (chain_case)('ABC'));
        $this->assertEquals('a-b-c-', (chain_case)('-ABC-'));
    }

    function test_namespace_split()
    {
        $this->assertEquals(['ns', 'hoge'], (namespace_split)('ns\\hoge'));
        $this->assertEquals(['\\ns', 'hoge'], (namespace_split)('\\ns\\hoge'));
        $this->assertEquals(['\\ns', ''], (namespace_split)('\\ns\\'));
        $this->assertEquals(['', 'hoge'], (namespace_split)('hoge'));
        $this->assertEquals(['', 'hoge'], (namespace_split)('\\hoge'));
        $this->assertEquals(['aaa', 'bbb'], (namespace_split)(new \Concrete('aaa\bbb')));
    }

    function test_htmltag()
    {
        $this->assertEquals(
            '<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden></a>',
            (htmltag)('a.c1#hoge.c2[name=hoge\[\]][href="http://hoge"][hidden]')
        );
        $this->assertEquals(
            '<a id="hoge" class="c1 c2" href="http://hoge">&lt;b&gt;bold&lt;/b&gt;</a>',
            (htmltag)(['a.c1#hoge.c2[href="http://hoge"]' => '<b>bold</b>'])
        );
        $this->assertEquals(
            '<a id="hoge" class="c1 c2" href="http://hoge"><b>&lt;bold&gt;</b></a>',
            (htmltag)([
                'a.c1#hoge.c2[href="http://hoge"]' => [
                    'b' => '<bold>',
                ],
            ])
        );
        $this->assertEquals(
            '<a id="hoge" class="c1 c2" href="http://hoge"><b>&lt;plain1&gt;<t>&lt;thin&gt;</t>&lt;plain2&gt;</b></a>',
            (htmltag)([
                'a.c1#hoge.c2[href="http://hoge"]' => [
                    'b' => [
                        '<plain1>',
                        't' => '<thin>',
                        '<plain2>',
                    ],
                ],
            ])
        );

        $this->assertEquals(
            '
<div id="hoge">
  <b>plain1</b>
  <b>plain2</b>
</div>
<span>plain</span>',
            (htmltag)([
                "\ndiv\n#hoge" => [
                    "\n  b"   => 'plain1',
                    "\n  b\n" => 'plain2',
                ],
                "span"         => 'plain',
            ])
        );

        $this->assertException('tagname is empty', htmltag, '#id.class');
        $this->assertException('#id is multiple', htmltag, 'a#id#id');
        $this->assertException('[a] is dumplicated', htmltag, 'a[a=1][a=2]');
        $this->assertException('[id] is dumplicated', htmltag, 'a#id[id=id]');
    }

    function provideUri()
    {
        $gen = function ($scheme = '', $user = '', $pass = '', $host = '', $port = '', $path = '', $query = [], $fragment = '') {
            return compact('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment');
        };
        return [
            'full'          => [
                'uri'   => 'scheme://user:pass@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('scheme', 'user', 'pass', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no schema'     => [
                'uri'   => 'user:pass@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', 'user', 'pass', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no user'       => [
                'uri'   => ':pass@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', 'pass', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no pass'       => [
                'uri'   => 'user@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', 'user', '', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no auth'       => [
                'uri'   => 'host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no host'       => [
                'uri'   => ':12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', '', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no port'       => [
                'uri'   => 'host/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', 'host', '', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no origin'     => [
                'uri'   => '/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', '', '', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no path'       => [
                'uri'   => '?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', '', '', '', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no query'      => [
                'uri'   => '#hash',
                'parts' => $gen('', '', '', '', '', '', [], 'hash'),
            ],
            'no query hash' => [
                'uri'   => '/path/to/hoge#hash',
                'parts' => $gen('', '', '', '', '', '/path/to/hoge', [], 'hash'),
            ],
            'no all'        => [
                'uri'   => '',
                'parts' => $gen(),
            ],
            'ipv4'          => [
                'uri'   => 'scheme://user:pass@127.0.0.1:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('scheme', 'user', 'pass', '127.0.0.1', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'ipv6'          => [
                'uri'   => 'scheme://user:pass@[2001:db8::1234:0:0:9abc]:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('scheme', 'user', 'pass', '2001:db8::1234:0:0:9abc', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'multibyte'     => [
                'uri'   => 'scheme://local.host/path/to/hoge?aaa=' . rawurlencode('あああ'),
                'parts' => $gen('scheme', '', '', 'local.host', '', '/path/to/hoge', ['aaa' => 'あああ'], ''),
            ],
        ];
    }

    function test_build_uri()
    {
        foreach ($this->provideUri() as $title => $data) {
            $this->assertEquals($data['uri'], (build_uri)($data['parts']), $title);
        }
    }

    function test_parse_uri()
    {
        foreach ($this->provideUri() as $title => $data) {
            $this->assertEquals($data['parts'], (parse_uri)($data['uri']), $title);
        }

        // default array
        $this->assertEquals([
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => '/defpath',
            'query'    => ['defquery' => ''],
            'fragment' => 'deffragment',
        ], (parse_uri)('', [
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => 'defpath',
            'query'    => 'defquery',
            'fragment' => 'deffragment',
        ]));

        // default string
        $this->assertEquals([
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => '/defpath',
            'query'    => ['defquery' => ''],
            'fragment' => 'deffragment',
        ], (parse_uri)('', 'defscheme://defuser:defpass@defhost:12345/defpath?defquery#deffragment'));
    }

    function test_parse_uri_special()
    {
        // double slash
        $this->assertEquals([
            'scheme'   => '',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ], (parse_uri)('//user:pass@host/path/to/hoge?op1=1&op2=2#hash'));

        // tripple slash
        $this->assertEquals([
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ], (parse_uri)('///path/to/hoge?op1=1&op2=2#hash'));

        // no port value
        $this->assertEquals([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ], (parse_uri)('scheme://user:pass@host:/path/to/hoge?op1=1&op2=2#hash'));

        // no path value
        $this->assertEquals([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ], (parse_uri)('scheme://user:pass@host?op1=1&op2=2#hash'));

        // no query value
        $this->assertEquals([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => [],
            'fragment' => 'hash',
        ], (parse_uri)('scheme://user:pass@host/path/to/hoge?#hash'));

        // no fragment value
        $this->assertEquals([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => [],
            'fragment' => '',
        ], (parse_uri)('scheme://user:pass@host/path/to/hoge?#'));
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

        $this->assertEquals('simple[a] = "A"
simple[b] = "B"
simple[quote] = "\"\000\\\\\'"
x[] = "A"
x[] = "B"
x[] = "C"
y[a] = "A"
y[b] = "B"
', (ini_export)($iniarray, ['process_sections' => false]));

        $this->assertEquals('[simple]
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
', (ini_export)($iniarray, ['process_sections' => true]));
    }

    function test_ini_import()
    {
        $this->assertEquals([
            'a'     => 'A',
            'b'     => 'B',
            'quote' => '"\000\\\'',
            'x'     => ['A', 'B', 'C'],
            'y'     => [
                'a' => 'A',
                'b' => 'B',
            ],
        ], (ini_import)('a = "A"
b = "B"
quote = "\"\000\\\\\'"
x[] = "A"
x[] = "B"
x[] = "C"
y[a] = "A"
y[b] = "B"
', ['process_sections' => false]));

        $this->assertEquals([
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
        ], (ini_import)('[simple]
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
', ['process_sections' => true]));
    }

    function test_csv_encoding()
    {
        $DATADIR = __DIR__ . '/Strings';

        $utf8array = [
            ['Ａ' => 'あ', 'Ｂ' => 'い', 'Ｃ' => 'う', 'Ｄ' => 'え', 'Ｅ' => 'お'],
            ['Ａ' => 'か', 'Ｂ' => 'き', 'Ｃ' => 'く', 'Ｄ' => 'け', 'Ｅ' => 'こ'],
        ];
        $sjisstring = require "$DATADIR/sjisstring.php";
        $sjisstring12345 = require "$DATADIR/sjisstring12345.php";
        $sjisstringnohead = require "$DATADIR/sjisstringnohead.php";

        $this->assertEquals($sjisstring, (csv_export)($utf8array, ['encoding' => 'SJIS']));
        $this->assertEquals($utf8array, (csv_import)($sjisstring, ['encoding' => 'SJIS']));

        $this->assertEquals($sjisstring12345, (csv_export)($utf8array, [
            'encoding' => 'SJIS',
            'headers'  => [
                'Ａ' => '１',
                'Ｂ' => '２',
                'Ｃ' => '３',
                'Ｄ' => '４',
                'Ｅ' => '５',
            ],
        ]));
        $this->assertEquals($utf8array, (csv_import)($sjisstringnohead, [
            'encoding' => 'SJIS',
            'headers'  => [
                'Ａ',
                'Ｂ',
                'Ｃ',
                'Ｄ',
                'Ｅ',
            ],
        ]));
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

        $this->assertEquals("a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
", (csv_export)($csvarrays));

        // headers 指定
        $this->assertEquals("A,C
a1,c1
a2,c2
a3,c3
", (csv_export)($csvarrays, ['headers' => ['a' => 'A', 'c' => 'C']]));

        // callback 指定
        $this->assertEquals("a,b,c
a1,B1,c1
a3,B3,c3
", (csv_export)($csvarrays, [
            'callback' => function (&$row, $n) {
                $row['b'] = strtoupper($row['b']);
                return $n !== 1;
            }
        ]));

        // output 指定
        $receiver = fopen('php://memory', 'r+b');
        $this->assertEquals(33, (csv_export)($csvarrays, ['output' => $receiver]));
        rewind($receiver);
        $this->assertEquals("a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
", stream_get_contents($receiver));

        // fputcsv 引数
        $csvarrays[0]['c'] = " c\n";
        $this->assertEquals("a b c
a1 b1 ' c
'
a2 b2 c2
a3 b3 c3
", (csv_export)($csvarrays, ['delimiter' => ' ', 'enclosure' => "'"]));
    }

    function test_csv_import()
    {
        $this->assertEquals([
            ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a2', 'b' => 'b2', 'c' => 'c2'],
            ['a' => 'a3', 'b' => 'b3', 'c' => 'c3'],
        ], (csv_import)('a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
'));

        // 空行とクオート
        $this->assertEquals([
            ['a' => 'a1,x', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'b3', 'c' => "c3\nx"],
        ], (csv_import)('a,b,c
"a1,x",b1,c1

a3,b3,"c3
x"
'));

        // ファイルポインタ
        file_put_contents(sys_get_temp_dir() . '/test.csv', 'a,b,c
"a1,x",b1,c1

a3,b3,"c3
x"
');
        $this->assertEquals([
            ['a' => 'a1,x', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'b3', 'c' => "c3\nx"],
        ], (csv_import)(fopen(sys_get_temp_dir() . '/test.csv', 'r')));

        // headers 指定（数値）
        $this->assertEquals([
            ['A' => 'a1', 'C' => 'c1'],
            ['A' => 'a2', 'C' => 'c2'],
        ], (csv_import)('
a1,b1,c1
a2,b2,c2
', ['headers' => ['A', 2 => 'C']]));

        // headers 指定（キーマップ）
        $this->assertEquals([
            ['xA' => 'a1', 'xC' => 'c1'],
            ['xA' => 'a2', 'xC' => 'c2'],
        ], (csv_import)('
A,B,C
a1,b1,c1
a2,b2,c2
', ['headers' => ['C' => 'xC', 'A' => 'xA', 'unknown' => 'x']]));

        // コールバック指定
        $this->assertEquals([
            ['a' => 'a1', 'b' => 'B1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'B3', 'c' => 'c3'],
        ], (csv_import)('a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
', [
            'callback' => function (&$row, $n) {
                $row['b'] = strtoupper($row['b']);
                return $n !== 1;
            }
        ]));

        // 要素数が合わないと例外
        $this->assertException('array_combine', csv_import, "a,b,c\nhoge");
    }

    function test_json_export()
    {
        // エラー情報を突っ込んでおく
        json_decode('aaa');

        // デフォルトオプション
        $this->assertEquals('[123.0,"あ"]', (json_export)([123.0, 'あ']));

        // オプション指定（上書き）
        $this->assertEquals("[\n    123,\n    \"\u3042\"\n]", (json_export)([123.0, 'あ'], [
            JSON_UNESCAPED_UNICODE      => false,
            JSON_PRESERVE_ZERO_FRACTION => false,
            JSON_PRETTY_PRINT           => true,
        ]));

        // depth
        $this->assertException('Maximum stack depth exceeded', json_export, [[[[[[]]]]]], [JSON_MAX_DEPTH => 3]);
    }

    function test_json_import()
    {
        // エラー情報を突っ込んでおく
        json_decode('aaa');

        // デフォルトオプション
        $this->assertEquals([123.0, "あ"], (json_import)('[123.0,"あ"]'));

        // オプション指定（上書き）
        $this->assertEquals((object) ['a' => 123.0, 'b' => "あ"], (json_import)('{"a":123.0,"b":"あ"}', [
            JSON_OBJECT_AS_ARRAY => false,
        ]));

        // depth
        $this->assertException('Maximum stack depth exceeded', json_import, '[[[[[[]]]]]]', [JSON_MAX_DEPTH => 3]);
    }

    function test_markdown_table()
    {
        $this->assertEquals("
| a   |
| --- |
| xx  |
", "\n" . (markdown_table)([['a' => 'xx']]));

        $this->assertEquals("
|   a |
| --: |
|  99 |
", "\n" . (markdown_table)([['a' => '99']]));

        $this->assertEquals("
| a   | b      |
| --- | ------ |
| aa  |        |
|     | b<br>b |
", "\n" . (markdown_table)([['a' => 'aa'], ['b' => "b\nb"]]));

        $this->assertEquals("
| a   | b   |
| --- | --- |
| あ  |     |
|     | い  |
", "\n" . (markdown_table)([['a' => 'あ'], ['b' => 'い']]));

        $this->assertException('must be array of hasharray', markdown_table, '');
    }

    function test_markdown_list()
    {
        $this->assertEquals("
- A
- B
- C: 
    - 1
    - 2
    - 3
", "\n" . (markdown_list)(['A', 'B', 'C' => [1, 2, 3]]));

        $this->assertEquals("
- a: A
- b: B
- ls: 
    - 1
    - 2
    - 3
", "\n" . (markdown_list)(['a' => 'A', 'b' => 'B', 'ls' => [1, 2, 3]]));

        $this->assertEquals("
- a: A
- b: B
- ls: LS
    - 1
    - 2
    - 3
", "\n" . (markdown_list)(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [1, 2, 3]]));

        $this->assertEquals("
* a = A
* b = B
* ls = LS
	1. 1
	2. 2
	3. 3
", "\n" . (markdown_list)(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [1, 2, 3]], [
                'indent'    => "\t",
                'separator' => ' = ',
                'liststyle' => '*',
                'ordered'   => true,
            ])
        );
    }

    function test_random_string()
    {
        $actual = (random_string)(256, 'abc');
        $this->assertEquals(256, strlen($actual)); // 256文字のはず
        $this->assertRegExp('#abc#', $actual); // 大抵の場合含まれるはず（極稀にコケる）

        $this->assertException('positive number', random_string, 0, 'x');
        $this->assertException('empty', random_string, 256, '');
    }

    public function test_kvsprintf()
    {
        $args = [
            'int'    => 12345,
            'float'  => 3.141592,
            'string' => 'mojiretu',
        ];

        // 普通の変換
        $result = (kvsprintf)('int:%int$d float:%float$F string:%string$s', $args);
        $this->assertEquals('int:12345 float:3.141592 string:mojiretu', $result);

        // 文字詰め(シンプル)
        $result = (kvsprintf)('int:%int$07d float:%float$010F string:%string$10s', $args);
        $this->assertEquals('int:0012345 float:003.141592 string:  mojiretu', $result);

        // 文字詰め(右。dで0埋めは効かない)
        $result = (kvsprintf)('int:%int$-07d float:%float$-010F string:%string$-10s', $args);
        $this->assertEquals('int:12345   float:3.14159200 string:mojiretu  ', $result);

        // 配列の順番は問わない
        $result = (kvsprintf)('int:%int$d float:%float$F string:%string$s', array_reverse($args));
        $this->assertEquals('int:12345 float:3.141592 string:mojiretu', $result);

        // 同じキーが出現
        $result = (kvsprintf)('int:%int$d int:%int$d int:%int$d', $args);
        $this->assertEquals('int:12345 int:12345 int:12345', $result);

        // %エスケープ
        $result = (kvsprintf)('int:%%int$d float:%%float$F string:%%string$s', $args);
        $this->assertEquals('int:%int$d float:%float$F string:%string$s', $result);

        // 先頭が書式指定子
        $result = (kvsprintf)('%hoge$d', ['hoge' => 123]);
        $this->assertEquals('123', $result);

        // "%%" の後に書式指定子
        $result = (kvsprintf)('%%%hoge$d', ['hoge' => 123]);
        $this->assertEquals('%123', $result);

        // キーが他のキーを含む
        $result = (kvsprintf)('%a$s_%aa$s_%aaa$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        $this->assertEquals('A_AA_AAA', $result);
        $result = (kvsprintf)('%aaa$s_%aa$s_%a$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        $this->assertEquals('AAA_AA_A', $result);

        // キー自体に%を含む
        $result = (kvsprintf)('%ho%ge$s', ['ho%ge' => 123]);
        $this->assertEquals('123', $result);

        // 存在しないキーを参照
        $this->assertException(new \OutOfBoundsException('Undefined index'), kvsprintf, '%aaaaa$d %bbbbb$d', ['hoge' => 123]);
    }

    public function test_preg_capture()
    {
        $this->assertEquals([], (preg_capture)('#([a-z])([0-9])([A-Z])#', 'a0Z', []));
        $this->assertEquals([1 => 'a'], (preg_capture)('#([a-z])([0-9])([A-Z])#', 'a0Z', [1 => '']));
        $this->assertEquals([4 => ''], (preg_capture)('#([a-z])([0-9])([A-Z])#', 'a0Z', [4 => '']));

        $this->assertEquals([], (preg_capture)('#([a-z])([0-9])([A-Z]?)#', 'a0', []));
        $this->assertEquals([3 => ''], (preg_capture)('#([a-z])([0-9])([A-Z]?)#', 'a0', [3 => '']));
        $this->assertEquals([3 => 'Z'], (preg_capture)('#([a-z])([0-9])([A-Z]?)#', 'a0Z', [3 => '']));

        $this->assertEquals([
            'one' => 'a',
            'two' => '0',
            'thr' => 'Z',
        ], (preg_capture)('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0Z', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]));
        $this->assertEquals([
            'one' => 'a',
            'two' => '0',
            'thr' => 'THR',
        ], (preg_capture)('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]));
    }

    public function test_preg_splice()
    {
        $m = [];
        $this->assertEquals("abc", (preg_splice)('#\d+#', '', 'abc123', $m));
        $this->assertEquals(['123'], $m);
        $this->assertEquals("ABC123", (preg_splice)('#([a-z]+)#', function ($m) { return strtoupper($m[1]); }, 'abc123', $m));
        $this->assertEquals(['abc', 'abc'], $m);
        $this->assertEquals((preg_splice)('#[a-z]+#', 'strtoupper', 'abc123', $m), 'strtoupper123');
        $this->assertEquals($m, ['abc']);
    }

    public function test_preg_replaces()
    {
        // simple
        $this->assertEquals('aaa99999zzz, aaa99999zzz', (preg_replaces)('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz'));
        $this->assertEquals('aaa99,999zzz', (preg_replaces)('#aaa(\d\d\d),(\d\d\d)zzz#', [1 => 99, 2 => 999], 'aaa123,456zzz'));

        // named
        $this->assertEquals('aaa99999zzz, aaa99999zzz', (preg_replaces)('#aaa(?<digit>\d\d\d)zzz#', ['digit' => 99999], 'aaa123zzz, aaa456zzz'));

        // multibyte
        $this->assertEquals('あxい|うxえxお', (preg_replaces)('#い(x)う#u', '|', 'あxいxうxえxお'));

        // limit, count
        $count = 0;
        $this->assertEquals('aaa99999zzz, aaa456zzz', (preg_replaces)('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz', 1, $count));
        $this->assertEquals(1, $count);
        $this->assertEquals('aaa99999zzz, aaa99999zzz', (preg_replaces)('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz', 9, $count));
        $this->assertEquals(2, $count);

        // misc
        $this->assertEquals('aaa99999zzz', (preg_replaces)('#aaa(\d\d\d)zzz#', 99999, 'aaa123zzz'));
        $this->assertEquals('aaa246zzz', (preg_replaces)('#aaa(\d\d\d)zzz#', function ($v) { return $v * 2; }, 'aaa123zzz'));
    }

    public function test_damerau_levenshtein()
    {
        $this->assertSame(0, (damerau_levenshtein)("12345", "12345"));
        $this->assertSame(3, (damerau_levenshtein)("", "xzy"));
        $this->assertSame(3, (damerau_levenshtein)("xzy", ""));
        $this->assertSame(0, (damerau_levenshtein)("", ""));
        $this->assertSame(1, (damerau_levenshtein)("1", "2"));
        $this->assertSame(1, (damerau_levenshtein)("12", "21"));
        $this->assertSame(2, (damerau_levenshtein)("2121", "11", 2, 1, 1));
        $this->assertSame(10, (damerau_levenshtein)("2121", "11", 2, 1, 5));
        $this->assertSame(2, (damerau_levenshtein)("11", "2121", 1, 1, 1));
        $this->assertSame(10, (damerau_levenshtein)("11", "2121", 5, 1, 1));
        $this->assertSame(3, (damerau_levenshtein)("111", "121", 2, 3, 2));
        $this->assertSame(4, (damerau_levenshtein)("111", "121", 2, 9, 2));
        $this->assertSame(2, (damerau_levenshtein)("13458", "12345"));
        $this->assertSame(2, (damerau_levenshtein)("1345", "1234"));
        $this->assertSame(1, (damerau_levenshtein)("debugg", "debug"));
        $this->assertSame(1, (damerau_levenshtein)("ddebug", "debug"));
        $this->assertSame(2, (damerau_levenshtein)("debbbug", "debug"));
        $this->assertSame(1, (damerau_levenshtein)("debugging", "debuging"));
        $this->assertSame(2, (damerau_levenshtein)("a", "bc"));
        $this->assertSame(2, (damerau_levenshtein)("xa", "xbc"));
        $this->assertSame(2, (damerau_levenshtein)("xax", "xbcx"));
        $this->assertSame(2, (damerau_levenshtein)("ax", "bcx"));

        $this->assertSame(1, (damerau_levenshtein)("abc", "bac"));
        $this->assertSame(2, (damerau_levenshtein)("bare", "bear"));
        $this->assertSame(2, (damerau_levenshtein)("12", "21", 1, 1, 1, 0));
        $this->assertSame(2, (damerau_levenshtein)("destroy", "destory", 1, 1, 1, 2));

        $this->assertSame(3, (damerau_levenshtein)("あいうえお", "xあういえおx"));
    }

    public function test_str_guess()
    {
        $percent = 0;
        $this->assertEquals("12345", (str_guess)("12345", [
            "12345",
        ], $percent));
        $this->assertEquals(100, $percent);

        $this->assertSame("1234", (str_guess)("12345", [
            "1",
            "12",
            "123",
            "1234",
        ], $percent));
        $this->assertEquals(80, $percent);

        $this->assertSame("x12345x", (str_guess)("12345", [
            "x12345x",
            "xx12345xx",
        ], $percent));
        $this->assertEquals(71, $percent);

        $this->assertSame("x12345x", (str_guess)("notfound", [
            "x12345x",
            "xx12345xx",
        ], $percent));
        $this->assertEquals(0, $percent);

        $this->assertException('is empty', str_guess, '', []);
    }

    function test_mb_substr_replace()
    {
        // 素の挙動は substr_replace と全く変わらない
        $params = [
            ['0123456789', 'X', 2, null],
            ['0123456789', 'X', 2, 0],
            ['0123456789', 'X', 2, 6],
            ['0123456789', 'X', 2, -2],
            ['0123456789', 'X', -8, 6],
            ['0123456789', 'X', -8, -2],
            ['0123456789', 'X', -8, 999],
            ['0123456789', 'X', -999, 999],
        ];
        foreach ($params as $param) {
            $this->assertEquals(substr_replace(...$param), (mb_substr_replace)(...$param), implode(', ', $param));
        }

        // もちろんマルチバイトでも動作する
        $this->assertEquals('０１X２３４５６７８９', (mb_substr_replace)('０１２３４５６７８９', 'X', 2, null));
        $this->assertEquals('０１X８９', (mb_substr_replace)('０１２３４５６７８９', 'X', 2, 6));
        $this->assertEquals('０１X８９', (mb_substr_replace)('０１２３４５６７８９', 'X', 2, -2));
        $this->assertEquals('０１X８９', (mb_substr_replace)('０１２３４５６７８９', 'X', -8, 6));
        $this->assertEquals('０１X８９', (mb_substr_replace)('０１２３４５６７８９', 'X', -8, -2));
    }

    public function test_str_array()
    {
        // http header
        $string = <<<TEXT
HTTP/1.1 200 OK
Content-Type: text/html; charset=utf-8
Connection: Keep-Alive
TEXT;
        $this->assertEquals([
            'HTTP/1.1 200 OK',
            'Content-Type' => 'text/html; charset=utf-8',
            'Connection'   => 'Keep-Alive',
        ], (str_array)($string, ':', true));

        // sar
        $string = <<<TEXT
13:00:01        CPU     %user     %nice   %system   %iowait    %steal     %idle
13:10:01        all      0.99      0.10      0.71      0.00      0.00     98.19
13:20:01        all      0.60      0.10      0.56      0.00      0.00     98.74
TEXT;
        $this->assertEquals([
            1 => [
                '13:00:01' => '13:10:01',
                'CPU'      => 'all',
                '%user'    => '0.99',
                '%nice'    => '0.10',
                '%system'  => '0.71',
                '%iowait'  => '0.00',
                '%steal'   => '0.00',
                '%idle'    => '98.19',
            ],
            2 => [
                '13:00:01' => '13:20:01',
                'CPU'      => 'all',
                '%user'    => '0.60',
                '%nice'    => '0.10',
                '%system'  => '0.56',
                '%iowait'  => '0.00',
                '%steal'   => '0.00',
                '%idle'    => '98.74',
            ],
        ], (str_array)($string, ' ', false));

        // misc
        $this->assertEquals([
            'a' => 'A',
            'b' => 'B',
            2   => '',
            3   => 'c',
        ], (str_array)("a=A\n\nb=B\n \nc", '=', true));
        $this->assertEquals([
            1 => ['a' => '1', 'b' => '2', 'c' => '3'],
            2 => ['a' => '4', 'b' => '5', 'c' => '6'],
            3 => null,
            4 => ['a' => '7', 'b' => '8', 'c' => '9'],
        ], (str_array)("a+b+c\n1+2+3\n\n4+5+6\n \n7+8+9", '+', false));
    }

    public function test_render_string()
    {
        // single
        $actual = (render_string)('int is $int' . "\n" . 'float is $float' . "\n" . 'string is $string', [
            'int'    => 12345,
            'float'  => 3.141592,
            'string' => 'mojiretu',
        ]);
        $this->assertEquals("int is 12345\nfloat is 3.141592\nstring is mojiretu", $actual);

        // double
        $actual = (render_string)("1\n2\n3{\$val} 4", ['val' => "\n"]);
        $this->assertEquals("1\n2\n3\n 4", $actual);

        // numeric
        $actual = (render_string)('aaa ${0} ${1} $k $v zzz', ['8', 9, 'k' => 'v', 'v' => 'V']);
        $this->assertEquals("aaa 8 9 v V zzz", $actual);

        // stringable
        $actual = (render_string)('aaa $val zzz', ['val' => new \Concrete('XXX')]);
        $this->assertEquals("aaa XXX zzz", $actual);

        // closure
        $actual = (render_string)('aaa $val zzz', ['val' => function () { return 'XXX'; }]);
        $this->assertEquals("aaa XXX zzz", $actual);
        $actual = (render_string)('aaa $v1 $v2 zzz', ['v1' => 9, 'v2' => function ($vars, $k) { return $vars['v1'] . $k; }]);
        $this->assertEquals("aaa 9 9v2 zzz", $actual);

        // _
        $actual = (render_string)('aaa {$_(123+456)} zzz', []);
        $this->assertEquals("aaa 579 zzz", $actual);
        $actual = (render_string)('aaa {$_(implode(\',\', $a))} zzz', ['a' => ['a', 'b', 'c']]);
        $this->assertEquals("aaa a,b,c zzz", $actual);
        $actual = (render_string)('aaa $_ zzz', ['_' => 'XXX']);
        $this->assertEquals("aaa XXX zzz", $actual);

        // quoting
        $actual = (render_string)('\'"\\$val', ['val' => '\'"\\']);
        $this->assertEquals('\'"\\\'"\\', $actual);

        // error
        @$this->assertException('failed to eval code', render_string, '$${}', []);
    }

    public function test_render_file()
    {
        $actual = (render_file)(__DIR__ . '/Strings/template.txt', [
            'zero',
            'string'  => 'string',
            'closure' => function () { return 'closure'; },
        ]);
        $this->assertEquals("string is string.
closure is closure.
zero is index 0.
123456 is expression.
579 is expression.
", $actual);
    }

    public function test_ob_include()
    {
        $actual = (ob_include)(__DIR__ . '/Strings/template.php', [
            'variable' => 'variable',
        ]);
        $this->assertEquals("This is plain text.
This is variable.
This is VARIABLE.
", $actual);
    }

    public function test_include_string()
    {
        $actual = (include_string)('This is plain text.
This is <?= $variable ?>.
This is <?php echo strtoupper($variable) ?>.
', [
            'variable' => 'variable',
        ]);
        $this->assertEquals("This is plain text.
This is variable.
This is VARIABLE.
", $actual);
    }
}

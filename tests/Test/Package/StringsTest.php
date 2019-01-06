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
        $this->assertEquals(['one|two|three', 'four'], (multiexplode)('|', $target, -2));
        $this->assertEquals(['one|two', 'three', 'four'], (multiexplode)('|', $target, -3));
        $this->assertEquals(['one', 'two', 'three', 'four'], (multiexplode)('|', $target, -999));

        // ただの文字列・正数の挙動は素の explode と変わらない
        $this->assertEquals(['one|two|three|four'], (multiexplode)('|', $target, 0));
        $this->assertEquals(['one', 'two|three|four'], (multiexplode)('|', $target, 2));
        $this->assertEquals(['one', 'two', 'three|four'], (multiexplode)('|', $target, 3));
        $this->assertEquals(['one', 'two', 'three', 'four'], (multiexplode)('|', $target, 999));
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

        assertEquals((quoteexplode)(',', 'a,b,{e,f}', ['{' => '}']), [
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
        // case insensitivity
        $this->assertEquals('i1xxxx', (str_subreplace)($string, 'X', ['i1'], true));
        // no number
        $this->assertException("key must be integer", str_subreplace, $string, 'x', ['s' => '']);
        // out od range
        $this->assertException("'x' of 5th.", str_subreplace, $string, 'x', [5 => 'nodef']);
        $this->assertException("'x' of -1th.", str_subreplace, $string, 'x', [-6 => 'nodef']);
        $this->assertException("'n' of 0th.", str_subreplace, $string, 'n', ['']);
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
}

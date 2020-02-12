<?php

namespace ryunosuke\Test\Package;

use Concrete;

class StringsTest extends AbstractTestCase
{
    function test_strcat()
    {
        // 単なる結合演算子の関数版
        that((strcat)('a', 'b', 'c'))->is('abc');

        // __toString() も活きるはず（implode してるだけだが念のため）
        $e = new \Exception();
        that((strcat)('a', $e, 'z'))->is("a{$e}z");
    }

    function test_concat()
    {
        that((concat)('prefix-', 'middle', '-suffix'))->isSame('prefix-middle-suffix');
        that((concat)('', 'middle', '-suffix'))->isSame('');
        that((concat)('prefix-', '', '-suffix'))->isSame('');
        that((concat)('prefix-', 'middle', ''))->isSame('');
    }

    function test_split_noempty()
    {
        // 空文字は空配列と規定している
        that((split_noempty)('hoge', ''))->is([]);
        that((split_noempty)(',', ',, ,'))->is([]);

        // 両サイド
        that((split_noempty)(',', ' a '))->is(['a']);

        // trim しない
        that((split_noempty)(',', " A,, , B ,C ", false))->is([' A', ' ', ' B ', 'C ']);

        // trim 文字が与えられる
        that((split_noempty)(',', " A,\tB ", "\t"))->is([' A', 'B ']);

        // 結果はただの配列になる
        that((split_noempty)(',', 'A,,B,,,C'))->is(['A', 'B', 'C']);
    }

    function test_multiexplode()
    {
        $target = 'one|two|three|four';

        // 配列だと複数文字列で分割
        that((multiexplode)(['|'], $target))->is(['one', 'two', 'three', 'four']);
        that((multiexplode)(['o'], $target))->is(['', 'ne|tw', '|three|f', 'ur']);
        that((multiexplode)(['|', 'o'], $target))->is(['', 'ne', 'tw', '', 'three', 'f', 'ur',]);

        // 負数は前詰めで返す
        that((multiexplode)('|', $target, -0))->is(['one|two|three|four']);
        that((multiexplode)('|', $target, -1))->is(['one|two|three|four']);
        that((multiexplode)('|', $target, -2))->is(['one|two|three', 'four']);
        that((multiexplode)('|', $target, -3))->is(['one|two', 'three', 'four']);
        that((multiexplode)('|', $target, -999))->is(['one', 'two', 'three', 'four']);

        // ただの文字列・正数の挙動は素の explode と変わらない
        that((multiexplode)('|', $target, 0))->is(['one|two|three|four']);
        that((multiexplode)('|', $target, 1))->is(['one|two|three|four']);
        that((multiexplode)('|', $target, 2))->is(['one', 'two|three|four']);
        that((multiexplode)('|', $target, 3))->is(['one', 'two', 'three|four']);
        that((multiexplode)('|', $target, 999))->is(['one', 'two', 'three', 'four']);

        // 上記の複合
        that((multiexplode)([',', ' ', '|'], 'a,b c|d', -1))->is(['a,b c|d']);
        that((multiexplode)([',', ' ', '|'], 'a,b c|d', -2))->is(['a,b c', 'd']);
        that((multiexplode)([',', ' ', '|'], 'a,b c|d', -3))->is(['a,b', 'c', 'd']);
        that((multiexplode)([',', ' ', '|'], 'a,b c|d', -4))->is(['a', 'b', 'c', 'd']);
    }

    function test_quoteexplode()
    {
        that((quoteexplode)(',', ',,,a,,,z,,,'))->is(['', '', '', 'a', '', '', 'z', '', '', '']);
        that((quoteexplode)('zzz', 'zzzAzzzzzzAzzz'))->is(['', 'A', '', 'A', '']);

        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 1, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a,"x,y",["y", "z"],c\\,d,\'e,f\'',
        ]);
        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 2, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y",["y", "z"],c\\,d,\'e,f\'',
        ]);
        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 3, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"],c\\,d,\'e,f\'',
        ]);
        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 4, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\\,d,\'e,f\'',
        ]);
        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 5, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            '\'e,f\'',
        ]);
        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 6, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            '\'e,f\'',
        ]);
        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', null, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            '\'e,f\'',
        ]);

        that((quoteexplode)(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            "'e,f'"
        ]);

        that((quoteexplode)([" ", "\t"], "a b\tc 'd e\tf'"))->is([
            'a',
            'b',
            'c',
            "'d e\tf'"
        ]);

        that((quoteexplode)(',', 'a,b,{e,f}', ['{' => '}']))->is([
            'a',
            'b',
            '{e,f}',
        ]);

        that((quoteexplode)('---', 'a---"x---y"---["y" --- "z"]---c\\---d---\'e---f\'', ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x---y"',
            '["y" --- "z"]',
            'c\---d',
            "'e---f'"
        ]);

        that((quoteexplode)(' ', 'a "b c" \'d e\'', '"\''))->is([
            'a',
            '"b c"',
            "'d e'"
        ]);

        that((quoteexplode)(' ', 'a"bc"', '"'))->is([
            'a"bc"',
        ]);

        that((quoteexplode)(' ', 'a"bc " ', '"'))->is([
            'a"bc "',
            '',
        ]);
    }

    function test_strrstr()
    {
        that((strrstr)('/a/b/c', 'not', true))->isSame(false);
        that((strrstr)('/a/b/c', 'not', false))->isSame(false);

        that((strrstr)('/a/b/c', '/'))->isSame('c');
        that((strrstr)('//a//b//c', '//'))->isSame('c');

        that((strrstr)('/a/b/c', '/', true))->isSame('c');
        that((strrstr)('//a//b//c', '//', true))->isSame('c');

        that((strrstr)('/a/b/c', '/', false))->isSame('/a/b/');
        that((strrstr)('//a//b//c', '//', false))->isSame('//a//b//');

        that((strrstr)('あ＿＿い＿＿う', '＿＿', true))->isSame('う');
        that((strrstr)('あ＿＿い＿＿う', '＿＿', false))->isSame('あ＿＿い＿＿');
    }

    function test_strpos_array()
    {
        that((strpos_array)('hogera', []))->isSame([]);
        that((strpos_array)('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word']))->isSame([
            0    => 11,
            'is' => 2,
            2    => 19,
        ]);

        that((strpos_array)('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], -4))->isSame([]);
        that((strpos_array)('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], -5))->isSame([
            2 => 19,
        ]);
        that((strpos_array)('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], 12))->isSame([
            2 => 19,
        ]);
        that((strpos_array)('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], 10))->isSame([
            0 => 11,
            2 => 19,
        ]);
    }

    function test_strpos_quoted()
    {
        that((strpos_quoted)("this is a 'special word' that special word", ['notfound']))->isSame(false);
        that((strpos_quoted)('this is a "special word" that special word', 'special'))->isSame(30);
        that((strpos_quoted)("this is a 'special word' that special word", 'word'))->isSame(38);
        that((strpos_quoted)("this is a \\'special word' that special word", 'word'))->isSame(20);

        that((strpos_quoted)('this is a "special word" that special word', 'special', 30))->isSame(30);
        that((strpos_quoted)('this is a "special word" that special word', 'special', 31))->isSame(false);

        that((strpos_quoted)('this is a "special word" that special word', 'word', -4))->isSame(38);
        that((strpos_quoted)('this is a "special word" that special word', 'word', -3))->isSame(false);

        that((strpos_quoted)("this is a 'special word' that special word", ['word', 'special']))->isSame(30);
        that((strpos_quoted)("this is a 'special word' that special word", ['hoge', 'hoga']))->isSame(false);

        that((strpos_quoted)('1:hoge, 2:*hoge*, 3:hoge', 'hoge', 5, '*'))->isSame(20);
        that((strpos_quoted)('1:hoge, 2:\\*hoge*, 3:hoge', 'hoge', 5, '*'))->isSame(12);

        that((strpos_quoted)('1:hoge, 2:*hoge*, 3:hoge', 'hoge', 5, '', ''))->isSame(11);
    }

    function test_str_chunk()
    {
        that((str_chunk)('abc', 1))->isSame(['a', 'bc']);
        that((str_chunk)('abc', 1, 1))->isSame(['a', 'b', 'c']);
        that((str_chunk)('abc', 1, 1, 1))->isSame(['a', 'b', 'c', '']);
        that((str_chunk)('abc', 1, 1, 1, 1))->isSame(['a', 'b', 'c', '']);

        that((str_chunk)('abc'))->isSame(['abc']);
        that((str_chunk)('abc', 0))->isSame(['', 'abc']);
        that((str_chunk)('abc', 1))->isSame(['a', 'bc']);
        that((str_chunk)('abc', 2))->isSame(['ab', 'c']);
        that((str_chunk)('abc', 3))->isSame(['abc', '']);
        that((str_chunk)('abc', 4))->isSame(['abc', '']);
        that((str_chunk)('abc', 9))->isSame(['abc', '']);
    }

    function test_str_anyof()
    {
        that((str_anyof)('a', ['a', 'b', 'c']))->isSame(0);
        that((str_anyof)('b', ['a', 'b', 'c']))->isSame(1);
        that((str_anyof)('c', ['a', 'b', 'c']))->isSame(2);
        that((str_anyof)('x', ['a', 'b', 'c']))->isSame(null);
        that((str_anyof)('A', ['a', 'b', 'c'], true))->isSame(0);
        that((str_anyof)('B', ['a', 'b', 'c'], true))->isSame(1);
        that((str_anyof)('C', ['a', 'b', 'c'], true))->isSame(2);
        that((str_anyof)('', ['a', 'b', 'c']))->isSame(null);
        that((str_anyof)(false, ['a', 'b', 'c']))->isSame(null);
        that((str_anyof)(null, ['a', 'b', 'c']))->isSame(null);
        that((str_anyof)('', ['', 'a', 'b', 'c']))->isSame(0);
        that((str_anyof)(false, ['', 'a', 'b', 'c']))->isSame(0);
        that((str_anyof)(null, ['', 'a', 'b', 'c']))->isSame(0);
        that((str_anyof)('a', [new Concrete('a'), new Concrete('b'), new Concrete('c')]))->isSame(0);
        that((str_anyof)('x', [new Concrete('a'), new Concrete('b'), new Concrete('c')]))->isSame(null);
        that((str_anyof)('A', [new Concrete('a'), new Concrete('b'), new Concrete('c')], true))->isSame(0);
        that((str_anyof)('1', [1, 2, 3]))->isSame(0);
        that((str_anyof)('2', [1, 2, 3]))->isSame(1);
        that((str_anyof)('3', [1, 2, 3]))->isSame(2);
        that((str_anyof)('9', [1, 2, 3]))->isSame(null);
        that((str_anyof)(1, ['1', '2', '3']))->isSame(0);
        that((str_anyof)(2, ['1', '2', '3']))->isSame(1);
        that((str_anyof)(3, ['1', '2', '3']))->isSame(2);
        that((str_anyof)(9, ['1', '2', '3']))->isSame(null);
    }

    function test_str_equals()
    {
        that((str_equals)('abcdef', 'abcdef'))->isTrue();
        that((str_equals)('abcdef', 'ABCDEF', true))->isTrue();

        // unmatch type
        that((str_equals)("123", 123))->isFalse();
        that((str_equals)("", null))->isFalse();

        // null byte
        that((str_equals)("abc\0def", "abc\0def"))->isTrue();
        that((str_equals)("abc\0def", "abc\0xyz"))->isFalse();
        that((str_equals)("abc\0def", "abc\0xyz", true))->isFalse();

        // stringable object
        $ex = new \Exception('hoge');
        that((str_equals)($ex, $ex))->isTrue();
    }

    function test_str_contains()
    {
        // single
        that((str_contains)('abcdef', 'cd'))->isTrue();
        that((str_contains)('abcdef', 'xx'))->isFalse();

        // single int
        that((str_contains)('12345', 5))->isTrue();
        that((str_contains)('12345', 9))->isFalse();

        // empty
        that((str_contains)('', ''))->isFalse();
        that((str_contains)('abcdef', ''))->isFalse();

        // single case_insensitivity
        that((str_contains)('abcdef', 'CD', true))->isTrue();
        that((str_contains)('abcdef', 'XX', true))->isFalse();

        // multi or
        that((str_contains)('abcdef', ['cd', 'XX'], false, false))->isTrue();
        that((str_contains)('abcdef', ['XX', 'YY'], false, false))->isFalse();

        // multi and
        that((str_contains)('abcdef', ['cd', 'ef'], false, true))->isTrue();
        that((str_contains)('abcdef', ['cd', 'XX'], false, true))->isFalse();

        // multi case_insensitivity
        that((str_contains)('abcdef', ['CD', 'XX'], true, false))->isTrue();
        that((str_contains)('abcdef', ['XX', 'YY'], true, false))->isFalse();
        that((str_contains)('abcdef', ['CD', 'EF'], true, true))->isTrue();
        that((str_contains)('abcdef', ['CD', 'XX'], true, true))->isFalse();

        // stringable object
        that((str_contains)(new \Concrete('abcdef'), new \Concrete('cd')))->isTrue();
        that((str_contains)(new \Concrete('abcdef'), new \Concrete('xx')))->isFalse();
        that((str_contains)(new \Concrete('abcdef'), new \Concrete('CD'), true, false))->isTrue();
        that((str_contains)(new \Concrete('abcdef'), new \Concrete('XX'), true))->isFalse();
    }

    function test_str_chop()
    {
        that((str_chop)('aaaMMMzzz', 'aaa'))->is("MMMzzz");
        that((str_chop)('aaaMMMzzz', null, 'zzz'))->is("aaaMMM");
        that((str_chop)('aaaMMMzzz', 'aaa', 'zzz'))->is("MMM");
        that((str_chop)('aaaMMMzzz', 'aaaa', 'zzzz'))->is("aaaMMMzzz");
        that((str_chop)(' aaaMMMzzz ', 'aaa', 'zzz'))->is(" aaaMMMzzz ");
        that((str_chop)('aaaMMMzzz', 'AAA', 'ZZZ'))->is("aaaMMMzzz");
        that((str_chop)('aaaMMMzzz', 'AAA', 'ZZZ', true))->is("MMM");
        that((str_chop)("\naaazzz", 'aaa'))->is("\naaazzz");
        that((str_chop)("aaazzz\n", null, 'zzz'))->is("aaazzz\n");
        that((str_chop)("\naaazzz\n", "\n", "\n"))->is("aaazzz");
        that((str_chop)('[#^.\\$]', "[", "]"))->is('#^.\\$');

        that((str_lchop)('aaaMMMzzz', 'aaa'))->is("MMMzzz");
        that((str_rchop)('aaaMMMzzz', 'zzz'))->is("aaaMMM");
    }

    function test_str_putcsv()
    {
        // シンプル
        that((str_putcsv)([1, 2, 3]))->is("1,2,3");
        that((str_putcsv)([1, 2, 3], "\t"))->is("1\t2\t3");
        that((str_putcsv)([1, ",", 3], ",", '`'))->is("1,`,`,3");
        that((str_putcsv)([1, "\t", '@`'], ",", '`', "@"))->is("1,`\t`,`@``");
        // コンプレックス
        that((str_putcsv)([[1, 2, 3], [4, 5, 6]]))->is("1,2,3\n4,5,6");
        that((str_putcsv)(new \ArrayIterator([[1, 2, 3], [4, 5, 6]])))->is("1,2,3\n4,5,6");
        that((str_putcsv)((function () {
            yield [1, 2, 3];
            yield [4, 5, 6];
        })()))->is("1,2,3\n4,5,6");

        that([str_putcsv, [], 'aa'])->throws('single character');
    }

    function test_str_subreplace()
    {
        $string = 'xxxxx';

        // empty
        that((str_subreplace)($string, 'x', []))->is('xxxxx');
        // string
        that((str_subreplace)($string, 'x', 'X'))->is('Xxxxx');
        // all
        that((str_subreplace)($string, 'x', ['X1', 'X2', 'X3', 'X4', 'X5']))->is('X1X2X3X4X5');
        // 3rd
        that((str_subreplace)($string, 'x', [2 => 'X3']))->is('xxX3xx');
        // 1st, 4th
        that((str_subreplace)($string, 'x', [0 => 'X1', 2 => 'X3']))->is('X1xX3xx');
        that((str_subreplace)($string, 'x', [2 => 'X3', 0 => 'X1']))->is('X1xX3xx');
        // overlap
        that((str_subreplace)($string, 'x', [0 => 'xxx', 1 => 'Z']))->is('xxxZxxx');
        // negative
        that((str_subreplace)($string, 'x', [-1 => 'Z']))->is('xxxxZ');
        that((str_subreplace)($string, 'x', [-5 => 'Z']))->is('Zxxxx');
        // notfound
        that((str_subreplace)($string, 'z', ['Z']))->is('xxxxx');
        // case insensitivity
        that((str_subreplace)($string, 'X', ['i1'], true))->is('i1xxxx');
        that((str_subreplace)($string, 'X', [-1 => 'i5'], true))->is('xxxxi5');
        // multibyte
        that((str_subreplace)('あああああ', 'あ', [2 => 'か']))->is('ああかああ');
        // no number
        that([str_subreplace, $string, 'x', ['s' => '']])->throws("key must be integer");
        // out od range
        that([str_subreplace, $string, 'x', [5 => 'nodef']])->throws("'x' of 5th.");
        that([str_subreplace, $string, 'x', [-6 => 'nodef']])->throws("'x' of -6th.");
    }

    function test_str_submap()
    {
        $string = 'hello, world';

        // empty
        that((str_submap)($string, []))->is('hello, world');
        // only 1
        that((str_submap)($string, [
            'l' => [
                1 => 'L',
            ],
        ]))->is('helLo, world');
        // multiple
        that((str_submap)($string, [
            'l' => [
                1 => 'L',
            ],
            'o' => [
                'o1',
                'o2',
            ],
        ]))->is('helLo1, wo2rld');
        // overlap
        that((str_submap)($string, [
            'hello' => 'world',
            'world' => 'WORLD',
        ]))->is('world, WORLD');
        // negative
        that((str_submap)($string, [
            'l' => [
                -2 => 'L',
            ],
            'o' => [
                -1 => 'O',
            ],
        ]))->is('helLo, wOrld');
        // notfound
        that((str_submap)($string, ['xxx' => 'XXX']))->is('hello, world');
        // case insensitivity
        that((str_submap)($string, [
            'HELLO' => 'H',
        ], true))->is('H, world');
        // multibyte
        that((str_submap)('へろーわーるど', ['ー' => [1 => '棒']]))->is('へろーわ棒るど');
        // no number
        that([str_submap, $string, ['w' => ['' => '']]])->throws("key must be integer");
        // out od range
        that([str_submap, $string, ['l' => [3 => 'nodef']]])->throws("'l' of 3th.");
        that([str_submap, $string, ['l' => [-4 => 'nodef']]])->throws("'l' of -4th.");
    }

    function test_str_embed()
    {
        $string = 'hello, world and "hello", \'world\' and \\"hello, \\\'world';

        // 単純な置換
        that((str_embed)($string, [
            'hello' => 'HELLO',
            'world' => 'WORLD',
        ]))->is('HELLO, WORLD and "hello", \'world\' and \\"HELLO, \\\'WORLD');
        that((str_embed)($string, [
            'hello' => ['hello1', 'hello2'],
            'world' => ['world1', 'world2'],
        ]))->is('hello1, world1 and "hello", \'world\' and \\"hello2, \\\'world2');

        // 隣り合う境界
        that((str_embed)('aaaaa', [
            'a' => 'A',
        ]))->is('AAAAA');
        that((str_embed)('aaaaa', [
            'a' => ['1', '2', 3, 4, new Concrete(5)],
        ]))->is('12345');
        that((str_embed)('aa"a"aa', [
            'a' => ['1', '2', 3, 4],
        ]))->is('12"a"34');

        // 長いものから置換される
        that((str_embed)('aaaaa', [
            'aaa' => 'A3',
            'aa'  => 'A2',
        ]))->is('A3A2');
        that((str_embed)('aaaaa', [
            'aa'  => 'A2',
            'aaa' => 'A3',
        ]))->is('A3A2');

        // 置換後の文字列は置換対象にならない
        that((str_embed)('xyz', [
            'x' => 'xyz',
            'y' => 'YYY',
        ]))->is('xyzYYYz');
        that((str_embed)('xyz', [
            'y' => 'YYY',
            'x' => 'xyz',
        ]))->is('xyzYYYz');

        // 空文字
        that((str_embed)('xyz', [
            'y' => '',
            'z' => '',
            'x' => 'X',
        ]))->is('X');

        // enclosure 指定
        that((str_embed)('x{x}x', [
            'x' => 'X',
            '{' => '[',
            '}' => ']',
        ], ['{' => '}']))->is('X{x}X');
        that((str_embed)('x{x}x{{x}}', [
            'x' => 'X',
            '{' => '[',
            '}' => ']',
        ], ['{{' => '}}']))->is('X[X]X{{x}}');

        // 見つからない場合はスルー
        that((str_embed)('xyz', [
            'notfound' => 'notfound',
        ]))->is('xyz');

        that([str_embed, 'hoge', ['' => 'empty']])->throws("src length is 0");
        that([str_embed, 'hoge', ['h' => [3 => 'nodef']]])->throws("'h' of 0th.");
    }

    function test_str_between()
    {
        ////////// 0123456789A1234567891B23456789C123456789D
        $string = '{simple}, "{enclose}", \\{{escape\\}}';
        $n = 0;
        that((str_between)($string, '{', '}', $n))->isSame('simple');
        that($n)->isSame(8);
        that((str_between)($string, '{', '}', $n))->isSame('escape\\}');
        that($n)->isSame(35);
        that((str_between)($string, '{', '}', $n))->isSame(false);
        that($n)->isSame(35);

        // ずっとエスケープ中なので見つからない
        $string = '"{a}{b}{c}{d}{e}{f}{g}"';
        $n = 0;
        that((str_between)($string, '{', '}', $n))->isSame(false);

        // from to が複数文字の場合
        $string = '{{name}}, {{hobby}}';
        $n = 0;
        that((str_between)($string, '{{', '}}', $n))->isSame('name');
        that((str_between)($string, '{{', '}}', $n))->isSame('hobby');
        that((str_between)($string, '{{', '}}', $n))->isSame(false);

        // 中身が空の場合
        $string = '{{}} {{}} {{}}';
        $n = 0;
        that((str_between)($string, '{{', '}}', $n))->isSame('');
        that((str_between)($string, '{{', '}}', $n))->isSame('');
        that((str_between)($string, '{{', '}}', $n))->isSame('');
        that((str_between)($string, '{{', '}}', $n))->isSame(false);

        // くっついている場合
        $string = '{{first}}{{second}}{{third}}';
        $n = 0;
        that((str_between)($string, '{{', '}}', $n))->isSame('first');
        that((str_between)($string, '{{', '}}', $n))->isSame('second');
        that((str_between)($string, '{{', '}}', $n))->isSame('third');
        that((str_between)($string, '{{', '}}', $n))->isSame(false);

        // 開始終了が一致していない場合
        $string = '{first}}}}}} and {second}';
        $n = 0;
        that((str_between)($string, '{', '}', $n))->isSame('first');
        that((str_between)($string, '{', '}', $n))->isSame('second');
        that((str_between)($string, '{', '}', $n))->isSame(false);

        // 開始終了に包含関係がある場合
        that((str_between)('!first!!', '!', '!!'))->isSame('first');
        that((str_between)('!!first!', '!!', '!'))->isSame('first');
        that((str_between)('!!first!!', '!!', '!!'))->isSame('first');

        // enclosure も escape もしない単純な場合
        $n = 0;
        that((str_between)('{first}"{second}"\\{third\\}', '{', '}', $n, null, null))->isSame('first');
        that((str_between)('{first}"{second}"\\{third\\}', '{', '}', $n, null, null))->isSame('second');
        that((str_between)('{first}"{second}"\\{third\\}', '{', '}', $n, null, null))->isSame('third\\');

        // ネストしている場合
        that((str_between)('{nest1{nest2{nest3}}}', '{', '}'))->isSame('nest1{nest2{nest3}}');
    }

    function test_str_ellipsis()
    {
        that((str_ellipsis)('1234567890', 8, '...', 0))->isSame('...67890');
        that((str_ellipsis)('1234567890', 8, '...', 1))->isSame('1...7890');
        that((str_ellipsis)('1234567890', 8, '...', 2))->isSame('12...890');
        that((str_ellipsis)('1234567890', 8, '...', 3))->isSame('123...90');
        that((str_ellipsis)('1234567890', 8, '...', 4))->isSame('1234...0');
        that((str_ellipsis)('1234567890', 8, '...', 5))->isSame('12345...');
        that((str_ellipsis)('1234567890', 8, '...', 6))->isSame('12345...');
        that((str_ellipsis)('1234567890', 8, '...', 7))->isSame('12345...');
        that((str_ellipsis)('1234567890', 8, '...', 8))->isSame('12345...');
        that((str_ellipsis)('1234567890', 8, '...', 9))->isSame('12345...');
        that((str_ellipsis)('1234567890', 8, '...', 10))->isSame('12345...');
        that((str_ellipsis)('1234567890', 8, '...', 11))->isSame('12345...');
        that((str_ellipsis)('1234567890', 8, '...', -1))->isSame('1234...0');
        that((str_ellipsis)('1234567890', 8, '...', -2))->isSame('123...90');
        that((str_ellipsis)('1234567890', 8, '...', -3))->isSame('12...890');
        that((str_ellipsis)('1234567890', 8, '...', -4))->isSame('1...7890');
        that((str_ellipsis)('1234567890', 8, '...', -5))->isSame('...67890');
        that((str_ellipsis)('1234567890', 8, '...', -6))->isSame('...67890');
        that((str_ellipsis)('1234567890', 8, '...', -7))->isSame('...67890');
        that((str_ellipsis)('1234567890', 8, '...', -8))->isSame('...67890');
        that((str_ellipsis)('1234567890', 8, '...', -9))->isSame('...67890');
        that((str_ellipsis)('1234567890', 8, '...', -10))->isSame('...67890');
        that((str_ellipsis)('1234567890', 8, '...', -11))->isSame('...67890');

        that((str_ellipsis)('1234567890', 8, '...', null))->isSame('12...890');
        that((str_ellipsis)('1234567890', 7, '...', null))->isSame('12...90');

        that((str_ellipsis)('１２３４５６７８９０', 8, '・・・', null))->isSame('１２・・・８９０');
        that((str_ellipsis)('１２３４５６７８９０', 7, '・・・', null))->isSame('１２・・・９０');

        that((str_ellipsis)('1234567890', 1, '...', null))->isSame('...');
        that((str_ellipsis)('1234567890', 1000, '...', null))->isSame('1234567890');
    }

    function test_str_diff()
    {
        that((str_diff)("e\nd\ne\ne\nc", "e\ne\na\ne\nC", ['stringify' => null]))->is(
            [
                ['=', ['e'], ['e'],],
                ['-', [1 => 'd'], 0,],
                ['=', [2 => 'e'], [1 => 'e'],],
                ['+', 2, [2 => 'a'],],
                ['=', [3 => 'e'], [3 => 'e'],],
                ['*', [4 => 'c'], [4 => 'C'],],
            ]);

        that((str_diff)("e\nd\ne\ne\nc\n<b>B</b>", "e\ne\na\ne\nC\n<b>B</b>", ['stringify' => 'html']))->is('e
<del>d</del>
e
<ins>a</ins>
e
<del>c</del>
<ins>C</ins>
&lt;b&gt;B&lt;/b&gt;');

        that((str_diff)("
sameline
diff1
diff2
diff3

sameline
diff4
diff5

sameline
this is a pen

that is a pen

", "
sameline
diff1x
diff2x

sameline
diff4x
diff5x
diff6x

sameline
this is the pen

that is the pen

", ['stringify' => 'html=perline']))->is('
sameline
diff1<ins>x</ins>
diff2<ins>x</ins>
<del>diff3</del>

sameline
diff4<ins>x</ins>
diff5<ins>x</ins>
<ins>diff6x</ins>

sameline
this is <del>a</del><ins>the</ins> pen

that is <del>a</del><ins>the</ins> pen

');
    }

    function test_str_diff_native()
    {
        $diff = '';
        if (defined('DIFF')) {
            $diff = array_filter(explode(',', DIFF), 'file_exists');
            $diff = reset($diff);
        }
        if (!$diff) {
            $this->markTestSkipped();
        }

        $shell = function ($x, $y, ...$opt) use ($diff) {
            $expected = null;
            $key = array_search('--nolabel', $opt);
            unset($opt[$key]);
            (process)($diff, array_merge($opt, [$x, $y]), '', $expected);
            if ($key !== false) {
                return implode("\n", array_slice(explode("\n", $expected), 2));
            }
            return $expected;
        };

        $x = __DIR__ . '/Strings/diff-x.txt';
        $y = __DIR__ . '/Strings/diff-y.txt';

        $expected = $shell($x, $y, '--unified=999', '--ignore-case', '--suppress-blank-empty', '--nolabel');
        $actual = (str_diff)(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999', 'ignore-case' => true]);
        that($actual)->is($expected);

        $expected = $shell($x, $y, '--unified=999', '--ignore-space-change', '--nolabel');
        $actual = (str_diff)(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999', 'ignore-space-change' => true]);
        that($actual)->is($expected);

        $expected = $shell($x, $y, '--unified=999', '--ignore-all-space', '--nolabel');
        $actual = (str_diff)(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999', 'ignore-all-space' => true]);
        that($actual)->is($expected);

        $expected = $shell($x, $y, '--unified=999', '--nolabel');
        $actual = (str_diff)(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999']);
        that($actual)->is($expected);

        $dataset = [
            [__DIR__ . '/Strings/diff-same.txt', __DIR__ . '/Strings/diff-same.txt'],
            [__DIR__ . '/Strings/diff-empty.txt', __DIR__ . '/Strings/diff-x.txt'],
            [__DIR__ . '/Strings/diff-y.txt', __DIR__ . '/Strings/diff-empty.txt'],
            [__DIR__ . '/Strings/diff-x.txt', __DIR__ . '/Strings/diff-y.txt'],
            [__DIR__ . '/Strings/diff-even-x.txt', __DIR__ . '/Strings/diff-even-y.txt'],
            [__DIR__ . '/Strings/diff-even-x.txt', __DIR__ . '/Strings/diff-odd-y.txt'],
            [__DIR__ . '/Strings/diff-odd-x.txt', __DIR__ . '/Strings/diff-odd-y.txt'],
            [__DIR__ . '/Strings/diff-odd-x.txt', __DIR__ . '/Strings/diff-even-y.txt'],
            [__DIR__ . '/Strings/diff-very-x.txt', __DIR__ . '/Strings/diff-very-y.txt'],
            [__DIR__ . '/Strings/diff-very-y.txt', __DIR__ . '/Strings/diff-very-x.txt'],
        ];

        foreach ($dataset as [$x, $y]) {
            $expected = $shell($x, $y, '--normal');
            $actual = (str_diff)(file_get_contents($x), file_get_contents($y), ['stringify' => 'normal']);
            that($actual)->as("$x <=> $y:\nExpected: $expected\nActual: $actual")->is($expected);

            for ($level = 0; $level < 5; $level++) {
                $levelopt = "context=$level";
                $expected = $shell($x, $y, "--$levelopt", '--nolabel');
                $actual = (str_diff)(file_get_contents($x), file_get_contents($y), ['stringify' => $levelopt]);
                that($actual)->as("$x <=> $y, $levelopt:\nExpected: $expected\nActual: $actual")->is($expected);

                $levelopt = "unified=$level";
                $expected = $shell($x, $y, "--$levelopt", '--nolabel');
                $actual = (str_diff)(file_get_contents($x), file_get_contents($y), ['stringify' => $levelopt]);
                that($actual)->as("$x <=> $y: $levelopt:\nExpected: $expected\nActual: $actual")->is($expected);
            }
        }
    }

    function test_starts_with()
    {
        that((starts_with)('abcdef', 'abc'))->isTrue();
        that((starts_with)('abcdef', 'ABC'))->isFalse();
        that((starts_with)('abcdef', 'xbc'))->isFalse();

        that((starts_with)('abcdef', 'abc', true))->isTrue();
        that((starts_with)('abcdef', 'ABC', true))->isTrue();
        that((starts_with)('abcdef', 'xbc', true))->isFalse();

        that((starts_with)('abcdef', ['a', 'X']))->isTrue();
        that((starts_with)('abcdef', ['abc', 'XXX']))->isTrue();
        that((starts_with)('abcdef', ['XXX']))->isFalse();
        that((starts_with)('abcdef', []))->isFalse();

        that((starts_with)('', 's'))->isFalse();
    }

    function test_ends_with()
    {
        that((ends_with)('abcdef', 'def'))->isTrue();
        that((ends_with)('abcdef', 'DEF'))->isFalse();
        that((ends_with)('abcdef', 'xef'))->isFalse();

        that((ends_with)('abcdef', 'def', true))->isTrue();
        that((ends_with)('abcdef', 'DEF', true))->isTrue();
        that((ends_with)('abcdef', 'xef', true))->isFalse();

        that((ends_with)('abcdef', ['f', 'X']))->isTrue();
        that((ends_with)('abcdef', ['def', 'XXX']))->isTrue();
        that((ends_with)('abcdef', ['XXX']))->isFalse();
        that((ends_with)('abcdef', []))->isFalse();

        that((ends_with)('', 's'))->isFalse();
    }

    function test_camel_case()
    {
        that((camel_case)(''))->is('');
        that((camel_case)('this-is-a-pen', '-'))->is('thisIsAPen');
        that((camel_case)('this_is_a_pen'))->is('thisIsAPen');
        that((camel_case)('_this_is_a_pen_'))->is('thisIsAPen');
    }

    function test_pascal_case()
    {
        that((pascal_case)(''))->is('');
        that((pascal_case)('this-is-a-pen', '-'))->is('ThisIsAPen');
        that((pascal_case)('this_is_a_pen'))->is('ThisIsAPen');
        that((pascal_case)('_this_is_a_pen_'))->is('ThisIsAPen');
    }

    function test_snake_case()
    {
        that((snake_case)(''))->is('');
        that((snake_case)('ThisIsAPen', '-'))->is('this-is-a-pen');
        that((snake_case)('ThisIsAPen'))->is('this_is_a_pen');
        that((snake_case)('ABC'))->is('a_b_c');
        that((snake_case)('_ABC_'))->is('a_b_c_');
    }

    function test_chain_case()
    {
        that((chain_case)(''))->is('');
        that((chain_case)('ThisIsAPen', '_'))->is('this_is_a_pen');
        that((chain_case)('ThisIsAPen'))->is('this-is-a-pen');
        that((chain_case)('ABC'))->is('a-b-c');
        that((chain_case)('-ABC-'))->is('a-b-c-');
    }

    function test_namespace_split()
    {
        that((namespace_split)('ns\\hoge'))->is(['ns', 'hoge']);
        that((namespace_split)('\\ns\\hoge'))->is(['\\ns', 'hoge']);
        that((namespace_split)('\\ns\\'))->is(['\\ns', '']);
        that((namespace_split)('hoge'))->is(['', 'hoge']);
        that((namespace_split)('\\hoge'))->is(['', 'hoge']);
        that((namespace_split)(new \Concrete('aaa\bbb')))->is(['aaa', 'bbb']);
    }

    function test_htmltag()
    {
        that((htmltag)('a.c1#hoge.c2[target=hoge\[\]][href="http://hoge"][hidden]'))->is(
            '<a id="hoge" class="c1 c2" target="hoge[]" href="http://hoge" hidden></a>'
        );
        that((htmltag)(['a.c1#hoge.c2[href="http://hoge"]' => '<b>bold</b>']))->is(
            '<a id="hoge" class="c1 c2" href="http://hoge">&lt;b&gt;bold&lt;/b&gt;</a>'
        );
        that((htmltag)([
            'a.c1#hoge.c2[href="http://hoge"]' => [
                'b' => '<bold>',
            ],
        ]))->is(
            '<a id="hoge" class="c1 c2" href="http://hoge"><b>&lt;bold&gt;</b></a>'
        );
        that((htmltag)([
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

        that((htmltag)([
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

        that([htmltag, '#id.class'])->throws('tagname is empty');
        that([htmltag, 'a#id#id'])->throws('#id is multiple');
        that([htmltag, 'a[a=1][a=2]'])->throws('[a] is dumplicated');
        that([htmltag, 'a#id[id=id]'])->throws('[id] is dumplicated');
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
            that((build_uri)($data['parts']))->as($title)->is($data['uri']);
        }
    }

    function test_parse_uri()
    {
        foreach ($this->provideUri() as $title => $data) {
            that((parse_uri)($data['uri']))->as($title)->is($data['parts']);
        }

        // default array
        that((parse_uri)('', [
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => 'defpath',
            'query'    => 'defquery',
            'fragment' => 'deffragment',
        ]))->is([
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => '/defpath',
            'query'    => ['defquery' => ''],
            'fragment' => 'deffragment',
        ]);

        // default string
        that((parse_uri)('', 'defscheme://defuser:defpass@defhost:12345/defpath?defquery#deffragment'))->is([
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => '/defpath',
            'query'    => ['defquery' => ''],
            'fragment' => 'deffragment',
        ]);
    }

    function test_parse_uri_special()
    {
        // double slash
        that((parse_uri)('//user:pass@host/path/to/hoge?op1=1&op2=2#hash'))->is([
            'scheme'   => '',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // tripple slash
        that((parse_uri)('///path/to/hoge?op1=1&op2=2#hash'))->is([
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // no port value
        that((parse_uri)('scheme://user:pass@host:/path/to/hoge?op1=1&op2=2#hash'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // no path value
        that((parse_uri)('scheme://user:pass@host?op1=1&op2=2#hash'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // no query value
        that((parse_uri)('scheme://user:pass@host/path/to/hoge?#hash'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => [],
            'fragment' => 'hash',
        ]);

        // no fragment value
        that((parse_uri)('scheme://user:pass@host/path/to/hoge?#'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => [],
            'fragment' => '',
        ]);
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

        that((ini_export)($iniarray, ['process_sections' => false]))->is('simple[a] = "A"
simple[b] = "B"
simple[quote] = "\"\000\\\\\'"
x[] = "A"
x[] = "B"
x[] = "C"
y[a] = "A"
y[b] = "B"
');

        that((ini_export)($iniarray, ['process_sections' => true]))->is('[simple]
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
');
    }

    function test_ini_import()
    {
        that((ini_import)('a = "A"
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

        that((ini_import)('[simple]
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

        that((csv_export)($utf8array, ['encoding' => 'SJIS']))->is($sjisstring);
        that((csv_import)($sjisstring, ['encoding' => 'SJIS']))->is($utf8array);

        that((csv_export)($utf8array, [
            'encoding' => 'SJIS',
            'headers'  => [
                'Ａ' => '１',
                'Ｂ' => '２',
                'Ｃ' => '３',
                'Ｄ' => '４',
                'Ｅ' => '５',
            ],
        ]))->is($sjisstring12345);
        that((csv_import)($sjisstringnohead, [
            'encoding' => 'SJIS',
            'headers'  => [
                'Ａ',
                'Ｂ',
                'Ｃ',
                'Ｄ',
                'Ｅ',
            ],
        ]))->is($utf8array);
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

        that((csv_export)($csvarrays))->is("a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
");

        // headers 指定
        that((csv_export)($csvarrays, ['headers' => ['a' => 'A', 'c' => 'C']]))->is("A,C
a1,c1
a2,c2
a3,c3
");

        // callback 指定
        that((csv_export)($csvarrays, [
            'callback' => function (&$row, $n) {
                $row['b'] = strtoupper($row['b']);
                return $n !== 1;
            }
        ]))->is("a,b,c
a1,B1,c1
a3,B3,c3
");

        // output 指定
        $receiver = fopen('php://memory', 'r+b');
        that((csv_export)($csvarrays, ['output' => $receiver]))->is(33);
        rewind($receiver);
        that(stream_get_contents($receiver))->is("a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
");

        // fputcsv 引数
        $csvarrays[0]['c'] = " c\n";
        that((csv_export)($csvarrays, ['delimiter' => ' ', 'enclosure' => "'"]))->is("a b c
a1 b1 ' c
'
a2 b2 c2
a3 b3 c3
");
    }

    function test_csv_import()
    {
        that((csv_import)('a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
'))->is([
            ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a2', 'b' => 'b2', 'c' => 'c2'],
            ['a' => 'a3', 'b' => 'b3', 'c' => 'c3'],
        ]);

        // 空行とクオート
        that((csv_import)('a,b,c
"a1,x",b1,c1

a3,b3,"c3
x"
'))->is([
            ['a' => 'a1,x', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'b3', 'c' => "c3\nx"],
        ]);

        // ファイルポインタ
        file_put_contents(sys_get_temp_dir() . '/test.csv', 'a,b,c
"a1,x",b1,c1

a3,b3,"c3
x"
');
        that((csv_import)(fopen(sys_get_temp_dir() . '/test.csv', 'r')))->is([
            ['a' => 'a1,x', 'b' => 'b1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'b3', 'c' => "c3\nx"],
        ]);

        // headers 指定（数値）
        that((csv_import)('
a1,b1,c1
a2,b2,c2
', ['headers' => ['A', 2 => 'C']]))->is([
            ['A' => 'a1', 'C' => 'c1'],
            ['A' => 'a2', 'C' => 'c2'],
        ]);

        // headers 指定（キーマップ）
        that((csv_import)('
A,B,C
a1,b1,c1
a2,b2,c2
', ['headers' => ['C' => 'xC', 'A' => 'xA', 'unknown' => 'x']]))->is([
            ['xA' => 'a1', 'xC' => 'c1'],
            ['xA' => 'a2', 'xC' => 'c2'],
        ]);

        // コールバック指定
        that((csv_import)('a,b,c
a1,b1,c1
a2,b2,c2
a3,b3,c3
', [
            'callback' => function (&$row, $n) {
                $row['b'] = strtoupper($row['b']);
                return $n !== 1;
            }
        ]))->is([
            ['a' => 'a1', 'b' => 'B1', 'c' => 'c1'],
            ['a' => 'a3', 'b' => 'B3', 'c' => 'c3'],
        ]);

        // 要素数が合わないと例外
        that([csv_import, "a,b,c\nhoge"])->throws('array_combine');
    }

    function test_json_export()
    {
        // エラー情報を突っ込んでおく
        json_decode('aaa');

        // デフォルトオプション
        that((json_export)([123.0, 'あ']))->is('[123.0,"あ"]');

        // オプション指定（上書き）
        that((json_export)([123.0, 'あ'], [
            JSON_UNESCAPED_UNICODE      => false,
            JSON_PRESERVE_ZERO_FRACTION => false,
            JSON_PRETTY_PRINT           => true,
        ]))->is("[\n    123,\n    \"\u3042\"\n]");

        // depth
        that([json_export, [[[[[[]]]]]], [\ryunosuke\Functions\Package\Strings::JSON_MAX_DEPTH => 3]])->throws('Maximum stack depth exceeded');
    }

    function test_json_import()
    {
        // エラー情報を突っ込んでおく
        json_decode('aaa');

        // デフォルトオプション
        that((json_import)('[123.0,"あ"]'))->is([123.0, "あ"]);

        // オプション指定（上書き）
        that((json_import)('{"a":123.0,"b":"あ"}', [
            JSON_OBJECT_AS_ARRAY => false,
        ]))->is((object) ['a' => 123.0, 'b' => "あ"]);

        // depth
        that([json_import, '[[[[[[]]]]]]', [\ryunosuke\Functions\Package\Strings::JSON_MAX_DEPTH => 3]])->throws('Maximum stack depth exceeded');
    }

    function test_paml_export()
    {
        that((paml_export)([
            "null"    => null,
            "bool1"   => false,
            "bool2"   => true,
            "int"     => 123,
            "double"  => 3.14,
            "string1" => "xyz",
            "string2" => '[x, "y", z]',
        ]))->isSame('null: null, bool1: false, bool2: true, int: 123, double: 3.14, string1: "xyz", string2: "[x, \\"y\\", z]"');

        that((paml_export)([
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
        that((paml_import)('null:null,bool1: false, bool2:true , int: 123, double: 3.14, string1:xyz,string2:"[x, \"y\", \'z\']"'))->isSame([
            "null"    => null,
            "bool1"   => false,
            "bool2"   => true,
            "int"     => 123,
            "double"  => 3.14,
            "string1" => "xyz",
            "string2" => '[x, "y", \'z\']',
        ]);

        that((paml_import)("hash:[1,2,'a,b,', \"c,d,\",x:'X','y:Y',\"z:Z\", 4]"))->isSame([
            "hash" => [1, 2, 'a,b,', 'c,d,', 'x' => 'X', 'y:Y', 'z:Z', 4],
        ]);

        that((paml_import)('d:\'a\\nz\', s:"a\\\\nz"'))->isSame([
            'd' => 'a\\nz',
            's' => "a\\nz",
        ]);

        that((paml_import)('e: E_ERROR, ao: ArrayObject::STD_PROP_LIST'))->isSame([
            "e"  => E_ERROR,
            "ao" => \ArrayObject::STD_PROP_LIST,
        ]);

        that((paml_import)('array:[1,2,"3"], nest:[a: [b: [c: [X]]]]'))->isSame([
            "array" => [1, 2, "3"],
            "nest"  => [
                "a" => [
                    "b" => [
                        "c" => ["X"],
                    ],
                ],
            ],
        ]);

        that((paml_import)("a:A,\nb:B,array:[1,\n2,\n\"3\\n4\",\n],object:{1,\n2,\n\"3\\n4\",\n}"))->is([
            'a'      => 'A',
            'b'      => 'B',
            "array"  => [1, 2, "3\n4"],
            "object" => (object) [1, 2, "3\n4"],
        ]);

        that((paml_import)('empty_array1:[], empty_array2:{}, empty_string1:,empty_string2:""'))->is([
            "empty_array1"  => [],
            "empty_array2"  => (object) [],
            "empty_string1" => '',
            "empty_string2" => '',
        ]);

        that((paml_import)('  '))->isSame([]);
        that((paml_import)(' xxx '))->isSame(['xxx']);
        that((paml_import)(',,'))->isSame(['', '']);
        that((paml_import)('array:[1,2,"3",]', [
            'trailing-comma' => true,
            'cache'          => false,
        ]))->isSame([
            "array" => [1, 2, "3"],
        ]);
        that((paml_import)('array:[1,2,"3",]', [
            'trailing-comma' => false,
            'cache'          => false,
        ]))->isSame([
            "array" => [1, 2, "3", ""],
        ]);
    }

    function test_paml_transport()
    {
        $string = file_get_contents(__DIR__ . '/Strings/text.paml');
        $array = (paml_import)($string);
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
        that((paml_export)($array))->isSame('text: "this is raw string", break: "this
is
break
string", quote1: "a
z", quote2: "a\\\\nz"');
    }

    function test_ltsv_import()
    {
        that((ltsv_import)("a:A	b:B	c:C"))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        that((ltsv_import)('a\ta:a	b:b\tb	c\\\\t:C\\\\C'))->is(["a\ta" => "a", "b" => "b\tb", "c\\t" => 'C\\C']);

        that((ltsv_import)('a:`["x","y"]`	b:B'))->is(['a' => ['x', 'y'], 'b' => 'B']);
        that((ltsv_import)('a:`xyz`	b:B'))->is(['a' => '`xyz`', 'b' => 'B']);
    }

    function test_ltsv_export()
    {
        that((ltsv_export)(['a' => 'A', 'b' => 'B', 'c' => 'C']))->is("a:A	b:B	c:C");
        that((ltsv_export)(["a\ta" => "a", "b" => "b\tb", "c\\t" => 'C\\C']))->is('a\ta:a	b:b\tb	c\\\\t:C\\\\C');
        that((ltsv_export)(["a\ta" => "a", "b" => "b\tb"], ['escape' => '%']))->is("a%ta:a	b:b%tb");
        that((ltsv_export)(["a\ta" => "a", "b" => "b\tb"], ['escape' => null]))->is("a	a:a	b:b	b");

        that((ltsv_export)(['a' => ['x', 'y'], 'b' => 'B']))->is('a:`["x","y"]`	b:B');
        that((ltsv_export)(['a' => new Concrete('hoge'), 'b' => 'B']))->is('a:hoge	b:B');

        that([ltsv_export, ['a:a' => 'A']])->throws('label contains ":"');
    }

    function test_markdown_table()
    {
        that("\n" . (markdown_table)([['a' => 'xx']]))->is("
| a   |
| --- |
| xx  |
");

        that("\n" . (markdown_table)([['a' => '99']]))->is("
|   a |
| --: |
|  99 |
");

        that("\n" . (markdown_table)([['a' => 'aa'], ['b' => "b\nb"]]))->is("
| a   | b      |
| --- | ------ |
| aa  |        |
|     | b<br>b |
");

        that("\n" . (markdown_table)([['a' => 'あ'], ['b' => 'い']]))->is("
| a   | b   |
| --- | --- |
| あ  |     |
|     | い  |
");

        that([markdown_table, ''])->throws('must be array of hasharray');
    }

    function test_markdown_list()
    {
        that("\n" . (markdown_list)(['A', 'B', 'C' => [1, 2, 3]]))->is("
- A
- B
- C: 
    - 1
    - 2
    - 3
");

        that("\n" . (markdown_list)(['a' => 'A', 'b' => 'B', 'ls' => [1, 2, 3]]))->is("
- a: A
- b: B
- ls: 
    - 1
    - 2
    - 3
");

        that("\n" . (markdown_list)(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [1, 2, 3]]))->is("
- a: A
- b: B
- ls: LS
    - 1
    - 2
    - 3
");

        that("\n" . (markdown_list)(['a' => 'A', 'b' => 'B', 'ls' => 'LS', [1, 2, 3]], [
                'indent'    => "\t",
                'separator' => ' = ',
                'liststyle' => '*',
                'ordered'   => true,
            ]))->is("
* a = A
* b = B
* ls = LS
	1. 1
	2. 2
	3. 3
"
        );
    }

    function test_random_string()
    {
        $actual = (random_string)(256, 'abc');
        that(strlen($actual))->is(256); // 256文字のはず
        that($actual)->matches('#abc#'); // 大抵の場合含まれるはず（極稀にコケる）

        that([random_string, 0, 'x'])->throws('positive number');
        that([random_string, 256, ''])->throws('empty');
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
        that($result)->is('int:12345 float:3.141592 string:mojiretu');

        // 文字詰め(シンプル)
        $result = (kvsprintf)('int:%int$07d float:%float$010F string:%string$10s', $args);
        that($result)->is('int:0012345 float:003.141592 string:  mojiretu');

        // 文字詰め(右。dで0埋めは効かない)
        $result = (kvsprintf)('int:%int$-07d float:%float$-010F string:%string$-10s', $args);
        that($result)->is('int:12345   float:3.14159200 string:mojiretu  ');

        // 配列の順番は問わない
        $result = (kvsprintf)('int:%int$d float:%float$F string:%string$s', array_reverse($args));
        that($result)->is('int:12345 float:3.141592 string:mojiretu');

        // 同じキーが出現
        $result = (kvsprintf)('int:%int$d int:%int$d int:%int$d', $args);
        that($result)->is('int:12345 int:12345 int:12345');

        // %エスケープ
        $result = (kvsprintf)('int:%%int$d float:%%float$F string:%%string$s', $args);
        that($result)->is('int:%int$d float:%float$F string:%string$s');

        // 先頭が書式指定子
        $result = (kvsprintf)('%hoge$d', ['hoge' => 123]);
        that($result)->is('123');

        // "%%" の後に書式指定子
        $result = (kvsprintf)('%%%hoge$d', ['hoge' => 123]);
        that($result)->is('%123');

        // キーが他のキーを含む
        $result = (kvsprintf)('%a$s_%aa$s_%aaa$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        that($result)->is('A_AA_AAA');
        $result = (kvsprintf)('%aaa$s_%aa$s_%a$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        that($result)->is('AAA_AA_A');

        // キー自体に%を含む
        $result = (kvsprintf)('%ho%ge$s', ['ho%ge' => 123]);
        that($result)->is('123');

        // 存在しないキーを参照
        that([kvsprintf, '%aaaaa$d %bbbbb$d', ['hoge' => 123]])->throws(new \OutOfBoundsException('Undefined index'));
    }

    public function test_preg_matches()
    {
        that((preg_matches)('#unmatch#', 'HelloWorld'))->isSame([]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#u', 'HelloWorld'))->isSame([
            'letter' => 'H',
            0        => 'ello',
        ]);

        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#u', 'HelloWorld', PREG_OFFSET_CAPTURE))->isSame([
            'letter' => ['H', 0],
            0        => ['ello', 1],
        ]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#u', 'HelloWorld', PREG_OFFSET_CAPTURE, 5))->isSame([
            'letter' => ['W', 5],
            0        => ['orld', 6],
        ]);

        that((preg_matches)('#unmatch#g', 'HelloWorld', PREG_PATTERN_ORDER))->isSame([]);
        that((preg_matches)('#unmatch#g', 'HelloWorld', PREG_SET_ORDER))->isSame([]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_PATTERN_ORDER))->isSame([
            'letter' => ['H', 'W'],
            0        => ['ello', 'orld'],
        ]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_SET_ORDER))->isSame([
            [
                'letter' => 'H',
                0        => 'ello',
            ],
            [
                'letter' => 'W',
                0        => 'orld',
            ],
        ]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_PATTERN_ORDER | PREG_OFFSET_CAPTURE))->isSame([
            'letter' => [['H', 0], ['W', 5]],
            0        => [['ello', 1], ['orld', 6]],
        ]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_SET_ORDER | PREG_OFFSET_CAPTURE))->isSame([
            [
                'letter' => ['H', 0],
                0        => ['ello', 1],
            ],
            [
                'letter' => ['W', 5],
                0        => ['orld', 6],
            ],
        ]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_SET_ORDER | PREG_OFFSET_CAPTURE, 5))->isSame([
            [
                'letter' => ['W', 5],
                0        => ['orld', 6],
            ],
        ]);

        that((preg_matches)('#(?<letter>[A-Z])([a-z])(?<second>[a-z])([a-z])(?<rest>[a-z]+)#ug', 'HelloUnitTestingWorld', PREG_PATTERN_ORDER))->isSame([
            'letter' => ['H', 'T', 'W'],
            0        => ['e', 'e', 'o',],
            'second' => ['l', 's', 'r',],
            1        => ['l', 't', 'l',],
            'rest'   => ['o', 'ing', 'd',],
        ]);
        that((preg_matches)('#(?<letter>[A-Z])([a-z])(?<second>[a-z])([a-z])(?<rest>[a-z]+)#ug', 'HelloUnitTestingWorld', PREG_SET_ORDER))->isSame([
            [
                'letter' => 'H',
                0        => 'e',
                'second' => 'l',
                1        => 'l',
                'rest'   => 'o',
            ],
            [
                'letter' => 'T',
                0        => 'e',
                'second' => 's',
                1        => 't',
                'rest'   => 'ing',
            ],
            [
                'letter' => 'W',
                0        => 'o',
                'second' => 'r',
                1        => 'l',
                'rest'   => 'd',
            ],
        ]);
    }

    public function test_preg_capture()
    {
        that((preg_capture)('#([a-z])([0-9])([A-Z])#', 'a0Z', []))->is([]);
        that((preg_capture)('#([a-z])([0-9])([A-Z])#', 'a0Z', [1 => '']))->is([1 => 'a']);
        that((preg_capture)('#([a-z])([0-9])([A-Z])#', 'a0Z', [4 => '']))->is([4 => '']);

        that((preg_capture)('#([a-z])([0-9])([A-Z]?)#', 'a0', []))->is([]);
        that((preg_capture)('#([a-z])([0-9])([A-Z]?)#', 'a0', [3 => '']))->is([3 => '']);
        that((preg_capture)('#([a-z])([0-9])([A-Z]?)#', 'a0Z', [3 => '']))->is([3 => 'Z']);

        that((preg_capture)('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0Z', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]))->is([
            'one' => 'a',
            'two' => '0',
            'thr' => 'Z',
        ]);
        that((preg_capture)('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]))->is([
            'one' => 'a',
            'two' => '0',
            'thr' => 'THR',
        ]);
    }

    public function test_preg_splice()
    {
        $m = [];
        that((preg_splice)('#\d+#', '', 'abc123', $m))->is("abc");
        that($m)->is(['123']);
        that((preg_splice)('#([a-z]+)#', function ($m) { return strtoupper($m[1]); }, 'abc123', $m))->is("ABC123");
        that($m)->is(['abc', 'abc']);
        that((preg_splice)('#[a-z]+#', 'strtoupper', 'abc123', $m))->is('strtoupper123');
        that($m)->is(['abc']);
    }

    public function test_preg_replaces()
    {
        // simple
        that((preg_replaces)('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz'))->is('aaa99999zzz, aaa99999zzz');
        that((preg_replaces)('#aaa(\d\d\d),(\d\d\d)zzz#', [1 => 99, 2 => 999], 'aaa123,456zzz'))->is('aaa99,999zzz');

        // named
        that((preg_replaces)('#aaa(?<digit>\d\d\d)zzz#', ['digit' => 99999], 'aaa123zzz, aaa456zzz'))->is('aaa99999zzz, aaa99999zzz');

        // multibyte
        that((preg_replaces)('#い(x)う#u', '|', 'あxいxうxえxお'))->is('あxい|うxえxお');

        // limit, count
        $count = 0;
        that((preg_replaces)('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz', 1, $count))->is('aaa99999zzz, aaa456zzz');
        that($count)->is(1);
        that((preg_replaces)('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz', 9, $count))->is('aaa99999zzz, aaa99999zzz');
        that($count)->is(2);

        // misc
        that((preg_replaces)('#aaa(\d\d\d)zzz#', 99999, 'aaa123zzz'))->is('aaa99999zzz');
        that((preg_replaces)('#aaa(\d\d\d)zzz#', function ($v) { return $v * 2; }, 'aaa123zzz'))->is('aaa246zzz');
    }

    public function test_damerau_levenshtein()
    {
        that((damerau_levenshtein)("12345", "12345"))->isSame(0);
        that((damerau_levenshtein)("", "xzy"))->isSame(3);
        that((damerau_levenshtein)("xzy", ""))->isSame(3);
        that((damerau_levenshtein)("", ""))->isSame(0);
        that((damerau_levenshtein)("1", "2"))->isSame(1);
        that((damerau_levenshtein)("12", "21"))->isSame(1);
        that((damerau_levenshtein)("2121", "11", 2, 1, 1))->isSame(2);
        that((damerau_levenshtein)("2121", "11", 2, 1, 5))->isSame(10);
        that((damerau_levenshtein)("11", "2121", 1, 1, 1))->isSame(2);
        that((damerau_levenshtein)("11", "2121", 5, 1, 1))->isSame(10);
        that((damerau_levenshtein)("111", "121", 2, 3, 2))->isSame(3);
        that((damerau_levenshtein)("111", "121", 2, 9, 2))->isSame(4);
        that((damerau_levenshtein)("13458", "12345"))->isSame(2);
        that((damerau_levenshtein)("1345", "1234"))->isSame(2);
        that((damerau_levenshtein)("debugg", "debug"))->isSame(1);
        that((damerau_levenshtein)("ddebug", "debug"))->isSame(1);
        that((damerau_levenshtein)("debbbug", "debug"))->isSame(2);
        that((damerau_levenshtein)("debugging", "debuging"))->isSame(1);
        that((damerau_levenshtein)("a", "bc"))->isSame(2);
        that((damerau_levenshtein)("xa", "xbc"))->isSame(2);
        that((damerau_levenshtein)("xax", "xbcx"))->isSame(2);
        that((damerau_levenshtein)("ax", "bcx"))->isSame(2);

        that((damerau_levenshtein)("abc", "bac"))->isSame(1);
        that((damerau_levenshtein)("bare", "bear"))->isSame(2);
        that((damerau_levenshtein)("12", "21", 1, 1, 1, 0))->isSame(2);
        that((damerau_levenshtein)("destroy", "destory", 1, 1, 1, 2))->isSame(2);

        that((damerau_levenshtein)("あいうえお", "xあういえおx"))->isSame(3);
    }

    public function test_ngram()
    {
        that((ngram)("あいうえお", 1))->isSame(["あ", "い", "う", "え", "お"]);
        that((ngram)("あいうえお", 2))->isSame(["あい", "いう", "うえ", "えお", "お"]);
        that((ngram)("あいうえお", 3))->isSame(["あいう", "いうえ", "うえお", "えお", "お"]);
    }

    public function test_str_guess()
    {
        $percent = 0;
        that((str_guess)("12345", [
            "12345",
        ], $percent))->isSame("12345");
        that($percent)->is(100);

        that((str_guess)("12345", [
            "1",
            "12",
            "123",
            "1234",
        ], $percent))->isSame("1234");
        that($percent)->is(53.77049180327869);

        that((str_guess)("12345", [
            "x12345x",
            "xx12345xx",
        ], $percent))->isSame("x12345x");
        that($percent)->is(52.69320843091335);

        that((str_guess)("notfound", [
            "x12345x",
            "xx12345xx",
        ], $percent))->isSame("xx12345xx");
        that($percent)->is(0);

        that([str_guess, '', []])->throws('is empty');
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
            that((mb_substr_replace)(...$param))->as(implode(', ', $param))->is(substr_replace(...$param));
        }

        // もちろんマルチバイトでも動作する
        that((mb_substr_replace)('０１２３４５６７８９', 'X', 2, null))->is('０１X２３４５６７８９');
        that((mb_substr_replace)('０１２３４５６７８９', 'X', 2, 6))->is('０１X８９');
        that((mb_substr_replace)('０１２３４５６７８９', 'X', 2, -2))->is('０１X８９');
        that((mb_substr_replace)('０１２３４５６７８９', 'X', -8, 6))->is('０１X８９');
        that((mb_substr_replace)('０１２３４５６７８９', 'X', -8, -2))->is('０１X８９');
    }

    function test_mb_trim()
    {
        that((mb_trim)(' 　 　 　'))->is('');
        that((mb_trim)(' 　 あああ　 　'))->is('あああ');
        that((mb_trim)(' 　
あああ　 　
 　 いいい
 　 ううう　 　
'))->is(('あああ　 　
 　 いいい
 　 ううう'));
    }

    public function test_str_array()
    {
        // http header
        $string = <<<TEXT
HTTP/1.1 200 OK
Content-Type: text/html; charset=utf-8
Connection: Keep-Alive
TEXT;
        that((str_array)($string, ':', true))->is([
            'HTTP/1.1 200 OK',
            'Content-Type' => 'text/html; charset=utf-8',
            'Connection'   => 'Keep-Alive',
        ]);

        // sar
        $string = <<<TEXT
13:00:01        CPU     %user     %nice   %system   %iowait    %steal     %idle
13:10:01        all      0.99      0.10      0.71      0.00      0.00     98.19
13:20:01        all      0.60      0.10      0.56      0.00      0.00     98.74
TEXT;
        that((str_array)($string, ' ', false))->is(
            [
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
            ]);

        // misc
        that((str_array)("a=A\n\nb=B\n \nc", '=', true))->is([
            'a' => 'A',
            'b' => 'B',
            2   => '',
            3   => 'c',
        ]);
        that((str_array)("a+b+c\n1+2+3\n\n4+5+6\n \n7+8+9", '+', false))->is([
            1 => ['a' => '1', 'b' => '2', 'c' => '3'],
            2 => ['a' => '4', 'b' => '5', 'c' => '6'],
            3 => null,
            4 => ['a' => '7', 'b' => '8', 'c' => '9'],
        ]);
    }

    public function test_render_string()
    {
        // single
        $actual = (render_string)('int is $int' . "\n" . 'float is $float' . "\n" . 'string is $string', [
            'int'    => 12345,
            'float'  => 3.141592,
            'string' => 'mojiretu',
        ]);
        that($actual)->is("int is 12345\nfloat is 3.141592\nstring is mojiretu");

        // double
        $actual = (render_string)("1\n2\n3{\$val} 4", ['val' => "\n"]);
        that($actual)->is("1\n2\n3\n 4");

        // numeric
        $actual = (render_string)('aaa ${0} ${1} $k $v zzz', ['8', 9, 'k' => 'v', 'v' => 'V']);
        that($actual)->is("aaa 8 9 v V zzz");

        // stringable
        $actual = (render_string)('aaa $val zzz', ['val' => new \Concrete('XXX')]);
        that($actual)->is("aaa XXX zzz");

        // closure
        $actual = (render_string)('aaa $val zzz', ['val' => function () { return 'XXX'; }]);
        that($actual)->is("aaa XXX zzz");
        $actual = (render_string)('aaa $v1 $v2 zzz', ['v1' => 9, 'v2' => function ($vars, $k) { return $vars['v1'] . $k; }]);
        that($actual)->is("aaa 9 9v2 zzz");

        // _
        $actual = (render_string)('aaa {$_(123+456)} zzz', []);
        that($actual)->is("aaa 579 zzz");
        $actual = (render_string)('aaa {$_(implode(\',\', $a))} zzz', ['a' => ['a', 'b', 'c']]);
        that($actual)->is("aaa a,b,c zzz");
        $actual = (render_string)('aaa $_ zzz', ['_' => 'XXX']);
        that($actual)->is("aaa XXX zzz");

        // quoting
        $actual = (render_string)('\'"\\$val', ['val' => '\'"\\']);
        that($actual)->is('\'"\\\'"\\');

        // error
        @that([render_string, '$${}', []])->throws('failed to eval code');
    }

    public function test_render_file()
    {
        $actual = (render_file)(__DIR__ . '/Strings/template.txt', [
            'zero',
            'string'  => 'string',
            'closure' => function () { return 'closure'; },
        ]);
        that($actual)->is("string is string.
closure is closure.
zero is index 0.
123456 is expression.
579 is expression.
");
    }

    public function test_ob_include()
    {
        $actual = (ob_include)(__DIR__ . '/Strings/template.php', [
            'variable' => 'variable',
        ]);
        that($actual)->is("This is plain text.
This is variable.
This is VARIABLE.
");
    }

    public function test_include_string()
    {
        $actual = (include_string)('This is plain text.
This is <?= $variable ?>.
This is <?php echo strtoupper($variable) ?>.
', [
            'variable' => 'variable',
        ]);
        that($actual)->is("This is plain text.
This is variable.
This is VARIABLE.
");
    }
}

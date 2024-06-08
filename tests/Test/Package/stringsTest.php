<?php

namespace ryunosuke\Test\Package;

use Concrete;
use function ryunosuke\Functions\Package\camel_case;
use function ryunosuke\Functions\Package\chain_case;
use function ryunosuke\Functions\Package\concat;
use function ryunosuke\Functions\Package\damerau_levenshtein;
use function ryunosuke\Functions\Package\ends_with;
use function ryunosuke\Functions\Package\include_string;
use function ryunosuke\Functions\Package\kvsprintf;
use function ryunosuke\Functions\Package\mb_compatible_encoding;
use function ryunosuke\Functions\Package\mb_ellipsis;
use function ryunosuke\Functions\Package\mb_ereg_options;
use function ryunosuke\Functions\Package\mb_ereg_split;
use function ryunosuke\Functions\Package\mb_monospace;
use function ryunosuke\Functions\Package\mb_str_pad;
use function ryunosuke\Functions\Package\mb_substr_replace;
use function ryunosuke\Functions\Package\mb_trim;
use function ryunosuke\Functions\Package\mb_wordwrap;
use function ryunosuke\Functions\Package\multiexplode;
use function ryunosuke\Functions\Package\namespace_split;
use function ryunosuke\Functions\Package\ngram;
use function ryunosuke\Functions\Package\pascal_case;
use function ryunosuke\Functions\Package\process;
use function ryunosuke\Functions\Package\quoteexplode;
use function ryunosuke\Functions\Package\render_file;
use function ryunosuke\Functions\Package\render_string;
use function ryunosuke\Functions\Package\render_template;
use function ryunosuke\Functions\Package\snake_case;
use function ryunosuke\Functions\Package\split_noempty;
use function ryunosuke\Functions\Package\starts_with;
use function ryunosuke\Functions\Package\str_anyof;
use function ryunosuke\Functions\Package\str_array;
use function ryunosuke\Functions\Package\str_between;
use function ryunosuke\Functions\Package\str_bytes;
use function ryunosuke\Functions\Package\str_chop;
use function ryunosuke\Functions\Package\str_chunk;
use function ryunosuke\Functions\Package\str_common_prefix;
use function ryunosuke\Functions\Package\str_control_apply;
use function ryunosuke\Functions\Package\str_diff;
use function ryunosuke\Functions\Package\str_ellipsis;
use function ryunosuke\Functions\Package\str_embed;
use function ryunosuke\Functions\Package\str_equals;
use function ryunosuke\Functions\Package\str_exists;
use function ryunosuke\Functions\Package\str_guess;
use function ryunosuke\Functions\Package\str_lchop;
use function ryunosuke\Functions\Package\str_patch;
use function ryunosuke\Functions\Package\str_putcsv;
use function ryunosuke\Functions\Package\str_quote;
use function ryunosuke\Functions\Package\str_rchop;
use function ryunosuke\Functions\Package\str_submap;
use function ryunosuke\Functions\Package\str_subreplace;
use function ryunosuke\Functions\Package\strcat;
use function ryunosuke\Functions\Package\strpos_array;
use function ryunosuke\Functions\Package\strpos_closest;
use function ryunosuke\Functions\Package\strpos_escaped;
use function ryunosuke\Functions\Package\strpos_quoted;
use function ryunosuke\Functions\Package\strposr;
use function ryunosuke\Functions\Package\strrstr;
use function ryunosuke\Functions\Package\strtr_escaped;

class stringsTest extends AbstractTestCase
{
    function test_camel_case()
    {
        that(camel_case(''))->is('');
        that(camel_case('this-is-a-pen', '-'))->is('thisIsAPen');
        that(camel_case('this_is_a_pen'))->is('thisIsAPen');
        that(camel_case('_this_is_a_pen_'))->is('thisIsAPen');
    }

    function test_chain_case()
    {
        that(chain_case(''))->is('');
        that(chain_case('ThisIsAPen', '_'))->is('this_is_a_pen');
        that(chain_case('ThisIsAPen'))->is('this-is-a-pen');
        that(chain_case('ABC'))->is('a-b-c');
        that(chain_case('-ABC-'))->is('a-b-c-');
    }

    function test_concat()
    {
        that(concat('prefix-', 'middle', '-suffix'))->isSame('prefix-middle-suffix');
        that(concat('', 'middle', '-suffix'))->isSame('');
        that(concat('prefix-', '', '-suffix'))->isSame('');
        that(concat('prefix-', 'middle', ''))->isSame('');
        that(concat('null', null))->isSame(null);
        that(concat(null, 'null'))->isSame(null);
    }

    function test_damerau_levenshtein()
    {
        that(damerau_levenshtein("12345", "12345"))->isSame(0);
        that(damerau_levenshtein("", "xzy"))->isSame(3);
        that(damerau_levenshtein("xzy", ""))->isSame(3);
        that(damerau_levenshtein("", ""))->isSame(0);
        that(damerau_levenshtein("1", "2"))->isSame(1);
        that(damerau_levenshtein("12", "21"))->isSame(1);
        that(damerau_levenshtein("2121", "11", 2, 1, 1))->isSame(2);
        that(damerau_levenshtein("2121", "11", 2, 1, 5))->isSame(10);
        that(damerau_levenshtein("11", "2121", 1, 1, 1))->isSame(2);
        that(damerau_levenshtein("11", "2121", 5, 1, 1))->isSame(10);
        that(damerau_levenshtein("111", "121", 2, 3, 2))->isSame(3);
        that(damerau_levenshtein("111", "121", 2, 9, 2))->isSame(4);
        that(damerau_levenshtein("13458", "12345"))->isSame(2);
        that(damerau_levenshtein("1345", "1234"))->isSame(2);
        that(damerau_levenshtein("debugg", "debug"))->isSame(1);
        that(damerau_levenshtein("ddebug", "debug"))->isSame(1);
        that(damerau_levenshtein("debbbug", "debug"))->isSame(2);
        that(damerau_levenshtein("debugging", "debuging"))->isSame(1);
        that(damerau_levenshtein("a", "bc"))->isSame(2);
        that(damerau_levenshtein("xa", "xbc"))->isSame(2);
        that(damerau_levenshtein("xax", "xbcx"))->isSame(2);
        that(damerau_levenshtein("ax", "bcx"))->isSame(2);

        that(damerau_levenshtein("abc", "bac"))->isSame(1);
        that(damerau_levenshtein("bare", "bear"))->isSame(2);
        that(damerau_levenshtein("12", "21", 1, 1, 1, 0))->isSame(2);
        that(damerau_levenshtein("destroy", "destory", 1, 1, 1, 2))->isSame(2);

        that(damerau_levenshtein("あいうえお", "xあういえおx"))->isSame(3);
    }

    function test_ends_with()
    {
        that(ends_with('abcdef', 'def'))->isTrue();
        that(ends_with('abcdef', 'DEF'))->isFalse();
        that(ends_with('abcdef', 'xef'))->isFalse();

        that(ends_with('abcdef', 'def', true))->isTrue();
        that(ends_with('abcdef', 'DEF', true))->isTrue();
        that(ends_with('abcdef', 'xef', true))->isFalse();

        that(ends_with('abcdef', ['f', 'X']))->isTrue();
        that(ends_with('abcdef', ['def', 'XXX']))->isTrue();
        that(ends_with('abcdef', ['XXX']))->isFalse();
        that(ends_with('abcdef', []))->isFalse();

        that(ends_with('', 's'))->isFalse();
    }

    function test_include_string()
    {
        $actual = include_string('This is plain text.
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

    function test_kvsprintf()
    {
        $args = [
            'int'    => 12345,
            'float'  => 3.141592,
            'string' => 'mojiretu',
        ];

        // 普通の変換
        $result = kvsprintf('int:%int$d float:%float$F string:%string$s', $args);
        that($result)->is('int:12345 float:3.141592 string:mojiretu');

        // 文字詰め(シンプル)
        $result = kvsprintf('int:%int$07d float:%float$010F string:%string$10s', $args);
        that($result)->is('int:0012345 float:003.141592 string:  mojiretu');

        // 文字詰め(右。dで0埋めは効かない)
        $result = kvsprintf('int:%int$-07d float:%float$-010F string:%string$-10s', $args);
        that($result)->is('int:12345   float:3.14159200 string:mojiretu  ');

        // 配列の順番は問わない
        $result = kvsprintf('int:%int$d float:%float$F string:%string$s', array_reverse($args));
        that($result)->is('int:12345 float:3.141592 string:mojiretu');

        // 同じキーが出現
        $result = kvsprintf('int:%int$d int:%int$d int:%int$d', $args);
        that($result)->is('int:12345 int:12345 int:12345');

        // %エスケープ
        $result = kvsprintf('int:%%int$d float:%%float$F string:%%string$s', $args);
        that($result)->is('int:%int$d float:%float$F string:%string$s');

        // 先頭が書式指定子
        $result = kvsprintf('%hoge$d', ['hoge' => 123]);
        that($result)->is('123');

        // "%%" の後に書式指定子
        $result = kvsprintf('%%%hoge$d', ['hoge' => 123]);
        that($result)->is('%123');

        // キーが他のキーを含む
        $result = kvsprintf('%a$s_%aa$s_%aaa$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        that($result)->is('A_AA_AAA');
        $result = kvsprintf('%aaa$s_%aa$s_%a$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        that($result)->is('AAA_AA_A');

        // キー自体に%を含む
        $result = kvsprintf('%ho%ge$s', ['ho%ge' => 123]);
        that($result)->is('123');

        // 存在しないキーを参照
        that(self::resolveFunction('kvsprintf'))('%aaaaa$d %bbbbb$d', ['hoge' => 123])->wasThrown(new \OutOfBoundsException('Undefined index'));
    }

    function test_mb_compatible_encoding()
    {
        that(mb_compatible_encoding('ascii', 'ascii'))->isTrue();
        that(mb_compatible_encoding('ascii', 'utf8'))->isTrue();
        that(mb_compatible_encoding('ascii', 'utf-8'))->isTrue();
        that(mb_compatible_encoding('ascii', 'sjis'))->isTrue();
        that(mb_compatible_encoding('ascii', 'shift_jis'))->isTrue();
        that(mb_compatible_encoding('ascii', 'eucjp'))->isTrue();
        that(mb_compatible_encoding('ascii', 'ucs2'))->isFalse();
        that(mb_compatible_encoding('ascii', 'utf32'))->isFalse();

        that(mb_compatible_encoding('utf8', 'utf-8'))->isTrue();
        that(mb_compatible_encoding('utf8', 'utf-8-docomo'))->isTrue();
        that(mb_compatible_encoding('utf8', 'utf-7'))->isFalse();
        that(mb_compatible_encoding('utf8', 'ascii'))->isFalse();
        that(mb_compatible_encoding('utf-8-docomo', 'utf8'))->isFalse();

        that(mb_compatible_encoding('sjis', 'sjis'))->isTrue();
        that(mb_compatible_encoding('sjis', 'sjis-win'))->isTrue();
        that(mb_compatible_encoding('sjis', 'windows-31j'))->isTrue();
        that(mb_compatible_encoding('sjis', 'cp932'))->isTrue();
        that(mb_compatible_encoding('sjis', 'utf8'))->isFalse();
        that(mb_compatible_encoding('sjis', 'ascii'))->isFalse();
        that(mb_compatible_encoding('windows-31j', 'sjis'))->isFalse();

        that(mb_compatible_encoding('8bit', '8bit'))->isTrue();
        that(mb_compatible_encoding('8bit', 'binary'))->isTrue();
        that(mb_compatible_encoding('sjis', '8bit'))->isNull();
        that(mb_compatible_encoding('8bit', 'utf8'))->isNull();

        that(self::resolveFunction('mb_compatible_encoding'))('unknown', 'unknown')->wasThrown("is not supported");
    }

    function test_mb_ellipsis()
    {
        that(mb_ellipsis('1234567890', 8, '...'))->isSame('123...90');
        that(mb_ellipsis('1234567890', 8, '...', +0))->isSame('...67890');
        that(mb_ellipsis('1234567890', 8, '...', +1))->isSame('1...7890');
        that(mb_ellipsis('1234567890', 8, '...', +2))->isSame('12...890');
        that(mb_ellipsis('1234567890', 8, '...', +3))->isSame('123...90');
        that(mb_ellipsis('1234567890', 8, '...', +4))->isSame('1234...0');
        that(mb_ellipsis('1234567890', 8, '...', +5))->isSame('12345...');
        that(mb_ellipsis('1234567890', 8, '...', +6))->isSame('12345...');
        that(mb_ellipsis('1234567890', 8, '...', -1))->isSame('1234...0');
        that(mb_ellipsis('1234567890', 8, '...', -2))->isSame('123...90');
        that(mb_ellipsis('1234567890', 8, '...', -3))->isSame('12...890');
        that(mb_ellipsis('1234567890', 8, '...', -4))->isSame('1...7890');
        that(mb_ellipsis('1234567890', 8, '...', -5))->isSame('...67890');
        that(mb_ellipsis('1234567890', 8, '...', -6))->isSame('...67890');

        that(mb_ellipsis('1あ2い3う4え5お', 8, '...'))->isSame('1あ...お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', +0))->isSame('...え5お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', +1))->isSame('1...5お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', +2))->isSame('1...5お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', +3))->isSame('1あ...お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', +4))->isSame('1あ2...');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', +5))->isSame('1あ2...');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', +6))->isSame('1あ2...');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', -1))->isSame('1あ2...');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', -2))->isSame('1あ...お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', -3))->isSame('1...5お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', -4))->isSame('1...5お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', -5))->isSame('...え5お');
        that(mb_ellipsis('1あ2い3う4え5お', 8, '...', -6))->isSame('...え5お');

        that(mb_ellipsis('', 1, '...', null))->isSame('');
        that(mb_ellipsis('1234567890', 1, '...', null))->isSame('...');
        that(mb_ellipsis('1234567890', 1000, '...', null))->isSame('1234567890');
    }

    function test_mb_ereg_options()
    {
        $recover = mb_ereg_options([
            'encoding' => 'cp932',
        ]);
        $pattern = mb_convert_encoding('fgａｂ', 'cp932', 'utf8');
        $subject = mb_convert_encoding('abcdefgａｂｃｄｅｆｇｈ', 'cp932', 'utf8');
        that(mb_ereg($pattern, $subject))->is(1);
        $recover();
        that(mb_ereg($pattern, $subject))->is(false);

        $recover = mb_ereg_options([
            'encoding'      => 'cp932',
            'regex_options' => 'i',
        ]);
        $pattern = mb_convert_encoding('fgａｂ', 'cp932', 'utf8');
        $subject = mb_convert_encoding('ABCDEFGａｂＣＤＥＦＧＨ', 'cp932', 'utf8');
        that(mb_ereg($pattern, $subject))->is(1);
        unset($recover);
        that(mb_ereg($pattern, $subject))->is(false);

        $original = mb_substitute_character();
        $recover1 = mb_ereg_options([
            'substitute_character' => mb_ord("Ｘ"),
        ]);
        that(mb_substitute_character())->is(mb_ord("Ｘ"));
        $recover2 = mb_ereg_options([
            'substitute_character' => mb_ord("Ｙ"),
        ]);
        that(mb_substitute_character())->is(mb_ord("Ｙ"));
        unset($recover2);
        that(mb_substitute_character())->is(mb_ord("Ｘ"));
        unset($recover1);
        that(mb_substitute_character())->is($original);
    }

    function test_mb_ereg_split()
    {
        $testcases = [
            // pattern
            'standard'             => [',', 'a1,b22,c333', -1, 0],
            'space'                => [',', ',a1,,b22,,c333,', -1, 0],
            'empty'                => ['', 'a1,b22,c333', -1, 0],
            'unmatch'              => ['hoge', 'a1,b22,c333', -1, 0],
            'nomatch'              => ['X?', 'a1,b22,c333', -1, 0],
            'nomatch-multi'        => ['X?', 'あ,いい,ううう', -1, 0],
            'or'                   => [',|\\|', 'a1|b22|,c333', -1, 0],
            '@invalid'             => ['**', 'hoge', -1, 0],
            // limit
            'limit0'               => [',', 'a1,b22,c333', 0, 0],
            'limit2'               => [',', 'a1,b22,c333', 2, 0],
            'limit2-empty'         => [',', ',a1,b22,c333,', 2, 0],
            'limit-2'              => [',', ',a1,b22,c333,', -2, 0],
            // flags
            'no_empty'             => [',', ',a1,,b22,,c333,', -1, PREG_SPLIT_NO_EMPTY],
            'no_empty+limit'       => [',', ',a1,,b22,,c333,', 2, PREG_SPLIT_NO_EMPTY],
            'delim_capture+no'     => [',', ',a1,,b22,,c333,', -1, PREG_SPLIT_DELIM_CAPTURE],
            'delim_capture1'       => ['(,)', ',a1,,b22,,c333,', -1, PREG_SPLIT_DELIM_CAPTURE],
            'delim_capture2'       => ['(,)(,)', ',a1,,b22,,c333,', -1, PREG_SPLIT_DELIM_CAPTURE],
            'offset_capture'       => ['(,)(,)', ',a1,,b22,,c333,', -1, PREG_SPLIT_OFFSET_CAPTURE],
            'all-flag'             => ['(,)(,)', ',a1,,b22,,c333,', -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE],
            'all-multibyte'        => ['(，)', '，Ａ，Ｂ，，Ｃ，', 2, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE],
            'all-flag+empty'       => ['', ',a1,,b22,,c333,', -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE],
            'all-flag+empty+limit' => ['', ',a1,,b22,,c333,', 3, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE],
        ];
        foreach ($testcases as $name => $args) {
            set_error_handler(fn() => $name[0] === '@');
            that(mb_ereg_split($args[0], $args[1], $args[2], $args[3]))->as($name)->is(preg_split("#{$args[0]}#u", $args[1], $args[2], $args[3]));
            restore_error_handler();
        }
    }

    function test_mb_monospace()
    {
        that(mb_monospace('※★▼…'))->isSame(8);
        that(mb_monospace('123456７8８'))->isSame(11);
        that(mb_monospace('Σ(ﾟДﾟ)え!！'))->isSame(15);
        that(mb_monospace('Σ(ﾟДﾟ)え!！', [
            "Σ"    => 1,
            "Ѐ-ӿ"  => 1,
            0xFF9F => 1,
        ]))->isSame(11);
        that(mb_monospace('あいうえおかきくけこさしすせそたちつてとなにぬねの', [
            "あいうえおさ-そな-の" => 1,
        ]))->isSame(35);
    }

    function test_mb_str_pad()
    {
        that(mb_str_pad('a', 11, '', STR_PAD_LEFT))->isSame('a');
        that(mb_str_pad('aaa', 1, 'x', STR_PAD_LEFT))->isSame('aaa');

        that(mb_str_pad('あ', 2, 'x', STR_PAD_LEFT))->isSame('あ');
        that(mb_str_pad('あ', 3, 'x', STR_PAD_LEFT))->isSame('xあ');
        that(mb_str_pad('ああ', 4, 'x', STR_PAD_LEFT))->isSame('ああ');
        that(mb_str_pad('ああ', 5, 'x', STR_PAD_LEFT))->isSame('xああ');
        that(mb_str_pad('ああ', 6, 'x', STR_PAD_LEFT))->isSame('xxああ');

        that(mb_str_pad('a', 6, 'x', STR_PAD_LEFT))->isSame('xxxxxa');
        that(mb_str_pad('a', 6, 'x', STR_PAD_RIGHT))->isSame('axxxxx');
        that(mb_str_pad('a', 6, 'x', STR_PAD_BOTH))->isSame('xxaxxx');

        that(mb_str_pad('あ', 7, 'x', STR_PAD_LEFT))->isSame('xxxxxあ');
        that(mb_str_pad('あ', 7, 'x', STR_PAD_RIGHT))->isSame('あxxxxx');
        that(mb_str_pad('あ', 7, 'x', STR_PAD_BOTH))->isSame('xxあxxx');

        that(mb_str_pad('a', 11, 'x', STR_PAD_LEFT))->isSame('xxxxxxxxxxa');
        that(mb_str_pad('a', 11, 'xyz', STR_PAD_LEFT))->isSame('xyzxyzxyza');
        that(mb_str_pad('a', 11, 'x', STR_PAD_RIGHT))->isSame('axxxxxxxxxx');
        that(mb_str_pad('a', 11, 'xyz', STR_PAD_RIGHT))->isSame('axyzxyzxyz');
        that(mb_str_pad('a', 11, 'x', STR_PAD_BOTH))->isSame('xxxxxaxxxxx');
        that(mb_str_pad('a', 11, 'xyz', STR_PAD_BOTH))->isSame('xyzaxyzxyz');
        that(mb_str_pad('a', 11, 'xy', STR_PAD_BOTH))->isSame('xyxyaxyxyxy');

        that(mb_str_pad('あ', 11, 'わ', STR_PAD_LEFT))->isSame('わわわわあ');
        that(mb_str_pad('あ', 11, 'わをん', STR_PAD_LEFT))->isSame('わをんあ');
        that(mb_str_pad('あ', 11, 'わ', STR_PAD_RIGHT))->isSame('あわわわわ');
        that(mb_str_pad('あ', 11, 'わをん', STR_PAD_RIGHT))->isSame('あわをん');
        that(mb_str_pad('あ', 11, 'わ', STR_PAD_BOTH))->isSame('わわあわわ');
        that(mb_str_pad('あ', 11, 'わをん', STR_PAD_BOTH))->isSame('あわをん');
        that(mb_str_pad('あ', 11, 'わを', STR_PAD_BOTH))->isSame('わをあわを');

        that(mb_str_pad('あ', 12, 'xy', STR_PAD_LEFT))->isSame('xyxyxyxyxyあ');
        that(mb_str_pad('あ', 12, 'xyzxyz', STR_PAD_LEFT))->isSame('xyzxyzあ');
        that(mb_str_pad('あ', 12, 'xy', STR_PAD_RIGHT))->isSame('あxyxyxyxyxy');
        that(mb_str_pad('あ', 12, 'xyzxyz', STR_PAD_RIGHT))->isSame('あxyzxyz');
        that(mb_str_pad('あ', 12, 'xy', STR_PAD_BOTH))->isSame('xyxyあxyxyxy');
        that(mb_str_pad('あ', 12, 'xyzxyz', STR_PAD_BOTH))->isSame('あxyzxyz');
        that(mb_str_pad('あ', 12, 'xyxy', STR_PAD_BOTH))->isSame('xyxyあxyxy');

        that(mb_str_pad('あ', 12, 'わ', STR_PAD_LEFT))->isSame('わわわわわあ');
        that(mb_str_pad('あ', 12, 'わをん', STR_PAD_LEFT))->isSame('わをんあ');
        that(mb_str_pad('あ', 12, 'わ', STR_PAD_RIGHT))->isSame('あわわわわわ');
        that(mb_str_pad('あ', 12, 'わをん', STR_PAD_RIGHT))->isSame('あわをん');
        that(mb_str_pad('あ', 12, 'わ', STR_PAD_BOTH))->isSame('わわあわわわ');
        that(mb_str_pad('あ', 12, 'わをん', STR_PAD_BOTH))->isSame('あわをん');
        that(mb_str_pad('あ', 12, 'わを', STR_PAD_BOTH))->isSame('わをあわを');

        // 最もよくあるユースケース（これをやるために mb_strlen ではなく mb_strwidth である必要がある）
        $strings = [
            mb_str_pad('a', 16, ' ', STR_PAD_RIGHT) . ': 1 alpha',
            mb_str_pad('hoge', 16, ' ', STR_PAD_RIGHT) . ': 4 alpha',
            mb_str_pad('free text', 16, ' ', STR_PAD_RIGHT) . ': 9 alpha',
            mb_str_pad('あ', 16, ' ', STR_PAD_RIGHT) . ': 1 mb',
            mb_str_pad('ほげ', 16, ' ', STR_PAD_RIGHT) . ': 2 mb',
            mb_str_pad('自由文', 16, ' ', STR_PAD_RIGHT) . ': 3 mb',
        ];
        that(implode("\n", $strings))->is(<<<EXPECTED
        a               : 1 alpha
        hoge            : 4 alpha
        free text       : 9 alpha
        あ              : 1 mb
        ほげ            : 2 mb
        自由文          : 3 mb
        EXPECTED
        );
    }

    function test_mb_substr_replace()
    {
        // 素の挙動は substr_replace と全く変わらない
        $params = [
            // ['0123456789', 'X', 2, null], // for php8
            ['0123456789', 'X', 2, 0],
            ['0123456789', 'X', 2, 6],
            ['0123456789', 'X', 2, -2],
            ['0123456789', 'X', -8, 6],
            ['0123456789', 'X', -8, -2],
            ['0123456789', 'X', -8, 999],
            ['0123456789', 'X', -999, 999],
        ];
        foreach ($params as $param) {
            that(mb_substr_replace(...$param))->as(implode(', ', $param))->is(substr_replace(...$param));
        }

        // もちろんマルチバイトでも動作する
        that(mb_substr_replace('０１２３４５６７８９', 'X', 2, null))->is('０１X');
        that(mb_substr_replace('０１２３４５６７８９', 'X', 2, 0))->is('０１X２３４５６７８９');
        that(mb_substr_replace('０１２３４５６７８９', 'X', 2, 6))->is('０１X８９');
        that(mb_substr_replace('０１２３４５６７８９', 'X', 2, -2))->is('０１X８９');
        that(mb_substr_replace('０１２３４５６７８９', 'X', -8, 6))->is('０１X８９');
        that(mb_substr_replace('０１２３４５６７８９', 'X', -8, -2))->is('０１X８９');
    }

    function test_mb_trim()
    {
        that(mb_trim(' 　 　 　'))->is('');
        that(mb_trim(' 　 あああ　 　'))->is('あああ');
        that(mb_trim(' 　
あああ　 　
 　 いいい
 　 ううう　 　
'))->is(('あああ　 　
 　 いいい
 　 ううう'));
    }

    function test_mb_wordwrap()
    {
        that(mb_wordwrap("", 10))->is("");
        that(mb_wordwrap("", 10, null))->is([""]);

        that(mb_wordwrap("\n\n", 10))->is("\n\n");
        that(mb_wordwrap("\n\n", 10, null))->is(["", "", ""]);

        that(mb_wordwrap("line1\nline2\ntommorow never knows", 10))->is(<<<ACTUAL
            line1
            line2
            tommorow n
            ever knows
            ACTUAL
        );
        that(mb_wordwrap("line1\nline2\ntommorow never knows", 10, null))->is([
            'line1',
            'line2',
            'tommorow n',
            'ever knows',
        ]);

        that(mb_wordwrap("line1\nline2\ntodayは晴天なり", 10))->is(<<<ACTUAL
            line1
            line2
            todayは晴
            天なり
            ACTUAL
        );
        that(mb_wordwrap("line1\nline2\ntodayは晴天なり", 10, null))->is([
            'line1',
            'line2',
            'todayは晴',
            '天なり',
        ]);

        that(mb_wordwrap("line1\nline2\ntommorowは雨天なり", 10))->is(<<<ACTUAL
            line1
            line2
            tommorowは
            雨天なり
            ACTUAL
        );
        that(mb_wordwrap("line1\nline2\ntommorowは雨天なり", 10, null))->is([
            'line1',
            'line2',
            'tommorowは',
            '雨天なり',
        ]);
    }

    function test_multiexplode()
    {
        $target = 'one|two|three|four';

        // 配列だと複数文字列で分割
        that(multiexplode(['|'], $target))->is(['one', 'two', 'three', 'four']);
        that(multiexplode(['o'], $target))->is(['', 'ne|tw', '|three|f', 'ur']);
        that(multiexplode(['|', 'o'], $target))->is(['', 'ne', 'tw', '', 'three', 'f', 'ur',]);

        // 負数は前詰めで返す
        that(multiexplode('|', $target, -0))->is(['one|two|three|four']);
        that(multiexplode('|', $target, -1))->is(['one|two|three|four']);
        that(multiexplode('|', $target, -2))->is(['one|two|three', 'four']);
        that(multiexplode('|', $target, -3))->is(['one|two', 'three', 'four']);
        that(multiexplode('|', $target, -999))->is(['one', 'two', 'three', 'four']);

        // ただの文字列・正数の挙動は素の explode と変わらない
        that(multiexplode('|', $target, 0))->is(['one|two|three|four']);
        that(multiexplode('|', $target, 1))->is(['one|two|three|four']);
        that(multiexplode('|', $target, 2))->is(['one', 'two|three|four']);
        that(multiexplode('|', $target, 3))->is(['one', 'two', 'three|four']);
        that(multiexplode('|', $target, 999))->is(['one', 'two', 'three', 'four']);

        // 上記の複合
        that(multiexplode([',', ' ', '|'], 'a,b c|d', -1))->is(['a,b c|d']);
        that(multiexplode([',', ' ', '|'], 'a,b c|d', -2))->is(['a,b c', 'd']);
        that(multiexplode([',', ' ', '|'], 'a,b c|d', -3))->is(['a,b', 'c', 'd']);
        that(multiexplode([',', ' ', '|'], 'a,b c|d', -4))->is(['a', 'b', 'c', 'd']);
    }

    function test_namespace_split()
    {
        that(namespace_split('ns\\hoge'))->is(['ns', 'hoge']);
        that(namespace_split('\\ns\\hoge'))->is(['\\ns', 'hoge']);
        that(namespace_split('\\ns\\'))->is(['\\ns', '']);
        that(namespace_split('hoge'))->is(['', 'hoge']);
        that(namespace_split('\\hoge'))->is(['', 'hoge']);
        that(namespace_split(new \Concrete('aaa\bbb')))->is(['aaa', 'bbb']);
    }

    function test_ngram()
    {
        that(ngram("あいうえお", 1))->isSame(["あ", "い", "う", "え", "お"]);
        that(ngram("あいうえお", 2))->isSame(["あい", "いう", "うえ", "えお", "お"]);
        that(ngram("あいうえお", 3))->isSame(["あいう", "いうえ", "うえお", "えお", "お"]);
    }

    function test_pascal_case()
    {
        that(pascal_case(''))->is('');
        that(pascal_case('this-is-a-pen', '-'))->is('ThisIsAPen');
        that(pascal_case('this_is_a_pen'))->is('ThisIsAPen');
        that(pascal_case('_this_is_a_pen_'))->is('ThisIsAPen');
        that(pascal_case('this-is/a_pen', '_-/'))->is('ThisIsAPen');
    }

    function test_quoteexplode()
    {
        that(quoteexplode(',', ',,,a,,,z,,,'))->is(['', '', '', 'a', '', '', 'z', '', '', '']);
        that(quoteexplode('zzz', 'zzzAzzzzzzAzzz'))->is(['', 'A', '', 'A', '']);

        that(quoteexplode(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 1, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a,"x,y",["y", "z"],c\\,d,\'e,f\'',
        ]);
        that(quoteexplode(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 2, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y",["y", "z"],c\\,d,\'e,f\'',
        ]);
        that(quoteexplode(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 3, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"],c\\,d,\'e,f\'',
        ]);
        that(quoteexplode(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 4, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\\,d,\'e,f\'',
        ]);
        that(quoteexplode(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 5, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            '\'e,f\'',
        ]);
        that(quoteexplode(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', 6, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            '\'e,f\'',
        ]);
        that(quoteexplode(',', 'a,"x,y",["y", "z"],c\\,d,\'e,f\'', null, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x,y"',
            '["y", "z"]',
            'c\,d',
            '\'e,f\'',
        ]);

        that(quoteexplode([" ", "\t"], "a b\tc 'd e\tf'"))->is([
            'a',
            'b',
            'c',
            "'d e\tf'",
        ]);

        that(quoteexplode(',', 'a,b,{e,f}', null, ['{' => '}']))->is([
            'a',
            'b',
            '{e,f}',
        ]);

        that(quoteexplode('---', 'a---"x---y"---["y" --- "z"]---c\\---d---\'e---f\'', null, ['[' => ']', '"' => '"', "'" => "'"], '\\'))->is([
            'a',
            '"x---y"',
            '["y" --- "z"]',
            'c\---d',
            "'e---f'",
        ]);

        that(quoteexplode(' ', 'a "b c" \'d e\'', null, '"\''))->is([
            'a',
            '"b c"',
            "'d e'",
        ]);

        that(quoteexplode(' ', 'a"bc"', null, '"'))->is([
            'a"bc"',
        ]);

        that(quoteexplode(' ', 'a"bc " ', null, '"'))->is([
            'a"bc "',
            '',
        ]);

        $string = 'a,b.c---d:';
        $actual = quoteexplode(['---', ',', '.', ':'], $string, options: ['delim-capture' => true]);
        that($actual)->is([
            "a",
            ",",
            "b",
            ".",
            "c",
            "---",
            "d",
            ":",
            "",
        ]);
        that(implode('', $actual))->is($string);
    }

    function test_render_file()
    {
        set_error_handler(function ($errno, $errmsg) {
            if (str_contains($errmsg, '${expr}')) {
                return null;
            }
            return false;
        });
        $actual = render_file(__DIR__ . '/files/template/template.txt', [
            'zero',
            'string'  => 'string',
            'closure' => fn() => 'closure',
        ]);
        that($actual)->is("string is string.
closure is closure.
zero is index 0.
123456 is expression.
579 is expression.
");
    }

    function test_render_string()
    {
        set_error_handler(function ($errno, $errmsg) {
            if (str_contains($errmsg, '${expr}')) {
                return null;
            }
            return false;
        });
        // single
        $actual = render_string('int is $int' . "\n" . 'float is $float' . "\n" . 'string is $string', [
            'int'    => 12345,
            'float'  => 3.141592,
            'string' => 'mojiretu',
        ]);
        that($actual)->is("int is 12345\nfloat is 3.141592\nstring is mojiretu");

        // double
        $actual = render_string("1\n2\n3{\$val} 4", ['val' => "\n"]);
        that($actual)->is("1\n2\n3\n 4");

        // numeric
        $actual = render_string('aaa ${0} ${1} $k $v zzz', ['8', 9, 'k' => 'v', 'v' => 'V']);
        that($actual)->is("aaa 8 9 v V zzz");

        // stringable
        $actual = render_string('aaa $val zzz', ['val' => new \Concrete('XXX')]);
        that($actual)->is("aaa XXX zzz");

        // closure
        $actual = render_string('aaa $val zzz', ['val' => fn() => 'XXX']);
        that($actual)->is("aaa XXX zzz");
        $actual = render_string('aaa $v1 $v2 zzz', ['v1' => 9, 'v2' => fn($vars, $k) => $vars['v1'] . $k]);
        that($actual)->is("aaa 9 9v2 zzz");

        // _
        $actual = render_string('aaa {$_(123+456)} zzz', []);
        that($actual)->is("aaa 579 zzz");
        $actual = render_string('aaa {$_(implode(\',\', $a))} zzz', ['a' => ['a', 'b', 'c']]);
        that($actual)->is("aaa a,b,c zzz");
        $actual = render_string('aaa $_ zzz', ['_' => 'XXX']);
        that($actual)->is("aaa XXX zzz");

        // quoting
        $actual = render_string('\'"\\$val', ['val' => '\'"\\']);
        that($actual)->is('\'"\\\'"\\');

        // error
        @that(self::resolveFunction('render_string'))('$${}', [])->wasThrown('failed to eval code');
    }

    function test_render_template()
    {
        // single
        $actual = render_template('false', ['false' => 'hoge']);
        that($actual)->is('false');

        // array
        $actual = render_template('${array[key]}', ['array' => ['h' => 'hoge'], 'key' => 'h']);
        that($actual)->is('hoge');

        // escape
        $actual = render_template('{val} {$val} \\${val} "hello" \'world\'', ['val' => 'hoge']);
        that($actual)->is('{val} {$val} ${val} "hello" \'world\'');

        // embed var
        $actual = render_template('C:${PHP_SAPI}, V:${val}, E:{$val}, F:${strtoupper(`pre-${val}`)}, S:${1+2+3}', ['val' => 'hoge']);
        that($actual)->is("C:cli, V:hoge, E:{\$val}, F:PRE-HOGE, S:6");

        // with tag
        $actual = render_template('C:${PHP_SAPI}, V:${val}, E:{$val}, F:${strtoupper(`pre-${val}`)}, S:${1+2+3}', [], fn($strings, ...$values) => [$strings, $values]);
        that($actual)->is([
            ['C:', ', V:', ', E:{$val}, F:', ', S:', ''],
            ['cli', 'val', 'PRE-VAL', 6],
        ]);
    }

    function test_snake_case()
    {
        that(snake_case(''))->is('');
        that(snake_case('ThisIsAPen', '-'))->is('this-is-a-pen');
        that(snake_case('ThisIsAPen'))->is('this_is_a_pen');
        that(snake_case('ABC'))->is('a_b_c');
        that(snake_case('_ABC_'))->is('a_b_c_');
        that(snake_case('URLEncode'))->is('u_r_l_encode');

        that(snake_case('', '-', true))->is('');
        that(snake_case('ThisIsAPen', '-', true))->is('this-is-a-pen');
        that(snake_case('ThisIsAPen', '_', true))->is('this_is_a_pen');
        that(snake_case('ABC', '_', true))->is('abc');
        that(snake_case('_ABC_', '_', true))->is('abc_');
        that(snake_case('URLEncode', '-', true))->is('url-encode');
    }

    function test_split_noempty()
    {
        // 空文字は空配列と規定している
        that(split_noempty('hoge', ''))->is([]);
        that(split_noempty(',', ',, ,'))->is([]);

        // 両サイド
        that(split_noempty(',', ' a '))->is(['a']);

        // trim しない
        that(split_noempty(',', " A,, , B ,C ", false))->is([' A', ' ', ' B ', 'C ']);

        // trim 文字が与えられる
        that(split_noempty(',', " A,\tB ", "\t"))->is([' A', 'B ']);

        // 結果はただの配列になる
        that(split_noempty(',', 'A,,B,,,C'))->is(['A', 'B', 'C']);
    }

    function test_starts_with()
    {
        that(starts_with('abcdef', 'abc'))->isTrue();
        that(starts_with('abcdef', 'ABC'))->isFalse();
        that(starts_with('abcdef', 'xbc'))->isFalse();

        that(starts_with('abcdef', 'abc', true))->isTrue();
        that(starts_with('abcdef', 'ABC', true))->isTrue();
        that(starts_with('abcdef', 'xbc', true))->isFalse();

        that(starts_with('abcdef', ['a', 'X']))->isTrue();
        that(starts_with('abcdef', ['abc', 'XXX']))->isTrue();
        that(starts_with('abcdef', ['XXX']))->isFalse();
        that(starts_with('abcdef', []))->isFalse();

        that(starts_with('', 's'))->isFalse();
    }

    function test_str_anyof()
    {
        that(str_anyof('a', ['a', 'b', 'c']))->isSame(0);
        that(str_anyof('b', ['a', 'b', 'c']))->isSame(1);
        that(str_anyof('c', ['a', 'b', 'c']))->isSame(2);
        that(str_anyof('x', ['a', 'b', 'c']))->isSame(null);
        that(str_anyof('A', ['a', 'b', 'c'], true))->isSame(0);
        that(str_anyof('B', ['a', 'b', 'c'], true))->isSame(1);
        that(str_anyof('C', ['a', 'b', 'c'], true))->isSame(2);
        that(str_anyof('', ['a', 'b', 'c']))->isSame(null);
        that(str_anyof(false, ['a', 'b', 'c']))->isSame(null);
        that(str_anyof(null, ['a', 'b', 'c']))->isSame(null);
        that(str_anyof('', ['', 'a', 'b', 'c']))->isSame(0);
        that(str_anyof(false, ['', 'a', 'b', 'c']))->isSame(0);
        that(str_anyof(null, ['', 'a', 'b', 'c']))->isSame(0);
        that(str_anyof('a', [new Concrete('a'), new Concrete('b'), new Concrete('c')]))->isSame(0);
        that(str_anyof('x', [new Concrete('a'), new Concrete('b'), new Concrete('c')]))->isSame(null);
        that(str_anyof('A', [new Concrete('a'), new Concrete('b'), new Concrete('c')], true))->isSame(0);
        that(str_anyof('1', [1, 2, 3]))->isSame(0);
        that(str_anyof('2', [1, 2, 3]))->isSame(1);
        that(str_anyof('3', [1, 2, 3]))->isSame(2);
        that(str_anyof('9', [1, 2, 3]))->isSame(null);
        that(str_anyof(1, ['1', '2', '3']))->isSame(0);
        that(str_anyof(2, ['1', '2', '3']))->isSame(1);
        that(str_anyof(3, ['1', '2', '3']))->isSame(2);
        that(str_anyof(9, ['1', '2', '3']))->isSame(null);
    }

    function test_str_array()
    {
        // http header
        $string = <<<TEXT
        HTTP/1.1 200 OK
        Content-Type: text/html; charset=utf-8
        Connection: Keep-Alive
        TEXT;
        that(str_array($string, ':', true))->is([
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
        that(str_array($string, ' ', false))->is(
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
        that(str_array("a=A\n\nb=B\n \nc", '=', true))->is([
            'a' => 'A',
            'b' => 'B',
            2   => '',
            3   => 'c',
        ]);
        that(str_array("a+b+c\n1+2+3\n\n4+5+6\n \n7+8+9", '+', false))->is([
            1 => ['a' => '1', 'b' => '2', 'c' => '3'],
            2 => ['a' => '4', 'b' => '5', 'c' => '6'],
            3 => null,
            4 => ['a' => '7', 'b' => '8', 'c' => '9'],
        ]);
    }

    function test_str_between()
    {
        ////////// 0123456789A1234567891B23456789C123456789D
        $string = '{simple}, "{enclose}", \\{{escape\\}}';
        $n = 0;
        that(str_between($string, '{', '}', $n))->isSame('simple');
        that($n)->isSame(8);
        that(str_between($string, '{', '}', $n))->isSame('escape\\}');
        that($n)->isSame(35);
        that(str_between($string, '{', '}', $n))->isSame(null);
        that($n)->isSame(35);

        // ずっとエスケープ中なので見つからない
        $string = '"{a}{b}{c}{d}{e}{f}{g}"';
        $n = 0;
        that(str_between($string, '{', '}', $n))->isSame(null);

        // from to が複数文字の場合
        $string = '{{name}}, {{hobby}}';
        $n = 0;
        that(str_between($string, '{{', '}}', $n))->isSame('name');
        that(str_between($string, '{{', '}}', $n))->isSame('hobby');
        that(str_between($string, '{{', '}}', $n))->isSame(null);

        // 中身が空の場合
        $string = '{{}} {{}} {{}}';
        $n = 0;
        that(str_between($string, '{{', '}}', $n))->isSame('');
        that(str_between($string, '{{', '}}', $n))->isSame('');
        that(str_between($string, '{{', '}}', $n))->isSame('');
        that(str_between($string, '{{', '}}', $n))->isSame(null);

        // くっついている場合
        $string = '{{first}}{{second}}{{third}}';
        $n = 0;
        that(str_between($string, '{{', '}}', $n))->isSame('first');
        that(str_between($string, '{{', '}}', $n))->isSame('second');
        that(str_between($string, '{{', '}}', $n))->isSame('third');
        that(str_between($string, '{{', '}}', $n))->isSame(null);

        // 開始終了が一致していない場合
        $string = '{first}}}}}} and {second}';
        $n = 0;
        that(str_between($string, '{', '}', $n))->isSame('first');
        that(str_between($string, '{', '}', $n))->isSame('second');
        that(str_between($string, '{', '}', $n))->isSame(null);

        // 開始終了に包含関係がある場合
        that(str_between('!first!!', '!', '!!'))->isSame('first');
        that(str_between('!!first!', '!!', '!'))->isSame('first');
        that(str_between('!!first!!', '!!', '!!'))->isSame('first');

        // enclosure も escape もしない単純な場合
        $n = 0;
        that(str_between('{first}"{second}"\\{third\\}', '{', '}', $n, '', ''))->isSame('first');
        that(str_between('{first}"{second}"\\{third\\}', '{', '}', $n, '', ''))->isSame('second');
        that(str_between('{first}"{second}"\\{third\\}', '{', '}', $n, '', ''))->isSame('third\\');

        // ネストしている場合
        that(str_between('{nest1{nest2{nest3}}}', '{', '}'))->isSame('nest1{nest2{nest3}}');
    }

    function test_str_bytes()
    {
        that(str_bytes('abc'))->isSame([97, 98, 99]);
        that(str_bytes('abc', 16))->isSame(["61", "62", "63"]);
        that(str_bytes("\x00\x80\xff"))->isSame([0x00, 0x80, 0xff]);
        that(str_bytes('あいう', "16"))->isSame(["e3", "81", "82", "e3", "81", "84", "e3", "81", "86"]);
        that(str_bytes(mb_convert_encoding('あいう', 'SJIS', 'UTF-8'), "16"))->isSame(["82", "a0", "82", "a2", "82", "a4"]);
    }

    function test_str_chop()
    {
        that(str_chop('aaaMMMzzz', 'aaa'))->is("MMMzzz");
        that(str_chop('aaaMMMzzz', '', 'zzz'))->is("aaaMMM");
        that(str_chop('aaaMMMzzz', 'aaa', 'zzz'))->is("MMM");
        that(str_chop('aaaMMMzzz', 'aaaa', 'zzzz'))->is("aaaMMMzzz");
        that(str_chop(' aaaMMMzzz ', 'aaa', 'zzz'))->is(" aaaMMMzzz ");
        that(str_chop('aaaMMMzzz', 'AAA', 'ZZZ'))->is("aaaMMMzzz");
        that(str_chop('aaaMMMzzz', 'AAA', 'ZZZ', true))->is("MMM");
        that(str_chop("\naaazzz", 'aaa'))->is("\naaazzz");
        that(str_chop("aaazzz\n", '', 'zzz'))->is("aaazzz\n");
        that(str_chop("\naaazzz\n", "\n", "\n"))->is("aaazzz");
        that(str_chop('[#^.\\$]', "[", "]"))->is('#^.\\$');

        that(str_lchop('aaaMMMzzz', 'aaa'))->is("MMMzzz");
        that(str_rchop('aaaMMMzzz', 'zzz'))->is("aaaMMM");
    }

    function test_str_chunk()
    {
        that(str_chunk('abc', 1))->isSame(['a', 'bc']);
        that(str_chunk('abc', 1, 1))->isSame(['a', 'b', 'c']);
        that(str_chunk('abc', 1, 1, 1))->isSame(['a', 'b', 'c', '']);
        that(str_chunk('abc', 1, 1, 1, 1))->isSame(['a', 'b', 'c', '']);

        that(str_chunk('abc'))->isSame(['abc']);
        that(str_chunk('abc', 0))->isSame(['', 'abc']);
        that(str_chunk('abc', 1))->isSame(['a', 'bc']);
        that(str_chunk('abc', 2))->isSame(['ab', 'c']);
        that(str_chunk('abc', 3))->isSame(['abc', '']);
        that(str_chunk('abc', 4))->isSame(['abc', '']);
        that(str_chunk('abc', 9))->isSame(['abc', '']);
    }

    function test_str_common_prefix()
    {
        that(str_common_prefix())->isSame(null);
        that(str_common_prefix('a'))->isSame(null);

        that(str_common_prefix('a', 'ab', 'abc'))->isSame('a');
        that(str_common_prefix('abc', 'ab', 'a'))->isSame('a');
        that(str_common_prefix('ab', 'ab', 'abc'))->isSame('ab');
        that(str_common_prefix('abc', 'ab', 'ab'))->isSame('ab');
        that(str_common_prefix('abc', 'abc', 'abc'))->isSame('abc');
        that(str_common_prefix('abcLxyz', 'abcMxyz', 'abcNxyz'))->isSame('abc');

        that(str_common_prefix('x', 'a', 'ab', 'abc'))->isSame('');
        that(str_common_prefix('', 'a', 'ab', 'abc'))->isSame('');

        that(str_common_prefix('あ', 'あい', 'あいう'))->isSame('あ');
        that(str_common_prefix('あいう', 'あい', 'あ'))->isSame('あ');
        that(str_common_prefix('あい', 'あい', 'あいう'))->isSame('あい');
        that(str_common_prefix('あいう', 'あい', 'あい'))->isSame('あい');
        that(str_common_prefix('あいう', 'あいう', 'あいう'))->isSame('あいう');
        that(str_common_prefix('あいうＸわをん', 'あいうＹわをん', 'あいうＺわをん'))->isSame('あいう');

        that(str_common_prefix('ん', 'あ', 'あい', 'あいう'))->isSame('');
        that(str_common_prefix('', 'あいう', 'あい', 'あ'))->isSame('');
    }

    function test_str_control_apply()
    {
        // BS
        that(str_control_apply("a\bz"))->is("z");
        that(str_control_apply("ab\b\bz"))->is("z");
        that(str_control_apply("a\b\bz"))->is("z");
        that(str_control_apply("\bz"))->is("z");
        that(str_control_apply("aX\bbX\bcXX\b\b"))->is("abc");

        // DEL
        that(str_control_apply("a\dz"))->is("a");
        that(str_control_apply("a\d\dyz"))->is("a");
        that(str_control_apply("a\d\dz"))->is("a");
        that(str_control_apply("a\d"))->is("a");
        that(str_control_apply("a\dXb\dXc\d\dXX"))->is("abc");

        // CR
        that(str_control_apply("bbb\rzzzz"))->is("zzzz");
        that(str_control_apply("\nbbb\rzzzz"))->is("\nzzzz");
        that(str_control_apply("a\nbbb\rzzzz"))->is("a\nzzzz");
        that(str_control_apply("a\nbbb\rcc\rzzzz"))->is("a\nzzzz");

        // misc
        that(str_control_apply("\b"))->is("");
        that(str_control_apply("\d"))->is("");
        that(str_control_apply("\r"))->is("");
        that(str_control_apply(""))->is("");
        that(str_control_apply("a\nb\r"))->is("a\n");
        that(str_control_apply("a\nb\r\bc"))->is("ac");

        $v = fn($v) => $v;
        $consts = [
            '    public const C1 = 1;',
            '    public const C2 = 2;',
        ];
        $properties = [
            '    public $property1 $p1 = 1;',
            '    public $property1 $p2 = 2;',
        ];
        $methods = [
            '    public function method1() {}',
            '    public function method2() {}',
        ];
        $class = str_control_apply(<<<CLASS
        class C
        {
            \r{$v(implode("\n", $consts) ?: "")}
        
            \r{$v($consts ? "" : "\b\b")}{$v(implode("\n", $properties))}
        
            \r{$v($properties ? "" : "\b\b")}{$v(implode("\n", $methods))}
        }
        CLASS,);
        that($class)->is(<<<'CLASS'
        class C
        {
            public const C1 = 1;
            public const C2 = 2;
        
            public $property1 $p1 = 1;
            public $property1 $p2 = 2;
        
            public function method1() {}
            public function method2() {}
        }
        CLASS,);
    }

    function test_str_diff()
    {
        that(str_diff("e\nd\ne\ne\nc", "e\ne\na\ne\nC", ['stringify' => null]))->is([
            ['=', ['e'], ['e'],],
            ['-', [1 => 'd'], 0,],
            ['=', [2 => 'e'], [1 => 'e'],],
            ['+', 2, [2 => 'a'],],
            ['=', [3 => 'e'], [3 => 'e'],],
            ['*', [4 => 'c'], [4 => 'C'],],
        ]);

        that(str_diff("同\n左\n同\n同\n異1\n長い行長い行長い行長い行", "同\n同\n右\n同\n異2\n長い行長い行長い行長い行", ['stringify' => 'split=10,32']))->is(<<<SIDEBYSIDE
            同             | 同
            左             < 
            同             | 同
                           > 右
            同             | 同
            異1            * 異2
            長い行長い行長 | 長い行長い行長
            い行長い行       い行長い行
            SIDEBYSIDE
        );

        that(str_diff(mb_convert_encoding("同\n左\n同\n同\n異1\n長い行長い行長い行長い行", 'SJIS'), mb_convert_encoding("同\n同\n右\n同\n異2\n長い行長い行長い行長い行", 'SJIS'), ['encoding' => 'SJIS', 'stringify' => 'split=10,32']))->is(mb_convert_encoding(<<<SIDEBYSIDE
            同             | 同
            左             < 
            同             | 同
                           > 右
            同             | 同
            異1            * 異2
            長い行長い行長 | 長い行長い行長
            い行長い行       い行長い行
            SIDEBYSIDE, 'SJIS')
        );

        that(str_diff("e\nd\ne\ne\nc\n<b>B</b>", "e\ne\na\ne\nC\n<b>B</b>", ['stringify' => 'html']))->is('e
<del>d</del>
e
<ins>a</ins>
e
<del>c</del>
<ins>C</ins>
&lt;b&gt;B&lt;/b&gt;');

        that(str_diff("
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

        $x = tmpfile();
        $y = "hoge";
        fwrite($x, "\0");

        rewind($x);
        that(str_diff($x, $y, ['allow-binary' => null]))->is(null);

        rewind($x);
        that(self::resolveFunction('str_diff'))($x, $y, ['allow-binary' => false])->wasThrown("binary string");

        $x = tmpfile();
        $y = "\0";
        fwrite($x, "hoge");

        rewind($x);
        that(str_diff($x, $y, ['allow-binary' => null]))->is(null);

        rewind($x);
        that(self::resolveFunction('str_diff'))($x, $y, ['allow-binary' => false])->wasThrown("binary string");
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
            process($diff, array_merge($opt, [$x, $y]), '', $expected);
            if ($key !== false) {
                return implode("\n", array_slice(explode("\n", $expected), 2));
            }
            /** @noinspection PhpExpressionAlwaysNullInspection */
            return $expected;
        };

        $x = __DIR__ . '/files/diff/diff-x.txt';
        $y = __DIR__ . '/files/diff/diff-y.txt';

        $expected = $shell($x, $y, '--unified=999', '--ignore-case', '--suppress-blank-empty', '--nolabel');
        $actual = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999', 'ignore-case' => true]);
        that($actual)->is($expected);

        $expected = $shell($x, $y, '--unified=999', '--ignore-space-change', '--nolabel');
        $actual = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999', 'ignore-space-change' => true]);
        that($actual)->is($expected);

        $expected = $shell($x, $y, '--unified=999', '--ignore-all-space', '--nolabel');
        $actual = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999', 'ignore-all-space' => true]);
        that($actual)->is($expected);

        $expected = $shell($x, $y, '--unified=999', '--nolabel');
        $actual = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=999']);
        that($actual)->is($expected);

        $dataset = [
            [__DIR__ . '/files/diff/diff-same.txt', __DIR__ . '/files/diff/diff-same.txt'],
            [__DIR__ . '/files/diff/diff-empty.txt', __DIR__ . '/files/diff/diff-x.txt'],
            [__DIR__ . '/files/diff/diff-y.txt', __DIR__ . '/files/diff/diff-empty.txt'],
            [__DIR__ . '/files/diff/diff-x.txt', __DIR__ . '/files/diff/diff-y.txt'],
            [__DIR__ . '/files/diff/diff-even-x.txt', __DIR__ . '/files/diff/diff-even-y.txt'],
            [__DIR__ . '/files/diff/diff-even-x.txt', __DIR__ . '/files/diff/diff-odd-y.txt'],
            [__DIR__ . '/files/diff/diff-odd-x.txt', __DIR__ . '/files/diff/diff-odd-y.txt'],
            [__DIR__ . '/files/diff/diff-odd-x.txt', __DIR__ . '/files/diff/diff-even-y.txt'],
            [__DIR__ . '/files/diff/diff-very-x.txt', __DIR__ . '/files/diff/diff-very-y.txt'],
            [__DIR__ . '/files/diff/diff-very-y.txt', __DIR__ . '/files/diff/diff-very-x.txt'],
        ];

        foreach ($dataset as [$x, $y]) {
            $expected = $shell($x, $y, '--normal');
            $actual = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => 'normal']);
            that($actual)->as("$x <=> $y:\nExpected: $expected\nActual: $actual")->is($expected);

            for ($level = 0; $level < 5; $level++) {
                $levelopt = "context=$level";
                $expected = $shell($x, $y, "--$levelopt", '--nolabel');
                $actual = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => $levelopt]);
                that($actual)->as("$x <=> $y, $levelopt:\nExpected: $expected\nActual: $actual")->is($expected);

                $levelopt = "unified=$level";
                $expected = $shell($x, $y, "--$levelopt", '--nolabel');
                $actual = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => $levelopt]);
                that($actual)->as("$x <=> $y: $levelopt:\nExpected: $expected\nActual: $actual")->is($expected);
            }
        }
    }

    function test_str_patch()
    {
        $xstring = <<<S
        a
        b
        c
        x
        y
        z
        S;
        $ystring = <<<S
        a
        c
        y
        z
        S;
        $patch = str_diff($xstring, $ystring, ['stringify' => 'unified=3']);

        // 差分なし
        that(str_patch($xstring, ''))->is($xstring);
        that(str_patch($ystring, '', ['reverse' => true]))->is($ystring);

        // ズレなし
        that(str_patch($xstring, $patch))->is($ystring);
        that(str_patch($ystring, $patch, ['reverse' => true]))->is($xstring);

        // 冒頭のズレ
        $diff = "1\n2\n3\n";
        that(str_patch($diff . $xstring, $patch))->is($diff . $ystring);
        that(str_patch($diff . $ystring, $patch, ['reverse' => true]))->is($diff . $xstring);

        // 末尾のズレ
        $diff = "\n1\n2\n3\n";
        that(str_patch($xstring . $diff, $patch))->is($ystring . $diff);
        that(str_patch($ystring . $diff, $patch, ['reverse' => true]))->is($xstring . $diff);

        // 当たっているならスルー
        that(str_patch($ystring, $patch, ['forward' => true]))->is($ystring);
        that(self::resolveFunction('str_patch'))($ystring, $patch, ['forward' => false])->wasThrown("not found hunk block");

        // ハンク中のズレ（適用不可）
        that(self::resolveFunction('str_patch'))(str_replace('b', 'B', $xstring), $patch)->wasThrown("not found hunk block");
        that(self::resolveFunction('str_patch'))(str_replace('b', 'B', $xstring), $patch, ['forward' => true])->wasThrown("not found hunk block");

        // 不正パッチ
        that(self::resolveFunction('str_patch'))($xstring, 'hoge')->wasThrown("patch is invalid");

        // unified:0
        $xstring = <<<S
        a
        b
        c
        S;
        $ystring = <<<S
        a
        b
        C
        S;
        $patch = str_diff($xstring, $ystring, ['stringify' => 'unified=0']);
        that(str_patch($xstring, $patch))->is($ystring);
        that(str_patch($ystring, $patch, ['reverse' => true]))->is($xstring);
        that(str_patch(substr($xstring, 2), $patch))->is(substr($ystring, 2));
        that(str_patch(substr($ystring, 2), $patch, ['reverse' => true]))->is(substr($xstring, 2));

        // 全行差分
        $xstring = "";
        $ystring = <<<S
        A
        B
        C
        S;
        $patch = str_diff($xstring, $ystring, ['stringify' => 'unified=0']);
        that(str_patch($xstring, $patch))->is($ystring);
        that(str_patch($ystring, $patch, ['reverse' => true]))->is($xstring);

        // UTF8
        $xstring = <<<S
        あいうえおsame
        かきくけこold
        わをんsame
        S;
        $ystring = <<<S
        あいうえおsame
        さしすせそnew
        わをんsame
        S;
        $patch = str_diff($xstring, $ystring, ['stringify' => 'unified=3']);
        that(str_patch($xstring, $patch))->is($ystring);
        that(str_patch($ystring, $patch, ['reverse' => true]))->is($xstring);

        // SJIS
        $xstring = mb_convert_encoding($xstring, 'SJIS');
        $ystring = mb_convert_encoding($ystring, 'SJIS');
        $patch = str_diff($xstring, $ystring, ['encoding' => 'SJIS', 'stringify' => 'unified=3']);
        that(str_patch($xstring, $patch, ['encoding' => 'SJIS']))->is($ystring);
        that(str_patch($ystring, $patch, ['encoding' => 'SJIS', 'reverse' => true]))->is($xstring);

        $dataset = [
            [__DIR__ . '/files/diff/diff-x.txt', __DIR__ . '/files/diff/diff-y.txt'],
            [__DIR__ . '/files/diff/diff-empty.txt', __DIR__ . '/files/diff/diff-x.txt'],
            [__DIR__ . '/files/diff/diff-y.txt', __DIR__ . '/files/diff/diff-empty.txt'],
            [__DIR__ . '/files/diff/diff-x.txt', __DIR__ . '/files/diff/diff-y.txt'],
            [__DIR__ . '/files/diff/diff-even-x.txt', __DIR__ . '/files/diff/diff-even-y.txt'],
            [__DIR__ . '/files/diff/diff-even-x.txt', __DIR__ . '/files/diff/diff-odd-y.txt'],
            [__DIR__ . '/files/diff/diff-odd-x.txt', __DIR__ . '/files/diff/diff-odd-y.txt'],
            [__DIR__ . '/files/diff/diff-odd-x.txt', __DIR__ . '/files/diff/diff-even-y.txt'],
            [__DIR__ . '/files/diff/diff-very-x.txt', __DIR__ . '/files/diff/diff-very-y.txt'],
            [__DIR__ . '/files/diff/diff-very-y.txt', __DIR__ . '/files/diff/diff-very-x.txt'],
        ];

        foreach ($dataset as [$x, $y]) {
            $patchXtoY = str_diff(file_get_contents($x), file_get_contents($y), ['stringify' => 'unified=3']);
            that(str_patch(file_get_contents($x), $patchXtoY))->is(file_get_contents($y));
            that(str_patch(file_get_contents($y), $patchXtoY, ['reverse' => true]))->is(file_get_contents($x));
        }
    }

    function test_str_ellipsis()
    {
        that(str_ellipsis('1234567890', 8, '...', 0))->isSame('...67890');
        that(str_ellipsis('1234567890', 8, '...', 1))->isSame('1...7890');
        that(str_ellipsis('1234567890', 8, '...', 2))->isSame('12...890');
        that(str_ellipsis('1234567890', 8, '...', 3))->isSame('123...90');
        that(str_ellipsis('1234567890', 8, '...', 4))->isSame('1234...0');
        that(str_ellipsis('1234567890', 8, '...', 5))->isSame('12345...');
        that(str_ellipsis('1234567890', 8, '...', 6))->isSame('12345...');
        that(str_ellipsis('1234567890', 8, '...', 7))->isSame('12345...');
        that(str_ellipsis('1234567890', 8, '...', 8))->isSame('12345...');
        that(str_ellipsis('1234567890', 8, '...', 9))->isSame('12345...');
        that(str_ellipsis('1234567890', 8, '...', 10))->isSame('12345...');
        that(str_ellipsis('1234567890', 8, '...', 11))->isSame('12345...');
        that(str_ellipsis('1234567890', 8, '...', -1))->isSame('1234...0');
        that(str_ellipsis('1234567890', 8, '...', -2))->isSame('123...90');
        that(str_ellipsis('1234567890', 8, '...', -3))->isSame('12...890');
        that(str_ellipsis('1234567890', 8, '...', -4))->isSame('1...7890');
        that(str_ellipsis('1234567890', 8, '...', -5))->isSame('...67890');
        that(str_ellipsis('1234567890', 8, '...', -6))->isSame('...67890');
        that(str_ellipsis('1234567890', 8, '...', -7))->isSame('...67890');
        that(str_ellipsis('1234567890', 8, '...', -8))->isSame('...67890');
        that(str_ellipsis('1234567890', 8, '...', -9))->isSame('...67890');
        that(str_ellipsis('1234567890', 8, '...', -10))->isSame('...67890');
        that(str_ellipsis('1234567890', 8, '...', -11))->isSame('...67890');

        that(str_ellipsis('1234567890', 8, '...', null))->isSame('12...890');
        that(str_ellipsis('1234567890', 7, '...', null))->isSame('12...90');

        that(str_ellipsis('１２３４５６７８９０', 8, '・・・', null))->isSame('１２・・・８９０');
        that(str_ellipsis('１２３４５６７８９０', 7, '・・・', null))->isSame('１２・・・９０');

        that(str_ellipsis('1234567890', 1, '...', null))->isSame('...');
        that(str_ellipsis('1234567890', 1000, '...', null))->isSame('1234567890');
    }

    function test_str_embed()
    {
        $string = 'hello, world and "hello", \'world\' and \\"hello, \\\'world';

        // 単純な置換
        that(str_embed($string, [
            'hello' => 'HELLO',
            'world' => 'WORLD',
        ]))->is('HELLO, WORLD and "hello", \'world\' and \\"HELLO, \\\'WORLD');

        // 配列指定
        that(str_embed($string, [
            'hello' => ['hello1', 'hello2'],
            'world' => ['world1', 'world2'],
        ]))->is('hello1, world1 and "hello", \'world\' and \\"hello2, \\\'world2');

        // クロージャ指定
        that(str_embed($string, [
            'hello' => fn($src, $n, $l) => strtoupper($src) . ":$n,$l",
            'world' => fn($src, $n, $l) => strtoupper($src) . ":$n,$l",
            'and'   => fn() => null,
        ]))->is('HELLO:0,0, WORLD:0,1 and "hello", \'world\' and \\"HELLO:1,2, \\\'WORLD:1,3');

        // 隣り合う境界
        that(str_embed('aaaaa', [
            'a' => 'A',
        ]))->is('AAAAA');
        that(str_embed('aaaaa', [
            'a' => ['1', '2', 3, 4, new Concrete(5)],
        ]))->is('12345');
        that(str_embed('aa"a"aa', [
            'a' => ['1', '2', 3, 4],
        ]))->is('12"a"34');

        // 長いものから置換される
        that(str_embed('aaaaa', [
            'aaa' => 'A3',
            'aa'  => 'A2',
        ]))->is('A3A2');
        that(str_embed('aaaaa', [
            'aa'  => 'A2',
            'aaa' => 'A3',
        ]))->is('A3A2');

        // 置換後の文字列は置換対象にならない
        that(str_embed('xyz', [
            'x' => 'xyz',
            'y' => 'YYY',
        ]))->is('xyzYYYz');
        that(str_embed('xyz', [
            'y' => 'YYY',
            'x' => 'xyz',
        ]))->is('xyzYYYz');

        // 空文字
        that(str_embed('xyz', [
            'y' => '',
            'z' => '',
            'x' => 'X',
        ]))->is('X');

        // enclosure 指定
        that(str_embed('x{x}x', [
            'x' => 'X',
            '{' => '[',
            '}' => ']',
        ], ['{' => '}']))->is('X{x}X');
        that(str_embed('x{x}x{{x}}', [
            'x' => 'X',
            '{' => '[',
            '}' => ']',
        ], ['{{' => '}}']))->is('X[X]X{{x}}');

        // 見つからない場合はスルー
        that(str_embed('xyz', [
            'notfound' => 'notfound',
        ]))->is('xyz');

        that(self::resolveFunction('str_embed'))('hoge', ['' => 'empty'])->wasThrown("src length is 0");
        that(self::resolveFunction('str_embed'))('hoge', ['h' => [3 => 'nodef']])->wasThrown("'h' of 0th.");
    }

    function test_str_equals()
    {
        that(str_equals('abcdef', 'abcdef'))->isTrue();
        that(str_equals('abcdef', 'ABCDEF', true))->isTrue();

        // unmatch type
        that(str_equals("123", 123))->isFalse();
        that(str_equals("", null))->isFalse();

        // null byte
        that(str_equals("abc\0def", "abc\0def"))->isTrue();
        that(str_equals("abc\0def", "abc\0xyz"))->isFalse();
        that(str_equals("abc\0def", "abc\0xyz", true))->isFalse();

        // stringable object
        $ex = new \Exception('hoge');
        that(str_equals($ex, $ex))->isTrue();
    }

    function test_str_exists()
    {
        // single
        that(str_exists('abcdef', 'cd'))->isTrue();
        that(str_exists('abcdef', 'xx'))->isFalse();

        // single int
        that(str_exists('12345', 5))->isTrue();
        that(str_exists('12345', 9))->isFalse();

        // empty
        that(str_exists('', ''))->isFalse();
        that(str_exists('abcdef', ''))->isFalse();

        // single case_insensitivity
        that(str_exists('abcdef', 'CD', true))->isTrue();
        that(str_exists('abcdef', 'XX', true))->isFalse();

        // multi or
        that(str_exists('abcdef', ['cd', 'XX'], false, false))->isTrue();
        that(str_exists('abcdef', ['XX', 'YY'], false, false))->isFalse();

        // multi and
        that(str_exists('abcdef', ['cd', 'ef'], false, true))->isTrue();
        that(str_exists('abcdef', ['cd', 'XX'], false, true))->isFalse();

        // multi case_insensitivity
        that(str_exists('abcdef', ['CD', 'XX'], true, false))->isTrue();
        that(str_exists('abcdef', ['XX', 'YY'], true, false))->isFalse();
        that(str_exists('abcdef', ['CD', 'EF'], true, true))->isTrue();
        that(str_exists('abcdef', ['CD', 'XX'], true, true))->isFalse();

        // stringable object
        that(str_exists(new \Concrete('abcdef'), new \Concrete('cd')))->isTrue();
        that(str_exists(new \Concrete('abcdef'), new \Concrete('xx')))->isFalse();
        that(str_exists(new \Concrete('abcdef'), new \Concrete('CD'), true, false))->isTrue();
        that(str_exists(new \Concrete('abcdef'), new \Concrete('XX'), true))->isFalse();
    }

    function test_str_guess()
    {
        $percent = null;
        that(str_guess("12345", [
            "12345",
        ], $percent))->isSame("12345");
        that($percent)->is(100);

        $percent = null;
        that(str_guess("12345", [
            "1",
            "12",
            "123",
            "1234",
        ], $percent))->isSame("1234");
        that($percent)->is(53.77049180327869);

        $percent = null;
        that(str_guess("12345", [
            "x12345x",
            "xx12345xx",
        ], $percent))->isSame("x12345x");
        that($percent)->is(52.69320843091335);

        $percent = null;
        that(str_guess("notfound", [
            "x12345x",
            "xx12345xx",
        ], $percent))->isSame("x12345x");
        that($percent)->is(0);

        $percent = 50;
        that(str_guess("1234", [
            "12",
            "123",
            "1234",
            "12345",
            "123456",
        ], $percent))->isSame(["1234", "12345"]);

        $percent = 100;
        that(str_guess("notfound", [
            "12",
            "123",
            "1234",
            "12345",
            "123456",
        ], $percent))->isSame([]);

        that(self::resolveFunction('str_guess'))('', [])->wasThrown('is empty');
    }

    function test_str_putcsv()
    {
        // シンプル
        that(str_putcsv([1, 2, 3]))->is("1,2,3");
        that(str_putcsv([1, 2, 3], "\t"))->is("1\t2\t3");
        that(str_putcsv([1, ",", 3], ",", '`'))->is("1,`,`,3");
        that(str_putcsv([1, "\t", '@`'], ",", '`', "@"))->is("1,`\t`,`@``");
        // コンプレックス
        that(str_putcsv([[1, 2, 3], [4, 5, 6]]))->is("1,2,3\n4,5,6");
        that(str_putcsv(new \ArrayIterator([[1, 2, 3], [4, 5, 6]])))->is("1,2,3\n4,5,6");
        that(str_putcsv((function () {
            yield [1, 2, 3];
            yield [4, 5, 6];
        })()))->is("1,2,3\n4,5,6");
    }

    function test_str_quote()
    {
        // 全アスキー & マルチバイトを混ぜたもの
        $string = implode('あ', array_map(fn($n) => chr($n), range(0, 127)));

        $encoded = str_quote($string);
        that($encoded)->is(
            "\"\\0あ\\1あ\\2あ\\3あ\\4あ\\5あ\\6あ\\7あ\\10あ\\tあ\\nあ\\vあ\\fあ\\rあ\\16あ\\17あ\\20あ\\21あ\\22あ\\23あ\\24あ\\25あ\\26あ\\27あ\\30あ\\31あ\\32あ\\eあ\\34あ\\35あ\\36あ\\37あ" .
            " あ!あ\\\"あ#あ\\\$あ%あ&あ'あ(あ)あ*あ+あ,あ-あ.あ/" .
            "あ0あ1あ2あ3あ4あ5あ6あ7あ8あ9あ" .
            ":あ;あ<あ=あ>あ?あ@あ" .
            "AあBあCあDあEあFあGあHあIあJあKあLあMあNあOあPあQあRあSあTあUあVあWあXあYあZあ" .
            "[あ\\\\あ]あ^あ_あ`あ" .
            "aあbあcあdあeあfあgあhあiあjあkあlあmあnあoあpあqあrあsあtあuあvあwあxあyあzあ{あ|あ}あ~あ\\177\"");
        // eval すると元に戻る
        that(eval("return $encoded;"))->is($string);

        // heredoc でも同様
        $encoded = str_quote($string, ['heredoc' => 'EOS']);
        that($encoded)->contains("<<<EOS");
        // eval すると元に戻る
        that(eval("return $encoded;"))->is($string);

        // nowdoc はちょっと特殊（タイプ可能文字しか書けない）
        $encoded = str_quote("a\n\tb\r\tc", ['nowdoc' => 'EOS']);
        that($encoded)->contains("<<<'EOS'");
        // eval すると元に戻る
        that(eval("return $encoded;"))->is("a\n\tb\r\tc");

        // 雑多なオプション
        that(str_quote("#a\nb\rc\tz", ['special-character' => ["#" => '\\#']]))->is("\"\#a\\nb\\rc\\tz\"");
        that(str_quote("a\nb\rc\tz", ['escape-character' => ["\t" => 'X']]))->is("\"a\\12b\\15cXz\"");
        that(str_quote("a\nb\rc\tz", ['escape-character' => [], 'control-character' => 'oct']))->is("\"a\\12b\\15c\\11z\"");
        that(str_quote("a\nb\rc\tz", ['escape-character' => [], 'control-character' => 'hex']))->is("\"a\\x0ab\\x0dc\\x09z\"");
        that(str_quote("a\nb\rc\tz", ['escape-character' => [], 'control-character' => 'HEX']))->is("\"a\\x0Ab\\x0Dc\\x09z\"");
    }

    function test_str_submap()
    {
        $string = 'hello, world';

        // empty
        that(str_submap($string, []))->is('hello, world');
        // only 1
        that(str_submap($string, [
            'l' => [
                1 => 'L',
            ],
        ]))->is('helLo, world');
        // multiple
        that(str_submap($string, [
            'l' => [
                1 => 'L',
            ],
            'o' => [
                'o1',
                'o2',
            ],
        ]))->is('helLo1, wo2rld');
        // overlap
        that(str_submap($string, [
            'hello' => 'world',
            'world' => 'WORLD',
        ]))->is('world, WORLD');
        // negative
        that(str_submap($string, [
            'l' => [
                -2 => 'L',
            ],
            'o' => [
                -1 => 'O',
            ],
        ]))->is('helLo, wOrld');
        // notfound
        that(str_submap($string, ['xxx' => 'XXX']))->is('hello, world');
        // case insensitivity
        that(str_submap($string, [
            'HELLO' => 'H',
        ], true))->is('H, world');
        // multibyte
        that(str_submap('へろーわーるど', ['ー' => [1 => '棒']]))->is('へろーわ棒るど');
        // no number
        that(self::resolveFunction('str_submap'))($string, ['w' => ['' => '']])->wasThrown("key must be integer");
        // out od range
        that(self::resolveFunction('str_submap'))($string, ['l' => [3 => 'nodef']])->wasThrown("'l' of 3th.");
        that(self::resolveFunction('str_submap'))($string, ['l' => [-4 => 'nodef']])->wasThrown("'l' of -4th.");
    }

    function test_str_subreplace()
    {
        $string = 'xxxxx';

        // empty
        that(str_subreplace($string, 'x', []))->is('xxxxx');
        // string
        that(str_subreplace($string, 'x', 'X'))->is('Xxxxx');
        // all
        that(str_subreplace($string, 'x', ['X1', 'X2', 'X3', 'X4', 'X5']))->is('X1X2X3X4X5');
        // 3rd
        that(str_subreplace($string, 'x', [2 => 'X3']))->is('xxX3xx');
        // 1st, 4th
        that(str_subreplace($string, 'x', [0 => 'X1', 2 => 'X3']))->is('X1xX3xx');
        that(str_subreplace($string, 'x', [2 => 'X3', 0 => 'X1']))->is('X1xX3xx');
        // overlap
        that(str_subreplace($string, 'x', [0 => 'xxx', 1 => 'Z']))->is('xxxZxxx');
        // negative
        that(str_subreplace($string, 'x', [-1 => 'Z']))->is('xxxxZ');
        that(str_subreplace($string, 'x', [-5 => 'Z']))->is('Zxxxx');
        // notfound
        that(str_subreplace($string, 'z', ['Z']))->is('xxxxx');
        // case insensitivity
        that(str_subreplace($string, 'X', ['i1'], true))->is('i1xxxx');
        that(str_subreplace($string, 'X', [-1 => 'i5'], true))->is('xxxxi5');
        // multibyte
        that(str_subreplace('あああああ', 'あ', [2 => 'か']))->is('ああかああ');
        // no number
        that(self::resolveFunction('str_subreplace'))($string, 'x', ['s' => ''])->wasThrown("key must be integer");
        // out od range
        that(self::resolveFunction('str_subreplace'))($string, 'x', [5 => 'nodef'])->wasThrown("'x' of 5th.");
        that(self::resolveFunction('str_subreplace'))($string, 'x', [-6 => 'nodef'])->wasThrown("'x' of -6th.");
    }

    function test_strcat()
    {
        // 単なる結合演算子の関数版
        that(strcat('a', 'b', 'c'))->is('abc');

        // __toString() も活きるはず（implode してるだけだが念のため）
        $e = new \Exception();
        that(strcat('a', $e, 'z'))->is("a{$e}z");
    }

    function test_strpos_array()
    {
        that(strpos_array('hogera', []))->isSame([]);
        that(strpos_array('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word']))->isSame([
            0    => 11,
            'is' => 2,
            2    => 19,
        ]);

        that(strpos_array('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], -4))->isSame([]);
        that(strpos_array('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], -5))->isSame([
            2 => 19,
        ]);
        that(strpos_array('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], 12))->isSame([
            2 => 19,
        ]);
        that(strpos_array('this is a "special word"', ['special', 'is' => 'is', 'notfound', 'word'], 10))->isSame([
            0 => 11,
            2 => 19,
        ]);
    }

    function test_strpos_closest()
    {
        //          +0123456789A123456789B123456789C123
        //          -321C987654321B987654321A9876543210
        $haystack = 'hello, hello, hello, hello, hello';

        // 正数読み飛ばし
        that(strpos_closest($haystack, 'hello', null, 1))->isSame(0);
        that(strpos_closest($haystack, 'hello', null, 2))->isSame(7);
        that(strpos_closest($haystack, 'hello', null, 3))->isSame(14);
        that(strpos_closest($haystack, 'hello', null, 4))->isSame(21);
        that(strpos_closest($haystack, 'hello', null, 5))->isSame(28);
        that(strpos_closest($haystack, 'hello', null, 6))->isSame(null);

        // 負数読み飛ばし
        that(strpos_closest($haystack, 'hello', null, -1))->isSame(28);
        that(strpos_closest($haystack, 'hello', null, -2))->isSame(21);
        that(strpos_closest($haystack, 'hello', null, -3))->isSame(14);
        that(strpos_closest($haystack, 'hello', null, -4))->isSame(7);
        that(strpos_closest($haystack, 'hello', null, -5))->isSame(0);
        that(strpos_closest($haystack, 'hello', null, -6))->isSame(null);

        // 正数オフセット（右探索）
        that(strpos_closest($haystack, 'hello', 0, 1))->isSame(0);
        that(strpos_closest($haystack, 'hello', 1, 1))->isSame(7);
        that(strpos_closest($haystack, 'hello', 7, 1))->isSame(7);
        that(strpos_closest($haystack, 'hello', 8, 1))->isSame(14);
        that(strpos_closest($haystack, 'hello', 14, 1))->isSame(14);
        that(strpos_closest($haystack, 'hello', 15, 1))->isSame(21);
        that(strpos_closest($haystack, 'hello', 21, 1))->isSame(21);
        that(strpos_closest($haystack, 'hello', 22, 1))->isSame(28);
        that(strpos_closest($haystack, 'hello', 28, 1))->isSame(28);
        that(strpos_closest($haystack, 'hello', 29, 1))->isSame(null);
        that(strpos_closest($haystack, 'hello', 99, 1))->isSame(null);

        // 正数オフセット（左探索）
        that(strpos_closest($haystack, 'hello', 0, -1))->isSame(null);
        that(strpos_closest($haystack, 'hello', 4, -1))->isSame(null);
        that(strpos_closest($haystack, 'hello', 5, -1))->isSame(0);
        that(strpos_closest($haystack, 'hello', 11, -1))->isSame(0);
        that(strpos_closest($haystack, 'hello', 12, -1))->isSame(7);
        that(strpos_closest($haystack, 'hello', 18, -1))->isSame(7);
        that(strpos_closest($haystack, 'hello', 19, -1))->isSame(14);
        that(strpos_closest($haystack, 'hello', 25, -1))->isSame(14);
        that(strpos_closest($haystack, 'hello', 26, -1))->isSame(21);
        that(strpos_closest($haystack, 'hello', 32, -1))->isSame(21);
        that(strpos_closest($haystack, 'hello', 33, -1))->isSame(28);
        that(strpos_closest($haystack, 'hello', 99, -1))->isSame(28);

        // 負数オフセット（右探索）
        that(strpos_closest($haystack, 'hello', -1, 1))->isSame(null);
        that(strpos_closest($haystack, 'hello', -4, 1))->isSame(null);
        that(strpos_closest($haystack, 'hello', -5, 1))->isSame(28);
        that(strpos_closest($haystack, 'hello', -11, 1))->isSame(28);
        that(strpos_closest($haystack, 'hello', -12, 1))->isSame(21);
        that(strpos_closest($haystack, 'hello', -18, 1))->isSame(21);
        that(strpos_closest($haystack, 'hello', -19, 1))->isSame(14);
        that(strpos_closest($haystack, 'hello', -25, 1))->isSame(14);
        that(strpos_closest($haystack, 'hello', -26, 1))->isSame(7);
        that(strpos_closest($haystack, 'hello', -32, 1))->isSame(7);
        that(strpos_closest($haystack, 'hello', -33, 1))->isSame(0);
        that(strpos_closest($haystack, 'hello', -99, 1))->isSame(0);

        // 負数オフセット（左探索）
        that(strpos_closest($haystack, 'hello', null, -1))->isSame(28);
        that(strpos_closest($haystack, 'hello', -2, -1))->isSame(21);
        that(strpos_closest($haystack, 'hello', -7, -1))->isSame(21);
        that(strpos_closest($haystack, 'hello', -8, -1))->isSame(14);
        that(strpos_closest($haystack, 'hello', -9, -1))->isSame(14);
        that(strpos_closest($haystack, 'hello', -15, -1))->isSame(7);
        that(strpos_closest($haystack, 'hello', -16, -1))->isSame(7);
        that(strpos_closest($haystack, 'hello', -22, -1))->isSame(0);
        that(strpos_closest($haystack, 'hello', -23, -1))->isSame(0);
        that(strpos_closest($haystack, 'hello', -29, -1))->isSame(null);
        that(strpos_closest($haystack, 'hello', -99, -1))->isSame(null);
    }

    function test_strpos_escaped()
    {
        $found = null;

        that(strpos_escaped('%%T-T', '%%', 0, '%', $found))->isSame(0);
        that($found)->isSame('%%');
        that(strpos_escaped('%%%T-T', 'T', 0, '%', $found))->isSame(5);
        that($found)->isSame('T');

        that(strpos_escaped('%T-T', 'T', 0, '%', $found))->isSame(3);
        that($found)->isSame('T');
        that(strpos_escaped('%%T-T', 'T', 0, '%', $found))->isSame(2);
        that($found)->isSame('T');

        that(strpos_escaped('%T-T', '%T', 0, '%', $found))->isSame(0);
        that($found)->isSame('%T');
        that(strpos_escaped('T-%T', '%T', 0, '%', $found))->isSame(2);
        that($found)->isSame('%T');
        that(strpos_escaped('%%T-T', '%T', 0, '%', $found))->isSame(null);
        that($found)->isSame(null);

        that(strpos_escaped('%xyz', ['xyz'], 0, '%', $found))->isSame(null);
        that($found)->isSame(null);
        that(strpos_escaped('%xyz', ['%xyz'], 0, '%', $found))->isSame(0);
        that($found)->isSame('%xyz');
        that(strpos_escaped('%%xyz', ['xyz'], 0, '%', $found))->isSame(2);
        that($found)->isSame('xyz');
        that(strpos_escaped('x%yz', ['x%yz'], 0, '%', $found))->isSame(0);
        that($found)->isSame('x%yz');
        that(strpos_escaped('x%%yz', ['x%%yz'], 0, '%', $found))->isSame(0);
        that($found)->isSame('x%%yz');

        that(strpos_escaped('%%xyz', ['xyz'], 0, '%%', $found))->isSame(null);
        that($found)->isSame(null);
        that(strpos_escaped('%%xyz', ['%%xyz'], 0, '%%', $found))->isSame(0);
        that($found)->isSame('%%xyz');
        that(strpos_escaped('%%%%xyz', ['xyz'], 0, '%%', $found))->isSame(4);
        that($found)->isSame('xyz');
        that(strpos_escaped('x%%yz', ['x%%yz'], 0, '%%', $found))->isSame(0);
        that($found)->isSame('x%%yz');
        that(strpos_escaped('x%%%%yz', ['x%%%%yz'], 0, '%%', $found))->isSame(0);
        that($found)->isSame('x%%%%yz');

        that(strpos_escaped('%%g-%g', 'asdf%g', 0, '%', $found))->isSame(4);
        that($found)->isSame('%g');
        that(strpos_escaped('%a-asdf', 'asdf%g', 0, '%', $found))->isSame(3);
        that($found)->isSame('a');
        that(strpos_escaped('%s-sdf', 'asdf%g', 0, '%', $found))->isSame(3);
        that($found)->isSame('s');
        that(strpos_escaped('%d-df', 'asdf%g', 0, '%', $found))->isSame(3);
        that($found)->isSame('d');
        that(strpos_escaped('%f-f', 'asdf%g', 0, '%', $found))->isSame(3);
        that($found)->isSame('f');
        that(strpos_escaped('%-X', 'asdf%g', 0, '%', $found))->isSame(null);
        that($found)->isSame(null);

        that(strpos_escaped('%%T', 'T', 1, '%', $found))->isSame(null);
        that(strpos_escaped('%%T', 'T', 2, '%', $found))->isSame(2);
        that(strpos_escaped('%%T', 'T', 3, '%', $found))->isSame(null);
        that(strpos_escaped('%%%T', '%T', 1, '%', $found))->isSame(null);
        that(strpos_escaped('%%%T', '%T', 2, '%', $found))->isSame(2);
        that(strpos_escaped('%%%T', '%T', 3, '%', $found))->isSame(null);
    }

    function test_strpos_quoted()
    {
        that(strpos_quoted("this is a 'special word' that special word", ['notfound']))->isSame(null);
        that(strpos_quoted('this is a "special word" that special word', 'special'))->isSame(30);
        that(strpos_quoted("this is a 'special word' that special word", 'word'))->isSame(38);
        that(strpos_quoted("this is a \\'special word' that special word", 'word'))->isSame(20);

        that(strpos_quoted('this is a "special word" that special word', 'special', 30))->isSame(30);
        that(strpos_quoted('this is a "special word" that special word', 'special', 31))->isSame(null);

        that(strpos_quoted('this is a "special word" that special word', 'word', -4))->isSame(38);
        that(strpos_quoted('this is a "special word" that special word', 'word', -3))->isSame(null);

        that(strpos_quoted("this is a 'special word' that special word", ['word', 'special']))->isSame(30);
        that(strpos_quoted("this is a 'special word' that special word", ['hoge', 'hoga']))->isSame(null);

        that(strpos_quoted('1:hoge, 2:*hoge*, 3:hoge', 'hoge', 5, '*'))->isSame(20);
        that(strpos_quoted('1:hoge, 2:\\*hoge*, 3:hoge', 'hoge', 5, '*'))->isSame(12);

        that(strpos_quoted('1:hoge, 2:*hoge*, 3:hoge', 'hoge', 5, '', ''))->isSame(11);

        $found = null;
        that(strpos_quoted("this is a 'special word' that special word", ['word', 'special'], 0, "'", "\\", $found))->isSame(30);
        that($found)->is("special");
        that(strpos_quoted("this is a 'special word' that sPecial word", ['word', 'special'], 0, "'", "\\", $found))->isSame(38);
        that($found)->is("word");
        that(strpos_quoted("this is a 'special word' that sPecial wOrd", ['word', 'special'], 0, "'", "\\", $found))->isSame(null);
        that($found)->isNull();
    }

    function test_strposr()
    {
        //          +0123456789A123456789
        //          -987654321A9876543210
        $haystack = 'hello, hello, hello';

        that(strposr($haystack, 'hello', 0))->isSame(false);
        that(strposr($haystack, 'hello', 1))->isSame(false);
        that(strposr($haystack, 'hello', 2))->isSame(false);
        that(strposr($haystack, 'hello', 3))->isSame(false);
        that(strposr($haystack, 'hello', 4))->isSame(false);
        that(strposr($haystack, 'hello', 5))->isSame(0);
        that(strposr($haystack, 'hello', 6))->isSame(0);
        that(strposr($haystack, 'hello', 7))->isSame(0);
        that(strposr($haystack, 'hello', 8))->isSame(0);
        that(strposr($haystack, 'hello', 9))->isSame(0);
        that(strposr($haystack, 'hello', 10))->isSame(0);
        that(strposr($haystack, 'hello', 11))->isSame(0);
        that(strposr($haystack, 'hello', 12))->isSame(7);
        that(strposr($haystack, 'hello', 13))->isSame(7);
        that(strposr($haystack, 'hello', 14))->isSame(7);
        that(strposr($haystack, 'hello', 15))->isSame(7);
        that(strposr($haystack, 'hello', 16))->isSame(7);
        that(strposr($haystack, 'hello', 17))->isSame(7);
        that(strposr($haystack, 'hello', 18))->isSame(7);
        that(strposr($haystack, 'hello', 19))->isSame(14);
        that(self::resolveFunction('strposr'))($haystack, 'hello', 20)->wasThrown('must be contained in argument');

        that(strposr($haystack, 'hello', null))->isSame(14);
        that(strposr($haystack, 'hello', -1))->isSame(7);
        that(strposr($haystack, 'hello', -2))->isSame(7);
        that(strposr($haystack, 'hello', -3))->isSame(7);
        that(strposr($haystack, 'hello', -4))->isSame(7);
        that(strposr($haystack, 'hello', -5))->isSame(7);
        that(strposr($haystack, 'hello', -6))->isSame(7);
        that(strposr($haystack, 'hello', -7))->isSame(7);
        that(strposr($haystack, 'hello', -8))->isSame(0);
        that(strposr($haystack, 'hello', -9))->isSame(0);
        that(strposr($haystack, 'hello', -10))->isSame(0);
        that(strposr($haystack, 'hello', -11))->isSame(0);
        that(strposr($haystack, 'hello', -12))->isSame(0);
        that(strposr($haystack, 'hello', -13))->isSame(0);
        that(strposr($haystack, 'hello', -14))->isSame(0);
        that(strposr($haystack, 'hello', -15))->isSame(false);
        that(strposr($haystack, 'hello', -16))->isSame(false);
        that(strposr($haystack, 'hello', -17))->isSame(false);
        that(strposr($haystack, 'hello', -18))->isSame(false);
        that(strposr($haystack, 'hello', -19))->isSame(false);
        that(self::resolveFunction('strposr'))($haystack, 'hello', -20)->wasThrown('must be contained in argument');
    }

    function test_strrstr()
    {
        that(strrstr('/a/b/c', 'not', true))->isSame(null);
        that(strrstr('/a/b/c', 'not', false))->isSame(null);

        that(strrstr('/a/b/c', '/'))->isSame('c');
        that(strrstr('//a//b//c', '//'))->isSame('c');

        that(strrstr('/a/b/c', '/', true))->isSame('c');
        that(strrstr('//a//b//c', '//', true))->isSame('c');

        that(strrstr('/a/b/c', '/', false))->isSame('/a/b/');
        that(strrstr('//a//b//c', '//', false))->isSame('//a//b//');

        that(strrstr('あ＿＿い＿＿う', '＿＿', true))->isSame('う');
        that(strrstr('あ＿＿い＿＿う', '＿＿', false))->isSame('あ＿＿い＿＿');
    }

    function test_strtr_escaped()
    {
        // 長いキーから順に置換されるし置換後の文字は置換対象にならない
        that(strtr_escaped('XXXX %s %%s %%%%%% %%%%%%%%', [
            's'    => 'S',
            '%s'   => 'S',
            '%%'   => 'P',
            'XXX'  => 'YYY',
            'XXXX' => '%s%s',
        ], '%'))->isSame('%s%s S PS PPP PPPP');

        that(strtr_escaped('XYZ ab %% %s', [
            'ab'  => 'AB',  // 2. 1 で置換された文字は対象にならない
            'A'   => '%a',  // 使われない
            'Z'   => '%z',  // 使われない
            '%%'  => 'p',   // 普通に置換される
            's'   => 'S',   // エスケープが対象なので置換されない（%s は文字 "s" ではない（\n が文字 "n" ではないのと同じ））
            'XYZ' => 'abc', // 1. 後ろにあるがまず置換される
        ], '%'))->isSame('abc AB p %s');
    }
}

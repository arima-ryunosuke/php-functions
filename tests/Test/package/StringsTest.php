<?php
namespace ryunosuke\Test\package;

class StringsTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_strcat()
    {
        // 単なる結合演算子の関数版
        $this->assertEquals('abc', strcat('a', 'b', 'c'));

        // __toString() も活きるはず（implode してるだけだが念のため）
        $e = new \Exception();
        $this->assertEquals("a{$e}z", strcat('a', $e, 'z'));
    }

    function test_split_noempty()
    {
        // 空文字は空配列と規定している
        $this->assertEquals([], split_noempty('hoge', ''));
        $this->assertEquals([], split_noempty(',', ',, ,'));

        // 両サイド
        $this->assertEquals(['a'], split_noempty(',', ' a '));

        // trim しない
        $this->assertEquals([' A', ' ', ' B ', 'C '], split_noempty(',', " A,, , B ,C ", false));

        // trim 文字が与えられる
        $this->assertEquals([' A', 'B '], split_noempty(',', " A,\tB ", "\t"));

        // 結果はただの配列になる
        $this->assertEquals(['A', 'B', 'C'], split_noempty(',', 'A,,B,,,C'));
    }

    function test_str_equals()
    {
        $this->assertTrue(str_equals('abcdef', 'abcdef'));
        $this->assertTrue(str_equals('abcdef', 'ABCDEF', true));

        // unmatch type
        $this->assertFalse(str_equals("123", 123));
        $this->assertFalse(str_equals("", null));

        // null byte
        $this->assertTrue(str_equals("abc\0def", "abc\0def"));
        $this->assertFalse(str_equals("abc\0def", "abc\0xyz"));
        $this->assertFalse(str_equals("abc\0def", "abc\0xyz", true));

        // stringable object
        $ex = new \Exception('hoge');
        $this->assertTrue(str_equals($ex, $ex));
    }

    function test_str_contains()
    {
        // single
        $this->assertTrue(str_contains('abcdef', 'cd'));
        $this->assertFalse(str_contains('abcdef', 'xx'));

        // single int
        $this->assertTrue(str_contains('12345', 5));
        $this->assertFalse(str_contains('12345', 9));

        // empty
        $this->assertFalse(str_contains('', ''));
        $this->assertFalse(str_contains('abcdef', ''));

        // single case_insensitivity
        $this->assertTrue(str_contains('abcdef', 'CD', true));
        $this->assertFalse(str_contains('abcdef', 'XX', true));

        // multi or
        $this->assertTrue(str_contains('abcdef', ['cd', 'XX'], false, false));
        $this->assertFalse(str_contains('abcdef', ['XX', 'YY'], false, false));

        // multi and
        $this->assertTrue(str_contains('abcdef', ['cd', 'ef'], false, true));
        $this->assertFalse(str_contains('abcdef', ['cd', 'XX'], false, true));

        // multi case_insensitivity
        $this->assertTrue(str_contains('abcdef', ['CD', 'XX'], true, false));
        $this->assertFalse(str_contains('abcdef', ['XX', 'YY'], true, false));
        $this->assertTrue(str_contains('abcdef', ['CD', 'EF'], true, true));
        $this->assertFalse(str_contains('abcdef', ['CD', 'XX'], true, true));

        // stringable object
        $this->assertTrue(str_contains(new \Concrete('abcdef'), new \Concrete('cd')));
        $this->assertFalse(str_contains(new \Concrete('abcdef'), new \Concrete('xx')));
        $this->assertTrue(str_contains(new \Concrete('abcdef'), new \Concrete('CD'), true, false));
        $this->assertFalse(str_contains(new \Concrete('abcdef'), new \Concrete('XX'), true));
    }

    function test_str_putcsv()
    {
        $this->assertEquals("1,2,3", str_putcsv([1, 2, 3]));
        $this->assertEquals("1\t2\t3", str_putcsv([1, 2, 3], "\t"));
        $this->assertEquals("1,`,`,3", str_putcsv([1, ",", 3], ",", '`'));
        $this->assertEquals("1,`\t`,`@``", str_putcsv([1, "\t", '@`'], ",", '`', "@"));

        $this->assertException('single character', function () {
            str_putcsv([], 'aa');
        });
    }

    function test_starts_with()
    {
        $this->assertTrue(starts_with('abcdef', 'abc'));
        $this->assertFalse(starts_with('abcdef', 'ABC'));
        $this->assertFalse(starts_with('abcdef', 'xbc'));

        $this->assertTrue(starts_with('abcdef', 'abc', true));
        $this->assertTrue(starts_with('abcdef', 'ABC', true));
        $this->assertFalse(starts_with('abcdef', 'xbc', true));

        $this->assertFalse(starts_with('', 's'));
    }

    function test_ends_with()
    {
        $this->assertTrue(ends_with('abcdef', 'def'));
        $this->assertFalse(ends_with('abcdef', 'DEF'));
        $this->assertFalse(ends_with('abcdef', 'xef'));

        $this->assertTrue(ends_with('abcdef', 'def', true));
        $this->assertTrue(ends_with('abcdef', 'DEF', true));
        $this->assertFalse(ends_with('abcdef', 'xef', true));

        $this->assertFalse(starts_with('', 's'));
    }

    function test_camel_case()
    {
        $this->assertEquals('', camel_case(''));
        $this->assertEquals('thisIsAPen', camel_case('this-is-a-pen', '-'));
        $this->assertEquals('thisIsAPen', camel_case('this_is_a_pen'));
        $this->assertEquals('thisIsAPen', camel_case('_this_is_a_pen_'));
    }

    function test_pascal_case()
    {
        $this->assertEquals('', pascal_case(''));
        $this->assertEquals('ThisIsAPen', pascal_case('this-is-a-pen', '-'));
        $this->assertEquals('ThisIsAPen', pascal_case('this_is_a_pen'));
        $this->assertEquals('ThisIsAPen', pascal_case('_this_is_a_pen_'));
    }

    function test_snake_case()
    {
        $this->assertEquals('', snake_case(''));
        $this->assertEquals('this-is-a-pen', snake_case('ThisIsAPen', '-'));
        $this->assertEquals('this_is_a_pen', snake_case('ThisIsAPen'));
        $this->assertEquals('a_b_c', snake_case('ABC'));
        $this->assertEquals('a_b_c_', snake_case('_ABC_'));
    }

    function test_chain_case()
    {
        $this->assertEquals('', chain_case(''));
        $this->assertEquals('this_is_a_pen', chain_case('ThisIsAPen', '_'));
        $this->assertEquals('this-is-a-pen', chain_case('ThisIsAPen'));
        $this->assertEquals('a-b-c', chain_case('ABC'));
        $this->assertEquals('a-b-c-', chain_case('-ABC-'));
    }

    function test_random_string()
    {
        $actual = random_string(256, 'abc');
        $this->assertEquals(256, strlen($actual)); // 256文字のはず
        $this->assertRegExp('#abc#', $actual); // 大抵の場合含まれるはず（極稀にコケる）

        $this->assertException('positive number', function () {
            random_string(0, 'x');
        });
        $this->assertException('empty', function () {
            random_string(256, '');
        });
    }

    function test_random_string_misc()
    {
        if (!function_exists('uopz_delete') || !function_exists('uopz_function')) {
            return;
        }

        // 一旦全部伏せる
        if (function_exists('random_bytes')) {
            uopz_delete('random_bytes');
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            uopz_delete('openssl_random_pseudo_bytes');
        }
        if (function_exists('mcrypt_create_iv')) {
            uopz_delete('mcrypt_create_iv');
        }

        // 提供関数が存在しない例外
        $this->assertException('enabled function is not exists', function () {
            random_string(256, 'x');
        });

        // random_bytes を定義
        uopz_function('mcrypt_create_iv', function ($length) {
            return str_repeat(chr(60), $length);
        });
        $this->assertEquals('xxxxxxxxxx', random_string(10, 'x'));

        // openssl_random_pseudo_bytes を定義
        uopz_function('openssl_random_pseudo_bytes', function ($length, &$crypto_strong) {
            if ($length === 1) {
                $crypto_strong = false;
            }
            return str_repeat(chr(60), $length);
        });
        $this->assertEquals('xxxxxxxxxx', random_string(10, 'x'));
        $this->assertException('$crypto_strong is false', function () {
            random_string(1, 'x');
        });

        // random_bytes を定義
        uopz_function('random_bytes', function ($length) {
            return str_repeat(chr(60), $length);
        });
        $this->assertEquals('xxxxxxxxxx', random_string(10, 'x'));

        // random_bytes を再定義
        uopz_delete('random_bytes');
        uopz_function('random_bytes', function () {
            return false;
        });
        $this->assertException('bytes length is 0', function () {
            random_string(1, 'x');
        });
    }

    public function test_kvsprintf()
    {
        $args = [
            'int'    => 12345,
            'float'  => 3.141592,
            'string' => 'mojiretu',
        ];

        // 普通の変換
        $result = kvsprintf('int:%int$d float:%float$F string:%string$s', $args);
        $this->assertEquals('int:12345 float:3.141592 string:mojiretu', $result);

        // 文字詰め(シンプル)
        $result = kvsprintf('int:%int$07d float:%float$010F string:%string$10s', $args);
        $this->assertEquals('int:0012345 float:003.141592 string:  mojiretu', $result);

        // 文字詰め(右。dで0埋めは効かない)
        $result = kvsprintf('int:%int$-07d float:%float$-010F string:%string$-10s', $args);
        $this->assertEquals('int:12345   float:3.14159200 string:mojiretu  ', $result);

        // 配列の順番は問わない
        $result = kvsprintf('int:%int$d float:%float$F string:%string$s', array_reverse($args));
        $this->assertEquals('int:12345 float:3.141592 string:mojiretu', $result);

        // 同じキーが出現
        $result = kvsprintf('int:%int$d int:%int$d int:%int$d', $args);
        $this->assertEquals('int:12345 int:12345 int:12345', $result);

        // %エスケープ
        $result = kvsprintf('int:%%int$d float:%%float$F string:%%string$s', $args);
        $this->assertEquals('int:%int$d float:%float$F string:%string$s', $result);

        // 先頭が書式指定子
        $result = kvsprintf('%hoge$d', ['hoge' => 123]);
        $this->assertEquals('123', $result);

        // "%%" の後に書式指定子
        $result = kvsprintf('%%%hoge$d', ['hoge' => 123]);
        $this->assertEquals('%123', $result);

        // キーが他のキーを含む
        $result = kvsprintf('%a$s_%aa$s_%aaa$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        $this->assertEquals('A_AA_AAA', $result);
        $result = kvsprintf('%aaa$s_%aa$s_%a$s', ['a' => 'A', 'aa' => 'AA', 'aaa' => 'AAA']);
        $this->assertEquals('AAA_AA_A', $result);

        // キー自体に%を含む
        $result = kvsprintf('%ho%ge$s', ['ho%ge' => 123]);
        $this->assertEquals('123', $result);

        // 存在しないキーを参照
        $this->assertException(new \OutOfBoundsException('Undefined index'), function () {
            kvsprintf('%aaaaa$d %bbbbb$d', ['hoge' => 123]);
        });
    }

    public function test_preg_capture()
    {
        $this->assertEquals([], preg_capture('#([a-z])([0-9])([A-Z])#', 'a0Z', []));
        $this->assertEquals([1 => 'a'], preg_capture('#([a-z])([0-9])([A-Z])#', 'a0Z', [1 => '']));
        $this->assertEquals([4 => ''], preg_capture('#([a-z])([0-9])([A-Z])#', 'a0Z', [4 => '']));

        $this->assertEquals([], preg_capture('#([a-z])([0-9])([A-Z]?)#', 'a0', []));
        $this->assertEquals([3 => ''], preg_capture('#([a-z])([0-9])([A-Z]?)#', 'a0', [3 => '']));
        $this->assertEquals([3 => 'Z'], preg_capture('#([a-z])([0-9])([A-Z]?)#', 'a0Z', [3 => '']));

        $this->assertEquals([
            'one' => 'a',
            'two' => '0',
            'thr' => 'Z',
        ], preg_capture('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0Z', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]));
        $this->assertEquals([
            'one' => 'a',
            'two' => '0',
            'thr' => 'THR',
        ], preg_capture('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]));
    }

    public function test_render_string()
    {
        // single
        $actual = render_string('int is $int' . "\n" . 'float is $float' . "\n" . 'string is $string', [
            'int'    => 12345,
            'float'  => 3.141592,
            'string' => 'mojiretu',
        ]);
        $this->assertEquals("int is 12345\nfloat is 3.141592\nstring is mojiretu", $actual);

        // double
        $actual = render_string("1\n2\n3{\$val} 4", ['val' => "\n"]);
        $this->assertEquals("1\n2\n3\n 4", $actual);

        // numeric
        $actual = render_string('aaa ${0} ${1} $k $v zzz', ['8', 9, 'k' => 'v', 'v' => 'V']);
        $this->assertEquals("aaa 8 9 v V zzz", $actual);

        // stringable
        $actual = render_string('aaa $val zzz', ['val' => new \Concrete('XXX')]);
        $this->assertEquals("aaa XXX zzz", $actual);

        // closure
        $actual = render_string('aaa $val zzz', ['val' => function () { return 'XXX'; }]);
        $this->assertEquals("aaa XXX zzz", $actual);
        $actual = render_string('aaa $v1 $v2 zzz', ['v1' => 9, 'v2' => function ($vars, $k) { return $vars['v1'] . $k; }]);
        $this->assertEquals("aaa 9 9v2 zzz", $actual);

        // _
        $actual = render_string('aaa {$_(123+456)} zzz', []);
        $this->assertEquals("aaa 579 zzz", $actual);
        $actual = render_string('aaa {$_(implode(\',\', $a))} zzz', ['a' => ['a', 'b', 'c']]);
        $this->assertEquals("aaa a,b,c zzz", $actual);
        $actual = render_string('aaa $_ zzz', ['_' => 'XXX']);
        $this->assertEquals("aaa XXX zzz", $actual);

        // quoting
        $actual = render_string('\'"\\$val', ['val' => '\'"\\']);
        $this->assertEquals('\'"\\\'"\\', $actual);

        // error
        $this->assertException('failed to eval code', function () {
            @render_string('$${}', []);
        });
        $this->assertException('failed to eval code', function () {
            render_string('${$e($ex)}', ['e' => throws, 'ex' => new \ParseError()]);
        });
    }

    public function test_render_file()
    {
        // template.txt でかなりおかしなことをしているのでグローバル空間のテストでしか実行できない
        if (!function_exists('render_string')) {
            return;
        }

        $actual = render_file(__DIR__ . '/Strings/template.txt', [
            'zero',
            'string'  => 'string',
            'closure' => function () { return 'closure'; },
        ]);
        $this->assertEquals("string is string.
closure is closure.
zero is index 0.
123456 is expression.
579 is expression.
a b c is expression.
", $actual);
    }
}

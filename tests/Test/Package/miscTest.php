<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\annotation_parse;
use function ryunosuke\Functions\Package\console_log;
use function ryunosuke\Functions\Package\evaluate;
use function ryunosuke\Functions\Package\function_configure;
use function ryunosuke\Functions\Package\mean;
use function ryunosuke\Functions\Package\namespace_parse;
use function ryunosuke\Functions\Package\namespace_resolve;
use function ryunosuke\Functions\Package\php_highlight;
use function ryunosuke\Functions\Package\php_indent;
use function ryunosuke\Functions\Package\php_opcode;
use function ryunosuke\Functions\Package\php_parse;
use function ryunosuke\Functions\Package\php_strip;
use function ryunosuke\Functions\Package\phpval;
use function ryunosuke\Functions\Package\process;
use function ryunosuke\Functions\Package\process_parallel;
use function ryunosuke\Functions\Package\rm_rf;
use function ryunosuke\Functions\Package\unique_id;
use function ryunosuke\Functions\Package\var_export2;

class miscTest extends AbstractTestCase
{
    function test_annotation_parse()
    {
        that(annotation_parse('aaaaa'))->isEmpty();

        $refmethod = new \ReflectionMethod(require __DIR__ . '/files/php/annotation.php', 'm');

        $actual = annotation_parse($refmethod);
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "single"    => ["123"],
            "closure"   => ["123", "+", "456"],
            "multi"     => ["a", "b", "c"],
            "quote"     => ["\"a b c\"", "123"],
            "noval"     => [
                null,
                null,
            ],
            "hash"      => [
                "a" => 123,
            ],
            "list"      => [123, 456],
            "hashX"     => [
                "a" => 123,
            ],
            "listX"     => [123, 456],
            "block"     => [
                "message" => ["this is message1\n    this is message2"],
            ],
            "blockX"    => [
                "message1" => ["this is message1"],
                "message2" => ["this is message2"],
            ],
            "double"    => [
                ["a"],
                ["b"],
                ["c\n\nthis", "is", "\\@escape"],
            ],
            "DateTime2" => \This\Is\Space\DateTime2::__set_state([
                "date"          => "2019-12-23 00:00:00.000000",
                "timezone_type" => 3,
                "timezone"      => "Asia/Tokyo",
            ]),
            "param"     => [
                ["string", "\$arg1", "引数1"],
                ["array", "\$arg2", "this", "is", "second", "argument"],
            ],
            "return"    => ["null", "返り値\nthis", "is", "\\@escape"],
        ]);

        $actual = annotation_parse($refmethod, [
            'single'  => true,
            'double'  => true,
            'block'   => true,
            'blockX'  => true,
            'closure' => fn($value) => phpval($value),
        ]);
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "single"    => "123",
            "closure"   => 579,
            "multi"     => ["a", "b", "c"],
            "quote"     => ["\"a b c\"", "123"],
            "noval"     => [
                null,
                null,
            ],
            "hash"      => [
                "a" => 123,
            ],
            "list"      => [123, 456],
            "hashX"     => [
                "a" => 123,
            ],
            "listX"     => [123, 456],
            "block"     => [
                "message" => "
    this is message1
    this is message2
",
            ],
            "blockX"    => [
                "message1" => "
    this is message1
",
                "message2" => "
    this is message2
",
            ],
            "double"    => ["a", "b", "c\n\nthis is \\@escape"],
            "DateTime2" => \This\Is\Space\DateTime2::__set_state([
                "date"          => "2019-12-23 00:00:00.000000",
                "timezone_type" => 3,
                "timezone"      => "Asia/Tokyo",
            ]),
            "param"     => [
                ["string", "\$arg1", "引数1"],
                ["array", "\$arg2", "this", "is", "second", "argument"],
            ],
            "return"    => ["null", "返り値\nthis", "is", "\\@escape"],
        ]);

        $actual = annotation_parse(new \ReflectionMethod(\This\Is\Space\DateTime2::class, 'method'), true);
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "message" => 'this is annotation',
        ]);

        $annotation = '
@hoge{a: 123}

@fuga {
    fuga1
    fuga2
}

@piyo dummy {
    piyo1: 1,
    piyo2: 2
}';
        $actual = annotation_parse($annotation);
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "hoge" => ['a' => 123],
            "fuga" => ["fuga1\n    fuga2"],
            "piyo" => [
                "dummy" => [
                    "piyo1" => 1,
                    "piyo2" => 2,
                ],
            ],
        ]);

        $actual = annotation_parse($annotation, true);
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "hoge" => "{a: 123}",
            "fuga" => "
    fuga1
    fuga2
",
            "piyo" => [
                "dummy" => "
    piyo1: 1,
    piyo2: 2
",
            ],
        ]);

        $actual = annotation_parse('
@mix type1{
    hoge1
    hoge2
}
@mix type2 {
    fuga1
    fuga2
}', true);
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "mix" => [
                "type1" => "
    hoge1
    hoge2
",
                "type2" => "
    fuga1
    fuga2
",
            ],
        ]);

        $actual = annotation_parse('
@mix hoge
@mix type {
    fuga1
    fuga2
}');
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "mix" => [
                0      => ["hoge"],
                "type" => ["fuga1\n    fuga2"],
            ],
        ]);

        $actual = annotation_parse('
@mix type{
    hoge1
    hoge2
}
@mix fuga
}');
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "mix" => [
                "type" => ["hoge1\n    hoge2"],
                0      => ["fuga\n}"],
            ],
        ]);

        $actual = annotation_parse('
@hoge This is hoge
@fuga This is fuga1
@fuga This is fuga2
', [
            'hoge' => [],
            'fuga' => null,
        ]);
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "hoge" => [
                ["This", "is", "hoge"],
            ],
            "fuga" => ["This", "is", "fuga2"],
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_console_log()
    {
        $this->expectOutputRegex('#aaa#');
        console_log('aaa');
        echo 'aaa';
        ob_end_flush();
    }

    function test_console_log_ex()
    {
        $this->expectExceptionMessage('header is already sent');
        console_log('aaa');
    }

    function test_evaluate()
    {
        $tmpdir = function_configure('storagedir');
        @rm_rf($tmpdir, false);
        that(evaluate('return $x * $x;', ['x' => 1]))->is(1);
        that(evaluate('return $x * $x;', ['x' => 2]))->is(4);
        that(evaluate('return $x * $x;', ['x' => 3]))->is(9);
        // 短すぎするのでキャッシュはされない
        that(glob("$tmpdir/*.php"))->count(0);

        that(evaluate('
return new class($x)
{
    private $var1;
    private $var2;

    public function method1($arg)
    {
        if ($arg) {
            return true;
        }
        return $arg;
    }

    public function method2($arg)
    {
        if (!$arg) {
            return true;
        }
        return $arg;
    }
};
', ['x' => 3]))->isObject();
        // ある程度長ければキャッシュされる
        that(glob("$tmpdir/*.php"))->count(1);

        that(self::resolveFunction('evaluate'))('
return new class()
{
    private $var1;
    private $var2;

    public function method1($arg)
    {
        if ($arg) {
            return true;
        }
        return $arg;
    }
syntax error
    public function method2($arg)
    {
        if (!$arg) {
            return true;
        }
        return $arg;
    }
};
')->wasThrown(new \ParseError(<<<ERR
        on line 14
        ERR
        ));

        that(self::resolveFunction('evaluate'))('syntax error')->wasThrown(new \ParseError(<<<ERR
        >>> syntax error
        ERR
        ));

        that(self::resolveFunction('evaluate'))(<<<PHP
        // 01
        syntax error // 02
        // 03
        // 04
        // 05
        // 06
        // 07
        // 08
        // 09
        // 10
        // 11
        // 12
        // 13
        PHP
        )->wasThrown(new \ParseError(<<<ERR
        // 01
        >>> syntax error // 02
        // 03
        // 04
        // 05
        // 06
        // 07
        ERR
        ));

        that(self::resolveFunction('evaluate'))(<<<PHP
        // 07
        // 08
        // 09
        // 10
        // 11
        >>> syntax error // 12
        // 13
        PHP
        )->wasThrown(new \ParseError(<<<ERR
        >>> syntax error
        ERR
        ));

        that(self::resolveFunction('evaluate'))(<<<PHP
        // 01
        // 02
        // 03
        // 04
        // 05
        // 06
        syntax error // 07
        // 08
        // 09
        // 10
        // 11
        // 12
        // 13
        PHP
        )->wasThrown(new \ParseError(<<<ERR
        // 02
        // 03
        // 04
        // 05
        // 06
        >>> syntax error // 07
        // 08
        // 09
        // 10
        // 11
        // 12
        ERR
        ));
    }

    function test_namespace_parse()
    {
        $actual = namespace_parse(__DIR__ . '/files/php/namespace-standard.php');
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "vendor\\NS"   => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "Space"       => "Sub\\Space",
                    "nsC"         => "vendor\\NS\\nsC",
                    "nsI"         => "vendor\\NS\\nsI",
                    "nsT"         => "vendor\\NS\\nsT",
                ],
            ],
            "other\\space" => [
                "const"    => [
                    "CONST" => "other\\space\\CONST",
                ],
                "function" => [],
                "alias"    => [],
            ],
        ]);

        $actual = namespace_parse(__DIR__ . '/files/php/namespace-multispace1.php');
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "vendor\\NS1"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS1\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS1\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS1\\nsC",
                    "nsI"         => "vendor\\NS1\\nsI",
                    "nsT"         => "vendor\\NS1\\nsT",
                    "D"           => "Main\\Sub11\\D",
                ],
            ],
            "other\\space" => [
                "const"    => [
                    "CONST1" => "other\\space\\CONST1",
                    "CONST2" => "other\\space\\CONST2",
                ],
                "function" => [],
                "alias"    => [],
            ],
            "vendor\\NS2"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS2\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS2\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS2\\nsC",
                    "nsI"         => "vendor\\NS2\\nsI",
                    "nsT"         => "vendor\\NS2\\nsT",
                    "D"           => "Main\\Sub12\\D",
                ],
            ],
        ]);

        $actual = namespace_parse(__DIR__ . '/files/php/namespace-multispace2.php');
        that($actual)->as('actual:' . var_export2($actual, true))->is([
            "vendor\\NS1"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS1\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS1\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS1\\nsC",
                    "nsI"         => "vendor\\NS1\\nsI",
                    "nsT"         => "vendor\\NS1\\nsT",
                    "D"           => "Main\\Sub21\\D",
                ],
            ],
            "other\\space" => [
                "const"    => [
                    "CONST1" => "other\\space\\CONST1",
                    "CONST2" => "other\\space\\CONST2",
                ],
                "function" => [],
                "alias"    => [],
            ],
            "vendor\\NS2"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS2\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS2\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS2\\nsC",
                    "nsI"         => "vendor\\NS2\\nsI",
                    "nsT"         => "vendor\\NS2\\nsT",
                    "D"           => "Main\\Sub22\\D",
                ],
            ],
        ]);

        $file = self::$TMPDIR . '/rf-parse_namespace.php';
        file_put_contents($file, '<?php namespace hoge;');
        that(namespace_parse($file, ['cache' => false]))->hasKey('hoge');
        file_put_contents($file, '<?php namespace fuga;');
        that(namespace_parse($file, ['cache' => false]))->hasKey('fuga');
    }

    function test_namespace_resolve()
    {
        $standard = __DIR__ . '/files/php/namespace-standard.php';
        $multispace1 = __DIR__ . '/files/php/namespace-multispace1.php';
        $multispace2 = __DIR__ . '/files/php/namespace-multispace2.php';

        that(namespace_resolve('\\Full\\middle\\name', []))->is('\\Full\\middle\\name');
        that(namespace_resolve('Space\\middle\\name', $standard))->is('Sub\\Space\\middle\\name');
        that(namespace_resolve('xC', $standard))->is('Main\\Sub\\C');
        that(namespace_resolve('ArrayObject', $standard))->is('ArrayObject');
        that(namespace_resolve('ArrayObject', $standard, ['function']))->is(null);
        that(namespace_resolve('AC', $standard))->is('array_chunk');
        that(namespace_resolve('AC', $standard, ['const']))->is(null);
        that(namespace_resolve('DS', $standard))->is('DIRECTORY_SEPARATOR');
        that(namespace_resolve('DS', $standard, ['alias']))->is(null);

        that(namespace_resolve('D', $standard))->is(null);
        that(namespace_resolve('D', [$multispace1 => ['vendor\\NS1']]))->is('Main\\Sub11\\D');
        that(namespace_resolve('D', [$multispace1 => ['vendor\\NS2']]))->is('Main\\Sub12\\D');
        that(namespace_resolve('D', [$multispace2 => ['vendor\\NS1']]))->is('Main\\Sub21\\D');
        that(namespace_resolve('D', [$multispace2 => ['vendor\\NS2']]))->is('Main\\Sub22\\D');
    }

    function test_php_highlight()
    {
        $phpcode = '<?php
// this is comment
$var1 = "this is var";
$var2 = "this is embed $var1";
$var3 = function () { return \ArrayObject::class; };
';
        that(php_highlight($phpcode, ['context' => 'plain']))->is($phpcode);
        that(php_highlight($phpcode, ['context' => 'cli']))->stringContains('[34;3m');
        that(php_highlight($phpcode, ['context' => 'html']))->stringContains('<span style');
        that(php_highlight($phpcode))->stringContains('function');

        that(self::resolveFunction('php_highlight'))($phpcode, ['context' => 'hoge'])->wasThrown('is not supported');
    }

    function test_php_indent()
    {
        $phpcode = '
// this is line comment1
// this is line comment1
echo 123;
# this is line comment2
echo 123;
/* this is block comment1 */
echo 123;
/*
 * this is block comment2
 */
echo 123;
/** this is doccomment1 */
/**
 * this is doccomment2
 */
echo 123;
// this is multiline
$multiline = "
1
2
3
";

// empty line below and above

if (true) {
    echo 123; // this is trailing comment
    if (true) {
        /* this is starting comment */echo 123;
    }
}
';
        $phpcode = php_indent($phpcode, [
            'indent'    => 4,
            'trimempty' => false,
        ]);

        that($phpcode)->is('
    // this is line comment1
    // this is line comment1
    echo 123;
    # this is line comment2
    echo 123;
    /* this is block comment1 */
    echo 123;
    /*
     * this is block comment2
     */
    echo 123;
    /** this is doccomment1 */
    /**
     * this is doccomment2
     */
    echo 123;
    // this is multiline
    $multiline = "
1
2
3
";
    
    // empty line below and above
    
    if (true) {
        echo 123; // this is trailing comment
        if (true) {
            /* this is starting comment */echo 123;
        }
    }
    ');

        $phpcode = php_indent($phpcode, "\t\t");

        that($phpcode)->is('
		// this is line comment1
		// this is line comment1
		echo 123;
		# this is line comment2
		echo 123;
		/* this is block comment1 */
		echo 123;
		/*
		 * this is block comment2
		 */
		echo 123;
		/** this is doccomment1 */
		/**
		 * this is doccomment2
		 */
		echo 123;
		// this is multiline
		$multiline = "
1
2
3
";

		// empty line below and above

		if (true) {
		    echo 123; // this is trailing comment
		    if (true) {
		        /* this is starting comment */echo 123;
		    }
		}
		');

        $phpcode = php_indent($phpcode, [
            'indent'    => "",
            'trimempty' => false,
        ]);

        that($phpcode)->is('
// this is line comment1
// this is line comment1
echo 123;
# this is line comment2
echo 123;
/* this is block comment1 */
echo 123;
/*
 * this is block comment2
 */
echo 123;
/** this is doccomment1 */
/**
 * this is doccomment2
 */
echo 123;
// this is multiline
$multiline = "
1
2
3
";

// empty line below and above

if (true) {
    echo 123; // this is trailing comment
    if (true) {
        /* this is starting comment */echo 123;
    }
}
');
    }

    function test_php_indent_heredoc()
    {
        that(php_indent('
$heredoc = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
', [
            'indent'  => '    ',
            'heredoc' => false,
        ]))->is('
    $heredoc = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
    ');
        $phpcode = '
$nowdoc = <<<\'HERE\'
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
$heredoc1 = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
    HERE;
$heredoc2 = <<<HERE
$colA
        {$colB},
        ${colB}

    HERE;
';

        $phpcode = php_indent($phpcode, [
            'indent'  => "    ",
            'heredoc' => true,
        ]);

        that($phpcode)->is('
    $nowdoc = <<<\'HERE\'
        SELECT
            $colA
            {$colB},
            ${colB}
        FROM
            table_name
        WHERE 1
            AND cd = ${substr($id, 2)}
            AND id = ${"id$i"}
    HERE;
    $heredoc1 = <<<HERE
        SELECT
            $colA
            {$colB},
            ${colB}
        FROM
            table_name
        WHERE 1
            AND cd = ${substr($id, 2)}
            AND id = ${"id$i"}
        HERE;
    $heredoc2 = <<<HERE
    $colA
            {$colB},
            ${colB}
    
        HERE;
    ');

        $phpcode = php_indent($phpcode, [
            'indent'  => "",
            'heredoc' => true,
        ]);

        that($phpcode)->is('
$nowdoc = <<<\'HERE\'
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
$heredoc1 = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
    HERE;
$heredoc2 = <<<HERE
$colA
        {$colB},
        ${colB}

    HERE;
');
    }

    function test_php_opcode()
    {
        $opcode = php_opcode('$a=1;$b=2;var_dump($a + $b + $c);');
        that($opcode)->containsAll([
            'ASSIGN',
            'INIT_FCALL',
        ]);
        that($opcode)->notContainsAny([
            'Notice',
            'Undefined',
        ], false);
    }

    function test_php_parse()
    {
        $code = '<?php a(123);';
        $tokens = php_parse($code);
        that($tokens)->is([
            // @formatter:off
            #             ID,           TOKEN,      L, C
            new \PhpToken(T_OPEN_TAG,   '<?php ',   1, 0),
            new \PhpToken(T_STRING,     'a',        1, 6),
            new \PhpToken(ord('('),     '(',        1, 7),
            new \PhpToken(T_LNUMBER,    '123',      1, 8),
            new \PhpToken(ord(')'),     ')',        1, 11),
            new \PhpToken(ord(';'),     ';',        1, 12),
            // @formatter:on
        ]);

        $code = <<<'PHP'
        <?php
        echo `this is backtick`;
        echo `this is $backtick`;
        PHP;

        that(php_parse($code, [
            'backtick' => false,
        ]))->is([
            // @formatter:off
            #             ID,           TOKEN,                  L, C
            new \PhpToken(T_OPEN_TAG,   "<?php\n",              1, 0),
            new \PhpToken(T_ECHO,       "echo",                 2, 6),
            new \PhpToken(T_WHITESPACE, " ",                    2, 10),
            new \PhpToken(ord('`'),     "`this is backtick`",   2, 11),
            new \PhpToken(ord(';'),     ";",                    2, 29),
            new \PhpToken(T_WHITESPACE, "\n",                   2, 30),
            new \PhpToken(T_ECHO,       "echo",                 3, 31),
            new \PhpToken(T_WHITESPACE, " ",                    3, 35),
            new \PhpToken(ord('`'),     "`this is \$backtick`", 3, 36),
            new \PhpToken(ord(';'),     ";",                    3, 55),
            // @formatter:on
        ]);

        $code = '<?php $c = function ($a = null) use ($x) {
    return $a + $x;
};';
        $tokens = php_parse($code, [
            'line' => [2, 2],
        ]);
        that(implode('', array_column($tokens, 'text')))->is('return $a + $x;' . "\n");
        $tokens = php_parse($code, [
            'position' => [43, 62],
        ]);
        that(implode('', array_column($tokens, 'text')))->is('return $a + $x;' . "\n");

        $tokens = php_parse($code);
        that($tokens)->is([
            // @formatter:off
            #             ID,           TOKEN,      L, C
            new \PhpToken(T_OPEN_TAG,   "<?php ",   1, 0),
            new \PhpToken(T_VARIABLE,   "\$c",      1, 6),
            new \PhpToken(T_WHITESPACE, " ",        1, 8),
            new \PhpToken(ord('='),     "=",        1, 9),
            new \PhpToken(T_WHITESPACE, " ",        1, 10),
            new \PhpToken(T_FUNCTION,   "function", 1, 11),
            new \PhpToken(T_WHITESPACE, " ",        1, 19),
            new \PhpToken(ord("("),     "(",        1, 20),
            new \PhpToken(T_VARIABLE,   "\$a",      1, 21),
            new \PhpToken(T_WHITESPACE, " ",        1, 23),
            new \PhpToken(ord('='),     "=",        1, 24),
            new \PhpToken(T_WHITESPACE, " ",        1, 25),
            new \PhpToken(T_STRING,     "null",     1, 26),
            new \PhpToken(ord(')'),     ")",        1, 30),
            new \PhpToken(T_WHITESPACE, " ",        1, 31),
            new \PhpToken(T_USE,        "use",      1, 32),
            new \PhpToken(T_WHITESPACE, " ",        1, 35),
            new \PhpToken(ord('('),     "(",        1, 36),
            new \PhpToken(T_VARIABLE,   "\$x",      1, 37),
            new \PhpToken(ord(')'),     ")",        1, 39),
            new \PhpToken(T_WHITESPACE, " ",        1, 40),
            new \PhpToken(ord('{'),     "{",        1, 41),
            new \PhpToken(T_WHITESPACE, "\n    ",   1, 42),
            new \PhpToken(T_RETURN,     "return",   2, 47),
            new \PhpToken(T_WHITESPACE, " ",        2, 53),
            new \PhpToken(T_VARIABLE,   "\$a",      2, 54),
            new \PhpToken(T_WHITESPACE, " ",        2, 56),
            new \PhpToken(ord('+'),     "+",        2, 57),
            new \PhpToken(T_WHITESPACE, " ",        2, 58),
            new \PhpToken(T_VARIABLE,   "\$x",      2, 59),
            new \PhpToken(ord(';'),     ";",        2, 61),
            new \PhpToken(T_WHITESPACE, "\n",       2, 62),
            new \PhpToken(ord('}'),     "}",        3, 63),
            new \PhpToken(ord(';'),     ";",        3, 64),
            // @formatter:on
        ]);

        $code = '<?php function($a,$b)use($usevar){if(false){return fn()=>[1,2,3];}}';
        $tokens = php_parse($code, [
            'begin' => T_FUNCTION,
            'end'   => ',',
        ]);
        that(implode('', array_column($tokens, 'text')))->is('function($a,$b)use($usevar){if(false){return fn()=>[1,2,3];}}');
        $tokens = php_parse($code, [
            'begin'  => T_FUNCTION,
            'end'    => ')',
            'greedy' => true,
        ]);
        that(implode('', array_column($tokens, 'text')))->is('function($a,$b)use($usevar){if(false){return fn()=>[1,2,3];}}');
        $tokens = php_parse($code, [
            'begin' => T_FUNCTION,
            'end'   => '{',
        ]);
        that(implode('', array_column($tokens, 'text')))->is('function($a,$b)use($usevar){');
        $tokens = php_parse($code, [
            'begin'  => '{',
            'end'    => '}',
            'offset' => count($tokens),
        ]);
        that(implode('', array_column($tokens, 'text')))->is('{if(false){return fn()=>[1,2,3];}}');

        $code = '<?php namespace hoge\\fuga\\piyo;class C {function m(){if(false){return function(){};}}}';
        $tokens = php_parse($code, [
            'begin' => T_NAMESPACE,
            'end'   => ';',
        ]);
        that(implode('', array_column($tokens, 'text')))->is('namespace hoge\fuga\piyo;');
        $tokens = php_parse($code, [
            'begin' => T_CLASS,
            'end'   => '}',
        ]);
        that(implode('', array_column($tokens, 'text')))->is('class C {function m(){if(false){return function(){};}}}');
    }

    function test_php_parse_short_open_tag()
    {
        $providerExpected = function ($code, $short_open_tag) {
            $include = var_export(realpath(__DIR__ . '/../../../include/global.php'), true);
            $export = var_export($code, true);
            $stdin = "<?php include($include);echo serialize(php_parse($export));";
            $stdout = '';
            process(PHP_BINARY, [
                "-d opcache.enable_cli=0",
                "-d short_open_tag=$short_open_tag",
            ], $stdin, $stdout);
            return unserialize($stdout);
        };

        $code = '
a<? echo 123 ?>
plain text
<? foreach ($array as $k => $v): ?>
    <? echo $k ?>
    plain text
    <? echo $v ?>
<? endforeach ?>
<? echo 789;
';

        that(php_parse($code, [
            'short_open_tag' => true,
        ]))->is($providerExpected($code, 1));

        that(php_parse($code, [
            'short_open_tag' => false,
        ]))->is($providerExpected($code, 0));
    }

    function test_php_strip()
    {
        $code = '
a<? echo 123 ?>
plain text
<? foreach ($array as $k => $v): ?>
    <? echo $k ?>
    plain text
    <? echo $v ?> and <?= $v ?>
<? endforeach ?>
<? echo 789;
';

        that(php_strip($code))->is('
aplain text
        plain text
     and ');
        that(php_strip($code, ['replacer' => 'xxx']))->is('
axxx6plain text
xxx5    xxx4    plain text
    xxx3 and xxx2xxx1xxx0');
        that(php_strip($code, ['replacer' => fn($code, $n) => strpos($code, 'foreach') ? 'foreach' : $n . "th"]))->is('
a6thplain text
foreach    4th    plain text
    3th and 2thforeach0th');
        that(php_strip($code, [
            'trailing_break' => false,
        ]))->is('
aplain text
        plain text
     and 
');

        $mapping = [];
        $html = php_strip($code, [], $mapping);
        that(strtr($html, $mapping))->is($code);
    }

    function test_unique_id()
    {
        $now = time();

        // 重複しない
        $ids = [];
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                $ids[] = unique_id();
            }
            usleep(10 * 1000);
        }
        that(count($ids))->is(count(array_unique($ids)));

        // 例え同じ時刻・IPでも7bitまでは重複しない
        $ids = [];
        for ($i = 0; $i < 128; $i++) {
            $ids[] = unique_id($id_info, [
                'timestamp' => $now,
                'ipaddress' => '127.0.0.1',
                'sequence'  => $i === 0 ? 0 : null,
            ]);
        }
        that(count($ids))->is(count(array_unique($ids)));

        // そもそも7bitを超えても sleep が入って timestamp が進むので結局重複しない
        $ids[] = unique_id($id_info, [
            'timestamp' => $now,
            'ipaddress' => '127.0.0.1',
        ]);
        that(count($ids))->is(count(array_unique($ids)));
        that($id_info['timestamp'])->gt($now);
        that($id_info['sequence'])->isSame(0);

        // 同じ時刻・IPなら sequence が進んでいる
        unique_id($id_info, [
            'sequence' => 0,
        ]);
        $ids = [];
        $ids[] = unique_id($id_info1, [
            'timestamp' => $now,
            'ipaddress' => '127.0.0.1',
        ]);
        $ids[] = unique_id($id_info2, [
            'timestamp' => $now,
            'ipaddress' => '127.0.0.1',
        ]);
        that(count($ids))->is(count(array_unique($ids)));
        that($id_info1['sequence'])->isSame($id_info2['sequence'] - 1);

        // 同じ時刻でも異なるIPなら重複しない
        $ids = [];
        unique_id($id_info, [
            'sequence' => 0,
        ]);
        $ids[] = unique_id($id_info1, [
            'timestamp' => $now,
            'ipaddress' => '127.0.0.1',
        ]);
        unique_id($id_info, [
            'sequence' => 0,
        ]);
        $ids[] = unique_id($id_info2, [
            'timestamp' => $now,
            'ipaddress' => '127.0.0.2',
        ]);
        that(count($ids))->is(count(array_unique($ids)));
        that($id_info1['timestamp'])->isSame($id_info2['timestamp']);
        that($id_info1['sequence'])->isSame($id_info2['sequence']);
        that($id_info1['ipsegment'])->isNotSame($id_info2['ipsegment']);

        // 別プロセス
        $now = time();
        $returns = process_parallel(static function ($index) use ($now) {
            time_sleep_until($now + 2);
            $ids = [];
            for ($i = 0; $i < 1000; $i++) {
                $id = unique_id($id_info);
                $id_info['id'] = $id;
                $ids[] = $id_info;
            }
            return $ids;
        }, [0, 1, 2, 3], options: [
            "opcache.enable_cli" => 0,
        ]);

        $results = array_merge(...array_column($returns, 'return'));
        $ids = array_column($results, 'id');
        $tss = array_column($results, 'timestamp');

        // 重複しない
        that(count($ids))->is(4 * 1000);
        that(count($ids))->is(count(array_unique($ids)));

        // 1ミリ秒で1回しか生成してないならテストの意味がない（絶対に重複しない）のでまぁ2回は生成出来ているものとする
        that(mean(array_count_values($tss)))->gt(2);
        // その中でも5回生成があればまぁよしとする
        that(max(array_count_values($tss)))->gt(5);
    }
}

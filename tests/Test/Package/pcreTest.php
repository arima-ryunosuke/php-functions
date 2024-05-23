<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\glob2regex;
use function ryunosuke\Functions\Package\preg_capture;
use function ryunosuke\Functions\Package\preg_matches;
use function ryunosuke\Functions\Package\preg_replaces;
use function ryunosuke\Functions\Package\preg_splice;
use const ryunosuke\Functions\Package\GLOB_RECURSIVE;

class pcreTest extends AbstractTestCase
{
    function test_glob2regex()
    {
        that(glob2regex('\\{hoge\\}*test??[ABC][!XYZ].{jp{e,}g,png}'))->is('\\{hoge\\}.*test..[ABC][^XYZ]\\.\\{jp\\{e,\\}g,png\\}');
        that(glob2regex('\\{hoge\\}*test??[ABC][!XYZ].{jp{e,}g,png}', GLOB_BRACE))->is('\\{hoge\\}.*test..[ABC][^XYZ]\\.(jp(e|)g|png)');
        that(glob2regex('noclose brace{jp{e,\\}g,png', GLOB_BRACE))->is('noclose brace{jp{e,\\}g,png');

        $cases = [
            ['expected' => 0, 'haystack' => 'test.jpg', 'pattern' => 'Atest.jpgZ', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'test.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => '*.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 't*.*jp', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => '*', 'flags' => 0, 'Az' => false],

            ['expected' => 1, 'haystack' => 'test1.jpg', 'pattern' => 'test?.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test2.jpg', 'pattern' => 'test?.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 0, 'haystack' => 'test33.jpg', 'pattern' => 'test?.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test33.jpg', 'pattern' => 'test??.jpg', 'flags' => 0, 'Az' => false],

            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'tes[t].jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'tes[At].jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'tes[tZ].jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 0, 'haystack' => 'test.jpg', 'pattern' => 'tes[AZ].jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'tes[!AZ].jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 0, 'haystack' => 'test.jpg', 'pattern' => 'tes[!AtZ].jpg', 'flags' => 0, 'Az' => false],

            ['expected' => 0, 'haystack' => 'test.jpeg', 'pattern' => 'test.jp{e,}g', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpeg', 'pattern' => 'test.jp{e,}g', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'test.jp{e,}g', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'test{.jpg,.gif,.png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'test.{jpg,gif,png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 0, 'haystack' => 'test.jpg', 'pattern' => 'test.{bmp,gif,png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => '{test.jpg,test.gif,test.png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 0, 'haystack' => 'test.jpg', 'pattern' => '{test.bmp,test.gif,test.png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test11.jpg', 'pattern' => 'test{??.jpg,??.gif,??.png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test11.jpg', 'pattern' => 'test{??.jpg,?.gif,???.png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 0, 'haystack' => 'test11.jpg', 'pattern' => 'test{?.jpg,??.gif,???.png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 1, 'haystack' => 'test.jpg', 'pattern' => 'tes{[At].jpg,[t].gif,[t].png}', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 0, 'haystack' => 'test.jpg', 'pattern' => 'tes{[A].jpg,[t].gif,[t].png}', 'flags' => GLOB_BRACE, 'Az' => false],

            ['expected' => 1, 'haystack' => 'te\\st.jpg', 'pattern' => 'te\\\\st.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'te{}st.jpg', 'pattern' => 'te{}st.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'te\\{\\}st.jpg', 'pattern' => 'te\\\\{\\\\}st.jpg', 'flags' => 0, 'Az' => false],
            ['expected' => 1, 'haystack' => 'te\\{\\}st.jpg', 'pattern' => 'te\\\\\\{\\\\\\}st.jpg', 'flags' => GLOB_BRACE, 'Az' => false],
            ['expected' => 0, 'haystack' => 'te\\{\\}st.jpg', 'pattern' => 'te\\\\{\\\\}st.jpg', 'flags' => GLOB_BRACE, 'Az' => false],

            ['expected' => 1, 'haystack' => '/path/to/test.jpg', 'pattern' => '/*/test.jpg', 'flags' => 0, 'Az' => true],
            ['expected' => 0, 'haystack' => '/path/to/test.jpg', 'pattern' => '/*/test.jpg', 'flags' => GLOB_RECURSIVE, 'Az' => true],
            ['expected' => 1, 'haystack' => '/path/to/test.jpg', 'pattern' => '/**/test.jpg', 'flags' => GLOB_RECURSIVE, 'Az' => true],
            ['expected' => 1, 'haystack' => '/path/to/test.jpg', 'pattern' => '/**.jpg', 'flags' => GLOB_RECURSIVE, 'Az' => true],
            ['expected' => 1, 'haystack' => '/path/to/.test.jpg', 'pattern' => '/**/.test.jpg', 'flags' => GLOB_RECURSIVE, 'Az' => true],
            ['expected' => 1, 'haystack' => '/path/to/dir/', 'pattern' => '/**/dir/', 'flags' => GLOB_RECURSIVE, 'Az' => true],
        ];

        foreach ($cases as $case) {
            $regexp = glob2regex($case['pattern'], $case['flags']);
            if ($case['Az']) {
                $regexp = "\\A$regexp\\z";
            }
            that(preg_match("#$regexp#", $case['haystack']))->as("{$case['pattern']} => $regexp")->is($case['expected']);
        }
    }

    function test_preg_capture()
    {
        that(preg_capture('#([a-z])([0-9])([A-Z])#', 'a0Z', []))->is([]);
        that(preg_capture('#([a-z])([0-9])([A-Z])#', 'a0Z', [1 => '']))->is([1 => 'a']);
        that(preg_capture('#([a-z])([0-9])([A-Z])#', 'a0Z', [4 => '']))->is([4 => '']);

        that(preg_capture('#([a-z])([0-9])([A-Z]?)#', 'a0', []))->is([]);
        that(preg_capture('#([a-z])([0-9])([A-Z]?)#', 'a0', [3 => '']))->is([3 => '']);
        that(preg_capture('#([a-z])([0-9])([A-Z]?)#', 'a0Z', [3 => '']))->is([3 => 'Z']);

        that(preg_capture('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0Z', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]))->is([
            'one' => 'a',
            'two' => '0',
            'thr' => 'Z',
        ]);
        that(preg_capture('#(?<one>[a-z])(?<two>[0-9])(?<thr>[A-Z]?)#', 'a0', [
            'one' => 'ONE',
            'two' => 'TWO',
            'thr' => 'THR',
        ]))->is([
            'one' => 'a',
            'two' => '0',
            'thr' => 'THR',
        ]);
    }

    function test_preg_matches()
    {
        that(preg_matches('#unmatch#', 'HelloWorld'))->isSame([]);
        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#u', 'HelloWorld'))->isSame([
            'letter' => 'H',
            0        => 'ello',
        ]);

        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#u', 'HelloWorld', PREG_OFFSET_CAPTURE))->isSame([
            'letter' => ['H', 0],
            0        => ['ello', 1],
        ]);
        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#u', 'HelloWorld', PREG_OFFSET_CAPTURE, 5))->isSame([
            'letter' => ['W', 5],
            0        => ['orld', 6],
        ]);

        that(preg_matches('#unmatch#g', 'HelloWorld', PREG_PATTERN_ORDER))->isSame([]);
        that(preg_matches('#unmatch#g', 'HelloWorld', PREG_SET_ORDER))->isSame([]);
        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_PATTERN_ORDER))->isSame([
            'letter' => ['H', 'W'],
            0        => ['ello', 'orld'],
        ]);
        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_SET_ORDER))->isSame([
            [
                'letter' => 'H',
                0        => 'ello',
            ],
            [
                'letter' => 'W',
                0        => 'orld',
            ],
        ]);
        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_PATTERN_ORDER | PREG_OFFSET_CAPTURE))->isSame([
            'letter' => [['H', 0], ['W', 5]],
            0        => [['ello', 1], ['orld', 6]],
        ]);
        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_SET_ORDER | PREG_OFFSET_CAPTURE))->isSame([
            [
                'letter' => ['H', 0],
                0        => ['ello', 1],
            ],
            [
                'letter' => ['W', 5],
                0        => ['orld', 6],
            ],
        ]);
        that(preg_matches('#(?<letter>[A-Z])([a-z]+)#ug', 'HelloWorld', PREG_SET_ORDER | PREG_OFFSET_CAPTURE, 5))->isSame([
            [
                'letter' => ['W', 5],
                0        => ['orld', 6],
            ],
        ]);

        that(preg_matches('#(?<letter>[A-Z])([a-z])(?<second>[a-z])([a-z])(?<rest>[a-z]+)#ug', 'HelloUnitTestingWorld', PREG_PATTERN_ORDER))->isSame([
            'letter' => ['H', 'T', 'W'],
            0        => ['e', 'e', 'o',],
            'second' => ['l', 's', 'r',],
            1        => ['l', 't', 'l',],
            'rest'   => ['o', 'ing', 'd',],
        ]);
        that(preg_matches('#(?<letter>[A-Z])([a-z])(?<second>[a-z])([a-z])(?<rest>[a-z]+)#ug', 'HelloUnitTestingWorld', PREG_SET_ORDER))->isSame([
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

    function test_preg_replaces()
    {
        // simple
        that(preg_replaces('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz'))->is('aaa99999zzz, aaa99999zzz');
        that(preg_replaces('#aaa(\d\d\d),(\d\d\d)zzz#', [1 => 99, 2 => 999], 'aaa123,456zzz'))->is('aaa99,999zzz');

        // named
        that(preg_replaces('#aaa(?<digit>\d\d\d)zzz#', ['digit' => 99999], 'aaa123zzz, aaa456zzz'))->is('aaa99999zzz, aaa99999zzz');

        // multibyte
        that(preg_replaces('#い(x)う#u', '|', 'あxいxうxえxお'))->is('あxい|うxえxお');

        // limit, count
        $count = 0;
        that(preg_replaces('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz', 1, $count))->is('aaa99999zzz, aaa456zzz');
        that($count)->is(1);
        that(preg_replaces('#aaa(\d\d\d)zzz#', [1 => 99999], 'aaa123zzz, aaa456zzz', 9, $count))->is('aaa99999zzz, aaa99999zzz');
        that($count)->is(2);

        // misc
        that(preg_replaces('#aaa(\d\d\d)zzz#', 99999, 'aaa123zzz'))->is('aaa99999zzz');
        that(preg_replaces('#aaa(\d\d\d)zzz#', fn($v) => $v * 2, 'aaa123zzz'))->is('aaa246zzz');
    }

    function test_preg_splice()
    {
        $m = [];
        that(preg_splice('#\d+#', '', 'abc123', $m))->is("abc");
        that($m)->is(['123']);
        that(preg_splice('#\d+#', '', 'abc123xyz789', $m, 1))->is("abcxyz789");
        that($m)->is(['123']);
        that(preg_splice('#([a-z]+)#', fn($m) => strtoupper($m[1]), 'abc123', $m))->is("ABC123");
        that($m)->is(['abc', 'abc']);
        that(preg_splice('#[a-z]+#', 'strtoupper', 'abc123', $m))->is('strtoupper123');
        that($m)->is(['abc']);
    }
}

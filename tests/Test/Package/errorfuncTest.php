<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\add_error_handler;
use function ryunosuke\Functions\Package\backtrace;
use function ryunosuke\Functions\Package\error;
use function ryunosuke\Functions\Package\phpval;
use function ryunosuke\Functions\Package\reflect_callable;
use function ryunosuke\Functions\Package\stacktrace;
use function ryunosuke\Functions\Package\stdclass;
use function ryunosuke\Functions\Package\str_exists;
use function ryunosuke\Functions\Package\tmpname;

class errorfuncTest extends AbstractTestCase
{
    function test_add_error_handler()
    {
        $handler1 = function ($errno) use (&$receiver) {
            if ($errno === E_WARNING || $errno === E_USER_WARNING) {
                return false;
            }
            $receiver = 'handler1';
        };
        $handler2 = function ($errno) use (&$receiver) {
            if (!(error_reporting() & $errno)) {
                return false;
            }
            $receiver = 'handler2';
        };
        $phpunit = add_error_handler($handler1);
        $current = add_error_handler($handler2);

        // 返り値は直前に設定していたもの
        that($phpunit)->isInstanceOf(\PHPUnit\Util\ErrorHandler::class);
        that($current)->is($handler1);

        // @ をつけなければ handler2 が呼ばれる（receiver = handler2）
        $receiver = null;
        trigger_error('', E_USER_NOTICE);
        that($receiver)->is('handler2');

        // @ をつけると handler1 に移譲される（receiver = handler1）
        $receiver = null;
        @trigger_error('', E_USER_NOTICE);
        that($receiver)->is('handler1');

        // さらに WARNING ならその前（phpunit のハンドラ）に移譲される（receiver が設定されない）
        $receiver = null;
        @trigger_error('', E_USER_WARNING);
        that($receiver)->is(null);

        restore_error_handler();
        restore_error_handler();
    }

    function test_backtrace()
    {
        $mock = new class() {
            function m1($options) { return backtrace(0, $options); }

            function m2($options) { return $this->m1($options); }

            function m3($options) { return $this->m2($options); }
        };

        $traces = $mock->m3([
            'function' => 'm2',
        ]);
        that($traces[0])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ]);
        that($traces[1])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ]);

        $traces = $mock->m3([
            'class' => fn($v) => str_exists($v, 'class@anonymous'),
        ]);
        that($traces[0])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm1',
            'class'    => get_class($mock),
        ]);
        that($traces[1])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ]);
        that($traces[2])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ]);

        $traces = $mock->m3([
            'class' => 'not found',
        ]);
        that($traces)->count(0);

        $traces = $mock->m3([
            'hoge' => 'not found',
        ]);
        that($traces)->count(0);

        $traces = $mock->m3([
            'file'   => __FILE__,
            'offset' => 1,
            'limit'  => 3,
        ]);
        that($traces)->count(3);
        that($traces[0])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm1',
            'class'    => get_class($mock),
        ]);
        that($traces[1])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ]);
        that($traces[2])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ]);
    }

    function test_error()
    {
        ini_set('error_log', 'syslog');
        error('message1');
        ini_restore('error_log');

        $t = tmpfile();
        error('message2', $t);
        rewind($t);
        $contents = stream_get_contents($t);
        that($contents)->stringContains('PHP Log:  message2');
        that($contents)->stringContains(__FILE__);

        $t = tmpname();
        error('message3', $t);
        $contents = file_get_contents($t);
        that($contents)->stringContains('PHP Log:  message3');
        that($contents)->stringContains(__FILE__);

        $persistences = reflect_callable(self::resolveFunction('error'))->getStaticVariables()['persistences'];
        that($persistences)->count(1)
            ->arrayHasKey($t)
        [$t]->isResource();

        that(self::resolveFunction('error'))('int', 1)->wasThrown('must be resource or string');
    }

    function test_stacktrace()
    {
        function test_stacktrace_in()
        {
            return stacktrace();
        }

        function test_stacktrace($that)
        {
            $that->that = $that;
            $c = fn($that) => phpval('\\ryunosuke\\Test\\Package\\test_stacktrace_in()');
            return $c($that);
        }

        $mock = new class() {
            static function sm($that) { return test_stacktrace($that); }

            function im() { return $this::sm($this); }
        };

        // stack
        $traces = explode("\n", $mock->im());
        that($traces[0])->stringContains('test_stacktrace_in');
        that($traces[1])->stringContains('eval');
        that($traces[2])->stringContains('{closure}');
        that($traces[3])->stringContains('evaluate');
        that($traces[4])->stringContains('phpval');
        that($traces[5])->stringContains('{closure}');
        that($traces[6])->stringContains('test_stacktrace');
        that($traces[7])->stringContains('::sm');
        that($traces[8])->stringContains('->im');

        // limit
        $traces = stacktrace([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    123456789,
                    'stringarg',
                    'long string long string long string',
                    stdclass(['name' => "fields"]),
                    ['a', 'b', 'c'],
                    ['a' => 'A', 'b' => 'B', 'c' => 'C'],
                    ['n' => ['e' => ['s' => ['t' => 'X']]]],
                    ['la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la'],
                ],
            ],
        ]);
        that($traces)->stringContains('123456789')
            ->stringContains('stringarg')
            ->stringContains('long string long...(more 19 length)')
            ->stringContains('stdClass{name:"fields"}')
            ->stringContains('["a", "b", "c"]')
            ->stringContains('{a:"A", b:"B", c:"C"}')
            ->stringContains('{n:{e:{s:{t:"X"}}}}')
            ->stringContains('["la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", ...(more 1 length)');

        // limit (specify)
        $traces = stacktrace([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    'abc',
                    ['a', 'b', 'c'],
                ],
            ],
        ], 2);
        that($traces)->is('hoge:1 func("ab...(more 1 length)", ["a", "b", ...(more 1 length)])');

        // format
        $traces = stacktrace([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
            ],
        ], '%s');
        that($traces)->is('hoge');

        // args
        $traces = stacktrace([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    'abc',
                    ['a', 'b', 'c'],
                ],
            ],
        ], ['args' => false]);
        that($traces)->is('hoge:1 func()');

        // delimiter
        $traces = stacktrace([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    'abc',
                    ['a', 'b', 'c'],
                ],
            ],
        ], ['delimiter' => null]);
        that($traces)->is(['hoge:1 func("abc", ["a", "b", "c"])']);

        /** @noinspection PhpUnusedParameterInspection */
        function test_stacktrace_mask($password, $array, $config)
        {
            return stacktrace();
        }

        $class = new class() {
            static function sm($password, $array, $config)
            {
                return test_stacktrace_mask($password, $array, $config);
            }

            function im($password, $array, $config)
            {
                return self::sm($password, $array, $config);
            }
        };

        // mask
        $actual = $class->im('XXX', ['secret' => 'XXX'], (object) ['credit' => 'XXX']);
        // XXX は塗りつぶされるので決して出現しない
        that($actual)->stringNotContains('XXX');
        // im, sm, test_stacktrace_mask の3回呼び出してるので計9個塗りつぶされる
        that(substr_count($actual, '***'))->is(9);
    }
}

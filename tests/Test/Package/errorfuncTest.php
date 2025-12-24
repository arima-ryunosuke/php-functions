<?php

namespace ryunosuke\Test\Package;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerTrait;
use function ryunosuke\Functions\Package\add_error_handler;
use function ryunosuke\Functions\Package\backtrace;
use function ryunosuke\Functions\Package\error;
use function ryunosuke\Functions\Package\process_parallel;
use function ryunosuke\Functions\Package\reflect_callable;
use function ryunosuke\Functions\Package\set_all_error_handler;
use function ryunosuke\Functions\Package\set_error_exception_handler;
use function ryunosuke\Functions\Package\set_trace_logger;
use function ryunosuke\Functions\Package\stacktrace;
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

    function test_set_all_error_handler()
    {
        $log = [];
        $restrer1 = set_all_error_handler(function ($t) use (&$log) {
            $log[] = 'l1 ' . $t->getMessage();
            return false;
        }, false);
        $restrer2 = set_all_error_handler(function ($t) use (&$log) {
            $log[] = 'l2 ' . $t->getMessage();
            return true;
        }, true);

        echo []['undefined-key'];

        $restrer2();
        $restrer1();

        that($log)->is([
            'l2 Undefined array key "undefined-key"',
            'l1 Undefined array key "undefined-key"',
        ]);

        $result = process_parallel([
            'warning:false'   => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t->getMessage());
                    return false;
                });

                return []['undefined'];
            },
            'warning:true'    => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t->getMessage());
                    return true;
                });

                return []['undefined-key'];
            },
            'error:false'     => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t->getMessage());
                    return false;
                });

                return 'undefined-function'();
            },
            'error:true'      => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t->getMessage());
                    return true;
                });

                return 'undefined-function'();
            },
            'exception:false' => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t);
                    return false;
                });

                throw new \Exception('exception');
            },
            'exception:true'  => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t);
                    return true;
                });

                throw new \Exception('exception');
            },
            'fatal:compile'   => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t->getMessage());
                });

                eval('function dummy_function(){}');
                eval('function dummy_function(){}');
            },
            'fatal:memory'    => static function () {
                set_all_error_handler(function (\Throwable $t) {
                    fwrite(STDOUT, $t->getMessage());
                });

                return str_repeat('x', 1024 * 1024 * 32);
            },
        ], options: [
            'ini' => [
                'display_errors' => 'stderr',
                'log_errors'     => 'off',
                'memory_limit'   => '16M',
            ],
        ]);

        that($result['warning:false']['stdout'])->contains('Undefined array key');
        that($result['warning:false']['stderr'])->isEmpty();

        that($result['warning:true']['stdout'])->contains('Undefined array key');
        that($result['warning:true']['stderr'])->contains('Warning:');

        that($result['error:false']['stdout'])->contains('Call to undefined function');
        that($result['error:false']['stderr'])->isEmpty();

        that($result['error:true']['stdout'])->contains('Call to undefined function');
        that($result['error:true']['stderr'])->contains('Call to undefined function');

        that($result['exception:false']['stdout'])->contains('exception');
        that($result['exception:false']['stderr'])->isEmpty();

        that($result['exception:true']['stdout'])->contains('exception');
        that($result['exception:true']['stderr'])->contains('Fatal error: Uncaught Exception');

        that($result['fatal:compile']['stdout'])->contains('Cannot redeclare');
        that($result['fatal:compile']['stderr'])->contains('Fatal error: Cannot redeclare');

        that($result['fatal:memory']['stdout'])->contains('Allowed memory size');
        that($result['fatal:memory']['stderr'])->contains('Fatal error: Allowed memory size');
    }

    function test_set_error_exception_handler()
    {
        $restore = set_error_exception_handler();

        // ErrorException になる
        try {
            $array = [];
            $array['dummy'] = $array['undefined'];
        }
        catch (\Throwable $t) {
            that($t)->isInstanceOf(\ErrorException::class);
        }

        // @付きは呼ばれない
        try {
            $array = [];
            $array['dummy'] = @$array['undefined'];
        }
        catch (\Throwable $t) {
            $this->fail($t);
        }

        unset($restore);
    }

    function test_set_trace_logger()
    {
        $_SERVER['UNIQUE_ID'] = 'thisisid';

        $loader = set_trace_logger(new class($logs) extends AbstractLogger {
            use LoggerTrait;

            private array $logs;

            public function __construct(&$logs)
            {
                $logs ??= [];
                $this->logs = &$logs;
            }

            public function log($level, $message, array $context = []): void
            {
                $this->logs[] = $context;
            }
        }, "#TraceTarget#");

        \ryunosuke\Test\Package\files\errorfunc\TraceTarget::run(['a' => ['b' => ['c' => 'Z']]], $s = new \stdClass(), 123, "string");

        spl_autoload_unregister($loader);

        that(array_column($logs, 'id'))->is(['thisisid', 'thisisid', 'thisisid']);
        that(array_column($logs, 'method'))->is(['run', '__construct', 'initialize']);
        that(array_column($logs, 'args'))->is([
            [['a' => ['b' => ['c' => 'Z']]], $s, 123, "string"],
            [[['a' => ['b' => ['c' => 'Z']]], $s, 123, "string"]],
            ['before'],
        ]);
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
            $c = fn($that) => eval('return \\ryunosuke\\Test\\Package\\test_stacktrace_in();');
            return $c($that);
        }

        $mock = new class() {
            public $that;

            static function sm($that) { return test_stacktrace($that); }

            function im() { return $this::sm($this); }
        };

        // stack
        $traces = explode("\n", $mock->im());
        that($traces[0])->stringContains('test_stacktrace_in');
        that($traces[1])->stringContains('eval');
        that($traces[2])->stringContains('{closure}');
        that($traces[3])->stringContains('test_stacktrace');
        that($traces[4])->stringContains('::sm');
        that($traces[5])->stringContains('->im');

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
                    (object) ['name' => "fields"],
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

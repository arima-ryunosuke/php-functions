<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../dataformat/markdown_table.php';
require_once __DIR__ . '/../errorfunc/set_error_exception_handler.php';
require_once __DIR__ . '/../info/cpu_timer.php';
require_once __DIR__ . '/../info/ini_sets.php';
require_once __DIR__ . '/../info/is_ansi.php';
require_once __DIR__ . '/../misc/evaluate.php';
require_once __DIR__ . '/../var/var_export3.php';
require_once __DIR__ . '/../var/var_pretty.php';
// @codeCoverageIgnoreEnd

/**
 * 簡易ベンチマークを取る
 *
 * 「指定ミリ秒内で何回コールできるか？」でベンチする。
 * メモリ使用量も取れるが ticks を利用しているのであまり正確ではないし、モノによっては計測できない（バージョンアップで memory_reset_peak_usage に変更される）。
 *
 * $suite は ['表示名' => $callable] 形式の配列。
 * 表示名が与えられていない場合、それらしい名前で表示する。
 *
 * Example:
 * ```php
 * // intval と int キャストはどちらが早いか調べる
 * benchmark([
 *     'intval',
 *     'intcast' => fn($v) => (int) $v,
 * ], ['12345'], 10);
 * ```
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param array|callable $suite ベンチ対象処理
 * @param array $args 各ケースに与えられる引数
 * @param int $millisec 呼び出しミリ秒
 * @param bool $output true だと標準出力に出力される
 * @return array ベンチ結果の配列
 */
function benchmark($suite, $args = [], $millisec = 1000, $output = true)
{
    $benchset = [];
    foreach (arrayize($suite) as $name => $caller) {
        if (!is_callable($caller, false, $callname)) {
            throw new \InvalidArgumentException('caller is not callable.');
        }

        if (is_int($name)) {
            // クロージャは "Closure::__invoke" になるので "ファイル#開始行-終了行" にする
            if ($caller instanceof \Closure) {
                $ref = new \ReflectionFunction($caller);
                $callname = $ref->getFileName() . '#' . $ref->getStartLine() . '-' . $ref->getEndLine();
            }
            $name = $callname;
        }

        if (isset($benchset[$name])) {
            throw new \InvalidArgumentException('duplicated benchname.');
        }

        $closure = \Closure::fromCallable($caller);
        if (!function_exists('memory_reset_peak_usage')) {
            // for compatible (wait for memory_reset_peak_usage)
            try {
                // いったん受けて返すことで tick を誘発する
                // @codeCoverageIgnoreStart
                $caller = function (&...$args) use ($caller) {
                    $dummy = $caller(...$args);
                    return $dummy;
                };
                // @codeCoverageIgnoreEnd
                $closure = evaluate("declare(ticks=1);\n" . var_export3($caller, ['outmode' => 'eval']));
            }
            catch (\Throwable) { // @codeCoverageIgnore
                // do nothing
            }
        }
        $benchset[$name] = $closure;
    }

    if (!$benchset) {
        throw new \InvalidArgumentException('benchset is empty.');
    }

    // opcache を利用するようなベンチはこの辺を切っておかないと正確な結果にならない
    // ウォームアップで mtime が更新され、その1秒以内にベンチが走るので一切 opcache が効かなくなるため
    $restore = ini_sets([
        'opcache.validate_timestamps'    => 0,
        'opcache.file_update_protection' => "0",
    ]);

    // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
    $handler_restore = set_error_exception_handler();
    $assertions = [];
    foreach ($benchset as $name => $caller) {
        $args2 = $args;
        $assertions[$name] = $caller(...$args2);
    }
    $handler_restore();

    // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
    // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
    $context = is_ansi(STDOUT) ? 'cli' : 'plain';
    $diffs = [];
    foreach ($assertions as $name => $return) {
        $diffs[var_pretty($return, [
            'context'   => $context,
            'limit'     => 1024,
            'maxcolumn' => 80,
            'return'    => true,
        ])][] = $name;
    }
    if (count($diffs) > 1) {
        $head = $body = [];
        foreach ($diffs as $return => $names) {
            $head[] = count($names) === 1 ? $names[0] : '(' . implode(' | ', $names) . ')';
            $body[implode(" & ", $names)] = $return;
        }
        trigger_error(sprintf("Results of %s are different.\n", implode(' & ', $head)));
        if (error_reporting() & E_USER_NOTICE) {
            // @codeCoverageIgnoreStart
            echo markdown_table([$body], [
                'context' => $context,
            ]);
            // @codeCoverageIgnoreEnd
        }
    }

    // ベンチ
    $cpu_timer = cpu_timer();
    // for compatible (wait for memory_reset_peak_usage)
    $memory_measurer = new class() {
        private int $peak;
        private int $initial;

        public function __invoke()
        {
            $this->peak = max($this->peak ?? 0, memory_get_usage());
        }

        public function start()
        {
            register_tick_function($this);
            gc_collect_cycles();
            if (function_exists('memory_reset_peak_usage')) {
                memory_reset_peak_usage(); // @codeCoverageIgnore
            }
            unset($this->peak);
            $this->initial = memory_get_usage();
        }

        public function result(): ?int
        {
            unregister_tick_function($this);
            if (function_exists('memory_reset_peak_usage')) {
                return memory_get_peak_usage() - $this->initial; // @codeCoverageIgnore
            }
            if (!isset($this->peak)) {
                return null; // @codeCoverageIgnore コード次第では tick されない場合がある
            }
            return $this->peak - $this->initial;
        }
    };
    $stats = [];
    foreach ($benchset as $name => $caller) {
        $cpu_timer->start();
        $memory_measurer->start();
        $microtime = microtime(true);
        $end = $microtime + $millisec / 1000;
        $args2 = $args;
        for ($n = 0; ($t = microtime(true)) <= $end; $n++) {
            $caller(...$args2);
            $elapsed = microtime(true) - $t;
            $stats[$name]['fastest'] = min($stats[$name]['fastest'] ?? PHP_FLOAT_MAX, $elapsed);
            $stats[$name]['slowest'] = max($stats[$name]['slowest'] ?? PHP_FLOAT_MIN, $elapsed);
        }
        $stats[$name]['count'] = $n;
        $stats[$name]['mills'] = (microtime(true) - $microtime) / $n;
        $stats[$name]['cpu'] = $cpu_timer->result();
        $stats[$name]['memory'] = $memory_measurer->result();
    }

    $restore();

    // 結果配列
    $result = [];
    $minmills = min(array_column($stats, 'mills'));
    uasort($stats, fn($a, $b) => $b['count'] <=> $a['count']);
    foreach ($stats as $name => $stat) {
        $result[$name] = [
            'name'    => $name,
            'cpu'     => $stat['cpu'],
            'memory'  => $stat['memory'],
            'called'  => $stat['count'],
            'fastest' => $stat['fastest'],
            'slowest' => $stat['slowest'],
            'mills'   => $stat['mills'],
            'ratio'   => $stat['mills'] / $minmills,
        ];
    }

    // 出力するなら出力
    if ($output) {
        $number_format = function ($value, $ratio = 1, $decimal = 0, $nullvalue = '') {
            return $value === null ? $nullvalue : number_format($value * $ratio, $decimal);
        };
        printf("Running %s cases (between %s ms):\n", count($benchset), $number_format($millisec));
        echo markdown_table(array_map(function ($v) use ($number_format) {
            return [
                'name'        => $v['name'],
                'cpu(user)'   => $number_format($v['cpu']['user'], 1000, 3),
                'cpu(system)' => $number_format($v['cpu']['system'], 1000, 3),
                'cpu(idle)'   => $number_format($v['cpu']['idle'], 1000, 3),
                'memory(KB)'  => $number_format($v['memory'], 1 / 1024, 3, "N/A"),
                'called'      => $number_format($v['called']),
                'fastest(ms)' => $number_format($v['fastest'], 1000, 6),
                'slowest(ms)' => $number_format($v['slowest'], 1000, 6),
                'average(ms)' => $number_format($v['mills'], 1000, 6),
                'ratio'       => $number_format($v['ratio'], 1, 3),
            ];
        }, $result));
    }

    return $result;
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../stream/include_stream.php';
// @codeCoverageIgnoreEnd

/**
 * 外部ツールに頼らない pure php なプロファイラを返す
 *
 * file プロトコル上書きと ticks と debug_backtrace によるかなり無理のある実装なので動かない環境・コードは多い。
 * その分お手軽だが下記の注意点がある。
 *
 * - file プロトコルを上書きするので、既に読み込み済みのファイルは計上されない
 * - tick されないステートメントは計上されない
 *     - 1行メソッドなどでありがち
 * - A->B->C という呼び出しで C が 3秒、B が 2秒、A が1秒かかった場合、 A は 6 秒、B は 5秒、C は 3 秒といて計上される
 *     - つまり、配下の呼び出しも重複して計上される
 *
 * この関数を呼んだ時点で計測は始まる。
 * 返り値としてイテレータを返すので、foreach で回せばコールスタック・回数・時間などが取得できる。
 * 配列で欲しい場合は直に呼べば良い。
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @param array $options オプション配列
 * @return \Traversable|callable プロファイライテレータ
 */
function profiler($options = [])
{
    $profiler = new class($options) implements \IteratorAggregate {
        private $result = [];
        private $wrapper;
        private $ticker;

        public function __construct($options = [])
        {
            $this->wrapper = include_stream()->register(static function ($filename) {
                if (pathinfo($filename, PATHINFO_EXTENSION) === 'php') {
                    return "<?php declare(ticks=1) ?>" . file_get_contents($filename);
                }
            });

            $options = array_replace([
                'callee'   => null,
                'location' => null,
            ], $options);
            $last_trace = [];
            $result = &$this->result;
            $this->ticker = static function () use ($options, &$last_trace, &$result) {
                $now = microtime(true);
                $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

                $last_count = count($last_trace);
                $current_count = count($traces);

                // スタック数が変わってない（=同じメソッドを処理している？）
                if ($current_count === $last_count) {
                    assert($current_count === $last_count); // @codeCoverageIgnore
                }
                // スタック数が増えた（=新しいメソッドが開始された？）
                elseif ($current_count > $last_count) {
                    foreach (array_slice($traces, 1, $current_count - $last_count) as $last) {
                        $last['time'] = $now;
                        $last['callee'] = (isset($last['class'], $last['type']) ? $last['class'] . $last['type'] : '') . $last['function'];
                        $last['location'] = isset($last['file'], $last['line']) ? $last['file'] . '#' . $last['line'] : null;
                        array_unshift($last_trace, $last);
                    }
                }
                // スタック数が減った（=処理してたメソッドを抜けた？）
                elseif ($current_count < $last_count) {
                    $prev = null; // array_map などの内部関数はスタックが一気に2つ増減する
                    foreach (array_splice($last_trace, 0, $last_count - $current_count) as $last) {
                        $time = $now - $last['time'];
                        $callee = $last['callee'];
                        $location = $last['location'] ?? ($prev['file'] ?? '') . '#' . ($prev['line'] ?? '');
                        $prev = $last;

                        foreach (['callee', 'location'] as $key) {
                            $condition = $options[$key];
                            if ($condition !== null) {
                                $condition = $condition instanceof \Closure ? $condition : fn($v) => preg_match($condition, $v);
                                if (!$condition($$key)) {
                                    continue 2;
                                }
                            }
                        }
                        $result[$callee][$location][] = $time;
                    }
                }
            };

            register_tick_function($this->ticker);
            opcache_reset();
        }

        public function __destruct()
        {
            unregister_tick_function($this->ticker);

            $this->wrapper->restore();
        }

        public function __invoke()
        {
            return $this->result;
        }

        public function getIterator(): \Traversable
        {
            return yield from $this->result;
        }
    };

    return $profiler;
}

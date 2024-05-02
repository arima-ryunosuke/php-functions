<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * CPU 時間を計れるオブジェクトを返す
 *
 * コンストラクタ（あるいは start）時点から stop までの下記を返す。
 *
 * - real: 実際の経過時間
 * - time: CPU時間（user + system）
 * - user: ユーザー時間
 * - system: システム時間
 * - idle: アイドル時間（real - time）
 * - time%: CPU使用率（time / real）
 * - user%: ユーザー使用率（user / time）
 * - system%: システム使用率（system / time）
 * - idle%: アイドル率（idle / real）
 *
 * 要するに POSIX の time コマンドとほぼ同じで、計算から導出できる値がちょっと増えただけ。
 *
 * - user が大きい場合（time と user が近い場合）、ユーザーランドの処理が多かったことを表す
 * - system が大きい場合（time と system が近い場合）、システムコールが多かったことを表す
 * - idle が大きい場合（real と time が離れている場合）、ネットワークや IO 等で CPU が遊んでいたことを表す
 *   - もっとも、コア数によってはその限りではない（単に他のプロセスを捌いていただけ、もあり得る）
 *   - linux 版 getrusage だとコンテキストスイッチが取れるので傾向は表せるけど…正確には無理だし Windows が対応していないので未対応
 *
 * Example:
 * ```php
 * $timer = cpu_timer();
 * foreach (range(0, 999) as $i) {
 *    // ファイル IO を伴う sha1 なら user,system,idle を程よく使うはず
 *    $hash = sha1_file(__FILE__);
 * }
 * //var_dump($timer->result());
 * //{
 * //  real: 0.13377594947814941,
 * //  user: 0.078125,
 * //  system: 0.046875,
 * //  time: 0.125,
 * //  idle: 0.008775949478149414,
 * //  user%: 62.5,
 * //  system%: 37.5,
 * //  time%: 93.4398152191154,
 * //  idle%: 6.560184780884589,
 * //}
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @return \CpuTimer|object タイマーオブジェクト
 */
function cpu_timer()
{
    return new class() {
        private float $start;
        private array $rusage;

        public function __construct()
        {
            $this->start();
        }

        public function start(): void
        {
            $this->start = microtime(true);
            $this->rusage = $this->getrusage();
        }

        public function result(): array
        {
            $real = microtime(true) - $this->start;
            $rusage = $this->getrusage();

            $utime = $rusage['ru_utime'] - $this->rusage['ru_utime'];
            $stime = $rusage['ru_stime'] - $this->rusage['ru_stime'];
            $time = $utime + $stime;
            $idle = $real - $time;

            return [
                'real'    => $real,
                'user'    => $utime,
                'system'  => $stime,
                'time'    => $time,
                'idle'    => $idle,
                'user%'   => $time === 0.0 ? NAN : ($utime / $time * 100),
                'system%' => $time === 0.0 ? NAN : ($stime / $time * 100),
                'time%'   => $real === 0.0 ? NAN : ($time / $real * 100),
                'idle%'   => $real === 0.0 ? NAN : ($idle / $real * 100),
            ];
        }

        public function __invoke($callback): array
        {
            $this->start();

            $callback();

            return $this->result();
        }

        private function getrusage()
        {
            $rusage = getrusage();
            $rusage['ru_utime'] = $rusage['ru_utime.tv_sec'] + $rusage['ru_utime.tv_usec'] / 1000 / 1000;
            $rusage['ru_stime'] = $rusage['ru_stime.tv_sec'] + $rusage['ru_stime.tv_usec'] / 1000 / 1000;
            return $rusage;
        }
    };
}

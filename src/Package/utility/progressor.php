<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 進捗(%)と見積もり(秒)を返すオブジェクトを返す
 *
 * $total に 0 を与えたり proceed していない状態だと結構なメソッドが null を返すので注意。
 *
 * 引数 $p は要するに外れ値の影響度だと思えばよい（高ければ高いほど見積もりが外れ値の影響を受ける）。
 * とはいえ 1 以上を与えることは（外れ値が逆方向に作用するため）ほぼあり得なく、0.5~1.0 あたりを与えておけばよいだろう。
 *
 * Example:
 * ```php
 * // このようにすると例えば下記のようになる
 * $progressor = progressor(11, 0.5);
 * foreach (range(1, 11) as $i) {
 *     $progressor->proceed(1);
 *
 *     // 基本100msかかるとするがたまに何かが刺さって1秒かかるとする
 *     usleep(100_000);
 *     if ($i === 2) {
 *         sleep(1);
 *     }
 *
 *     printf("%d: %.2f[%%], %.3f[s]\n", $progressor->current(), $progressor->percent(), $progressor->estimate());
 * }
 * <<<'OUT'
 * 1: 9.09[%], 0.000[s]
 * 2: 18.18[%], 0.237[s]
 * 3: 27.27[%], 1.689[s]    // $p はここの跳ね上がり具合に影響する
 * 4: 36.36[%], 1.277[s]
 * 5: 45.45[%], 0.996[s]
 * 6: 54.55[%], 0.778[s]
 * 7: 63.64[%], 0.594[s]
 * 8: 72.73[%], 0.429[s]
 * 9: 81.82[%], 0.279[s]
 * 10: 90.91[%], 0.136[s]
 * 11: 100.00[%], 0.000[s]
 * OUT;
 * ```
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param int $total 全件数
 * @param float $p ヘルダー平均の p
 * @return \Progressor|object プログレスインスタンス
 */
function progressor(int $total, float $p = 1.0)
{
    assert($total >= 0);
    assert($p > 0);

    return new class($total, $p) {
        private int   $current    = 0;
        private float $hoelderSum = 0;
        private float $startTime;
        private float $previousTime;

        public function __construct(private int $total, private float $p)
        {
            $this->startTime = microtime(true);
            $this->previousTime = microtime(true);
        }

        /**
         * 処理を進める
         */
        public function proceed(int $step = 1)
        {
            $now = microtime(true);

            $this->current = min($this->total, $this->current + $step);
            $this->hoelderSum += pow(($now - $this->previousTime) * $step, $this->p);
            $this->previousTime = $now;
        }

        /**
         * 現在値を返す
         */
        public function current(): int
        {
            return $this->current;
        }

        /**
         * 残件数を返す
         */
        public function remain(): int
        {
            return $this->total - $this->current;
        }

        /**
         * 全件数を返す
         */
        public function total(): int
        {
            return $this->total;
        }

        /**
         * 進捗パーセントを返す
         */
        public function percent(): ?float
        {
            if ($this->total === 0) {
                return null;
            }
            return $this->current / $this->total * 100;
        }

        /**
         * 実行時間を返す
         */
        public function elapse(): float
        {
            return microtime(true) - $this->startTime;
        }

        /**
         * 見積もり秒を返す
         */
        public function estimate(): ?float
        {
            if ($this->current === 0) {
                return null;
            }
            return $this->remain() * $this->mean();
        }

        /**
         * 平均実行秒を返す
         */
        public function mean(): ?float
        {
            if ($this->current === 0) {
                return null;
            }
            return pow($this->hoelderSum / $this->current, 1 / $this->p);
        }
    };
}

<?php
// @formatter:off

/**
 * stub for progressor
 *
 *
 *
 * @used-by \progressor()
 * @used-by \ryunosuke\Functions\progressor()
 * @used-by \ryunosuke\Functions\Package\progressor()
 */
class Progressor
{


    /**
     * 処理を進める
     */
    public function proceed(int $step = 1) { }
    /**
     * 現在値を返す
     */
    public function current(): int { }
    /**
     * 残件数を返す
     */
    public function remain(): int { }
    /**
     * 全件数を返す
     */
    public function total(): int { }
    /**
     * 進捗パーセントを返す
     */
    public function percent(): ?float { }
    /**
     * 実行時間を返す
     */
    public function elapse(): float { }
    /**
     * 見積もり秒を返す
     */
    public function estimate(): ?float { }
    /**
     * 平均実行秒を返す
     */
    public function mean(): ?float { }
}

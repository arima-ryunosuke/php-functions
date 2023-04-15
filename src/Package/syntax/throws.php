<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * throw の関数版
 *
 * hoge() or throw などしたいことがまれによくあるはず。
 *
 * Example:
 * ```php
 * try {
 *     throws(new \Exception('throws'));
 * }
 * catch (\Exception $ex) {
 *     that($ex->getMessage())->isSame('throws');
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param \Exception $ex 投げる例外
 * @return mixed （`return hoge or throws` のようなコードで警告が出るので抑止用）
 */
function throws($ex)
{
    throw $ex;
}

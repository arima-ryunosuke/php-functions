<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 連想配列を元に環境変数を設定する
 *
 * 値に null を渡すと環境変数の削除動作となる。
 * 返り値として成否配列を返すが、この返り値の形式は互換性を維持せず、変更になる可能性がある。
 *
 * Example:
 * ```php
 * setenvs([
 *     'ENV1' => 'e1',
 *     'ENV2' => 'e2',
 *     'ENV3' => null,
 * ]);
 * that(getenv('ENV1'))->isSame('e1');
 * that(getenv('ENV2'))->isSame('e2');
 * that(getenv('ENV3'))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param iterable $env_vars [環境変数名 => 値]
 * @return array 成否配列
 */
function setenvs($env_vars)
{
    $result = [];
    foreach ($env_vars as $envname => $val) {
        if ($val === null) {
            $result[$envname] = putenv("$envname");
        }
        else {
            $result[$envname] = putenv("$envname=$val");
        }
    }
    return $result;
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * switch 構文の関数版
 *
 * case にクロージャを与えると実行して返す。
 * つまり、クロージャを返すことは出来ないので注意。
 *
 * $default を与えないとマッチしなかったときに例外を投げる。
 *
 * Example:
 * ```php
 * $cases = [
 *     1 => 'value is 1',
 *     2 => fn() => 'value is 2',
 * ];
 * that(switchs(1, $cases))->isSame('value is 1');
 * that(switchs(2, $cases))->isSame('value is 2');
 * that(switchs(3, $cases, 'undefined'))->isSame('undefined');
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param mixed $value 調べる値
 * @param array $cases case 配列
 * @param null $default マッチしなかったときのデフォルト値。指定しないと例外
 * @return mixed
 */
function switchs($value, $cases, $default = null)
{
    if (!array_key_exists($value, $cases)) {
        if (func_num_args() === 2) {
            throw new \OutOfBoundsException("value $value is not defined in " . json_encode(array_keys($cases)));
        }
        return $default;
    }

    $case = $cases[$value];
    if ($case instanceof \Closure) {
        return $case($value);
    }
    return $case;
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/var_type.php';
// @codeCoverageIgnoreEnd

/**
 * 配列・オブジェクトを問わずキーやプロパティの値を取得する
 *
 * 配列が与えられた場合は array_key_exists でチェック。
 * オブジェクトは一旦 isset で確認した後 null の場合は実際にアクセスして取得する。
 *
 * Example:
 * ```php
 * $array = [
 *     'k' => 'v',
 *     'n' => null,
 * ];
 * that(attr_get('k', $array))->isSame('v');                  // もちろん存在する
 * that(attr_get('n', $array))->isSame(null);                 // isset ではないので null も true
 * that(attr_get('x', $array, 'default'))->isSame('default'); // 存在しないのでデフォルト値
 *
 * $object = (object) $array;
 * // オブジェクトでも使える
 * that(attr_get('k', $object))->isSame('v');                  // もちろん存在する
 * that(attr_get('n', $object))->isSame(null);                 // isset ではないので null も true
 * that(attr_get('x', $object, 'default'))->isSame('default'); // 存在しないのでデフォルト値
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param int|string $key 取得するキー
 * @param array|object $value 取得される配列・オブジェクト
 * @param mixed $default なかった場合のデフォルト値
 * @return mixed $key の値
 */
function attr_get($key, $value, $default = null)
{
    if (is_array($value)) {
        // see https://www.php.net/manual/function.array-key-exists.php#107786
        return isset($value[$key]) || array_key_exists($key, $value) ? $value[$key] : $default;
    }

    if ($value instanceof \ArrayAccess) {
        // あるならあるでよい
        if (isset($value[$key])) {
            return $value[$key];
        }
        // 問題は「ない場合」と「あるが null だった場合」の区別で、ArrayAccess の実装次第なので一元的に確定するのは不可能
        // ここでは「ない場合はなんらかのエラー・例外が出るはず」という前提で実際に値を取得して確認する
        try {
            error_clear_last();
            $result = @$value[$key];
            return error_get_last() ? $default : $result;
        }
        catch (\Throwable) {
            return $default;
        }
    }

    // 上記のプロパティ版
    if (is_object($value)) {
        try {
            if (isset($value->$key)) {
                return $value->$key;
            }
            error_clear_last();
            $result = @$value->$key;
            return error_get_last() ? $default : $result;
        }
        catch (\Throwable) {
            return $default;
        }
    }

    throw new \InvalidArgumentException(sprintf('%s must be array or object (%s).', '$value', var_type($value)));
}

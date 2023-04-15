<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * falsy の範囲を少し拡張した bool キャスト
 *
 * 例えば ajax 等で {hoge: false} とすると "false" が飛んできてしまうが、その場合も false 判定されるようになる。
 * この処理は FILTER_VALIDATE_BOOLEAN で行うので "off", "no", 等も false を返す。
 *
 * あとドキュメントには空白文字について言及がないが、どうも trim される模様。
 * trim するかどうかは呼び元で判断すべきだと思う（" true " が true, "    " が false になるのは果たして正しいのか）ので、第2引数で分岐できるようにしてある。
 * boolval やキャストでは trim されないようなのでデフォルト false にしてある。
 *
 * Example:
 * ```php
 * // こういう文字列も false になる
 * that(flagval('false'))->isFalse();
 * that(flagval('off'))->isFalse();
 * that(flagval('no'))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var bool 化する値
 * @param bool $trim $var が文字列の場合に trim するか
 * @return bool bool 化した値
 */
function flagval($var, $trim = false)
{
    if ($trim === false && is_string($var)) {
        if (strlen(trim($var)) !== strlen($var)) {
            return true;
        }
    }
    return filter_var($var, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? (bool) $var;
}

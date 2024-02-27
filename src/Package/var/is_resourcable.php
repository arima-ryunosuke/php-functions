<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 閉じたリソースでも true を返す is_resource
 *
 * マニュアル（ https://www.php.net/manual/ja/function.is-resource.php ）に記載の通り、 isresource は閉じたリソースで false を返す。
 * リソースはリソースであり、それでは不便なこともあるので、閉じていようとリソースなら true を返す関数。
 *
 * Example:
 * ```php
 * // 閉じたリソースを用意
 * $resource = tmpfile();
 * fclose($resource);
 * // is_resource は false を返すが・・・
 * that(is_resource($resource))->isFalse();
 * // is_resourcable は true を返す
 * that(is_resourcable($resource))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @return bool リソースなら true
 */
function is_resourcable($var)
{
    if (is_resource($var)) {
        return true;
    }
    // もっといい方法があるかもしれないが、簡単に調査したところ gettype するしか術がないような気がする
    if (strpos(gettype($var), 'resource') === 0) {
        return true;
    }
    return false;
}

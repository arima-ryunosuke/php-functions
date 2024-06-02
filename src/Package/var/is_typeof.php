<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * 変数が型に合致するか調べる
 *
 * is_a のビルトイン＋DNF 対応版。
 *
 * DNF の場合、括弧は必須だしネストも不可。
 * 実質的には ReflectionType の文字列表現を与えるのみ。
 *
 * いわゆる strict_types=1 で、型の変換は伴わない。
 * それはそれで不便なことがある（stringable とか）ので対応するかもしれない。
 *
 * Example:
 * ```php
 * that(is_typeof(null, 'null'))->isTrue();
 * that(is_typeof(null, '?int'))->isTrue();
 * that(is_typeof(1234, '?int'))->isTrue();
 * that(is_typeof(1234, 'int|string'))->isTrue();
 * that(is_typeof('ss', 'int|string'))->isTrue();
 * that(is_typeof(null, 'int|string'))->isFalse();
 * that(is_typeof([], 'array|(ArrayAccess&Countable&iterable)'))->isTrue();
 * that(is_typeof(new \ArrayObject(), 'array|(ArrayAccess&Countable&iterable)'))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @param string $typestring 型文字列
 * @param null|object|string $context self,static のコンテキスト
 * @return bool $typestring に合致するなら true
 */
function is_typeof($var, string $typestring, $context = null)
{
    $match = function ($type) use ($var, $context) {
        $type = trim($type);
        // ?type は 7.4 を最後に姿を消したが $typestring はただの文字列なので与えられる可能性がなくはない
        if ($type[0] === '?') {
            if ($var === null) {
                return true;
            }
            $type = substr($type, 1);
        }
        return match ($type) {
            'void', 'never'  => false, // 単一戻り値専用なのでオマケのようなもの
            'mixed'          => true,
            'null'           => $var === null,
            'true'           => $var === true,
            'false'          => $var === false,
            'bool'           => is_bool($var),
            'int'            => is_int($var),
            'float'          => is_float($var),
            'string'         => is_string($var),
            'array'          => is_array($var),
            'object'         => is_object($var),
            'iterable'       => is_iterable($var),
            'callable'       => is_callable($var),
            'countable'      => is_countable($var),   // Countable は配列が引っかからないので Countable/countable を区別している
            'resource'       => is_resourcable($var), // 型宣言できないのでオマケのようなもの
            'self', 'static' => is_a($var, is_object($context) ? get_class($context) : $context),
            default          => is_a($var, $type),
        };
    };

    // DNF の()は必須かつネストしないので単純 explode で問題ない
    foreach (explode('|', $typestring) as $ortype) {
        if (preg_match('#\(?([^)]+)\)?#u', $ortype, $m)) {
            foreach (explode('&', $m[1]) as $andtype) {
                if (!$match($andtype)) {
                    continue 2;
                }
            }
            return true;
        }
    }

    return false;
}

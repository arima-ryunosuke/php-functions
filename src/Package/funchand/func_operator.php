<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../syntax/throws.php';
// @codeCoverageIgnoreEnd

/**
 * 演算子のクロージャを返す
 *
 * 関数ベースなので `??` のような言語組み込みの特殊な演算子は若干希望通りにならない（Notice が出る）。
 * 2つ目以降の引数でオペランドを指定できる。
 *
 * Example:
 * ```php
 * $not = func_operator('!');    // 否定演算子クロージャ
 * that(false)->isSame($not(true));
 *
 * $minus = func_operator('-'); // マイナス演算子クロージャ
 * that($minus(2))->isSame(-2);       // 引数1つで呼ぶと1項演算子
 * that($minus(3, 2))->isSame(3 - 2); // 引数2つで呼ぶと2項演算子
 *
 * $cond = func_operator('?:'); // 条件演算子クロージャ
 * that($cond('OK', 'NG'))->isSame('OK' ?: 'NG');               // 引数2つで呼ぶと2項演算子
 * that($cond(false, 'OK', 'NG'))->isSame(false ? 'OK' : 'NG'); // 引数3つで呼ぶと3項演算子
 *
 * $gt5 = func_operator('<=', 5); // 5以下を判定するクロージャ
 * that(array_filter([1, 2, 3, 4, 5, 6, 7, 8, 9], $gt5))->isSame([1, 2, 3, 4, 5]);
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param string $operator 演算子
 * @param mixed ...$operands 右オペランド
 * @return \Closure 演算子のクロージャ
 */
function func_operator($operator, ...$operands)
{
    static $operators = null;
    $operators = $operators ?: [
        ''           => static fn($v1) => $v1, // こんな演算子はないが、「if ($value) {}」として使えることがある
        '!'          => static fn($v1) => !$v1,
        '+'          => static fn($v1, $v2 = null) => func_num_args() === 1 ? (+$v1) : ($v1 + $v2),
        '-'          => static fn($v1, $v2 = null) => func_num_args() === 1 ? (-$v1) : ($v1 - $v2),
        '~'          => static fn($v1) => ~$v1,
        '++'         => static fn(&$v1) => ++$v1,
        '--'         => static fn(&$v1) => --$v1,
        '?:'         => static fn($v1, $v2, $v3 = null) => func_num_args() === 2 ? ($v1 ?: $v2) : ($v1 ? $v2 : $v3),
        '??'         => static fn($v1, $v2) => $v1 ?? $v2,
        '=='         => static fn($v1, $v2) => $v1 == $v2,
        '==='        => static fn($v1, $v2) => $v1 === $v2,
        '!='         => static fn($v1, $v2) => $v1 != $v2,
        '<>'         => static fn($v1, $v2) => $v1 <> $v2,
        '!=='        => static fn($v1, $v2) => $v1 !== $v2,
        '<'          => static fn($v1, $v2) => $v1 < $v2,
        '<='         => static fn($v1, $v2) => $v1 <= $v2,
        '>'          => static fn($v1, $v2) => $v1 > $v2,
        '>='         => static fn($v1, $v2) => $v1 >= $v2,
        '<=>'        => static fn($v1, $v2) => $v1 <=> $v2,
        '.'          => static fn($v1, $v2) => $v1 . $v2,
        '*'          => static fn($v1, $v2) => $v1 * $v2,
        '/'          => static fn($v1, $v2) => $v1 / $v2,
        '%'          => static fn($v1, $v2) => $v1 % $v2,
        '**'         => static fn($v1, $v2) => $v1 ** $v2,
        '^'          => static fn($v1, $v2) => $v1 ^ $v2,
        '&'          => static fn($v1, $v2) => $v1 & $v2,
        '|'          => static fn($v1, $v2) => $v1 | $v2,
        '<<'         => static fn($v1, $v2) => $v1 << $v2,
        '>>'         => static fn($v1, $v2) => $v1 >> $v2,
        '&&'         => static fn($v1, $v2) => $v1 && $v2,
        '||'         => static fn($v1, $v2) => $v1 || $v2,
        'or'         => static fn($v1, $v2) => $v1 or $v2,
        'and'        => static fn($v1, $v2) => $v1 and $v2,
        'xor'        => static fn($v1, $v2) => $v1 xor $v2,
        'instanceof' => static fn($v1, $v2) => $v1 instanceof $v2,
        'new'        => static fn($v1, ...$v) => new $v1(...$v),
        'clone'      => static fn($v1) => clone $v1,
    ];

    $opefunc = $operators[trim($operator)] ?? throws(new \InvalidArgumentException("$operator is not defined Operator."));

    if ($operands) {
        return static fn($v1) => $opefunc($v1, ...$operands);
    }

    return $opefunc;
}

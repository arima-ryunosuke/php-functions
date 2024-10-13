<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_and.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../classobj/object_properties.php';
require_once __DIR__ . '/../random/unique_string.php';
require_once __DIR__ . '/../strings/str_exists.php';
require_once __DIR__ . '/../strings/str_quote.php';
require_once __DIR__ . '/../var/is_primitive.php';
// @codeCoverageIgnoreEnd

/**
 * 組み込みの var_export をいい感じにしたもの
 *
 * 下記の点が異なる。
 *
 * - 配列は 5.4 以降のショートシンタックス（[]）で出力
 * - ただの配列は1行（[1, 2, 3]）でケツカンマなし、連想配列は桁合わせインデントでケツカンマあり
 * - 文字列はダブルクオート
 * - null は null（小文字）
 * - 再帰構造を渡しても警告がでない（さらに NULL ではなく `'*RECURSION*'` という文字列になる）
 * - 配列の再帰構造の出力が異なる（Example参照）
 *
 * Example:
 * ```php
 * // 単純なエクスポート
 * that(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true))->isSame('[
 *     "array" => [1, 2, 3],
 *     "hash"  => [
 *         "a" => "A",
 *         "b" => "B",
 *         "c" => "C",
 *     ],
 * ]');
 * // 再帰構造を含むエクスポート（標準の var_export は形式が異なる。 var_export すれば分かる）
 * $rarray = [];
 * $rarray['a']['b']['c'] = &$rarray;
 * $robject = new \stdClass();
 * $robject->a = new \stdClass();
 * $robject->a->b = new \stdClass();
 * $robject->a->b->c = $robject;
 * that(var_export2(compact('rarray', 'robject'), true))->isSame('[
 *     "rarray"  => [
 *         "a" => [
 *             "b" => [
 *                 "c" => "*RECURSION*",
 *             ],
 *         ],
 *     ],
 *     "robject" => (object) [
 *         "a" => (object) [
 *             "b" => (object) [
 *                 "c" => "*RECURSION*",
 *             ],
 *         ],
 *     ],
 * ]');
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $value 出力する値
 * @param bool|array $options オプション配列（var_export に寄せるため bool も受け付ける）
 * @return string|null $return=true の場合は出力せず結果を返す
 */
function var_export2($value, $options = [])
{
    if (!is_array($options)) {
        $options = [
            'return' => !!$options,
        ];
    }

    $options += [
        'minify' => false, // 短縮形で返す（実質的には情報を減らして1行で返す）
        'indent' => 4,     // インデントの空白数
        'return' => false, // 値を戻すか出力するか
    ];

    // 再帰用クロージャ
    $export = function ($value, $context, $nest = 0, $parents = []) use (&$export, $options) {
        // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
        foreach ($parents as $parent) {
            if ($parent === $value) {
                return $export('*RECURSION*', 'recursion');
            }
        }

        $space = $options['minify'] ? "" : " ";
        $break = $options['minify'] ? "" : "\n";

        // 配列は連想判定したり再帰したり色々
        if (is_array($value)) {
            $spacer1 = str_repeat($space, ($nest + 1) * $options['indent']);
            $spacer2 = str_repeat($space, $nest * $options['indent']);

            $hashed = is_hasharray($value);

            // スカラー値のみで構成されているならシンプルな再帰
            if (!$hashed && array_and($value, fn(...$args) => is_primitive(...$args))) {
                return '[' . implode(",$space", array_map(fn($v) => $export($v, 'array-value'), $value)) . ']';
            }

            // 連想配列はキーを含めて桁あわせ
            if ($hashed) {
                $keys = array_map(fn($v) => $export($v, 'array-key'), array_combine($keys = array_keys($value), $keys));
                $maxlen = max(array_map('strlen', $keys));
            }
            $kvl = '';
            $lastkey = array_key_last($value);
            $parents[] = $value;
            foreach ($value as $k => $v) {
                $keystr = $hashed ? $keys[$k] . str_repeat($space, $maxlen - strlen($keys[$k])) . "$space=>$space" : '';
                $kvl .= $spacer1 . $keystr . $export($v, 'array-value', $nest + 1, $parents) . ($k === $lastkey && $options['minify'] ? "" : ",") . "$break";
            }
            return "[$break{$kvl}{$spacer2}]";
        }
        // オブジェクトは単にプロパティを __set_state する文字列を出力する
        elseif (is_object($value)) {
            $parents[] = $value;
            $classname = get_class($value);
            if ($classname === \stdClass::class) {
                return "(object)$space" . $export((array) $value, 'object', $nest, $parents);
            }
            return $classname . '::__set_state(' . $export(object_properties($value), 'object', $nest, $parents) . ')';
        }
        // 文字列はダブルクオート（場合によってはヒアドキュメント）
        elseif (is_string($value)) {
            // 列揃えのため配列のキーは常にダブルクォート
            if ($context === 'array-key') {
                return str_quote($value);
            }
            // 改行を含むならヒアドキュメント
            if (!$options['minify'] && str_exists($value, ["\r", "\n"])) {
                // ただし、改行文字だけの場合は除く（何らかの引数で改行文字だけを渡すシチュエーションはそれなりにあるのでヒアドキュメントだと冗長）
                if (trim($value, "\r\n") !== '') {
                    return str_quote($value, [
                        'heredoc' => unique_string($value, 'TEXT', '_'),
                        'indent'  => $nest * $options['indent'],
                    ]);
                }
            }
            return str_quote($value);
        }
        // null は小文字で居て欲しい
        elseif (is_null($value)) {
            return 'null';
        }
        // それ以外は標準に従う
        else {
            return var_export($value, true);
        }
    };

    // 結果を返したり出力したり
    $result = $export($value, null);
    if ($options['return']) {
        return $result;
    }
    echo $result, "\n";
}

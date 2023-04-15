<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_distinct.php';
require_once __DIR__ . '/../array/array_lmap.php';
require_once __DIR__ . '/../array/array_map_key.php';
require_once __DIR__ . '/../dataformat/paml_import.php';
require_once __DIR__ . '/../strings/str_ellipsis.php';
require_once __DIR__ . '/../var/stringify.php';
// @codeCoverageIgnoreEnd

/**
 * 配列のスキーマを定義して配列を正規化する
 *
 * - type: 値の型を指定する
 *   - is_XXX の XXX 部分: 左記で検証
 *   - number: is_int or is_float で検証
 *   - class 名: instanceof で検証
 *   - list: 値がマージされて通常配列になる
 *     - list@string のようにすると配列の中身の型を指定できる
 *   - hash: 連想配列になる
 *   - string|int: string or int
 *   - ['string', 'int']: 上と同じ
 * - closure: 指定クロージャで検証・フィルタ
 *   - all: 値を引数に取り、返り値が新しい値となる
 * - unique: 重複を除去する
 *   - list: 重複除去（パラメータがソートアルゴリズムになる）
 * - enum: 値が指定値のいずれかであるか検証する
 *   - all: in_array で検証する
 * - min: 値が指定値以上であるか検証する
 *   - string: strlen で検証
 *   - list: count で検証
 *   - all: その値で検証
 * - max: 値が指定値以下であるか検証する
 *   - min の逆
 * - match: 値が正規表現にマッチするか検証する
 *   - all: preg_match で検証する
 * - unmatch: 値が正規表現にマッチしないか検証する
 *   - match の逆
 * - include: 値が指定値を含むか検証する
 *   - string: strpos で検証
 *   - list: in_array で検証
 * - exclude: 値が指定値を含まないか検証する
 *   - include の逆
 *
 * 検証・フィルタは原則として型を見ない（指定されていればすべて実行される）。
 * のでおかしな型におかしな検証・フィルタを与えると型エラーが出ることがある。
 *
 * 検証は途中経過を問わない。
 * 後ろの配列で上書きされた値や unique で減った配列などは以下に違反していても valid と判断される。
 *
 * 素直に json schema を使えという内なる声が聞こえなくもない。
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $schema スキーマ配列
 * @param mixed ...$arrays 検証する配列（可変引数。マージされる）
 * @return array 正規化された配列
 */
function array_schema($schema, ...$arrays)
{
    $throw = function ($key, $value, $message) {
        $value = str_ellipsis(stringify($value), 32);
        throw new \DomainException("invalid value $key. $value must be $message");
    };
    // 検証兼フィルタ郡
    $validators = [
        'filter'    => function ($definition, $value, $key) use ($throw) {
            $filter = $definition['filter'];
            if (!is_array($filter)) {
                $filter = [$filter];
            }
            if (($newvalue = filter_var($value, ...$filter)) === false) {
                $filter_name = array_combine(array_map('filter_id', filter_list()), filter_list());
                $throw($key, $value, "filter_var " . $filter_name[$filter[0]] . "(" . json_encode($filter[1] ?? []) . ")");
            }
            return $newvalue;
        },
        'type'      => function ($definition, $value, $key) use ($throw) {
            foreach ($definition['type'] as $type) {
                if ($type === 'number' && (is_int($value) || is_float($value))) {
                    return $value;
                }
                if (function_exists($checker = "is_$type") && $checker($value)) {
                    return $value;
                }
                if (in_array($type, ['list', 'hash'], true) && is_array($value)) {
                    return $value;
                }
                if ($value instanceof $type) {
                    return $value;
                }
            }
            $throw($key, $value, implode(' or ', $definition['type']));
        },
        'closure'   => function ($definition, $value, $key) use ($throw) {
            return $definition['closure']($value, $definition);
        },
        'unique'    => function ($definition, $value, $key) use ($throw) {
            return array_values(array_distinct($value, $definition['unique']));
        },
        'min'       => function ($definition, $value, $key) use ($throw) {
            if (is_string($value)) {
                if (strlen($value) < $definition['min']) {
                    $throw($key, $value, "strlen >= {$definition['min']}");
                }
            }
            elseif (is_array($value)) {
                if (count($value) < $definition['min']) {
                    $throw($key, $value, "count >= {$definition['min']}");
                }
            }
            elseif ($value < $definition['min']) {
                $throw($key, $value, ">= {$definition['min']}");
            }
            return $value;
        },
        'max'       => function ($definition, $value, $key) use ($throw) {
            if (is_string($value)) {
                if (strlen($value) > $definition['max']) {
                    $throw($key, $value, "strlen <= {$definition['max']}");
                }
            }
            elseif (is_array($value)) {
                if (count($value) > $definition['max']) {
                    $throw($key, $value, "count <= {$definition['max']}");
                }
            }
            elseif ($value > $definition['max']) {
                $throw($key, $value, "<= {$definition['max']}");
            }
            return $value;
        },
        'precision' => function ($definition, $value, $key) use ($throw) {
            $precision = $definition['precision'] + 1;
            if (preg_match("#\.\d{{$precision}}$#", $value)) {
                $throw($key, $value, "precision {$definition['precision']}");
            }
            return $value;
        },
        'enum'      => function ($definition, $value, $key) use ($throw) {
            if (!in_array($value, $definition['enum'], true)) {
                $throw($key, $value, "any of " . json_encode($definition['enum']));
            }
            return $value;
        },
        'match'     => function ($definition, $value, $key) use ($throw) {
            if (!preg_match($definition['match'], $value)) {
                $throw($key, $value, "match {$definition['match']}");
            }
            return $value;
        },
        'unmatch'   => function ($definition, $value, $key) use ($throw) {
            if (preg_match($definition['unmatch'], $value)) {
                $throw($key, $value, "unmatch {$definition['unmatch']}");
            }
            return $value;
        },
        'include'   => function ($definition, $value, $key) use ($throw) {
            if (is_array($value)) {
                if (!in_array($definition['include'], $value)) {
                    $throw($key, $value, "include {$definition['include']}");
                }
            }
            elseif (strpos($value, $definition['include']) === false) {
                $throw($key, $value, "include {$definition['include']}");
            }
            return $value;
        },
        'exclude'   => function ($definition, $value, $key) use ($throw) {
            if (is_array($value)) {
                if (in_array($definition['exclude'], $value)) {
                    $throw($key, $value, "exclude {$definition['exclude']}");
                }
            }
            elseif (strpos($value, $definition['exclude']) !== false) {
                $throw($key, $value, "exclude {$definition['exclude']}");
            }
            return $value;
        },
    ];

    $validate = function ($value, $rule, $path) use ($validators) {
        if (is_string($rule['type'])) {
            $rule['type'] = explode('|', $rule['type']);
        }
        $rule['type'] = array_map(fn($type) => explode('@', $type, 2)[0], $rule['type']);

        foreach ($validators as $name => $validator) {
            if (array_key_exists($name, $rule)) {
                $value = $validator($rule, $value, "{$path}");
            }
        }
        return $value;
    };

    $main = function ($schema, $path, ...$arrays) use (&$main, $validate) {
        if (is_string($schema)) {
            $schema = paml_import($schema);
        }
        if (!array_key_exists('type', $schema)) {
            throw new \InvalidArgumentException("$path not have type key");
        }
        if (!$arrays) {
            if (!array_key_exists('default', $schema)) {
                throw new \InvalidArgumentException("$path has no value");
            }
            $arrays[] = $schema['default'];
        }

        [$maintype, $subtype] = explode('@', implode('', (array) $schema['type']), 2) + [1 => null];
        if ($maintype === 'list') {
            $result = array_merge(...array_lmap($arrays, $validate, $schema, $path));
            if (isset($subtype)) {
                $subschema = ['type' => $subtype] + array_map_key($schema, fn($k) => $k[0] === '@' ? substr($k, 1) : null);
                foreach ($result as $k => $v) {
                    $result[$k] = $main($subschema, "$path/$k", $v);
                }
            }
            return $validate($result, $schema, $path);
        }
        elseif ($maintype === 'hash') {
            $result = [];
            foreach ($schema as $k => $rule) {
                if ($k[0] === '#') {
                    $name = substr($k, 1);
                    $result[$name] = $main($rule, "$path/$k", ...array_column($arrays, $name));
                }
            }
            return $validate($result, $schema, $path);
        }
        else {
            return $validate(end($arrays), $schema, $path);
        }
    };

    return $main($schema, '', ...$arrays);
}

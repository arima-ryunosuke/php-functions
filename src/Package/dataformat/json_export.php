<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_and.php';
require_once __DIR__ . '/../array/array_append.php';
require_once __DIR__ . '/../array/array_unset.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../filesystem/fnmatch_or.php';
require_once __DIR__ . '/../strings/strtr_escaped.php';
require_once __DIR__ . '/../var/is_primitive.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * json_encode のプロキシ関数
 *
 * 引数体系とデフォルト値を変更してある。また、エラー時に例外が飛ぶ。
 *
 * 下記の拡張オプションがある。
 *
 * - JSON_INLINE_LEVEL: PRETTY_PRINT 時に指定以上の階層をインライン化する（数値以外にパスで階層も指定できる）
 * - JSON_INLINE_SCALARLIST: PRETTY_PRINT 時にスカラーのみのリストをインライン化する
 * - JSON_INDENT: PRETTY_PRINT 時にインデント数・文字列を指定する
 * - JSON_CLOSURE: 任意のリテラルを埋め込む
 *   - クロージャの返り値がそのまま埋め込まれるので、文字列化可能な結果を返さなければならない
 *
 * JSON_ES5 を与えると JSON5 互換でエンコードされる。
 * その際下記のプションも使用可能になる。
 *
 * - JSON_TEMPLATE_LITERAL: 改行を含む文字列をテンプレートリテラルで出力する
 * - JSON_TRAILING_COMMA: 末尾カンマを強制する
 * - JSON_COMMENT_PREFIX: コメントとして埋め込まれるキープレフィックスを指定する
 *   - そのキーで始まる要素が文字列なら // コメントになる
 *   - そのキーで始まる要素が配列なら /* コメントになる
 *
 * Example:
 * ```php
 * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
 * that(json_export(['a' => 'A', 'b' => 'B'], [
 *    JSON_PRETTY_PRINT => false,
 * ]))->is('{"a":"A","b":"B"}');
 * // json5 でコメント付きかつ末尾カンマ強制モード
 * that(json_export(['a' => 'A', '#comment' => 'this is comment', 'b' => 'B'], [
 *    JSON_ES5            => true,
 *    JSON_TRAILING_COMMA => true,
 *    JSON_COMMENT_PREFIX => '#',
 *    JSON_PRETTY_PRINT   => true,
 * ]))->is('{
 *     a: "A",
 *     // this is comment
 *     b: "B",
 * }');
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param mixed $value encode する値
 * @param array $options JSON_*** をキーにした連想配列。 値が false は指定されていないとみなされる
 * @return string JSON 文字列
 */
function json_export($value, $options = [])
{
    $options += [
        JSON_UNESCAPED_UNICODE      => true, // エスケープなしで特にデメリットはない
        JSON_PRESERVE_ZERO_FRACTION => true, // 勝手に変換はできるだけ避けたい
        JSON_THROW_ON_ERROR         => true, // 標準動作はエラーすら出ずに false を返すだけ
    ];
    $es5 = array_unset($options, JSON_ES5, false);
    $comma = array_unset($options, JSON_TRAILING_COMMA, false);
    $comment = array_unset($options, JSON_COMMENT_PREFIX, '');
    $depth = array_unset($options, JSON_MAX_DEPTH, 512);
    $indent = array_unset($options, JSON_INDENT, null);
    $closure = array_unset($options, JSON_CLOSURE, false);
    $nest_level = array_unset($options, JSON_NEST_LEVEL, 0);
    $inline_level = array_unset($options, JSON_INLINE_LEVEL, 0);
    $template_literal = array_unset($options, JSON_TEMPLATE_LITERAL, false);
    $inline_scalarlist = array_unset($options, JSON_INLINE_SCALARLIST, false);
    // 後方互換性のため null のときのみデフォルト値を使う
    $object_handlers = array_unset($options, JSON_OBJECT_HANDLER, []) ?? [
        \DateTimeInterface::class => fn($v) => 'new Date(' . floor($v->format("U.v") * 1000) . ')',
        \GMP::class               => fn($v) => gmp_strval($v) . "n",
    ];

    $option = array_sum(array_keys(array_filter($options)));

    $encode = function ($value, $parents, $objective) use (&$encode, $option, $depth, $indent, $closure, $template_literal, $object_handlers, $inline_scalarlist, $nest_level, $inline_level, $es5, $comma, $comment) {
        $nest = $nest_level + count($parents);
        $indent = $indent ?: 4;

        if ($depth < $nest) {
            throw new \ErrorException('Maximum stack depth exceeded', JSON_ERROR_DEPTH);
        }
        if ($closure && $value instanceof \Closure) {
            return $value();
        }
        if (is_object($value)) {
            if ($value instanceof \JsonSerializable) {
                return $encode($value->jsonSerialize(), $parents, false);
            }
            if ($es5) {
                foreach ($object_handlers as $class => $handler) {
                    if (is_a($value, $class, true)) {
                        return $handler($value);
                    }
                }
            }
            return $encode((array) $value, $parents, true);
        }
        if (is_array($value)) {
            $pretty_print = $option & JSON_PRETTY_PRINT;
            $force_object = $option & JSON_FORCE_OBJECT;

            $withoutcommentarray = $value;
            if ($es5 && strlen($comment)) {
                $withoutcommentarray = array_filter($withoutcommentarray, fn($k) => strpos("$k", $comment) === false, ARRAY_FILTER_USE_KEY);
            }

            $objective = $force_object || $objective || is_hasharray($withoutcommentarray);

            if (!$value) {
                return $objective ? '{}' : '[]';
            }

            $inline = false;
            if ($inline_level) {
                if (is_array($inline_level)) {
                    $inline = $inline || fnmatch_or(array_map(fn($v) => "$v.*", $inline_level), implode('.', $parents) . '.');
                }
                elseif (ctype_digit("$inline_level")) {
                    $inline = $inline || $inline_level <= $nest;
                }
                else {
                    $inline = $inline || fnmatch("$inline_level.*", implode('.', $parents) . '.');
                }
            }
            if ($inline_scalarlist) {
                $inline = $inline || !$objective && array_and($value, fn($v) => is_primitive($v) || $v instanceof \Closure);
            }

            $break = $indent0 = $indent1 = $indent2 = $separator = '';
            $delimiter = ',';
            if ($pretty_print && !$inline) {
                $break = "\n";
                $separator = ' ';
                $indent0 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 0) * $indent) : str_repeat($indent, ($nest + 0));
                $indent1 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 1) * $indent) : str_repeat($indent, ($nest + 1));
                $indent2 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 2) * $indent) : str_repeat($indent, ($nest + 2));
            }
            if ($pretty_print && $inline) {
                $separator = ' ';
                $delimiter = ', ';
            }

            $n = 0;
            $count = count($withoutcommentarray);
            $result = ($objective ? '{' : '[') . $break;
            foreach ($value as $k => $v) {
                if ($es5 && strlen($comment) && strpos("$k", $comment) === 0) {
                    if (!$pretty_print) {
                        $v = (array) $v;
                    }
                    if (is_array($v)) {
                        $comments = [];
                        foreach ($v as $vv) {
                            $comments[] = "$indent2$vv";
                        }
                        $result .= "$indent1/*$break" . implode($break, $comments) . "$break$indent1*/";
                    }
                    else {
                        $comments = [];
                        foreach (preg_split('#\\R#u', $v) as $vv) {
                            $comments[] = "$indent1// $vv";
                        }
                        $result .= implode($break, $comments);
                    }
                }
                else {
                    $result .= $indent1;
                    if ($objective) {
                        $result .= ($es5 && preg_match("#^[a-zA-Z_$][a-zA-Z0-9_$]*$#u", $k) ? $k : json_encode("$k")) . ":$separator";
                    }
                    $result .= $encode($v, array_append($parents, $k), false);
                    if (++$n !== $count || ($comma && !$inline)) {
                        $result .= $delimiter;
                    }
                }
                $result .= $break;
            }
            return $result . $indent0 . ($objective ? '}' : ']');
        }

        if ($es5) {
            if (is_float($value) && is_nan($value)) {
                return 'NaN';
            }
            if (is_float($value) && is_infinite($value) && $value > 0) {
                return '+Infinity';
            }
            if (is_float($value) && is_infinite($value) && $value < 0) {
                return '-Infinity';
            }
            if ($template_literal && is_string($value) && strpos($value, "\n") !== false) {
                $jsonstr = json_encode($value, $option, $depth);
                $jsonstr = substr($jsonstr, 1, -1);
                $jsonstr = strtr_escaped($jsonstr, [
                    '\\n' => "\n",
                    '\\r' => "\r",
                    '`'   => '\\`',
                ]);
                return "`$jsonstr`";
            }
        }
        return json_encode($value, $option, $depth);
    };

    // 特別な状況（クロージャを使うとか ES5 でないとか）以外は 標準を使用したほうが遥かに速い
    if ($indent || $closure || $inline_scalarlist || $inline_level || $es5 || $comma || $comment || $template_literal) {
        return $encode($value, [], false);
    }
    else {
        return json_encode($value, $option, $depth);
    }
}

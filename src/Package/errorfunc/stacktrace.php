<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/object_properties.php';
require_once __DIR__ . '/../strings/str_quote.php';
require_once __DIR__ . '/../var/stringify.php';
// @codeCoverageIgnoreEnd

/**
 * スタックトレースを文字列で返す
 *
 * `(new \Exception())->getTraceAsString()` と実質的な役割は同じ。
 * ただし、 getTraceAsString は引数が Array になったりクラス名しか取れなかったり微妙に使い勝手が悪いのでもうちょっと情報量を増やしたもの。
 *
 * 第1引数 $traces はトレース的配列を受け取る（`(new \Exception())->getTrace()` とか）。
 * 未指定時は debug_backtrace() で採取する。
 *
 * 第2引数 $option は文字列化する際の設定を指定する。
 * 情報量が増える分、機密も含まれる可能性があるため、 mask オプションで塗りつぶすキーや引数名を指定できる（クロージャの引数までは手出ししないため留意）。
 * limit と format は比較的指定頻度が高いかつ互換性維持のため配列オプションではなく直に渡すことが可能になっている。
 *
 * @package ryunosuke\Functions\Package\errorfunc
 *
 * @param ?array $traces debug_backtrace 的な配列
 * @param int|string|array $option オプション
 * @return string|array トレース文字列（delimiter オプションに null を渡すと配列で返す）
 */
function stacktrace($traces = null, $option = [])
{
    if (is_int($option)) {
        $option = ['limit' => $option];
    }
    elseif (is_string($option)) {
        $option = ['format' => $option];
    }

    $option += [
        'format'    => '%s:%s %s', // 文字列化するときの sprintf フォーマット
        'args'      => true,       // 引数情報を埋め込むか否か
        'limit'     => 16,         // 配列や文字列を千切る長さ
        'delimiter' => "\n",       // スタックトレースの区切り文字（null で配列になる）
        'mask'      => ['#^password#', '#^secret#', '#^credential#', '#^credit#'],
    ];
    $limit = $option['limit'];
    $maskregexs = (array) $option['mask'];
    $mask = static function ($key, $value) use ($maskregexs) {
        if (!is_string($value)) {
            return $value;
        }
        foreach ($maskregexs as $regex) {
            if (preg_match($regex, $key)) {
                return str_repeat('*', strlen($value));
            }
        }
        return $value;
    };

    $stringify = static function ($value) use ($limit, $mask) {
        // 再帰用クロージャ
        $export = static function ($value, $nest = 0, $parents = []) use (&$export, $limit, $mask) {
            // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return var_export('*RECURSION*', true);
                }
            }
            // 配列は連想判定したり再帰したり色々
            if (is_array($value)) {
                $parents[] = $value;
                $flat = $value === array_values($value);
                $kvl = [];
                foreach ($value as $k => $v) {
                    if (count($kvl) >= $limit) {
                        $kvl[] = sprintf('...(more %d length)', count($value) - $limit);
                        break;
                    }
                    $kvl[] = ($flat ? '' : $k . ':') . $export(call_user_func($mask, $k, $v), $nest + 1, $parents);
                }
                return ($flat ? '[' : '{') . implode(', ', $kvl) . ($flat ? ']' : '}');
            }
            // オブジェクトは単にプロパティを配列的に出力する
            elseif (is_object($value)) {
                $parents[] = $value;
                return get_class($value) . $export(object_properties($value), $nest, $parents);
            }
            // 文字列はダブルクォート
            elseif (is_string($value)) {
                if (($strlen = strlen($value)) > $limit) {
                    $value = substr($value, 0, $limit) . sprintf('...(more %d length)', $strlen - $limit);
                }
                return str_quote($value);
            }
            // それ以外は stringify
            else {
                return stringify($value);
            }
        };

        return $export($value);
    };

    $traces ??= array_slice(debug_backtrace(), 1);
    $result = [];
    foreach ($traces as $i => $trace) {
        // メソッド内で関数定義して呼び出したりすると file が無いことがある（かなりレアケースなので無視する）
        if (!isset($trace['file'])) {
            continue; // @codeCoverageIgnore
        }

        $file = $trace['file'];
        $line = $trace['line'];
        if (strpos($trace['file'], "eval()'d code") !== false && ($traces[$i + 1]['function'] ?? '') === 'eval') {
            $file = $traces[$i + 1]['file'];
            $line = $traces[$i + 1]['line'] . "." . $trace['line'];
        }

        if (isset($trace['type'])) {
            $callee = $trace['class'] . $trace['type'] . $trace['function'];
            if ($option['args'] && $maskregexs && method_exists($trace['class'], $trace['function'])) {
                $ref = new \ReflectionMethod($trace['class'], $trace['function']);
            }
        }
        else {
            $callee = $trace['function'];
            if ($option['args'] && $maskregexs && function_exists($callee)) {
                $ref = new \ReflectionFunction($trace['function']);
            }
        }
        $args = [];
        if ($option['args']) {
            $args = $trace['args'] ?? [];
            if (isset($ref)) {
                $params = $ref->getParameters();
                foreach ($params as $n => $param) {
                    if (array_key_exists($n, $args)) {
                        $args[$n] = $mask($param->getName(), $args[$n]);
                    }
                }
            }
        }
        $callee .= '(' . implode(', ', array_map($stringify, $args)) . ')';

        $result[] = sprintf($option['format'], $file, $line, $callee);
    }
    if ($option['delimiter'] === null) {
        return $result;
    }
    return implode($option['delimiter'], $result);
}

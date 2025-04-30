<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/evaluate.php';
require_once __DIR__ . '/../strings/str_quote.php';
// @codeCoverageIgnoreEnd

/**
 * "hoge {$hoge}" 形式のレンダリング
 *
 * 文字列を eval して "hoge {$hoge}" 形式の文字列に変数を埋め込む。
 * 基本処理は `eval("return '" . addslashes($template) . "';");` と考えて良いが、下記が異なる。
 *
 * - 数値キーが参照できる
 * - クロージャは呼び出し結果が埋め込まれる。引数は (変数配列, 自身のキー文字列)
 * - 引数をそのまま返すだけの特殊な変数 $_ が宣言される
 * - シングルクォートのエスケープは外される
 *
 * $_ が宣言されるのは変数配列に '_' を含んでいないときのみ（上書きを防止するため）。
 * この $_ は php の埋め込み変数の闇を利用するととんでもないことが出来たりする（サンプルやテストコードを参照）。
 *
 * ダブルクオートはエスケープされるので文字列からの脱出はできない。
 * また、 `{$_(syntax(""))}` のように {$_()} 構文で " も使えなくなるので \' を使用しなければならない。
 *
 * Example:
 * ```php
 * // クロージャは呼び出し結果が埋め込まれる
 * that(render_string('$c', ['c' => fn($vars, $k) => $k . '-closure']))->isSame('c-closure');
 * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
 * that(render_string('{$_(123 + 456)}', []))->isSame('579');
 * // 要するに '$_()' の中に php の式が書けるようになる
 * that(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']]))->isSame('a,n,z');
 * that(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]]))->isSame('9');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $template レンダリング文字列
 * @param array $array レンダリング変数
 * @return string レンダリングされた文字列
 */
function render_string(?string $template, $array)
{
    // eval 可能な形式に変換
    $evalcode = 'return ' . str_quote($template, [
            'special-character' => [
                '\\' => '\\\\', // バックスラッシュ
                '"'  => '\\"',  // 二重引用符
            ],
        ]) . ';';

    // 利便性を高めるために変数配列を少しいじる
    $vars = [];
    foreach ($array as $k => $v) {
        // クロージャはその実行結果を埋め込む仕様
        if ($v instanceof \Closure) {
            $v = $v($array, $k);
        }
        $vars[$k] = $v;
    }
    // '_' はそのまま返すクロージャとする（キーがないときのみ）
    if (!array_key_exists('_', $vars)) {
        $vars['_'] = fn($v) => $v;
    }

    try {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return (function () {
            return evaluate(func_get_arg(0), func_get_arg(1));
        })($evalcode, $vars);
    }
    catch (\ParseError $ex) {
        throw new \RuntimeException('failed to eval code.' . $evalcode, 0, $ex);
    }
}

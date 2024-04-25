<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/php_parse.php';
require_once __DIR__ . '/../random/unique_string.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列から php コードを取り除く
 *
 * 正確にはオプションの replacer で指定したものに置換される（デフォルト空文字なので削除になる）。
 * replacer にクロージャを渡すと(phpコード, 出現番号) が渡ってくるので、それに応じて値を返せばそれに置換される。
 * 文字列を指定すると自動で出現番号が付与される。
 *
 * $mapping 配列には「どれをどのように」と言った変換表が格納される。
 * 典型的には strtr に渡して php コードを復元させるのに使用する。
 *
 * Example:
 * ```php
 * $phtml = 'begin php code <?php echo 123 ?> end';
 * // php コードが消えている
 * that(php_strip($phtml))->is('begin php code  end');
 * // $mapping を使用すると元の文字列に復元できる
 * $html = php_strip($phtml, [], $mapping);
 * that(strtr($html, $mapping))->is($phtml);
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $phtml php コードを含む文字列
 * @param array $option オプション配列
 * @param array $mapping 変換表が格納される参照変数
 * @return string php コードが除かれた文字列
 */
function php_strip($phtml, $option = [], &$mapping = [])
{
    $option = array_replace([
        'short_open_tag' => true,
        'trailing_break' => true,
        'replacer'       => func_num_args() === 3 ? null : '',
    ], $option, [
        //'flags'  => Syntax::TOKEN_NAME,
        //'cache'  => false,
        'phptag' => false,
    ]);

    $replacer = $option['replacer'];
    if ($replacer === '') {
        $replacer = fn($phptag, $n) => '';
    }
    if ($replacer === null) {
        $replacer = unique_string($phtml, 64);
    }

    $tmp = php_parse($phtml, $option);

    if ($option['trailing_break']) {
        $tokens = $tmp;
    }
    else {
        $tokens = [];
        $echoopen = false;
        $taglength = strlen('?>');
        foreach ($tmp as $token) {
            if ($token[0] === T_OPEN_TAG_WITH_ECHO) {
                $echoopen = true;
            }
            if ($echoopen && $token[0] === T_CLOSE_TAG && isset($token[1][$taglength])) {
                $echoopen = false;

                $tokens[] = [
                    $token[0],
                    rtrim($token[1]),
                    $token[2],
                    $token[3],
                ];
                $tokens[] = [
                    T_INLINE_HTML,
                    substr($token[1], $taglength),
                    $token[2],
                    $token[3] + $taglength,
                ];
            }
            else {
                $tokens[] = $token;
            }
        }
    }

    $offsets = [];
    foreach ($tokens as $token) {
        if ($token[0] === T_OPEN_TAG || $token[0] === T_OPEN_TAG_WITH_ECHO) {
            $offsets[] = [$token[3], null];
        }
        elseif ($token[0] === T_CLOSE_TAG) {
            $lastkey = count($offsets) - 1;
            $offsets[$lastkey][1] = $token[3] + strlen($token[1]) - $offsets[$lastkey][0];
        }
    }
    if ($offsets) {
        $lastkey = count($offsets) - 1;
        $offsets[$lastkey][1] = $offsets[$lastkey][1] ?? strlen($phtml) - $offsets[$lastkey][0];
    }

    $mapping = [];
    foreach (array_reverse($offsets) as $n => [$offset, $length]) {
        if ($replacer instanceof \Closure) {
            $mapping[$n] = substr($phtml, $offset, $length);
            $phtml = substr_replace($phtml, $replacer($mapping[$n], $n), $offset, $length);
        }
        else {
            $tag = $replacer . $n;
            $mapping[$tag] = substr($phtml, $offset, $length);
            $phtml = substr_replace($phtml, $tag, $offset, $length);
        }
    }

    return $phtml;
}

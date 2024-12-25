<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/function_shorten.php';
require_once __DIR__ . '/../utility/cacheobject.php';
// @codeCoverageIgnoreEnd

/**
 * 変数指定をできるようにした compact
 *
 * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
 *
 * Example:
 * ```php
 * $hoge = 'HOGE';
 * $fuga = 'FUGA';
 * that(hashvar($hoge, $fuga))->isSame(['hoge' => 'HOGE', 'fuga' => 'FUGA']);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed ...$vars 変数（可変引数）
 * @return array 引数の変数を変数名で compact した配列
 */
function hashvar(...$vars)
{
    $num = count($vars);

    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
    $file = $trace['file'];
    $line = $trace['line'];
    $function = function_shorten($trace['function']);

    $cache = cacheobject(__FUNCTION__)->hash([$file, $line, $function], function () use ($file, $line, $function) {
        // 呼び出し元の1行を取得
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        $target = $lines[$line - 1];

        // 1行内で複数呼んでいる場合のための配列
        $caller = [];
        $callers = [];

        // php パーシング
        $starting = false;
        $tokens = \PhpToken::tokenize('<?php ' . $target);
        foreach ($tokens as $token) {
            // トークン配列の場合
            if ($token->id >= 255) {
                // 自身の呼び出しが始まった
                if (!$starting && $token->id === T_STRING && $token->text === $function) {
                    $starting = true;
                }
                // 呼び出し中でかつ変数トークンなら変数名を確保
                elseif ($starting && $token->id === T_VARIABLE) {
                    $caller[] = ltrim($token->text, '$');
                }
                // 上記以外の呼び出し中のトークンは空白しか許されない
                elseif ($starting && $token->id !== T_WHITESPACE) {
                    throw new \UnexpectedValueException('argument allows variable only.');
                }
            }
            // 1文字単位の文字列の場合
            else {
                // 自身の呼び出しが終わった
                if ($starting && $token->text === ')' && $caller) {
                    $callers[] = $caller;
                    $caller = [];
                    $starting = false;
                }
            }
        }

        // 同じ引数の数の呼び出しは区別することが出来ない
        $length = count($callers);
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i + 1; $j < $length; $j++) {
                if (count($callers[$i]) === count($callers[$j])) {
                    throw new \UnexpectedValueException('argument is ambiguous.');
                }
            }
        }

        return $callers;
    });

    // 引数の数が一致する呼び出しを返す
    foreach ($cache as $caller) {
        if (count($caller) === $num) {
            return array_combine($caller, $vars);
        }
    }

    // 仕組み上ここへは到達しないはず（呼び出し元のシンタックスが壊れてるときに到達しうるが、それならばそもそもこの関数自体が呼ばれないはず）。
    throw new \DomainException('syntax error.'); // @codeCoverageIgnore
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrays.php';
require_once __DIR__ . '/../array/is_hasharray.php';
// @codeCoverageIgnoreEnd

/**
 * try ～ finally 構文の close 特化版
 *
 * $try の呼び出し完了後に必ず close するようにする。
 * C# の using, java の try-with-resource みたいなもの。
 *
 * $resources 引数は [filename, mode], [filename => mode] のような配列を受け付け、中で fopen される。
 *
 * resource 型を想定しているが、オブジェクトの場合は close, free, dispose あたりを試みる。
 * このメソッド候補は互換性を問わず変更されることがある。
 * そもそも、stream 以外のリソースや完全不透明クラスはオマケのようなもので完全サポートはしないし互換性も考慮しない。
 *
 * close で例外が飛んだ場合は握りつぶされる。
 * この握りつぶした例外を取得する方法は今のところ存在しない。
 *
 * Example:
 * ```php
 * that(try_close(fn($fp, $string) => fwrite($fp, $string), $tmpfile = tmpfile(), 'test'))->is(4);
 * that(gettype($tmpfile))->is('resource (closed)'); // 閉じている
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param callable $try try ブロッククロージャ
 * @param object|resource|array ...$resources $try に渡る引数
 * @return mixed $try ブロックの返り値
 */
function try_close($callback, ...$resources)
{
    // hash to array
    foreach ($resources as $n => $resource) {
        if (is_array($resource) && is_hasharray($resource)) {
            array_splice($resources, $n, 1, iterator_to_array(arrays($resource)));
        }
    }
    // array to resource
    foreach ($resources as $n => $resource) {
        if (is_array($resource)) {
            $resources[$n] = fopen(...$resource);
        }
    }

    try {
        return $callback(...$resources);
    }
    catch (\Throwable $t) {
        // $t を設定するために catch ブロックが必要
        throw $t;
    }
    finally {
        // 逆順で閉じる（今のところあまり意味はないが C#/java もそうなってる）
        foreach (array_reverse($resources, true) as $n => $resource) {
            try {
                $names = ['close', 'free', 'dispose'];

                if (is_resource($resource)) {
                    $rtype = get_resource_type($resource);
                    if ($rtype === 'stream') {
                        fclose($resource);
                    }
                    else {
                        // fclose は stoream しか使えず、他は大抵専用の XXX_close のようなものが存在する
                        // @codeCoverageIgnoreStart
                        foreach ($names as $method) {
                            $funcname = explode(' ', $rtype)[0] . "_{$method}";
                            if (is_callable($funcname)) {
                                $funcname($resource);
                                break;
                            }
                        }
                        // @codeCoverageIgnoreEnd
                    }
                }
                if (is_object($resource)) {
                    foreach ($names as $method) {
                        if (is_callable([$resource, $method])) {
                            $resource->$method();
                            break;
                        }

                        // php8.0 からリソースから不透明クラスへの移行が進んでいる（リソースがクラスになっただけでメソッドが生えているわけではない）
                        // その変換は容易ではない（例えば↓は curl_close を想定しているが、CurlShareHandle 等のクラスもあり完全対応しない）
                        $funcname = (new \ReflectionClass($resource))->getExtension()?->getName() . "_{$method}";
                        if (is_callable($funcname)) {
                            $funcname($resource);
                            break;
                        }
                    }
                }
            }
            catch (\Throwable $t2) {
                // どうする？
                // java の try-with-resource は close 例外を握りつぶして後から getSuppressed で取得できるようになっている
                // php には getSuppressed なんてない。 previous があるが後から設定できないし設定済みかもしれないので上書きはよくない
                // 文脈的には確実に閉じたいわけなので throw することもできないし、欲しい例外は $callback 内の例外であって close の例外ではない

                // @codeCoverageIgnoreStart
                if (1 === 2) {
                    // エラー化する？（欲しいとき以外は邪魔だし例外オブジェクトとしては取得できない）
                    trigger_error($t2, E_USER_WARNING);

                    // 溜めておいて error_get_last みたいな別関数で取得できるようにする？（「握りつぶした例外をとりあえず溜めておく場所」は有用な気もする）
                    $suppressed[$n] = $t2;

                    // 直代入？ （php8.2 以降は不可能）
                    if (isset($t)) {
                        $t->suppressed = $t2;
                    }
                }
                // @codeCoverageIgnoreEnd
            }
        }
    }
}

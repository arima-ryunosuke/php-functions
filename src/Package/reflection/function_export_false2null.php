<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_maps.php';
require_once __DIR__ . '/../reflection/function_parameter.php';
require_once __DIR__ . '/../reflection/reflect_type_resolve.php';
// @codeCoverageIgnoreEnd

/**
 * 存在する関数の内、false 返しを null 返しに再定義したファイルを返す
 *
 * 標準関数は歴史的な事情で false を返すものが多い（strpos, strtotime 等）。
 * ただ大抵の場合は null の方が好ましいことが多い（int|false より ?int の方が分かりやすいし ?? を駆使できる）。
 * （`strpos(',', 'hello, world') ?? -1` みたいなことができない）。
 *
 * $false_only:false にすると存在する全関数も返す。false 返しでない関数は単純な委譲で余計なことはしない。
 * これは「strpos は nullable だから F\\strpos で、他はグローバル」という使い分けの利便性のためだが、出力数が膨大になるので留意。
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param string $namespace 吐き出す名前空間
 * @param bool $false_only false 返しのみか。false を与えると全関数を返す
 * @return string 吐き出された関数定義を含むファイル内容
 */
function function_export_false2null(string $namespace, bool $false_only = true): string
{
    $all = [];
    foreach (get_defined_functions(true) as $functions) {
        foreach ($functions as $funcname) {
            $reffunc = new \ReflectionFunction($funcname);
            $extension = (string) $reffunc->getExtensionName() ?: 'user';
            $all[$extension][$funcname] = $reffunc;
        }
    }

    $formatterOff = "@formatter:" . "off"; // 文字列的に分離しないと外側のコードまで off になる
    $contents = <<<PHP
    <?php
    /**
     * @noinspection PhpDeprecationInspection
     * @noinspection PhpUndefinedFunctionInspection
     * @noinspection PhpUndefinedConstantInspection
     */
    # Don't touch this code. This is auto generated.
    namespace $namespace;
    
    // $formatterOff
    
    PHP;
    foreach ($all as $extension => $functions) {
        $contents .= "\n# $extension\n\n";

        foreach ($functions as $funcname => $reffunc) {
            // 拡張関数で名前空間を持つ者がいる（e.g. pcov）
            if (str_contains($funcname, '\\')) {
                continue;
            }
            // assert を名前空間内に定義することはできない
            if ($funcname === 'assert') {
                continue;
            }
            // 標準関数に参照返しは存在しないはず（したとしても1文で返すのが難しいので対応しない）
            if ($reffunc->returnsReference()) {
                continue; // @codeCoverageIgnore
            }
            $return = reflect_type_resolve($reffunc->getReturnType() ?: 'mixed');
            $returns = explode('|', $return);

            $param = implode(', ', array_maps($reffunc->getParameters(), fn($p) => ($p->isVariadic() ? '...' : '') . '$' . $p->getName()));
            $args = implode(', ', function_parameter($reffunc));

            if (!in_array('null', $returns) && in_array('false', $returns)) {
                $return = str_replace('false', 'null', $return);
                $body = "return (\$result = \\{$funcname}($param)) === false ? null : \$result;";
            }
            else {
                if ($false_only) {
                    continue;
                }
                if (in_array('void', $returns)) {
                    $body = "\\{$funcname}($param);";
                }
                else {
                    $body = "return \\{$funcname}($param);";
                }
            }

            $contents .= "function $funcname({$args}):$return {{$body}}\n";
        }
    }

    return $contents;
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/class_loader.php';
require_once __DIR__ . '/../misc/evaluate.php';
require_once __DIR__ . '/../misc/php_tokens.php';
require_once __DIR__ . '/../pcre/preg_replaces.php';
require_once __DIR__ . '/../reflection/callable_code.php';
require_once __DIR__ . '/../reflection/function_parameter.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../reflection/reflect_type_resolve.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * 既存（未読み込みに限る）クラスを強制的に置換する
 *
 * 例えば継承ツリーが下記の場合を考える。
 *
 * classA <- classB <- classC
 *
 * この場合、「classC は classB に」「classB は classA に」それぞれ依存している、と考えることができる。
 * これは静的に決定的であり、この依存を壊したり注入したりする手段は存在しない。
 * 例えば classA の実装を差し替えたいときに、いかに classA を継承した classAA を定義したとしても classB の親は classA で決して変わらない。
 *
 * この関数を使うと本当に classA そのものを弄るので、継承ツリーを下記のように変えることができる。
 *
 * classA <- classAA <- classB <- classC
 *
 * つまり、classA を継承した classAA を定義してそれを classA とみなすことが可能になる。
 * ただし、内部的には class_alias を使用して実現しているので厳密には異なるクラスとなる。
 *
 * 実際のところかなり強力な機能だが、同時にかなり黒魔術的なので乱用は控えたほうがいい。
 *
 * Example:
 * ```php
 * // Y1 extends X1 だとしてクラス定義でオーバーライドする
 * class_replace('\\ryunosuke\\Test\\Package\\files\\classes\\X1', function () {
 *     // アンスコがついたクラスが定義されるので匿名クラスを返す
 *     return new class() extends \ryunosuke\Test\Package\files\classes\X1_
 *     {
 *         function method(){return 'this is X1d';}
 *         function newmethod(){return 'this is newmethod';}
 *     };
 * });
 * // X1 を継承している Y1 にまで影響が出ている（X1 を完全に置換できたということ）
 * that((new \ryunosuke\Test\Package\files\classes\Y1())->method())->isSame('this is X1d');
 * that((new \ryunosuke\Test\Package\files\classes\Y1())->newmethod())->isSame('this is newmethod');
 *
 * // Y2 extends X2 だとしてクロージャ配列でオーバーライドする
 * class_replace('\\ryunosuke\\Test\\Package\\files\classes\\X2', fn() => [
 *     'method'    => function () {return 'this is X2d';},
 *     'newmethod' => function () {return 'this is newmethod';},
 * ]);
 * // X2 を継承している Y2 にまで影響が出ている（X2 を完全に置換できたということ）
 * that((new \ryunosuke\Test\Package\files\classes\Y2())->method())->isSame('this is X2d');
 * that((new \ryunosuke\Test\Package\files\classes\Y2())->newmethod())->isSame('this is newmethod');
 *
 * // メソッド定義だけであればクロージャではなく配列指定でも可能。さらに trait 配列を渡すとそれらを use できる
 * class_replace('\\ryunosuke\\Test\\Package\\files\classes\\X3', [
 *     [\ryunosuke\Test\Package\files\classes\XTrait::class],
 *     'method' => function () {return 'this is X3d';},
 * ]);
 * // X3 を継承している Y3 にまで影響が出ている（X3 を完全に置換できたということ）
 * that((new \ryunosuke\Test\Package\files\classes\Y3())->method())->isSame('this is X3d');
 * // トレイトのメソッドも生えている
 * that((new \ryunosuke\Test\Package\files\classes\Y3())->traitMethod())->isSame('this is XTrait::traitMethod');
 *
 * // メソッドとトレイトだけならば無名クラスを渡すことでも可能
 * class_replace('\\ryunosuke\\Test\\Package\\files\classes\\X4', new class() {
 *     use \ryunosuke\Test\Package\files\classes\XTrait;
 *     function method(){return 'this is X4d';}
 * });
 * // X4 を継承している Y4 にまで影響が出ている（X4 を完全に置換できたということ）
 * that((new \ryunosuke\Test\Package\files\classes\Y4())->method())->isSame('this is X4d');
 * // トレイトのメソッドも生えている
 * that((new \ryunosuke\Test\Package\files\classes\Y4())->traitMethod())->isSame('this is XTrait::traitMethod');
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string $class 対象クラス名
 * @param \Closure|object|array $register 置換クラスを定義 or 返すクロージャ or 定義メソッド配列 or 無名クラス
 */
function class_replace($class, $register)
{
    $class = ltrim($class, '\\');

    // 読み込み済みクラスは置換できない（php はクラスのアンロード機能が存在しない）
    if (class_exists($class, false)) {
        throw new \DomainException("'$class' is already declared.");
    }

    // 対象クラス名をちょっとだけ変えたクラスを用意して読み込む
    $classfile = class_loader()->findFile($class);
    $fname = function_configure('cachedir') . '/' . rawurlencode(__FUNCTION__ . '-' . $class) . '.php';
    if (!file_exists($fname)) {
        $content = file_get_contents($classfile);
        $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
        file_put_contents($fname, $content, LOCK_EX);
    }
    require_once $fname;

    if ($register instanceof \Closure) {
        $newclass = $register();
    }
    elseif (is_object($register)) {
        $ref = new \ReflectionObject($register);
        $newclass = [class_uses($register)];
        $trait_methods = $ref->getTraitAliases();
        foreach (class_uses($register) as $trait) {
            $trait_methods += array_flip(get_class_methods($trait));
        }
        foreach ($ref->getMethods() as $method) {
            if (!isset($trait_methods[$method->getName()])) {
                $newclass[$method->getName()] = $method->isStatic() ? $method->getClosure() : $method->getClosure($register);
            }
        }
    }
    else {
        $newclass = $register;
    }

    // 無名クラス
    if (is_object($newclass)) {
        $newclass = get_class($newclass);
    }
    // 配列はメソッド定義のクロージャ配列とする
    if (is_array($newclass)) {
        $tokens = php_tokens(file_get_contents($fname));

        $begin = $tokens[0]->next(T_NAMESPACE);
        $end = $begin->next(';');
        $origspace = trim(implode('', array_column(array_slice($tokens, $begin->index + 1, $end->index - $begin->index - 1), 'text')));

        $begin = $end->next(T_CLASS);
        $end = $begin->next(T_STRING);
        $origclass = trim(implode('', array_column(array_slice($tokens, $begin->index + 1, $end->index - $begin->index + 1), 'text')));

        $classcode = '';
        foreach ($newclass as $name => $member) {
            if (is_array($member)) {
                foreach ($member as $trait) {
                    $classcode .= "use \\" . trim($trait, '\\') . ";\n";
                }
            }
            else {
                [$declare, $codeblock] = callable_code($member);
                $parentclass = new \ReflectionClass("\\$origspace\\$origclass");
                // 元クラスに定義されているならオーバーライドとして特殊な処理を行う
                if ($parentclass->hasMethod($name)) {
                    /** @var \ReflectionFunctionAbstract $refmember */
                    $refmember = reflect_callable($member);
                    $refmethod = $parentclass->getMethod($name);
                    // 指定クロージャに引数が無くて、元メソッドに有るなら継承
                    if (!$refmember->getNumberOfParameters() && $refmethod->getNumberOfParameters()) {
                        $declare = 'function (' . implode(', ', function_parameter($refmethod)) . ')';
                    }
                    // 同上。返り値版
                    if (!$refmember->hasReturnType() && $refmethod->hasReturnType()) {
                        $declare .= ':' . reflect_type_resolve($refmethod->getReturnType());
                    }
                }
                $mname = preg_replaces('#function(\\s*)\\(#u', " $name", $declare);
                $classcode .= "public $mname $codeblock\n";
            }
        }

        $newclass = "\\$origspace\\{$origclass}_";
        evaluate("namespace $origspace;\nclass {$origclass}_ extends {$origclass}\n{\n$classcode}");
    }

    class_alias($newclass, $class);
}

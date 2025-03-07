<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/php_tokens.php';
require_once __DIR__ . '/../strings/concat.php';
require_once __DIR__ . '/../strings/namespace_split.php';
require_once __DIR__ . '/../utility/json_storage.php';
// @codeCoverageIgnoreEnd

/**
 * php ファイルをパースして名前空間配列を返す
 *
 * ファイル内で use/use const/use function していたり、シンボルを定義していたりする箇所を検出して名前空間単位で返す。
 * クラスコンテキストでの解決できないシンボルはその名前空間として返す。
 * つまり、 use せずに いきなり new Hoge() などとしてもその同一名前空間の Hoge として返す。
 * これは同一名前空間であれば use せずとも使用できる php の仕様に合わせるため。
 * 対象はクラスのみであり、定数・関数は対象外。
 * use せずに hoge_function() などとしても、それが同一名前空間なのかグローバルにフォールバックされるのかは静的には決して分からないため。
 *
 * その他、#[AttributeName]や ClassName::class など、おおよそクラス名が必要とされるコンテキストでのシンボルは全て返される。
 *
 * Example:
 * ```php
 * // このような php ファイルをパースすると・・・
 * file_set_contents(sys_get_temp_dir() . '/namespace.php', '
 * <?php
 * namespace NS1;
 * use ArrayObject as AO;
 * use function strlen as SL;
 * function InnerFunc(){}
 * class InnerClass{}
 * define("OUTER\\\\CONST", "OuterConst");
 *
 * namespace NS2;
 * use RuntimeException as RE;
 * use const COUNT_RECURSIVE as CR;
 * class InnerClass{}
 * const InnerConst = 123;
 *
 * // いきなり Hoge を new してみる
 * new Hoge();
 * ');
 * // このような名前空間配列が得られる
 * that(namespace_parse(sys_get_temp_dir() . '/namespace.php'))->isSame([
 *     'NS1' => [
 *         'const'    => [],
 *         'function' => [
 *             'SL'        => 'strlen',
 *             'InnerFunc' => 'NS1\\InnerFunc',
 *         ],
 *         'alias'    => [
 *             'AO'         => 'ArrayObject',
 *             'InnerClass' => 'NS1\\InnerClass',
 *         ],
 *     ],
 *     'OUTER' => [
 *         'const'    => [
 *             'CONST' => 'OUTER\\CONST',
 *         ],
 *         'function' => [],
 *         'alias'    => [],
 *     ],
 *     'NS2' => [
 *         'const'    => [
 *             'CR'         => 'COUNT_RECURSIVE',
 *             'InnerConst' => 'NS2\\InnerConst',
 *         ],
 *         'function' => [],
 *         'alias'    => [
 *             'RE'         => 'RuntimeException',
 *             'InnerClass' => 'NS2\\InnerClass',
 *             'Hoge'       => 'NS2\\Hoge', // 同一名前空間として返される
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $filename ファイル名
 * @param array $options オプション配列
 * @return array 名前空間配列
 */
function namespace_parse($filename, $options = [])
{
    $filename = realpath($filename);
    $filemtime = filemtime($filename);
    $options += [
        'cache' => null,
    ];

    $storage = json_storage(__FUNCTION__);

    $storage['mtime'] ??= $filemtime;
    $options['cache'] ??= $storage['mtime'] >= $filemtime;
    if (!$options['cache']) {
        unset($storage['mtime']);
        unset($storage[$filename]);
    }
    return $storage[$filename] ??= (function () use ($filename) {
        $namespace = '';
        $classend = null;

        $tokens = php_tokens(file_get_contents($filename));
        $token = $tokens[0];

        $T_ENUM = defined('T_ENUM') ? T_ENUM : -1; // for compatible
        $result = [];
        while (true) {
            $token = $token->next(["define", T_NAMESPACE, T_USE, T_CONST, T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT, $T_ENUM, T_EXTENDS, T_IMPLEMENTS, T_ATTRIBUTE, T_NAME_QUALIFIED, T_STRING]);
            if ($token === null) {
                break;
            }
            if ($classend !== null && $token->index >= $classend) {
                $classend = null;
            }

            // define は現在の名前空間とは無関係に名前空間定数を宣言することができる
            if ($token->is(T_STRING) && $token->is("define")) {
                // ただし実行されないと定義されないので class 内は無視
                if ($classend !== null) {
                    continue;
                }

                // しかも変数が使えたりして静的には決まらないので "" or '' のみとする
                $token = $token->next([T_CONSTANT_ENCAPSED_STRING, ',']);
                if ($token->is(T_CONSTANT_ENCAPSED_STRING)) {
                    $define = trim(stripslashes(substr($token, 1, -1)), '\\');
                    [$ns, $nm] = namespace_split($define);
                    $result[$ns] ??= [
                        'const'    => [],
                        'function' => [],
                        'alias'    => [],
                    ];
                    $result[$ns]['const'][$nm] = $define;
                }
            }
            // 識別子。多岐に渡るので文脈を見て無視しなければならない
            if ($token->is(T_STRING)) {
                if ($token->prev()->is([
                    T_OBJECT_OPERATOR,          // $object->member
                    T_NULLSAFE_OBJECT_OPERATOR, // $object?->member
                    T_CONST,                    // const CONST = 'dummy'
                    T_GOTO,                     // goto LABEL
                ])) {
                    continue;
                }
                // hoge_function(named: $argument)
                if ($token->next()->is(':')) {
                    continue;
                }
                // hoge_function()
                if (!$token->prev()->is(T_NEW) && $token->next()->is('(')) {
                    continue;
                }
                if ($token->is([
                    // typehint
                    ...['never', 'void', 'null', 'false', 'true', 'bool', 'int', 'float', 'string', 'object', 'iterable', 'mixed'],
                    // specials
                    ...['self', 'static', 'parent'],
                ])) {
                    continue;
                }
                if (defined($token->text)) {
                    continue;
                }

                if (false
                    || $token->prev()->is(T_NEW)           // new ClassName
                    || $token->prev()->is(':')             // function method(): ClassName
                    || $token->next()->is(T_VARIABLE)      // ClassName $argument
                    || $token->next()->is(T_DOUBLE_COLON)  // ClassName::CONSTANT
                ) {
                    $result[$namespace]['alias'][$token->text] ??= concat($namespace, '\\') . $token->text;
                }
            }
            // T_STRING とほぼ同じ（修飾版）。T_NAME_QUALIFIED である時点で Space\Name であることはほぼ確定だがいくつか除外するものがある
            if ($token->is(T_NAME_QUALIFIED)) {
                // hoge_function()
                if (!$token->prev()->is(T_NEW) && $token->next()->is('(')) {
                    continue;
                }
                // 最近の php は標準でも名前空間を持つものがあるので除外しておく
                if (defined($token->text)) {
                    continue;
                }
                $result[$namespace]['alias'][$token->text] ??= concat($namespace, '\\') . $token->text;
            }
            if ($token->is(T_NAMESPACE)) {
                $token = $token->next();
                $namespace = $token->text;
                $result[$namespace] = [
                    'const'    => [],
                    'function' => [],
                    'alias'    => [],
                ];
            }
            if ($token->is(T_USE)) {
                // function () **use** ($var) {...}
                if ($token->prev()?->is(')')) {
                    continue;
                }
                // class {**use** Trait;}
                if ($classend !== null) {
                    while (!$token->is(['{', ';'])) {
                        $token = $token->next(['{', ';', ',']);
                        if (!$token->prev()->is(T_NAME_FULLY_QUALIFIED)) {
                            $result[$namespace]['alias'][$token->prev()->text] ??= concat($namespace, '\\') . $token->prev()->text;
                        }
                    }
                    continue;
                }

                $next = $token->next();
                $key = 'alias';
                if ($next->is(T_CONST)) {
                    $key = 'const';
                    $token = $next;
                }
                if ($next->is(T_FUNCTION)) {
                    $key = 'function';
                    $token = $next;
                }

                $token = $token->next();
                $qualified = trim($token->text, '\\');

                $next = $token->next();
                if ($next->is(T_NS_SEPARATOR)) {
                    while (!$token->is('}')) {
                        $token = $token->next(['}', ',', T_AS]);
                        if ($token->is(T_AS)) {
                            $qualified2 = $qualified . "\\" . $token->prev()->text;
                            $result[$namespace][$key][$token->next()->text] = $qualified2;
                            $token = $token->next()->next();
                        }
                        else {
                            $qualified2 = $qualified . "\\" . $token->prev()->text;
                            $result[$namespace][$key][namespace_split($qualified2)[1]] = $qualified2;
                        }
                    }
                }
                elseif ($next->is(T_AS)) {
                    $token = $next->next();
                    $result[$namespace][$key][$token->text] = $qualified;
                }
                else {
                    $result[$namespace][$key][namespace_split($qualified)[1]] = $qualified;
                }
            }
            if ($token->is([T_CLASS, T_TRAIT, T_INTERFACE, $T_ENUM])) {
                // class ClassName {...}, $anonymous = new class() {...}
                if ($token->next()->is(T_STRING) || $token->prev()->is(T_NEW) || $token->prev(T_ATTRIBUTE)?->prev()->is(T_NEW)) {
                    // new class {}, new class(new class {}) {}
                    $next = $token->next(['{', '(']);
                    if ($next->is('(')) {
                        $next = $next->end()->next('{');
                    }
                    $classend = max($classend ?? -1, $next->end()->index);
                }
                // class ClassName
                if ($token->next()->is(T_STRING)) {
                    $result[$namespace]['alias'][$token->next()->text] = concat($namespace, '\\') . $token->next()->text;
                }
            }
            if ($token->is(T_EXTENDS)) {
                while (!$token->is([T_IMPLEMENTS, '{'])) {
                    $token = $token->next([T_IMPLEMENTS, '{', ',']);
                    if (!$token->prev()->is(T_NAME_FULLY_QUALIFIED)) {
                        $result[$namespace]['alias'][$token->prev()->text] ??= concat($namespace, '\\') . $token->prev()->text;
                    }
                }
            }
            if ($token->is(T_IMPLEMENTS)) {
                while (!$token->is(['{'])) {
                    $token = $token->next(['{', ',']);
                    if (!$token->prev()->is(T_NAME_FULLY_QUALIFIED)) {
                        $result[$namespace]['alias'][$token->prev()->text] ??= concat($namespace, '\\') . $token->prev()->text;
                    }
                }
            }
            if ($token->is(T_CONST)) {
                // class {**const** HOGE=1;}
                if ($classend !== null) {
                    continue;
                }
                $result[$namespace]['const'][$token->next()->text] ??= concat($namespace, '\\') . $token->next()->text;
            }
            if ($token->is(T_FUNCTION)) {
                // class {**function** hoge() {}}
                if ($classend !== null) {
                    continue;
                }
                // $closure = function () {};
                if ($token->next()->is('(')) {
                    continue;
                }
                $result[$namespace]['function'][$token->next()->text] ??= concat($namespace, '\\') . $token->next()->text;
            }
            if ($token->is(T_ATTRIBUTE)) {
                $token = $token->next([T_NAME_FULLY_QUALIFIED, T_NAME_QUALIFIED, T_STRING]);
                if (!$token->is(T_NAME_FULLY_QUALIFIED)) {
                    $result[$namespace]['alias'][$token->text] ??= concat($namespace, '\\') . $token->text;
                }
            }
        }

        return $result;
    })();
}

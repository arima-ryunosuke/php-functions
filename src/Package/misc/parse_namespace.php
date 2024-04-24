<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_explode.php';
require_once __DIR__ . '/../array/array_find.php';
require_once __DIR__ . '/../array/last_key.php';
require_once __DIR__ . '/../misc/parse_php.php';
require_once __DIR__ . '/../strings/concat.php';
require_once __DIR__ . '/../strings/namespace_split.php';
require_once __DIR__ . '/../utility/cache.php';
// @codeCoverageIgnoreEnd

/**
 * php ファイルをパースして名前空間配列を返す
 *
 * ファイル内で use/use const/use function していたり、シンボルを定義していたりする箇所を検出して名前空間単位で返す。
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
 * ');
 * // このような名前空間配列が得られる
 * that(parse_namespace(sys_get_temp_dir() . '/namespace.php'))->isSame([
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
function parse_namespace($filename, $options = [])
{
    $filename = realpath($filename);
    $filemtime = filemtime($filename);
    $options += [
        'cache' => null,
    ];
    if ($options['cache'] === null) {
        $options['cache'] = cache($filename, fn() => $filemtime, 'filemtime') >= $filemtime;
    }
    if (!$options['cache']) {
        cache($filename, null, 'filemtime');
        cache($filename, null, __FUNCTION__);
    }
    return cache($filename, function () use ($filename) {
        $stringify = function ($tokens) {
            return trim(implode('', array_column(array_filter($tokens, function ($token) {
                return in_array($token[0], [T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_NAME_RELATIVE, T_STRING], true);
            }), 1)), '\\');
        };

        $keys = [
            0           => 'alias', // for use
            T_CLASS     => 'alias',
            T_INTERFACE => 'alias',
            T_TRAIT     => 'alias',
            T_STRING    => 'const', // for define
            T_CONST     => 'const',
            T_FUNCTION  => 'function',
        ];

        $contents = "?>" . file_get_contents($filename);
        $namespace = '';
        $tokens = [-1 => null];
        $result = [];
        while (true) {
            $tokens = parse_php($contents, [
                'flags'  => TOKEN_PARSE,
                'begin'  => ["define", T_NAMESPACE, T_USE, T_CONST, T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT],
                'end'    => ['{', ';', '(', T_EXTENDS, T_IMPLEMENTS],
                'offset' => last_key($tokens) + 1,
            ]);
            if (!$tokens) {
                break;
            }
            $token = reset($tokens);
            // define は現在の名前空間とは無関係に名前空間定数を宣言することができる
            if ($token[0] === T_STRING && $token[1] === "define") {
                $tokens = parse_php($contents, [
                    'flags'  => TOKEN_PARSE,
                    'begin'  => [T_CONSTANT_ENCAPSED_STRING],
                    'end'    => [T_CONSTANT_ENCAPSED_STRING],
                    'offset' => last_key($tokens),
                ]);
                $cname = substr(implode('', array_column($tokens, 1)), 1, -1);
                $define = trim(json_decode("\"$cname\""), '\\');
                [$ns, $nm] = namespace_split($define);
                if (!isset($result[$ns])) {
                    $result[$ns] = [
                        'const'    => [],
                        'function' => [],
                        'alias'    => [],
                    ];
                }
                $result[$ns][$keys[$token[0]]][$nm] = $define;
            }
            switch ($token[0]) {
                case T_NAMESPACE:
                    $namespace = $stringify($tokens);
                    $result[$namespace] = [
                        'const'    => [],
                        'function' => [],
                        'alias'    => [],
                    ];
                    break;
                case T_USE:
                    $tokenCorF = array_find($tokens, fn($token) => ($token[0] === T_CONST || $token[0] === T_FUNCTION) ? $token[0] : 0, false);

                    $prefix = '';
                    if (end($tokens)[1] === '{') {
                        $prefix = $stringify($tokens);
                        $tokens = parse_php($contents, [
                            'flags'  => TOKEN_PARSE,
                            'begin'  => ['{'],
                            'end'    => ['}'],
                            'offset' => last_key($tokens),
                        ]);
                    }

                    $multi = array_explode($tokens, fn($token) => $token[1] === ',');
                    foreach ($multi as $ttt) {
                        $as = array_explode($ttt, fn($token) => $token[0] === T_AS);

                        $alias = $stringify($as[0]);
                        if (isset($as[1])) {
                            $result[$namespace][$keys[$tokenCorF]][$stringify($as[1])] = concat($prefix, '\\') . $alias;
                        }
                        else {
                            $result[$namespace][$keys[$tokenCorF]][namespace_split($alias)[1]] = concat($prefix, '\\') . $alias;
                        }
                    }
                    break;
                case T_CONST:
                case T_FUNCTION:
                case T_CLASS:
                case T_INTERFACE:
                case T_TRAIT:
                    $alias = $stringify($tokens);
                    if (strlen($alias)) {
                        $result[$namespace][$keys[$token[0]]][$alias] = concat($namespace, '\\') . $alias;
                    }
                    // ブロック内に興味はないので進めておく（function 内 function などはあり得るが考慮しない）
                    if ($token[0] !== T_CONST) {
                        $tokens = parse_php($contents, [
                            'flags'  => TOKEN_PARSE,
                            'begin'  => ['{'],
                            'end'    => ['}'],
                            'offset' => last_key($tokens),
                        ]);
                        break;
                    }
            }
        }
        return $result;
    }, __FUNCTION__);
}

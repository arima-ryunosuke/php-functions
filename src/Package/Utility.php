<?php

namespace ryunosuke\Functions\Package;

/**
 * 汎用的なユーティリティ
 */
class Utility
{
    /**
     * $_FILES の構造を組み替えて $_POST などと同じにする
     *
     * $_FILES の配列構造はバグとしか思えないのでそれを是正する関数。
     * 第1引数 $files は指定可能だが、大抵は $_FILES であり、指定するのはテスト用。
     *
     * サンプルを書くと長くなるので例は{@source \ryunosuke\Test\Package\UtilityTest::test_get_uploaded_files() テストファイル}を参照。
     *
     * @param ?array $files $_FILES の同じ構造の配列。省略時は $_FILES
     * @return array $_FILES を $_POST などと同じ構造にした配列
     */
    public static function get_uploaded_files($files = null)
    {
        $result = [];
        foreach (($files ?: $_FILES) as $name => $file) {
            if (is_array($file['name'])) {
                $file = (get_uploaded_files)((array_each)($file['name'], function (&$carry, $dummy, $subkey) use ($file) {
                    $carry[$subkey] = (array_lookup)($file, $subkey);
                }, []));
            }
            $result[$name] = $file;
        }
        return $result;
    }

    /**
     * 連続した数値の配列を縮めて返す
     *
     * 例えば `[1, 2, 4, 6, 7, 9]` が `['1~2', 4, '6~7', 9]` になる。
     * 結合法則は指定可能（上記は "~" を指定したもの）。
     * null を与えると配列の配列で返すことも可能。
     *
     * Example:
     * ```php
     * // 単純に文字列指定
     * that(number_serial([1, 2, 4, 6, 7, 9], 1, '~'))->is(['1~2', 4, '6~7', 9]);
     * // null を与えると from, to の配列で返す
     * that(number_serial([1, 2, 4, 6, 7, 9], 1, null))->is([[1, 2], [4, 4], [6, 7], [9, 9]]);
     * // $step は負数・小数・逆順も対応している（正負でよしなにソートされる）
     * that(number_serial([-9, 0.2, 0.5, -0.3, 0.1, 0, -0.2, 9], -0.1, '~'))->is([9, 0.5, '0.2~0', '-0.2~-0.3', -9]);
     * ```
     *
     * @param iterable|array $numbers 数値配列
     * @param int|float $step 連続とみなすステップ。負数を指定すれば逆順指定にも使える
     * @param string|null|\Closure $separator 連続列を結合する文字列（string: 文字結合、null: 配列、Closure: 2引数が渡ってくる）
     * @param bool $doSort ソートをするか否か。事前にソート済みであることが明らかであれば false の方が良い
     * @return array 連続値をまとめた配列
     */
    public static function number_serial($numbers, $step = 1, $separator = null, $doSort = true)
    {
        $precision = ini_get('precision');
        $step = $step + 0;

        if ($doSort) {
            $numbers = (kvsort)($numbers, $step < 0 ? -SORT_NUMERIC : SORT_NUMERIC);
        }

        $build = function ($from, $to) use ($separator, $precision) {
            if ($separator instanceof \Closure) {
                return $separator($from, $to);
            }
            if ((varcmp)($from, $to, SORT_NUMERIC, $precision) === 0) {
                if ($separator === null) {
                    return [$from, $to];
                }
                return $from;
            }
            elseif ($separator === null) {
                return [$from, $to];
            }
            else {
                return $from . $separator . $to;
            }
        };

        $result = [];
        foreach ($numbers as $k => $number) {
            $number = $number + 0;
            if (!isset($from, $to)) {
                $from = $to = $number;
                continue;
            }
            if ((varcmp)($to + $step, $number, SORT_NUMERIC, $precision) !== 0) {
                $result[] = $build($from, $to);
                $from = $number;
            }
            $to = $number;
        }
        if (isset($from, $to)) {
            $result[] = $build($from, $to);
        }

        return $result;
    }

    /**
     * 本ライブラリで使用するキャッシュディレクトリを設定する
     *
     * @param string|null $dirname キャッシュディレクトリ。省略時は返すのみ
     * @return string 設定前のキャッシュディレクトリ
     */
    public static function cachedir($dirname = null)
    {
        static $cachedir;
        if ($cachedir === null) {
            $cachedir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . strtr(__NAMESPACE__, ['\\' => '%']);
            (cachedir)($cachedir); // for mkdir
        }

        if ($dirname === null) {
            return $cachedir;
        }

        if (!file_exists($dirname)) {
            @mkdir($dirname, 0777 & (~umask()), true);
        }
        $result = $cachedir;
        $cachedir = realpath($dirname);
        return $result;
    }

    /**
     * シンプルにキャッシュする
     *
     * この関数は get/set/delete を兼ねる。
     * キャッシュがある場合はそれを返し、ない場合は $provider を呼び出してその結果をキャッシュしつつそれを返す。
     *
     * $provider に null を与えるとキャッシュの削除となる。
     *
     * Example:
     * ```php
     * $provider = function(){return rand();};
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * that($rand1)->isSame($rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * that($rand1)->isNotSame($rand3);
     * ```
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param ?string $namespace 名前空間
     * @return mixed キャッシュ
     */
    public static function cache($key, $provider, $namespace = null)
    {
        static $cacheobject;
        $cacheobject = $cacheobject ?? new class((cachedir)()) {
                const CACHE_EXT = '.php-cache';

                /** @var string キャッシュディレクトリ */
                private $cachedir;

                /** @var array 内部キャッシュ */
                private $cache;

                /** @var array 変更感知配列 */
                private $changed;

                public function __construct($cachedir)
                {
                    $this->cachedir = $cachedir;
                    $this->cache = [];
                    $this->changed = [];
                }

                public function __destruct()
                {
                    // 変更されているもののみ保存
                    foreach ($this->changed as $namespace => $dummy) {
                        $filepath = $this->cachedir . '/' . rawurlencode($namespace) . self::CACHE_EXT;
                        $content = "<?php\nreturn " . var_export($this->cache[$namespace], true) . ";\n";

                        $temppath = tempnam(sys_get_temp_dir(), 'cache');
                        if (file_put_contents($temppath, $content) !== false) {
                            @chmod($temppath, 0644);
                            if (!@rename($temppath, $filepath)) {
                                @unlink($temppath);
                            }
                        }
                    }
                }

                public function has($namespace, $key)
                {
                    // ファイルから読み込む必要があるので get しておく
                    $this->get($namespace, $key);
                    return array_key_exists($key, $this->cache[$namespace]);
                }

                public function get($namespace, $key)
                {
                    // 名前空間自体がないなら作る or 読む
                    if (!isset($this->cache[$namespace])) {
                        $nsarray = [];
                        $cachpath = $this->cachedir . '/' . rawurldecode($namespace) . self::CACHE_EXT;
                        if (file_exists($cachpath)) {
                            $nsarray = require $cachpath;
                        }
                        $this->cache[$namespace] = $nsarray;
                    }

                    return $this->cache[$namespace][$key] ?? null;
                }

                public function set($namespace, $key, $value)
                {
                    // 新しい値が来たら変更フラグを立てる
                    if (!isset($this->cache[$namespace]) || !array_key_exists($key, $this->cache[$namespace]) || $this->cache[$namespace][$key] !== $value) {
                        $this->changed[$namespace] = true;
                    }

                    $this->cache[$namespace][$key] = $value;
                }

                public function delete($namespace, $key)
                {
                    $this->changed[$namespace] = true;
                    unset($this->cache[$namespace][$key]);
                }

                public function clear()
                {
                    // インメモリ情報をクリアして・・・
                    $this->cache = [];
                    $this->changed = [];

                    // ファイルも消す
                    foreach (glob($this->cachedir . '/*' . self::CACHE_EXT) as $file) {
                        unlink($file);
                    }
                }
            };

        // flush (for test)
        if ($key === null) {
            if ($provider === null) {
                $cacheobject->clear();
            }
            $cacheobject = null;
            return;
        }

        $namespace = $namespace ?? __FILE__;

        $exist = $cacheobject->has($namespace, $key);
        if ($provider === null) {
            $cacheobject->delete($namespace, $key);
            return $exist;
        }
        if (!$exist) {
            $cacheobject->set($namespace, $key, $provider());
        }
        return $cacheobject->get($namespace, $key);
    }

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
     * @param string $filename ファイル名
     * @return array 名前空間配列
     */
    public static function parse_namespace($filename)
    {
        return (cache)(realpath($filename), function () use ($filename) {
            $stringify = function ($tokens) {
                return trim(implode('', array_column(array_filter($tokens, function ($token) {
                    return $token[0] === T_NS_SEPARATOR || $token[0] === T_STRING;
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
                $tokens = (parse_php)($contents, [
                    'flags'  => TOKEN_PARSE,
                    'begin'  => [T_NAMESPACE, T_USE, T_STRING, T_CONST, T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT],
                    'end'    => ['{', ';', '(', T_EXTENDS, T_IMPLEMENTS],
                    'offset' => (last_key)($tokens) + 1,
                ]);
                if (!$tokens) {
                    break;
                }
                $token = reset($tokens);
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
                        $tokenCorF = (array_find)($tokens, function ($token) {
                            return ($token[0] === T_CONST || $token[0] === T_FUNCTION) ? $token[0] : 0;
                        }, false);

                        $prefix = '';
                        if (end($tokens)[1] === '{') {
                            $prefix = $stringify($tokens);
                            $tokens = (parse_php)($contents, [
                                'flags'  => TOKEN_PARSE,
                                'begin'  => ['{'],
                                'end'    => ['}'],
                                'offset' => (last_key)($tokens),
                            ]);
                        }

                        $multi = (array_explode)($tokens, function ($token) { return $token[1] === ','; });
                        foreach ($multi as $ttt) {
                            $as = (array_explode)($ttt, function ($token) { return $token[0] === T_AS; });

                            $alias = $stringify($as[0]);
                            if (isset($as[1])) {
                                $result[$namespace][$keys[$tokenCorF]][$stringify($as[1])] = (concat)($prefix, '\\') . $alias;
                            }
                            else {
                                $result[$namespace][$keys[$tokenCorF]][(namespace_split)($alias)[1]] = (concat)($prefix, '\\') . $alias;
                            }
                        }
                        break;
                    case T_STRING:
                        // define は現在の名前空間とは無関係に名前空間定数を宣言することができる
                        if (strtolower($token[1]) === 'define') {
                            $tokens = (parse_php)($contents, [
                                'flags'  => TOKEN_PARSE,
                                'begin'  => [T_CONSTANT_ENCAPSED_STRING],
                                'end'    => [T_CONSTANT_ENCAPSED_STRING],
                                'offset' => (last_key)($tokens),
                            ]);
                            $define = trim(json_decode(implode('', array_column($tokens, 1))), '\\');
                            [$ns, $nm] = (namespace_split)($define);
                            $result[$ns][$keys[$token[0]]][$nm] = $define;
                        }
                        break;
                    case T_CONST:
                    case T_FUNCTION:
                    case T_CLASS:
                    case T_INTERFACE:
                    case T_TRAIT:
                        $alias = $stringify($tokens);
                        if (strlen($alias)) {
                            $result[$namespace][$keys[$token[0]]][$alias] = (concat)($namespace, '\\') . $alias;
                        }
                        // ブロック内に興味はないので進めておく（function 内 function などはあり得るが考慮しない）
                        if ($token[0] !== T_CONST) {
                            $tokens = (parse_php)($contents, [
                                'flags'  => TOKEN_PARSE,
                                'begin'  => ['{'],
                                'end'    => ['}'],
                                'offset' => (last_key)($tokens),
                            ]);
                            break;
                        }
                }
            }
            return $result;
        }, __FUNCTION__);
    }

    /**
     * エイリアス名を完全修飾名に解決する
     *
     * 例えばあるファイルのある名前空間で `use Hoge\Fuga\Piyo;` してるときの `Piyo` を `Hoge\Fuga\Piyo` に解決する。
     *
     * Example:
     * ```php
     * // このような php ファイルがあるとして・・・
     * file_set_contents(sys_get_temp_dir() . '/symbol.php', '
     * <?php
     * namespace vendor\NS;
     *
     * use ArrayObject as AO;
     * use function strlen as SL;
     *
     * function InnerFunc(){}
     * class InnerClass{}
     * ');
     * // 下記のように解決される
     * that(resolve_symbol('AO', sys_get_temp_dir() . '/symbol.php'))->isSame('ArrayObject');
     * that(resolve_symbol('SL', sys_get_temp_dir() . '/symbol.php'))->isSame('strlen');
     * that(resolve_symbol('InnerFunc', sys_get_temp_dir() . '/symbol.php'))->isSame('vendor\\NS\\InnerFunc');
     * that(resolve_symbol('InnerClass', sys_get_temp_dir() . '/symbol.php'))->isSame('vendor\\NS\\InnerClass');
     * ```
     *
     * @param string $shortname エイリアス名
     * @param string|array $nsfiles ファイル名 or [ファイル名 => 名前空間名]
     * @param array $targets エイリアスタイプ（'const', 'function', 'alias' のいずれか）
     * @return string|null 完全修飾名。解決できなかった場合は null
     */
    public static function resolve_symbol(string $shortname, $nsfiles, $targets = ['const', 'function', 'alias'])
    {
        // 既に完全修飾されている場合は何もしない
        if (($shortname[0] ?? null) === '\\') {
            return $shortname;
        }

        // use Inner\Space のような名前空間の use の場合を考慮する
        $parts = explode('\\', $shortname, 2);
        $prefix = isset($parts[1]) ? array_shift($parts) : null;

        if (is_string($nsfiles)) {
            $nsfiles = [$nsfiles => []];
        }

        $targets = (array) $targets;
        foreach ($nsfiles as $filename => $namespaces) {
            $namespaces = array_flip(array_map(function ($n) { return trim($n, '\\'); }, (array) $namespaces));
            foreach ((parse_namespace)($filename) as $namespace => $ns) {
                if (!$namespaces || isset($namespaces[$namespace])) {
                    if (isset($ns['alias'][$prefix])) {
                        return $ns['alias'][$prefix] . '\\' . implode('\\', $parts);
                    }
                    foreach ($targets as $target) {
                        if (isset($ns[$target][$shortname])) {
                            return $ns[$target][$shortname];
                        }
                    }
                }
            }
        }
        return null;
    }

    /**
     * アノテーションっぽい文字列をそれっぽくパースして返す
     *
     * $annotation にはリフレクションオブジェクトも渡せる。
     * その場合、getDocComment や getFilename, getNamespaceName などを用いてある程度よしなに名前解決する。
     * もっとも、@Class(args) 形式を使わないのであれば特に意味はない。
     *
     * $schame で「どのように取得するか？」のスキーマ定義が渡せる。
     * ただし、現実装では「そのまま文字列で返すか？」の bool 値とクロージャしか渡すことはできない。
     *
     * アノテーションの仕様は下記（すべて $schema が false であるとする）。
     *
     * - @から行末まで（1行に複数のアノテーションは含められない）
     *     - ただし行末が `({[` のいずれかであれば次の `]})` までブロックを記載する機会が与えられる
     *     - ブロックを見つけたときは本来値となるべき値がキーに、ブロックが値となり、結果は必ず配列化される
     * - 同じアノテーションを複数見つけたときは配列化される
     * - `@hogera`: 値なしは null を返す
     * - `@hogera v1 "v2 v3"`: ["v1", "v2 v3"] という配列として返す
     * - `@hogera {key: 123}`: ["key" => 123] という（連想）配列として返す
     * - `@hogera [123, 456]`: [123, 456] という連番配列として返す
     * - `@hogera ("2019/12/23")`: hogera で解決できるクラス名で new して返す（$filename 引数の指定が必要）
     * - 下3つの形式はアノテーション区切りのスペースはあってもなくても良い
     *
     * $schema が true だと上記のような変換は一切行わず、素朴な文字列で返す。
     * あくまで簡易実装であり、本格的に何かをしたいなら専用のパッケージを導入したほうが良い。
     *
     * Example:
     * ```php
     * $annotations = parse_annotation('
     * 冒頭の - に意味はない
     * - @noval
     * - @single this is value
     * - @closure this is value
     * - @array this is value
     * - @hash {key: 123}
     * - @list [1, 2, 3]
     * - @ArrayObject([1, 2, 3])
     * - @block message {
     *       this is message1
     *       this is message2
     *   }
     * - @same this is same value1
     * - @same this is same value2
     * - @same this is same value3
     * ', [
     *     'single'  => true,
     *     'closure' => function ($value) { return explode(' ', strtoupper($value)); },
     * ]);
     * that($annotations)->is([
     *     'noval'       => null,                        // 値なしは null になる
     *     'single'      => 'this is value',             // $schema 指定してるので文字列になる
     *     'closure'     => ['THIS', 'IS', 'VALUE'],     // $schema 指定してそれがクロージャだとコールバックされる
     *     'array'       => ['this', 'is', 'value'],     // $schema 指定していないので配列になる
     *     'hash'        => ['key' => '123'],            // 連想配列になる
     *     'list'        => [1, 2, 3],                   // 連番配列になる
     *     'ArrayObject' => new \ArrayObject([1, 2, 3]), // new されてインスタンスになる
     *     "block"       => [                            // ブロックはブロック外をキーとした連想配列になる（複数指定でキーは指定できるイメージ）
     *         "message" => ["this is message1\n      this is message2"],
     *     ],
     *     'same'        => [                            // 複数あるのでそれぞれの配列になる
     *         ['this', 'is', 'same', 'value1'],
     *         ['this', 'is', 'same', 'value2'],
     *         ['this', 'is', 'same', 'value3'],
     *     ],
     * ]);
     * ```
     *
     * @param string|\Reflector $annotation アノテーション文字列
     * @param array|mixed $schema スキーマ定義
     * @param string|array $nsfiles ファイル名 or [ファイル名 => 名前空間名]
     * @return array アノテーション配列
     */
    public static function parse_annotation($annotation, $schema = [], $nsfiles = [])
    {
        if ($annotation instanceof \Reflector) {
            $reflector = $annotation;
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $annotation = $reflector->getDocComment();

            // クラスメンバーリフレクションは getDeclaringClass しないと名前空間が取れない
            if (false
                || $reflector instanceof \ReflectionClassConstant
                || $reflector instanceof \ReflectionProperty
                || $reflector instanceof \ReflectionMethod
            ) {
                $reflector = $reflector->getDeclaringClass();
            }

            // 無名クラスに名前空間という概念はない（無くはないが普通に想起される名前空間ではない）
            $namespaces = [];
            if (!($reflector instanceof \ReflectionClass && $reflector->isAnonymous())) {
                $namespaces[] = $reflector->getNamespaceName();
            }
            $nsfiles[$reflector->getFileName()] = $nsfiles[$reflector->getFileName()] ?? $namespaces;

            // doccomment 特有のインデントを削除する
            $annotation = preg_replace('#(\\R)\\s+\\*\s#ui', '$1', $annotation);
        }

        $result = [];
        $multiples = [];

        for ($i = 0, $l = strlen($annotation); $i < $l; $i++) {
            $i = (strpos_quoted)($annotation, '@', $i);
            if ($i === false) {
                break;
            }

            $seppos = min((strpos_array)($annotation, [" ", "\t", "\n", '[', '{', '('], $i + 1) ?: [false]);
            $name = substr($annotation, $i + 1, $seppos - $i - 1);
            $i += strlen($name);
            $name = trim($name);

            $key = null;
            $value = '';
            if ($annotation[$seppos] !== "\n") {
                $endpos = (strpos_quoted)($annotation, "\n", $seppos);
                $prev = $endpos - 1;
                $brace = [
                    '(' => ')',
                    '{' => '}',
                    '[' => ']',
                ];
                if (isset($brace[$annotation[$prev]])) {
                    $s = $annotation[$prev];
                    $e = $brace[$s];
                    $endpos--;
                    $key = trim(substr($annotation, $seppos, $endpos - $seppos));
                    $value = $s . (str_between)($annotation, $s, $e, $endpos) . $e;
                    $i = $endpos;
                }
                else {
                    $value = substr($annotation, $seppos, $endpos - $seppos);
                    $i += strlen($value);
                    $value = trim($value);
                }
            }

            $rawmode = $schema;
            if (is_array($rawmode)) {
                $rawmode = array_key_exists($name, $rawmode) ? $rawmode[$name] : false;
            }
            if ($rawmode instanceof \Closure) {
                $value = $rawmode($value, $key);
            }
            elseif ($rawmode) {
                if (is_string($key)) {
                    $value = substr($value, 1, -1);
                }
            }
            else {
                if ($value === '') {
                    $value = null;
                }
                elseif (in_array($value[0] ?? null, ['('], true)) {
                    $class = (resolve_symbol)($name, $nsfiles, 'alias') ?? $name;
                    $value = new $class(...(paml_import)(substr($value, 1, -1)));
                }
                elseif (in_array($value[0] ?? null, ['{', '['], true)) {
                    $value = (array) (paml_import)($value)[0];
                }
                else {
                    $value = array_values(array_filter((quoteexplode)([" ", "\t", "\n"], $value), "strlen"));
                }
            }

            if (array_key_exists($name, $result) && !isset($multiples[$name])) {
                $multiples[$name] = true;
                $result[$name] = [$result[$name]];
            }
            if (strlen($key)) {
                $multiples[$name] = true;
                $result[$name][$key] = $value;
            }
            elseif (isset($multiples[$name])) {
                $result[$name][] = $value;
            }
            else {
                $result[$name] = $value;
            }
        }

        return $result;
    }

    /**
     * リソースが ansi color に対応しているか返す
     *
     * パイプしたりリダイレクトしていると false を返す。
     *
     * @see https://github.com/symfony/console/blob/v4.2.8/Output/StreamOutput.php#L98
     *
     * @param resource $stream 調べるリソース
     * @return bool ansi color に対応しているなら true
     */
    public static function is_ansi($stream)
    {
        // テスト用に隠し引数で DS を取っておく
        $DIRECTORY_SEPARATOR = DIRECTORY_SEPARATOR;
        assert(!!$DIRECTORY_SEPARATOR = func_num_args() > 1 ? func_get_arg(1) : $DIRECTORY_SEPARATOR);

        if ('Hyper' === getenv('TERM_PROGRAM')) {
            return true;
        }

        if ($DIRECTORY_SEPARATOR === '\\') {
            return (\function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support($stream))
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        return @stream_isatty($stream);
    }

    /**
     * 文字列に ANSI Color エスケープシーケンスを埋め込む
     *
     * - "blue" のような小文字色名は文字色
     * - "BLUE" のような大文字色名は背景色
     * - "bold" のようなスタイル名は装飾
     *
     * となる。その区切り文字は現在のところ厳密に定めていない（`fore+back|bold` のような形式で定めることも考えたけどメリットがない）。
     * つまり、アルファベット以外で分割するので、
     *
     * - `blue|WHITE@bold`: 文字青・背景白・太字
     * - `blue WHITE bold underscore`: 文字青・背景白・太字・下線
     * - `italic|bold,blue+WHITE  `: 文字青・背景白・太字・斜体
     *
     * という動作になる（記号で区切られていれば形式はどうでも良いということ）。
     * ただ、この指定方法は変更が入る可能性が高いのでスペースあたりで区切っておくのがもっとも無難。
     *
     * @param string $string 対象文字列
     * @param string $color 色とスタイル文字列
     * @return string エスケープシーケンス付きの文字列
     */
    public static function ansi_colorize($string, $color)
    {
        // see https://en.wikipedia.org/wiki/ANSI_escape_code#SGR_parameters
        // see https://misc.flogisoft.com/bash/tip_colors_and_formatting
        $ansicodes = [
            // forecolor
            'default'    => [39, 39],
            'black'      => [30, 39],
            'red'        => [31, 39],
            'green'      => [32, 39],
            'yellow'     => [33, 39],
            'blue'       => [34, 39],
            'magenta'    => [35, 39],
            'cyan'       => [36, 39],
            'white'      => [97, 39],
            'gray'       => [90, 39],
            // backcolor
            'DEFAULT'    => [49, 49],
            'BLACK'      => [40, 49],
            'RED'        => [41, 49],
            'GREEN'      => [42, 49],
            'YELLOW'     => [43, 49],
            'BLUE'       => [44, 49],
            'MAGENTA'    => [45, 49],
            'CYAN'       => [46, 49],
            'WHITE'      => [47, 49],
            'GRAY'       => [100, 49],
            // style
            'bold'       => [1, 22],
            'faint'      => [2, 22], // not working ?
            'italic'     => [3, 23],
            'underscore' => [4, 24],
            'blink'      => [5, 25],
            'reverse'    => [7, 27],
            'conceal'    => [8, 28],
        ];

        $names = array_flip(preg_split('#[^a-z]#i', $color));
        $styles = array_intersect_key($ansicodes, $names);
        $setters = implode(';', array_column($styles, 0));
        $unsetters = implode(';', array_column($styles, 1));
        return "\033[{$setters}m{$string}\033[{$unsetters}m";
    }

    /**
     * proc_open ～ proc_close の一連の処理を行う
     *
     * 標準入出力は文字列で受け渡しできるが、決め打ち実装なのでいわゆる対話型なプロセスは起動できない。
     * また、標準入出力はリソース型を渡すこともできる。
     *
     * Example:
     * ```php
     * // サンプル実行用ファイルを用意
     * $phpfile = sys_get_temp_dir() . '/rf-sample.php';
     * file_put_contents($phpfile, "<?php
     *     fwrite(STDOUT, fgets(STDIN));
     *     fwrite(STDERR, 'err');
     *     exit((int) ini_get('max_file_uploads'));
     * ");
     * // 引数と標準入出力エラーを使った単純な例
     * $rc = process(PHP_BINARY, [
     *     '-d' => 'max_file_uploads=123',
     *     $phpfile,
     * ], 'out', $stdout, $stderr);
     * that($rc)->isSame(123); // -d で与えた max_file_uploads で exit してるので 123
     * that($stdout)->isSame('out'); // 標準出力に標準入力を書き込んでいるので "out" が格納される
     * that($stderr)->isSame('err'); // 標準エラーに書き込んでいるので "err" が格納される
     * ```
     *
     * @param string $command 実行コマンド。php7.4 未満では escapeshellcmd される
     * @param array|string $args コマンドライン引数。php7.4 未満では文字列はそのまま結合され、配列は escapeshellarg された上でキーと結合される
     * @param string|resource $stdin 標準入力（string を渡すと単純に読み取れられる。resource を渡すと fread される）
     * @param string|resource $stdout 標準出力（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
     * @param string|resource $stderr 標準エラー（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
     * @param ?string $cwd 作業ディレクトリ
     * @param ?array $env 環境変数
     * @return int リターンコード
     */
    public static function process($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null)
    {
        if (version_compare(PHP_VERSION, '7.4.0') >= 0 && is_array($args)) {
            // @codeCoverageIgnoreStart
            $statement = [$command];
            foreach ($args as $k => $v) {
                if (!is_int($k)) {
                    $statement[] = $k;
                }
                $statement[] = $v;
            }
            // @codeCoverageIgnoreEnd
        }
        else {
            if (is_array($args)) {
                $args = (array_sprintf)($args, function ($v, $k) {
                    $ev = escapeshellarg($v);
                    return is_int($k) ? $ev : "$k $ev";
                }, ' ');
            }
            $statement = escapeshellcmd($command) . " $args";
        }

        $proc = proc_open($statement, [
            0 => is_resource($stdin) ? $stdin : ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes, $cwd, $env);

        if ($proc === false) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command start failed."); // @codeCoverageIgnore
        }

        if (!is_resource($stdin)) {
            fwrite($pipes[0], $stdin);
            fclose($pipes[0]);
        }
        if (!is_resource($stdout)) {
            $stdout = '';
        }
        if (!is_resource($stderr)) {
            $stderr = '';
        }

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);
        try {
            while (feof($pipes[1]) === false || feof($pipes[2]) === false) {
                $read = [$pipes[1], $pipes[2]];
                $write = $except = null;
                if (stream_select($read, $write, $except, 1) === false) {
                    // （システムコールが別のシグナルによって中断された場合などに起こりえます）
                    throw new \RuntimeException('stream_select failed.'); // @codeCoverageIgnore
                }
                foreach ($read as $fp) {
                    $buffer = fread($fp, 1024);
                    if ($fp === $pipes[1]) {
                        if (!is_resource($stdout)) {
                            $stdout .= $buffer;
                        }
                        else {
                            fwrite($stdout, $buffer);
                        }
                    }
                    elseif ($fp === $pipes[2]) {
                        if (!is_resource($stderr)) {
                            $stderr .= $buffer;
                        }
                        else {
                            fwrite($stderr, $buffer);
                        }
                    }
                }
            }
        }
        finally {
            fclose($pipes[1]);
            fclose($pipes[2]);
            $rc = proc_close($proc);
        }

        if ($rc === -1) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command exit failed."); // @codeCoverageIgnore
        }
        return $rc;
    }

    /**
     * コマンドライン引数をパースして引数とオプションを返す
     *
     * 少しリッチな {@link http://php.net/manual/function.getopt.php getopt} として使える（shell 由来のオプション構文(a:b::)はどうも馴染みにくい）。
     * ただし「値が必須なオプション」はサポートしない。
     * もっとも、オプションとして空文字が来ることはほぼ無いのでデフォルト値を空文字にすることで対応可能。
     *
     * $rule に従って `--noval filename --opt optval` のような文字列・配列をパースする。
     * $rule 配列の仕様は下記。
     *
     * - キーは「オプション名」を指定する。ただし・・・
     *     - 数値キーは「引数」を意味する
     *     - スペースの後に「ショート名」を与えられる
     * - 値は「デフォルト値」を指定する。ただし・・・
     *     - `[]` は「複数値オプション」を意味する（配列にしない限り同オプションの多重指定は許されない）
     *     - `null` は「値なしオプション」を意味する（スイッチングオプション）
     * - 空文字キーは解釈自体のオプションを与える
     *     - 今のところ throw のみの実装。配列ではなく bool を与えられる
     *
     * 上記の仕様でパースして「引数は数値連番、オプションはオプション名をキーとした配列」を返す。
     * なお、いわゆる「引数」はどこに来ても良い（前オプション、後オプションの区別がない）。
     *
     * $argv には配列や文字列が与えられるが、ほとんどテスト用に近く、普通は未指定で $argv を使うはず。
     *
     * Example:
     * ```php
     * // いくつか織り交ぜたスタンダードな例
     * $rule = [
     *     'opt'       => 'def',    // 基本的には「デフォルト値」を表す
     *     'longopt l' => '',       // スペース区切りで「ショート名」を意味する
     *     1           => 'defarg', // 数値キーは「引数」を意味する
     * ];
     * that(arguments($rule, '--opt optval arg1 -l longval'))->isSame([
     *     'opt'     => 'optval',  // optval と指定している
     *     'longopt' => 'longval', // ショート名指定でも本来の名前で返ってくる
     *     'arg1',   // いわゆるコマンドライン引数（optval は opt に飲まれるので含まれない）
     *     'defarg', // いわゆるコマンドライン引数（与えられていないが、ルールの 1 => 'defarg' が活きている）
     * ]);
     *
     * // 「値なしオプション」と「複数値オプション」の例
     * $rule = [
     *     'noval1 l'  => null, // null は「値なしオプション」を意味する（指定されていれば true されていなければ false を返す）
     *     'noval2 m'  => null, // 同上
     *     'noval3 n'  => null, // 同上
     *     'opts o' => [],      // 配列を与えると「複数値オプション」を表す
     * ];
     * that(arguments($rule, '--opts o1 -ln arg1 -o o2 arg2 --opts o3'))->isSame([
     *     'noval1' => true,  // -ln で同時指定されているので true
     *     'noval2' => false, // -ln で同時指定されてないので false
     *     'noval3' => true,  // -ln の同時指定されているので true
     *     'opts'   => ['o1', 'o2', 'o3'], // ロング、ショート混在でも OK
     *     'arg1', // 一見 -ln のオプション値に見えるが、 noval は値なしなので引数として得られる
     *     'arg2', // 前オプション、後オプションの区別はないのでどこに居ようと引数として得られる
     * ]);
     *
     * // 空文字で解釈自体のオプションを与える
     * $rule = [
     *     ''  => false, // 定義されていないオプションが来ても例外を投げずに引数として処理する
     * ];
     * that(arguments($rule, '--long A -short B'))->isSame([
     *     '--long', // 明らかにオプション指定に見えるが、 long というオプションは定義されていないので引数として解釈される
     *     'A',      // 同上。long のオプション値に見えるが、ただの引数
     *     '-short', // 同上。short というオプションは定義されていない
     *     'B',      // 同上。short のオプション値に見えるが、ただの引数
     * ]);
     * ```
     *
     * @param array $rule オプションルール
     * @param array|string|null $argv パースするコマンドライン引数。未指定時は $argv が使用される
     * @return array コマンドライン引数＋オプション
     */
    public static function arguments($rule, $argv = null)
    {
        $opt = (array_unset)($rule, '', []);
        if (is_bool($opt)) {
            $opt = ['thrown' => $opt];
        }
        $opt += [
            'thrown' => true,
        ];

        if ($argv === null) {
            $argv = array_slice($_SERVER['argv'], 1); // @codeCoverageIgnore
        }
        if (is_string($argv)) {
            $argv = (quoteexplode)([" ", "\t"], $argv);
            $argv = array_filter($argv, 'strlen');
        }
        $argv = array_values($argv);

        $shortmap = [];
        $argsdefaults = [];
        $optsdefaults = [];
        foreach ($rule as $name => $default) {
            if (is_int($name)) {
                $argsdefaults[$name] = $default;
                continue;
            }
            [$longname, $shortname] = preg_split('#\s+#u', $name, -1, PREG_SPLIT_NO_EMPTY) + [1 => null];
            if ($shortname !== null) {
                if (array_key_exists($shortname, $shortmap)) {
                    throw new \InvalidArgumentException("duplicated short option name '$shortname'");
                }
                $shortmap[$shortname] = $longname;
            }
            if (array_key_exists($longname, $optsdefaults)) {
                throw new \InvalidArgumentException("duplicated option name '$shortname'");
            }
            $optsdefaults[$longname] = $default;
        }

        $n = 0;
        $already = [];
        $result = array_map(function ($v) { return $v === null ? false : $v; }, $optsdefaults);
        while (($token = array_shift($argv)) !== null) {
            if (strlen($token) >= 2 && $token[0] === '-') {
                if ($token[1] === '-') {
                    $optname = substr($token, 2);
                    if (!$opt['thrown'] && !array_key_exists($optname, $optsdefaults)) {
                        $result[$n++] = $token;
                        continue;
                    }
                }
                else {
                    $shortname = substr($token, 1);
                    if (!$opt['thrown'] && !isset($shortmap[$shortname])) {
                        $result[$n++] = $token;
                        continue;
                    }
                    if (strlen($shortname) > 1) {
                        array_unshift($argv, '-' . substr($shortname, 1));
                        $shortname = substr($shortname, 0, 1);
                    }
                    if (!isset($shortmap[$shortname])) {
                        throw new \InvalidArgumentException("undefined short option name '$shortname'.");
                    }
                    $optname = $shortmap[$shortname];
                }

                if (!array_key_exists($optname, $optsdefaults)) {
                    throw new \InvalidArgumentException("undefined option name '$optname'.");
                }
                if (isset($already[$optname]) && !is_array($result[$optname])) {
                    throw new \InvalidArgumentException("'$optname' is specified already.");
                }
                $already[$optname] = true;

                if ($optsdefaults[$optname] === null) {
                    $result[$optname] = true;
                }
                else {
                    if (!isset($argv[0]) || strpos($argv[0], '-') === 0) {
                        throw new \InvalidArgumentException("'$optname' requires value.");
                    }
                    if (is_array($result[$optname])) {
                        $result[$optname][] = array_shift($argv);
                    }
                    else {
                        $result[$optname] = array_shift($argv);
                    }
                }
            }
            else {
                $result[$n++] = $token;
            }
        }

        array_walk_recursive($result, function (&$v) {
            if (is_string($v)) {
                $v = trim(str_replace('\\"', '"', $v), '"');
            }
        });
        return $result + $argsdefaults;
    }

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
     * @param ?array $traces debug_backtrace 的な配列
     * @param int|string|array $option オプション
     * @return string|array トレース文字列（delimiter オプションに null を渡すと配列で返す）
     */
    public static function stacktrace($traces = null, $option = [])
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
                    return get_class($value) . $export((get_object_properties)($value), $nest, $parents);
                }
                // 文字列は改行削除
                elseif (is_string($value)) {
                    $value = str_replace(["\r\n", "\r", "\n"], '\n', $value);
                    if (($strlen = strlen($value)) > $limit) {
                        $value = substr($value, 0, $limit) . sprintf('...(more %d length)', $strlen - $limit);
                    }
                    return '"' . addcslashes($value, "\"\0\\") . '"';
                }
                // それ以外は stringify
                else {
                    return (stringify)($value);
                }
            };

            return $export($value);
        };

        $traces = $traces ?? array_slice(debug_backtrace(), 1);
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

    /**
     * 特定条件までのバックトレースを取得する
     *
     * 第2引数 $options を満たすトレース以降を返す。
     * $options は ['$trace の key' => "条件"] を渡す。
     * 条件は文字列かクロージャで、文字列の場合は緩い一致、クロージャの場合は true を返した場合にそれ以降を返す。
     *
     * Example:
     * ```php
     * function f001 () {return backtrace(0, ['function' => __NAMESPACE__ . '\\f002', 'limit' => 2]);}
     * function f002 () {return f001();}
     * function f003 () {return f002();}
     * $traces = f003();
     * // limit 指定してるので2個
     * that($traces)->count(2);
     * // 「function が f002 以降」を返す
     * that($traces[0])->arraySubset([
     *     'function' => __NAMESPACE__ . '\\f002'
     * ]);
     * that($traces[1])->arraySubset([
     *     'function' => __NAMESPACE__ . '\\f003'
     * ]);
     * ```
     *
     * @param int $flags debug_backtrace の引数
     * @param array $options フィルタ条件
     * @return array バックトレース
     */
    public static function backtrace($flags = \DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = [])
    {
        $result = [];
        $traces = debug_backtrace($flags);
        foreach ($traces as $n => $trace) {
            foreach ($options as $key => $val) {
                if (!isset($trace[$key])) {
                    continue;
                }

                if ($val instanceof \Closure) {
                    $break = $val($trace[$key]);
                }
                else {
                    $break = $trace[$key] == $val;
                }
                if ($break) {
                    $result = array_slice($traces, $n);
                    break 2;
                }
            }
        }

        // offset, limit は特別扱いで千切り指定
        if (isset($options['offset']) || isset($options['limit'])) {
            $result = array_slice($result, $options['offset'] ?? 0, $options['limit'] ?? count($result));
        }

        return $result;
    }

    /**
     * 外部ツールに頼らない pure php なプロファイラを返す
     *
     * file プロトコル上書きと ticks と debug_backtrace によるかなり無理のある実装なので動かない環境・コードは多い。
     * その分お手軽だが下記の注意点がある。
     *
     * - file プロトコルを上書きするので、既に読み込み済みのファイルは計上されない
     * - tick されないステートメントは計上されない
     *     - 1行メソッドなどでありがち
     * - A->B->C という呼び出しで C が 3秒、B が 2秒、A が1秒かかった場合、 A は 6 秒、B は 5秒、C は 3 秒といて計上される
     *     - つまり、配下の呼び出しも重複して計上される
     *
     * この関数を呼んだ時点で計測は始まる。
     * 返り値としてイテレータを返すので、foreach で回せばコールスタック・回数・時間などが取得できる。
     * 配列で欲しい場合は直に呼べば良い。
     *
     * @param array $options オプション配列
     * @return \Traversable|callable プロファイライテレータ
     */
    public static function profiler($options = [])
    {
        $declareProtocol = new
        /**
         * @method opendir($path, $context = null)
         * @method touch($filename, $time = null, $atime = null)
         * @method chmod($filename, $mode)
         * @method chown($filename, $user)
         * @method chgrp($filename, $group)
         * @method fopen($filename, $mode, $use_include_path = false, $context = null)
         */
        class {
            const DECLARE_TICKS = "<?php declare(ticks=1) ?>";

            /** @var int https://github.com/php/php-src/blob/php-7.2.11/main/php_streams.h#L528-L529 */
            private const STREAM_OPEN_FOR_INCLUDE = 0x00000080;

            /** @var resource https://www.php.net/manual/class.streamwrapper.php */
            public $context;

            private $require;
            private $prepend;
            private $handle;

            public function __call($name, $arguments)
            {
                $fname = preg_replace(['#^dir_#', '#^stream_#'], ['', 'f'], $name, 1, $count);
                if ($count) {
                    // flock は特別扱い（file_put_contents (LOCK_EX) を呼ぶと 0 で来ることがある）
                    // __call で特別扱いもおかしいけど、個別に定義するほうが逆にわかりにくい
                    if ($fname === 'flock' && ($arguments[0] ?? null) === 0) {
                        return true;
                    }
                    return $fname($this->handle, ...$arguments);
                }

                stream_wrapper_restore('file');
                try {
                    switch ($name) {
                        default:
                            // mkdir, rename, unlink, ...
                            return $name(...$arguments);
                        case 'rmdir':
                            [$path, $options] = $arguments + [1 => 0];
                            assert(isset($options)); // @todo It is used?
                            return rmdir($path, $this->context);
                        case 'url_stat':
                            [$path, $flags] = $arguments + [1 => 0];
                            if ($flags & STREAM_URL_STAT_LINK) {
                                $func = 'lstat';
                            }
                            else {
                                $func = 'stat';
                            }
                            if ($flags & STREAM_URL_STAT_QUIET) {
                                return @$func($path);
                            }
                            else {
                                return $func($path);
                            }
                    }
                }
                finally {
                    stream_wrapper_unregister('file');
                    stream_wrapper_register('file', get_class($this));
                }
            }

            public function dir_opendir($path, $options)
            {
                return !!$this->handle = $this->opendir(...$this->context ? [$path, $this->context] : [$path]);
            }

            public function stream_open($path, $mode, $options, &$opened_path)
            {
                $this->require = $options & self::STREAM_OPEN_FOR_INCLUDE;
                $this->prepend = false;
                $use_path = $options & STREAM_USE_PATH;
                if ($options & STREAM_REPORT_ERRORS) {
                    $this->handle = $this->fopen($path, $mode, $use_path); // @codeCoverageIgnore
                }
                else {
                    $this->handle = @$this->fopen($path, $mode, $use_path);
                }
                if ($use_path && $this->handle) {
                    $opened_path = stream_get_meta_data($this->handle)['uri']; // @codeCoverageIgnore
                }
                return !!$this->handle;
            }

            public function stream_read($count)
            {
                if (!$this->prepend && $this->require && ftell($this->handle) === 0) {
                    $this->prepend = true;
                    return self::DECLARE_TICKS;
                }
                return fread($this->handle, $count);
            }

            public function stream_stat()
            {
                $stat = fstat($this->handle);
                if ($this->require) {
                    $decsize = strlen(self::DECLARE_TICKS);
                    $stat[7] += $decsize;
                    $stat['size'] += $decsize;
                }
                return $stat;
            }

            public function stream_set_option($option, $arg1, $arg2)
            {
                // Windows の file スキームでは呼ばれない？（確かにブロッキングやタイムアウトは無縁そう）
                // @codeCoverageIgnoreStart
                switch ($option) {
                    default:
                        throw new \Exception();
                    case STREAM_OPTION_BLOCKING:
                        return stream_set_blocking($this->handle, $arg1);
                    case STREAM_OPTION_READ_TIMEOUT:
                        return stream_set_timeout($this->handle, $arg1, $arg2);
                    case STREAM_OPTION_READ_BUFFER:
                        return stream_set_read_buffer($this->handle, $arg2) === 0; // @todo $arg1 is used?
                    case STREAM_OPTION_WRITE_BUFFER:
                        return stream_set_write_buffer($this->handle, $arg2) === 0; // @todo $arg1 is used?
                }
                // @codeCoverageIgnoreEnd
            }

            public function stream_metadata($path, $option, $value)
            {
                switch ($option) {
                    default:
                        throw new \Exception(); // @codeCoverageIgnore
                    case STREAM_META_TOUCH:
                        return $this->touch($path, ...$value);
                    case STREAM_META_ACCESS:
                        return $this->chmod($path, $value);
                    case STREAM_META_OWNER_NAME:
                    case STREAM_META_OWNER:
                        return $this->chown($path, $value);
                    case STREAM_META_GROUP_NAME:
                    case STREAM_META_GROUP:
                        return $this->chgrp($path, $value);
                }
            }

            public function stream_cast($cast_as) { /* @todo I'm not sure */ }
        };

        $profiler = new class(get_class($declareProtocol), $options) implements \IteratorAggregate {
            private $wrapper;
            private $options;
            private $last_trace;
            private $result;

            public function __construct($wrapper, $options = [])
            {
                $this->wrapper = $wrapper;
                $this->options = array_replace([
                    'callee'   => null,
                    'location' => null,
                ], $options);

                $this->last_trace = [];
                $this->result = [];

                stream_wrapper_unregister('file');
                stream_wrapper_register('file', $this->wrapper);

                register_tick_function([$this, 'tick']);
                opcache_reset();
            }

            public function __destruct()
            {
                unregister_tick_function([$this, 'tick']);

                stream_wrapper_restore('file');
            }

            public function __invoke()
            {
                return $this->result;
            }

            public function getIterator()
            {
                return yield from $this->result;
            }

            public function tick()
            {
                $now = microtime(true);
                $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

                $last_count = count($this->last_trace);
                $current_count = count($traces);

                // スタック数が変わってない（=同じメソッドを処理している？）
                if ($current_count === $last_count) {
                    // dummy
                    assert($current_count === $last_count);
                }
                // スタック数が増えた（=新しいメソッドが開始された？）
                elseif ($current_count > $last_count) {
                    foreach (array_slice($traces, 1, $current_count - $last_count) as $last) {
                        $last['time'] = $now;
                        $last['callee'] = (isset($last['class'], $last['type']) ? $last['class'] . $last['type'] : '') . $last['function'];
                        $last['location'] = isset($last['file'], $last['line']) ? $last['file'] . '#' . $last['line'] : null;
                        array_unshift($this->last_trace, $last);
                    }
                }
                // スタック数が減った（=処理してたメソッドを抜けた？）
                elseif ($current_count < $last_count) {
                    $prev = null; // array_map などの内部関数はスタックが一気に2つ増減する
                    foreach (array_splice($this->last_trace, 0, $last_count - $current_count) as $last) {
                        $time = $now - $last['time'];
                        $callee = $last['callee'];
                        $location = $last['location'] ?? ($prev['file'] ?? '') . '#' . ($prev['line'] ?? '');
                        $prev = $last;

                        foreach (['callee', 'location'] as $key) {
                            $condition = $this->options[$key];
                            $value = $$key;
                            if ($condition !== null) {
                                if ($condition instanceof \Closure) {
                                    if (!$condition($value)) {
                                        continue 2;
                                    }
                                }
                                else {
                                    if (!preg_match($condition, $value)) {
                                        continue 2;
                                    }
                                }
                            }
                        }
                        $this->result[$callee][$location][] = $time;
                    }
                }
            }
        };

        return $profiler;
    }

    /**
     * エラー出力する
     *
     * 第1引数 $message はそれらしく文字列化されて出力される。基本的にはあらゆる型を与えて良い。
     *
     * 第2引数 $destination で出力対象を指定する。省略すると error_log 設定に従う。
     * 文字列を与えるとファイル名とみなし、ファイルに追記される。
     * ファイルを開くが、**ファイルは閉じない**。閉じ処理は php の終了処理に身を任せる。
     * したがって閉じる必要がある場合はファイルポインタを渡す必要がある。
     *
     * @param string|mixed $message 出力メッセージ
     * @param resource|string|mixed $destination 出力先
     * @return int 書き込んだバイト数
     */
    public static function error($message, $destination = null)
    {
        static $persistences = [];

        $time = date('d-M-Y H:i:s e');
        $content = (stringify)($message);
        $location = '';
        if (!($message instanceof \Exception || $message instanceof \Throwable)) {
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
                if (isset($trace['file'], $trace['line'])) {
                    $location = " in {$trace['file']} on line {$trace['line']}";
                    break;
                }
            }
        }
        $line = "[$time] PHP Log:  $content$location\n";

        if ($destination === null) {
            $destination = (blank_if)(ini_get('error_log'), 'php://stderr');
        }

        if ($destination === 'syslog') {
            syslog(LOG_INFO, $message);
            return strlen($line);
        }

        if (is_resource($destination)) {
            $fp = $destination;
        }
        elseif (is_string($destination)) {
            if (!isset($persistences[$destination])) {
                $persistences[$destination] = fopen($destination, 'a');
            }
            $fp = $persistences[$destination];
        }

        if (empty($fp)) {
            throw new \InvalidArgumentException('$destination must be resource or string.');
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $line);
        flock($fp, LOCK_UN);

        return strlen($line);
    }

    /**
     * エラーハンドラを追加する
     *
     * 追加したエラーハンドラが false を返すと標準のエラーハンドラではなく、直近の設定されていたエラーハンドラに移譲される。
     * （直近にエラーハンドラが設定されていなかったら標準ハンドラになる）。
     *
     * 「局所的にエラーハンドラを変更したいけど特定の状況は設定済みハンドラへ流したい」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // @ 付きなら元々のハンドラに移譲、@ なしなら何らかのハンドリングを行う例
     * add_error_handler(function () {
     *     if (error_reporting() === 0) {
     *         // この false はマニュアルにある「この関数が FALSE を返した場合は、通常のエラーハンドラが処理を引き継ぎます」ではなく、
     *         // 「さっきまで設定されていたエラーハンドラが処理を引き継ぎます」という意味になる
     *         return false;
     *     }
     *     // do something
     * });
     * // false の扱いが異なるだけでその他の挙動はすべて set_error_handler と同じなので restore_error_handler で戻せる
     * restore_error_handler();
     * ```
     *
     * @param callable $handler エラーハンドラ
     * @param int $error_types エラータイプ
     * @return callable|null 直近に設定されていたエラーハンドラ（未設定の場合は null）
     */
    public static function add_error_handler($handler, $error_types = \E_ALL | \E_STRICT)
    {
        $already = set_error_handler(static function () use ($handler, &$already) {
            $result = $handler(...func_get_args());
            if ($result === false && $already !== null) {
                return $already(...func_get_args());
            }
            return $result;
        }, $error_types);
        return $already;
    }

    /**
     * 処理時間を計測する
     *
     * 第1引数 $callable を $count 回回してその処理時間を返す。
     *
     * Example:
     * ```php
     * // 0.01 秒を 10 回回すので 0.1 秒は超える
     * that(timer(function(){usleep(10 * 1000);}, 10))->greaterThan(0.1);
     * ```
     *
     * @param callable $callable 処理クロージャ
     * @param int $count ループ回数
     * @return float 処理時間
     */
    public static function timer(callable $callable, $count = 1)
    {
        $count = (int) $count;
        if ($count < 1) {
            throw new \InvalidArgumentException("\$count must be greater than 0 (specified $count).");
        }

        $t = microtime(true);
        for ($i = 0; $i < $count; $i++) {
            $callable();
        }
        return microtime(true) - $t;
    }

    /**
     * 簡易ベンチマークを取る
     *
     * 「指定ミリ秒内で何回コールできるか？」でベンチする。
     *
     * $suite は ['表示名' => $callable] 形式の配列。
     * 表示名が与えられていない場合、それらしい名前で表示する。
     *
     * Example:
     * ```php
     * // intval と int キャストはどちらが早いか調べる
     * benchmark([
     *     'intval',
     *     'intcast' => function($v){return (int)$v;},
     * ], ['12345'], 10);
     * ```
     *
     * @param array|callable $suite ベンチ対象処理
     * @param array $args 各ケースに与えられる引数
     * @param int $millisec 呼び出しミリ秒
     * @param bool $output true だと標準出力に出力される
     * @return array ベンチ結果の配列
     */
    public static function benchmark($suite, $args = [], $millisec = 1000, $output = true)
    {
        $benchset = [];
        foreach ((arrayize)($suite) as $name => $caller) {
            if (!is_callable($caller, false, $callname)) {
                throw new \InvalidArgumentException('caller is not callable.');
            }

            if (is_int($name)) {
                // クロージャは "Closure::__invoke" になるので "ファイル#開始行-終了行" にする
                if ($caller instanceof \Closure) {
                    $ref = new \ReflectionFunction($caller);
                    $callname = $ref->getFileName() . '#' . $ref->getStartLine() . '-' . $ref->getEndLine();
                }
                $name = $callname;
            }

            if (isset($benchset[$name])) {
                throw new \InvalidArgumentException('duplicated benchname.');
            }

            $benchset[$name] = \Closure::fromCallable($caller);
        }

        if (!$benchset) {
            throw new \InvalidArgumentException('benchset is empty.');
        }

        // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
        $assertions = (call_safely)(function ($benchset, $args) {
            $result = [];
            $args2 = $args;
            foreach ($benchset as $name => $caller) {
                $result[$name] = $caller(...$args2);
            }
            return $result;
        }, $benchset, $args);

        // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
        // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
        foreach ($assertions as $name1 => $return1) {
            foreach ($assertions as $name2 => $return2) {
                if ($return1 !== null && $return2 !== null && $return1 !== $return2) {
                    $returns1 = (stringify)($return1);
                    $returns2 = (stringify)($return2);
                    trigger_error("Results of $name1 and $name2 are different. ($returns1, $returns2)");
                }
            }
        }

        // ベンチ
        $counts = [];
        foreach ($benchset as $name => $caller) {
            $end = microtime(true) + $millisec / 1000;
            $args2 = $args;
            for ($n = 0; microtime(true) <= $end; $n++) {
                $caller(...$args2);
            }
            $counts[$name] = $n;
        }

        // 結果配列
        $result = [];
        $maxcount = max($counts);
        arsort($counts);
        foreach ($counts as $name => $count) {
            $result[] = [
                'name'   => $name,
                'called' => $count,
                'mills'  => $millisec / $count,
                'ratio'  => $maxcount / $count,
            ];
        }

        // 出力するなら出力
        if ($output) {
            printf("Running %s cases (between %s ms):\n", count($benchset), number_format($millisec));
            echo (markdown_table)(array_map(function ($v) {
                return [
                    'name'       => $v['name'],
                    'called'     => number_format($v['called'], 0),
                    '1 call(ms)' => number_format($v['mills'], 6),
                    'ratio'      => number_format($v['ratio'], 3),
                ];
            }, $result));
        }

        return $result;
    }
}

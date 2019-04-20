<?php

namespace ryunosuke\Functions\Package;

/**
 * クラス・オブジェクト関連のユーティリティ
 */
class Classobj
{
    /**
     * 初期フィールド値を与えて stdClass を生成する
     *
     * 手元にある配列でサクッと stdClass を作りたいことがまれによくあるはず。
     *
     * object キャストでもいいんだが、 Iterator/Traversable とかも stdClass 化したいかもしれない。
     * それにキャストだとコールバックで呼べなかったり、数値キーが死んだりして微妙に使いづらいところがある。
     *
     * Example:
     * ```php
     * // 基本的には object キャストと同じ
     * $fields = ['a' => 'A', 'b' => 'B'];
     * assertEquals(stdclass($fields), (object) $fields);
     * // ただしこういうことはキャストでは出来ない
     * assertEquals(array_map('stdclass', [$fields]), [(object) $fields]); // コールバックとして利用する
     * assertTrue(property_exists(stdclass(['a', 'b']), '0')); // 数値キー付きオブジェクトにする
     * ```
     *
     * @param iterable $fields フィールド配列
     * @return \stdClass 生成した stdClass インスタンス
     */
    public static function stdclass(iterable $fields = [])
    {
        $stdclass = new \stdClass();
        foreach ($fields as $key => $value) {
            $stdclass->$key = $value;
        }
        return $stdclass;
    }

    /**
     * ディレクトリ構造から名前空間を推測して返す
     *
     * 指定パスに名前空間を持つような php ファイルが有るならその名前空間を返す。
     * 指定パスに名前空間を持つような php ファイルが無いなら親をたどる。
     * 親に名前空間を持つような php ファイルが有るならその名前空間＋ローカルパスを返す。
     *
     * 言葉で表すとややこしいが、「そのパスに配置しても違和感の無い名前空間」を返してくれるはず。
     *
     * @param string $location 配置パス。ファイル名を与えるとそのファイルを配置すべきクラス名を返す
     * @return string 名前空間
     */
    public static function detect_namespace($location)
    {
        // php をパースして名前空間部分を得るクロージャ
        $detectNS = function ($phpfile) {
            $tokens = token_get_all(file_get_contents($phpfile));
            $count = count($tokens);

            $namespace = [];
            foreach ($tokens as $n => $token) {
                if (is_array($token) && $token[0] === T_NAMESPACE) {
                    // T_NAMESPACE と T_WHITESPACE で最低でも2つは読み飛ばしてよい
                    for ($m = $n + 2; $m < $count; $m++) {
                        // よほどのことがないと T_NAMESPACE の次の T_STRING は名前空間の一部
                        if (is_array($tokens[$m]) && $tokens[$m][0] === T_STRING) {
                            $namespace[] = $tokens[$m][1];
                        }
                        // 終わりが来たら結合して返す
                        if ($tokens[$m] === ';') {
                            return implode('\\', $namespace);
                        }
                    }
                }
            }
            return null;
        };

        // 指定パスの兄弟ファイルを調べた後、親ディレクトリを辿っていく
        $basenames = [];
        return (dirname_r)($location, function ($directory) use ($detectNS, &$basenames) {
            foreach (array_filter(glob("$directory/*.php"), 'is_file') as $file) {
                $namespace = $detectNS($file);
                if ($namespace !== null) {
                    $localspace = implode('\\', array_reverse($basenames));
                    return rtrim($namespace . '\\' . $localspace, '\\');
                }
            }
            $basenames[] = pathinfo($directory, PATHINFO_FILENAME);
        }) ?: (throws)(new \InvalidArgumentException('can not detect namespace. invalid output path or not specify namespace.'));
    }

    /**
     * composer のクラスローダを返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * ```php
     * assertInstanceof(\Composer\Autoload\ClassLoader::class, class_loader());
     * ```
     *
     * @param string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
     * @return \Composer\Autoload\ClassLoader クラスローダ
     */
    public static function class_loader($startdir = null)
    {
        $file = (cache)('path', function () use ($startdir) {
            $cache = (dirname_r)($startdir ?: __DIR__, function ($dir) {
                if (file_exists($file = "$dir/autoload.php") || file_exists($file = "$dir/vendor/autoload.php")) {
                    return $file;
                }
            });
            if (!$cache) {
                throw new \DomainException('autoloader is not found.');
            }
            return $cache;
        }, __FUNCTION__);
        return require $file;
    }

    /**
     * クラスの名前空間部分を取得する
     *
     * Example:
     * ```php
     * assertSame(class_namespace('vendor\\namespace\\ClassName'), 'vendor\\namespace');
     * ```
     *
     * @param string|object $class 対象クラス・オブジェクト
     * @return string クラスの名前空間
     */
    public static function class_namespace($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $parts = explode('\\', $class);
        array_pop($parts);
        return ltrim(implode('\\', $parts), '\\');
    }

    /**
     * クラスの名前空間部分を除いた短い名前を取得する
     *
     * Example:
     * ```php
     * assertSame(class_shorten('vendor\\namespace\\ClassName'), 'ClassName');
     * ```
     *
     * @param string|object $class 対象クラス・オブジェクト
     * @return string クラスの短い名前
     */
    public static function class_shorten($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $parts = explode('\\', $class);
        return array_pop($parts);
    }

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
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X1', function() {
     *     // アンスコがついたクラスが定義されるのでそれを継承して定義する
     *     class X1d extends \ryunosuke\Test\Package\Classobj\X1_
     *     {
     *         function method(){return 'this is X1d';}
     *         function newmethod(){return 'this is newmethod';}
     *     }
     *     // このように匿名クラスを返しても良い。ただし、混在せずにどちらか一方にすること
     *     return new class() extends \ryunosuke\Test\Package\Classobj\X1_
     *     {
     *         function method(){return 'this is X1d';}
     *         function newmethod(){return 'this is newmethod';}
     *     };
     * });
     * // X1 を継承している Y1 にまで影響が出ている（X1 を完全に置換できたということ）
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y1())->method(), 'this is X1d');
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y1())->newmethod(), 'this is newmethod');
     *
     * // Y2 extends X2 だとしてクロージャ配列でオーバーライドする
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X2', function() {
     *     return [
     *         'method'    => function(){return 'this is X2d';},
     *         'newmethod' => function(){return 'this is newmethod';},
     *     ];
     * });
     * // X2 を継承している Y2 にまで影響が出ている（X2 を完全に置換できたということ）
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y2())->method(), 'this is X2d');
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y2())->newmethod(), 'this is newmethod');
     * ```
     *
     * @param string $class 対象クラス名
     * @param \Closure $register 置換クラスを定義 or 返すクロージャ or 定義メソッド配列
     */
    public static function class_replace($class, $register)
    {
        $class = ltrim($class, '\\');

        // 読み込み済みクラスは置換できない（php はクラスのアンロード機能が存在しない）
        if (class_exists($class, false)) {
            throw new \DomainException("'$class' is already declared.");
        }

        // 対象クラス名をちょっとだけ変えたクラスを用意して読み込む
        $classfile = (class_loader)()->findFile($class);
        $fname = (cachedir)() . '/' . rawurlencode(__FUNCTION__ . '-' . $class) . '.php';
        if (func_num_args() === 2 || !file_exists($fname)) {
            $content = file_get_contents($classfile);
            $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
            file_put_contents($fname, $content, LOCK_EX);
        }
        require_once $fname;

        $classess = get_declared_classes();
        $newclass = $register();

        // クロージャ内部でクラス定義した場合（増えたクラスでエイリアスする）
        if ($newclass === null) {
            $classes = array_diff(get_declared_classes(), $classess);
            if (count($classes) !== 1) {
                throw new \DomainException('declared multi classes.' . implode(',', $classes));
            }
            $newclass = reset($classes);
        }
        // php7.0 から無名クラスが使えるのでそのクラス名でエイリアスする
        if (is_object($newclass)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $newclass = get_class($newclass);
        }
        // 配列はメソッド定義のクロージャ配列とする
        if (is_array($newclass)) {
            $content = file_get_contents($fname);
            $origspace = (parse_php)($content, [
                'begin' => T_NAMESPACE,
                'end'   => ';',
            ]);
            array_shift($origspace);
            array_pop($origspace);

            $origclass = (parse_php)($content, [
                'begin'  => T_CLASS,
                'end'    => T_STRING,
                'offset' => count($origspace),
            ]);
            array_shift($origclass);

            $origspace = trim(implode('', array_column($origspace, 1)));
            $origclass = trim(implode('', array_column($origclass, 1)));

            $methods = '';
            foreach ($newclass as $name => $func) {
                $codes = (callable_code)($func);
                $mname = (preg_replaces)('#function(\\s*)\\(#u', " $name", $codes[0]);
                $methods .= "public $mname {$codes[1]}";
            }

            $newclass = "\\$origspace\\{$origclass}_";
            (evaluate)("namespace $origspace;class {$origclass}_ extends {$origclass}{ $methods }");
        }

        class_alias($newclass, $class);
    }

    /**
     * インスタンスを動的に拡張する
     *
     * インスタンスに特異メソッド・特異フィールドのようなものを生やす。
     * ただし、特異フィールドの用途はほとんどない（php はデフォルトで特異フィールドのような動作なので）。
     * そのクラスの __set/__get が禁止されている場合に使えるかもしれない程度。
     *
     * クロージャ配列を渡すと特異メソッドになる。
     * そのクロージャの $this は元オブジェクトで bind される。
     * ただし、static closure を渡した場合はそれは static メソッドとして扱われる。
     *
     * 内部的にはいわゆる Decorator パターンを動的に実行しているだけであり、実行速度は劣悪。
     * 当然ながら final クラスの拡張もできない。
     *
     * Example:
     * ```php
     * // Expcetion に「コードとメッセージを結合して返す」メソッドを動的に生やす
     * $object = new \Exception('hoge', 123);
     * $newobject = class_extends($object, [
     *     'codemessage' => function() {
     *         // bind されるので protected フィールドが使える
     *         return $this->code . ':' . $this->message;
     *     },
     * ]);
     * assertSame($newobject->codemessage(), '123:hoge');
     * ```
     *
     * @param string $object 対象オブジェクト
     * @param \Closure[] $methods 注入するメソッド
     * @param array $fields 注入するフィールド
     * @return object $object を拡張した object
     */
    public static function class_extends($object, $methods, $fields = [])
    {
        static $template_source, $template_reflection;
        if (!isset($template_source)) {
            // コード補完やフォーマッタを効かせたいので文字列 eval ではなく直に new する（1回だけだし）
            // @codeCoverageIgnoreStart
            $template_reflection = new \ReflectionClass(
                new class()
                {
                    private static $__originalClass;
                    private        $__original;
                    private        $__fields;
                    private        $__methods;
                    private static $__staticMethods = [];

                    public function __construct(\ReflectionClass $refclass = null, $original = null, $fields = [], $methods = [])
                    {
                        if ($refclass === null) {
                            return;
                        }
                        self::$__originalClass = get_class($original);

                        $this->__original = $original;
                        $this->__fields = $fields;

                        foreach ($methods as $name => $method) {
                            $method = \Closure::fromCallable($method);
                            $bmethod = @$method->bindTo($this->__original, $refclass->isInternal() ? $this : $this->__original);
                            // 内部クラスは $this バインドできないので original じゃなく自身にする
                            if ($bmethod) {
                                $this->__methods[$name] = $bmethod;
                            }
                            else {
                                self::$__staticMethods[$name] = $method->bindTo(null, self::$__originalClass);
                            }
                        }
                    }

                    public function __get($name)
                    {
                        if (array_key_exists($name, $this->__fields)) {
                            return $this->__fields[$name];
                        }
                        return $this->__original->$name;
                    }

                    public function __set($name, $value)
                    {
                        if (array_key_exists($name, $this->__fields)) {
                            return $this->__fields[$name] = $value;
                        }
                        return $this->__original->$name = $value;
                    }

                    public function __call($name, $arguments)
                    {
                        if (array_key_exists($name, $this->__methods)) {
                            return $this->__methods[$name](...$arguments);
                        }
                        return $this->__original->$name(...$arguments);
                    }

                    public static function __callStatic($name, $arguments)
                    {
                        if (array_key_exists($name, self::$__staticMethods)) {
                            return (self::$__staticMethods)[$name](...$arguments);
                        }
                        return self::$__originalClass::$name(...$arguments);
                    }
                }
            );
            // @codeCoverageIgnoreEnd
            $sl = $template_reflection->getStartLine();
            $el = $template_reflection->getEndLine();
            $template_source = implode("", array_slice(file($template_reflection->getFileName()), $sl, $el - $sl - 1));
        }

        /** @var \ReflectionClass[][] $spawners */
        static $spawners = [];

        $classname = get_class($object);
        if (!isset($spawners[$classname])) {
            $classalias = str_replace('\\', '__', $classname);

            $cachefile = (cachedir)() . '/' . rawurlencode(__FUNCTION__ . '-' . $classname) . '.php';
            if (!file_exists($cachefile)) {
                $declares = [];
                foreach ((new \ReflectionClass($classname))->getMethods() as $method) {
                    if (!$method->isFinal() && !$method->isAbstract()) {
                        if (!in_array($method->getName(), get_class_methods($template_reflection->getName()))) {
                            $modifier = implode(' ', \Reflection::getModifierNames($method->getModifiers()));
                            $name = $method->getName();
                            $reference = $method->returnsReference() ? '&' : '';
                            $receiver = $method->isStatic() ? 'self::$__originalClass::' : '$this->__original->';

                            $params = (function_parameter)($method);
                            $prms = implode(', ', $params);
                            $args = implode(', ', array_keys($params));
                            $declares[] = "$modifier function $reference$name($prms) {
                                \$return = $reference $receiver$name(...[$args]);
                                return \$return;
                            }";
                        }
                    }
                }
                $code = "class X$classalias extends $classname$template_source" . implode("\n", $declares) . '}';
                file_put_contents($cachefile, "<?php\n" . $code, LOCK_EX);
            }
            require_once $cachefile;
            $spawners[$classname] = [
                'original'   => new \ReflectionClass($classname),
                'reflection' => new \ReflectionClass("X$classalias"),
            ];
        }
        return $spawners[$classname]['reflection']->newInstance($spawners[$classname]['original'], $object, $fields, $methods);
    }

    /**
     * パス形式でプロパティ値を取得
     *
     * 存在しない場合は $default を返す。
     *
     * Example:
     * ```php
     * $class = stdclass([
     *     'a' => stdclass([
     *         'b' => stdclass([
     *             'c' => 'vvv'
     *         ])
     *     ])
     * ]);
     * assertSame(object_dive($class, 'a.b.c'), 'vvv');
     * assertSame(object_dive($class, 'a.b.x', 9), 9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * assertSame(object_dive($class, ['a', 'b', 'c']), 'vvv');
     * ```
     *
     * @param object $object 調べるオブジェクト
     * @param string|array $path パス文字列。配列も与えられる
     * @param mixed $default 無かった場合のデフォルト値
     * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
     * @return mixed パスが示すプロパティ値
     */
    public static function object_dive($object, $path, $default = null, $delimiter = '.')
    {
        $keys = is_array($path) ? $path : explode($delimiter, $path);
        foreach ($keys as $key) {
            if (!isset($object->$key)) {
                return $default;
            }
            $object = $object->$key;
        }
        return $object;
    }

    /**
     * オブジェクトのプロパティを可視・不可視を問わず取得する
     *
     * get_object_vars + no public プロパティを返すイメージ。
     *
     * Example:
     * ```php
     * $object = new \Exception('something', 42);
     * $object->oreore = 'oreore';
     *
     * // get_object_vars はそのスコープから見えないプロパティを取得できない
     * // var_dump(get_object_vars($object));
     *
     * // array キャストは全て得られるが null 文字を含むので扱いにくい
     * // var_dump((array) $object);
     *
     * // この関数を使えば不可視プロパティも取得できる
     * assertArraySubset([
     *     'message' => 'something',
     *     'code'    => 42,
     *     'oreore'  => 'oreore',
     * ], get_object_properties($object));
     * ```
     *
     * @param object $object オブジェクト
     * @return array 全プロパティの配列
     */
    public static function get_object_properties($object)
    {
        static $refs = [];
        $class = get_class($object);
        if (!isset($refs[$class])) {
            $props = (new \ReflectionClass($class))->getProperties();
            $refs[$class] = (array_each)($props, function (&$carry, \ReflectionProperty $rp) {
                if (!$rp->isStatic()) {
                    $rp->setAccessible(true);
                    $carry[$rp->getName()] = $rp;
                }
            }, []);
        }

        // 配列キャストだと private で ヌル文字が出たり static が含まれたりするのでリフレクションで取得して勝手プロパティで埋める
        $vars = (array_map_method)($refs[$class], 'getValue', [$object]);
        $vars += get_object_vars($object);

        return $vars;
    }
}

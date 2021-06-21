<?php

namespace ryunosuke\Functions\Package;

/**
 * クラス・オブジェクト関連のユーティリティ
 */
class Classobj
{
    /** 自分自身を表す定数 */
    const IS_OWNSELF = 1 << 1;

    /** public を表す定数 */
    const IS_PUBLIC = 1 << 2;

    /** protected を表す定数 */
    const IS_PROTECTED = 1 << 3;

    /** private を表す定数 */
    const IS_PRIVATE = 1 << 4;

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
     * that(stdclass($fields))->is((object) $fields);
     * // ただしこういうことはキャストでは出来ない
     * that(array_map('stdclass', [$fields]))->is([(object) $fields]); // コールバックとして利用する
     * that(property_exists(stdclass(['a', 'b']), '0'))->isTrue();     // 数値キー付きオブジェクトにする
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
     * Example:
     * ```php
     * // Example 用としてこのクラスのディレクトリを使用してみる
     * $dirname = dirname(class_loader()->findFile(\ryunosuke\Functions\Package\Classobj::class));
     * // "$dirname/Hoge" の名前空間を推測して返す
     * that(detect_namespace("$dirname/Hoge"))->isSame("ryunosuke\\Functions\\Package\\Hoge");
     * ```
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
                        if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
                            if (is_array($tokens[$m]) && $tokens[$m][0] === T_NAME_QUALIFIED) {
                                return $tokens[$m][1];
                            }
                            if (is_array($tokens[$m]) && $tokens[$m][0] === T_NAME_FULLY_QUALIFIED) {
                                $namespace[] = trim($tokens[$m][1], '\\');
                            }
                        }
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
     * クラスが use しているトレイトを再帰的に取得する
     *
     * トレイトが use しているトレイトが use しているトレイトが use している・・・のような場合もすべて返す。
     *
     * Example:
     * ```php
     * trait T1{}
     * trait T2{use T1;}
     * trait T3{use T2;}
     * that(class_uses_all(new class{use T3;}))->isSame([
     *     'Example\\T3', // クラスが直接 use している
     *     'Example\\T2', // T3 が use している
     *     'Example\\T1', // T2 が use している
     * ]);
     * ```
     *
     * @param string|object $class
     * @param bool $autoload オートロードを呼ぶか
     * @return array トレイト名の配列
     */
    public static function class_uses_all($class, $autoload = true)
    {
        // まずはクラス階層から取得
        $traits = [];
        do {
            $traits += array_fill_keys(class_uses($class, $autoload), false);
        } while ($class = get_parent_class($class));

        // そのそれぞれのトレイトに対してさらに再帰的に探す
        // 見つかったトレイトがさらに use している可能性もあるので「増えなくなるまで」 while ループして探す必要がある
        // （まずないと思うが）再帰的に use していることもあるかもしれないのでムダを省くためにチェック済みフラグを設けてある（ただ多分不要）
        $count = count($traits);
        while (true) {
            foreach ($traits as $trait => $checked) {
                if (!$checked) {
                    $traits[$trait] = true;
                    $traits += array_fill_keys(class_uses($trait, $autoload), false);
                }
            }
            if ($count === count($traits)) {
                break;
            }
            $count = count($traits);
        }
        return array_keys($traits);
    }

    /**
     * composer のクラスローダを返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * ```php
     * that(class_loader())->isInstanceOf(\Composer\Autoload\ClassLoader::class);
     * ```
     *
     * @param ?string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
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
     * that(class_namespace('vendor\\namespace\\ClassName'))->isSame('vendor\\namespace');
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
     * that(class_shorten('vendor\\namespace\\ClassName'))->isSame('ClassName');
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
     * that((new \ryunosuke\Test\Package\Classobj\Y1())->method())->isSame('this is X1d');
     * that((new \ryunosuke\Test\Package\Classobj\Y1())->newmethod())->isSame('this is newmethod');
     *
     * // Y2 extends X2 だとしてクロージャ配列でオーバーライドする
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X2', function() {
     *     return [
     *         'method'    => function(){return 'this is X2d';},
     *         'newmethod' => function(){return 'this is newmethod';},
     *     ];
     * });
     * // X2 を継承している Y2 にまで影響が出ている（X2 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y2())->method())->isSame('this is X2d');
     * that((new \ryunosuke\Test\Package\Classobj\Y2())->newmethod())->isSame('this is newmethod');
     *
     * // メソッド定義だけであればクロージャではなく配列指定でも可能。さらに trait 配列を渡すとそれらを use できる
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X3', [
     *     [\ryunosuke\Test\Package\Classobj\XTrait::class],
     *     'method' => function(){return 'this is X3d';},
     * ]);
     * // X3 を継承している Y3 にまで影響が出ている（X3 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y3())->method())->isSame('this is X3d');
     * // トレイトのメソッドも生えている
     * that((new \ryunosuke\Test\Package\Classobj\Y3())->traitMethod())->isSame('this is XTrait::traitMethod');
     * ```
     *
     * @param string $class 対象クラス名
     * @param \Closure|array $register 置換クラスを定義 or 返すクロージャ or 定義メソッド配列
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
        if (!file_exists($fname)) {
            $content = file_get_contents($classfile);
            $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
            file_put_contents($fname, $content, LOCK_EX);
        }
        require_once $fname;

        $classess = get_declared_classes();
        if ($register instanceof \Closure) {
            $newclass = $register();
        }
        else {
            $newclass = $register;
        }

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

            $classcode = '';
            foreach ($newclass as $name => $member) {
                if (is_array($member)) {
                    foreach ($member as $trait) {
                        $classcode .= "use \\" . trim($trait, '\\') . ";\n";
                    }
                }
                else {
                    [$declare, $codeblock] = (callable_code)($member);
                    $parentclass = new \ReflectionClass("\\$origspace\\$origclass");
                    // 元クラスに定義されているならオーバーライドとして特殊な処理を行う
                    if ($parentclass->hasMethod($name)) {
                        /** @var \ReflectionFunctionAbstract $refmember */
                        $refmember = (reflect_callable)($member);
                        $refmethod = $parentclass->getMethod($name);
                        // 指定クロージャに引数が無くて、元メソッドに有るなら継承
                        if (!$refmember->getNumberOfParameters() && $refmethod->getNumberOfParameters()) {
                            $declare = 'function (' . implode(', ', (function_parameter)($refmethod)) . ')';
                        }
                        // 同上。返り値版
                        if (!$refmember->hasReturnType() && $refmethod->hasReturnType()) {
                            $declare .= ':' . (reflect_types)($refmethod->getReturnType())->getName();
                        }
                    }
                    $mname = (preg_replaces)('#function(\\s*)\\(#u', " $name", $declare);
                    $classcode .= "public $mname $codeblock\n";
                }
            }

            $newclass = "\\$origspace\\{$origclass}_";
            (evaluate)("namespace $origspace;\nclass {$origclass}_ extends {$origclass}\n{\n$classcode}");
        }

        class_alias($newclass, $class);
    }

    /**
     * インスタンスを動的に拡張する
     *
     * インスタンスに特異メソッド・特異フィールドのようなものを生やす。
     * ただし、特異フィールドの用途はほとんどない（php はデフォルトで特異フィールドのような動作なので）。
     * そのクラスの `__set`/`__get` が禁止されている場合に使えるかもしれない程度。
     *
     * クロージャ配列を渡すと特異メソッドになる。
     * そのクロージャの $this は元オブジェクトで bind される。
     * ただし、static closure を渡した場合はそれは static メソッドとして扱われる。
     *
     * 内部的にはいわゆる Decorator パターンを動的に実行しているだけであり、実行速度は劣悪。
     * 当然ながら final クラス/メソッドの拡張もできない。
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
     * that($newobject->codemessage())->isSame('123:hoge');
     *
     * // オーバーライドもできる（ArrayObject の count を2倍になるように上書き）
     * $object = new \ArrayObject([1, 2, 3]);
     * $newobject = class_extends($object, [
     *     'count' => function() {
     *         // parent は元オブジェクトを表す
     *         return parent::count() * 2;
     *     },
     * ]);
     * that($newobject->count())->isSame(6);
     * ```
     *
     * @param object $object 対象オブジェクト
     * @param \Closure[] $methods 注入するメソッド
     * @param array $fields 注入するフィールド
     * @return object $object を拡張した object
     */
    public static function class_extends($object, $methods, $fields = [])
    {
        assert(is_array($methods));

        // こうするとコード補完が活きやすくなる
        if (false) {
            /** @noinspection PhpUnreachableStatementInspection */
            return $object; // @codeCoverageIgnore
        }

        static $template_source, $template_reflection;
        if (!isset($template_source)) {
            // コード補完やフォーマッタを効かせたいので文字列 eval ではなく直に new する（1回だけだし）
            // @codeCoverageIgnoreStart
            $template_reflection = new \ReflectionClass(new class() {
                    private static $__originalClass;
                    private        $__original;
                    private        $__fields;
                    private        $__methods       = [];
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
                        return $this->__original->$name(...$arguments);
                    }

                    public static function __callStatic($name, $arguments)
                    {
                        return self::$__originalClass::$name(...$arguments);
                    }
                }
            );
            // @codeCoverageIgnoreEnd
            $sl = $template_reflection->getStartLine();
            $el = $template_reflection->getEndLine();
            $template_source = implode("", array_slice(file($template_reflection->getFileName()), $sl, $el - $sl - 1));
        }

        $getReturnType = function (\ReflectionFunctionAbstract $reffunc) {
            if ($reffunc->hasReturnType()) {
                return ': ' . (reflect_types)($reffunc->getReturnType())->getName();
            }
        };

        $parse = static function ($name, \ReflectionFunctionAbstract $reffunc) use ($getReturnType) {
            if ($reffunc instanceof \ReflectionMethod) {
                $modifier = implode(' ', \Reflection::getModifierNames($reffunc->getModifiers()));
                $receiver = ($reffunc->isStatic() ? 'self::$__originalClass::' : '$this->__original->') . $name;
            }
            else {
                $bindable = (is_bindable_closure)($reffunc->getClosure());
                $modifier = $bindable ? '' : 'static ';
                $receiver = ($bindable ? '$this->__methods' : 'self::$__staticMethods') . "[" . var_export($name, true) . "]";
            }

            $ref = $reffunc->returnsReference() ? '&' : '';

            $params = (function_parameter)($reffunc);
            $prms = implode(', ', $params);
            $args = implode(', ', array_keys($params));

            $rtype = $getReturnType($reffunc);

            return [
                "$modifier function $ref$name($prms)$rtype",
                "{ \$return = $ref$receiver(...[$args]);return \$return; }\n",
            ];
        };

        /** @var \ReflectionClass[][]|\ReflectionMethod[][][] $spawners */
        static $spawners = [];

        $classname = get_class($object);
        $classalias = str_replace('\\', '__', $classname);

        if (!isset($spawners[$classname])) {
            $refclass = new \ReflectionClass($classname);
            $classmethods = [];
            foreach ($refclass->getMethods() as $method) {
                if (!$method->isFinal() && !$method->isAbstract() && !in_array($method->getName(), get_class_methods($template_reflection->getName()))) {
                    $classmethods[$method->name] = $method;
                }
            }

            $cachefile = (cachedir)() . '/' . rawurlencode(__FUNCTION__ . '-' . $classname) . '.php';
            if (!file_exists($cachefile)) {
                $declares = "";
                foreach ($classmethods as $name => $method) {
                    $declares .= implode(' ', $parse($name, $method));
                }
                $traitcode = "trait X{$classalias}Trait\n{\n{$template_source}{$declares}}";
                file_put_contents($cachefile, "<?php\n" . $traitcode, LOCK_EX);
            }

            require_once $cachefile;
            $spawners[$classname] = [
                'original' => $refclass,
                'methods'  => $classmethods,
            ];
        }

        $declares = "";
        // 指定クロージャ配列から同名メソッドを差っ引いたもの（まさに特異メソッドとなる）
        foreach (array_diff_key($methods, $spawners[$classname]['methods']) as $name => $singular) {
            $declares .= implode(' ', $parse($name, new \ReflectionFunction($singular)));
        }
        // 指定クロージャ配列でメソッドと同名のもの（オーバーライドを模倣する）
        foreach (array_intersect_key($methods, $spawners[$classname]['methods']) as $name => $override) {
            $method = $spawners[$classname]['methods'][$name];
            $ref = $method->returnsReference() ? '&' : '';
            $receiver = $method->isStatic() ? 'self::$__originalClass::' : '$this->__original->';
            $modifier = implode(' ', \Reflection::getModifierNames($method->getModifiers()));

            // シグネチャエラーが出てしまうので、指定がない場合は強制的に合わせる
            $refmember = new \ReflectionFunction($override);
            $params = (function_parameter)(!$refmember->getNumberOfParameters() && $method->getNumberOfParameters() ? $method : $override);
            $rtype = $getReturnType(!$refmember->hasReturnType() && $method->hasReturnType() ? $method : $refmember);

            [, $codeblock] = (callable_code)($override);
            $tokens = (parse_php)($codeblock);
            array_shift($tokens);
            $parented = null;
            foreach ($tokens as $n => $token) {
                if ($token[0] !== T_WHITESPACE) {
                    if ($token[0] === T_STRING && $token[1] === 'parent') {
                        $parented = $n;
                    }
                    elseif ($parented !== null && $token[0] === T_DOUBLE_COLON) {
                        unset($tokens[$parented]);
                        $tokens[$n][1] = $receiver;
                    }
                    else {
                        $parented = null;
                    }
                }
            }
            $codeblock = implode('', array_column($tokens, 1));

            $prms = implode(', ', $params);
            $declares .= "$modifier function $ref$name($prms)$rtype $codeblock\n";
        }

        $newclassname = "X{$classalias}Class" . md5(uniqid('RF', true));
        (evaluate)("class $newclassname extends $classname\n{\nuse X{$classalias}Trait;\n$declares}", [], 10);
        return new $newclassname($spawners[$classname]['original'], $object, $fields, $methods);
    }

    /**
     * ReflectionType の型配列を返す
     *
     * ReflectionType のインターフェース・仕様がコロコロ変わってついていけないので関数化した。
     *
     * ReflectionType に準ずるインスタンスを渡すと取り得る候補を配列ライクなオブジェクトで返す。
     * 引数は配列で複数与えても良い。よしなに扱って複数型として返す。
     * また「Type が一意に導出できる Reflection」を渡しても良い（ReflectionProperty など）。
     * null を与えた場合はエラーにはならず、スルーされる（getType は null を返し得るので利便性のため）。
     *
     * 単純に ReflectionType の配列ライクなオブジェクトを返すが、そのオブジェクトは `__toString` が実装されており、文字列化するとパイプ区切りの型文字列を返す。
     * これは 8.0 における ReflectionUnionType の `__toString` を模倣したものである。
     * 互換性のある型があった場合、上位の型に内包されて型文字列としては出現しない。
     *
     * Countable も実装されているが、その結果は「内部 Type の数」ではなく、論理的に「取り得る型の数」を返す。
     * 例えば `?int` は型としては1つだが、実際は int, null の2つを取り得るため、 count は 2 を返す。
     * 端的に言えば「`__toString` のパイプ区切りの型の数」を返す。
     *
     * あとは便利メソッドとして下記が生えている。
     *
     * - jsonSerialize: JsonSerializable 実装
     * - getTypes: 取り得る型をすべて返す（ReflectionUnionType 互換）
     * - getName: ReflectionUnionType 非互換 toString な型宣言文字列を返す
     * - allows: その値を取りうるか判定して返す
     *
     * ReflectionUnionType とは完全互換ではないので、php8.0が完全に使える環境であれば素直に ReflectionUnionType を使ったほうが良い。
     * （「常に（型分岐せずに）複数形で扱える」程度のメリットしかない。allows は惜しいが）。
     *
     * ちなみに型の変遷は下記の通り。
     *
     * - php7.1: ReflectionType::__toString が非推奨になった
     * - php7.1: ReflectionNamedType が追加され、各種 getType でそれを返すようになった
     * - php8.0: ReflectionType::__toString が非推奨ではなくなった
     * - php8.0: ReflectionUnionType が追加され、複合の場合は getType でそれを返すようになった
     *
     * Example:
     * ```php
     * $object = new class {
     *     function method(object $o):?string {}
     * };
     * $method = new \ReflectionMethod($object, 'method');
     * $types = reflect_types($method->getParameters()[0]->getType());
     * // 文字列化すると型宣言文字列を返すし、配列アクセスや count, iterable でそれぞれの型が得られる
     * that((string) $types)->is('object');
     * that($types[0])->isInstanceOf(\ReflectionType::class);
     * that(iterator_to_array($types))->eachIsInstanceOf(\ReflectionType::class);
     * that(count($types))->is(1);
     * // 返り値でも同じ（null 許容なので null が付くし count も 2 になる）
     * $types = reflect_types($method->getReturnType());
     * that((string) $types)->is('string|null');
     * that(count($types))->is(2);
     * ```
     *
     * @param \ReflectionFunctionAbstract|\ReflectionType|\ReflectionType[]|null $reflection_type getType 等で得られるインスタンス
     * @return \Traversable|\ArrayAccess|\Countable|\ReflectionNamedType|\ReflectionUnionType
     */
    public static function reflect_types($reflection_type = null)
    {
        if (!is_array($reflection_type)) {
            $reflection_type = [$reflection_type];
        }

        foreach ($reflection_type as $n => $rtype) {
            if ($rtype instanceof \ReflectionProperty) {
                /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                $reflection_type[$n] = $rtype->getType();
            }
            if ($rtype instanceof \ReflectionFunctionAbstract) {
                $reflection_type[$n] = $rtype->getReturnType();
            }
            if ($rtype instanceof \ReflectionParameter) {
                $reflection_type[$n] = $rtype->getType();
            }
        }

        return new class(...$reflection_type)
            extends \stdClass
            implements \IteratorAggregate, \ArrayAccess, \Countable, \JsonSerializable {

            private const PSEUDO = [
                'mixed'    => [],
                'static'   => ['object', 'mixed'],
                'self'     => ['static', 'object', 'mixed'],
                'parent'   => ['static', 'object', 'mixed'],
                'callable' => ['mixed'],
                'iterable' => ['mixed'],
                'object'   => ['mixed'],
                'array'    => ['iterable', 'mixed'],
                'string'   => ['mixed'],
                'int'      => ['mixed'],
                'float'    => ['mixed'],
                'bool'     => ['mixed'],
                'false'    => ['bool', 'mixed'],
                'null'     => ['mixed'],
                'void'     => [],
            ];

            public function __construct(?\ReflectionType ...$reflection_types)
            {
                $types = [];
                foreach ($reflection_types as $type) {
                    if ($type === null) {
                        continue;
                    }

                    /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                    $types = array_merge($types, $type instanceof \ReflectionUnionType ? $type->getTypes() : [$type]);
                }

                // 配列キャストで配列を得たいので下手にフィールドを宣言せず直に生やす
                foreach ($types as $n => $type) {
                    $this->$n = $type;
                }
            }

            public function __toString()
            {
                return implode('|', $this->toStrings(true, true));
            }

            public function getIterator()
            {
                // yield from $this->getTypes();
                return new \ArrayIterator($this->getTypes());
            }

            public function offsetExists($offset)
            {
                return isset($this->$offset);
            }

            public function offsetGet($offset)
            {
                return $this->$offset;
            }

            public function offsetSet($offset, $value)
            {
                // for debug
                if (is_string($value)) {
                    $value = new class ($value, self::PSEUDO) extends \ReflectionNamedType {
                        private $typename;
                        private $nullable;
                        private $builtins;

                        public function __construct($typename, $builtins)
                        {
                            $this->typename = ltrim($typename, '?');
                            $this->nullable = $typename[0] === '?';
                            $this->builtins = $builtins;
                        }

                        public function getName() { return $this->typename; }

                        public function allowsNull() { return $this->nullable; }

                        public function isBuiltin() { return isset($this->builtins[$this->typename]); }

                        public function __toString() { return $this->getName(); }
                    };
                }

                assert($value instanceof \ReflectionType);
                if ($offset === null) {
                    $offset = max(array_keys($this->getTypes()) ?: [-1]) + 1;
                }
                $this->$offset = $value;
            }

            public function offsetUnset($offset)
            {
                unset($this->$offset);
            }

            public function count()
            {
                return count($this->toStrings(true, false));
            }

            public function jsonSerialize()
            {
                return $this->toStrings(true, true);
            }

            public function getName()
            {
                $types = array_flip($this->toStrings(true, true));
                $nullable = false;
                if (isset($types['null']) && count($types) === 2) {
                    unset($types['null']);
                    $nullable = true;
                }

                $result = [];
                foreach ($types as $type => $dummy) {
                    $result[] = (isset(self::PSEUDO[$type]) ? '' : '\\') . $type;
                }
                return ($nullable ? '?' : '') . implode('|', $result);
            }

            public function getTypes()
            {
                return (array) $this;
            }

            public function allows($type, $strict = false)
            {
                $types = array_flip($this->toStrings(false, false));

                if (isset($types['mixed'])) {
                    return true;
                }

                foreach ($types as $allow => $dummy) {
                    if (function_exists($f = "is_$allow") && $f($type)) {
                        return true;
                    }
                    if (is_a($type, $allow, true)) {
                        return true;
                    }
                }

                if (!$strict) {
                    if (is_int($type) || is_float($type) || is_bool($type)) {
                        if (isset($types['int']) || isset($types['float']) || isset($types['bool']) || isset($types['string'])) {
                            return true;
                        }
                    }
                    if (is_string($type) || (is_object($type) && method_exists($type, '__toString'))) {
                        if (isset($types['string'])) {
                            return true;
                        }
                        if ((isset($types['int']) || isset($types['float'])) && is_numeric("$type")) {
                            return true;
                        }
                    }
                }
                return false;
            }

            private function toStrings($ignore_compatible = true, $sort = true)
            {
                $types = [];
                foreach ($this->getTypes() as $type) {
                    // ドキュメント上は「ReflectionNamedType を返す可能性があります」とのことなので getName 前提はダメ
                    // かといって文字列化前提だと 7.1 以降で deprecated が出てしまう
                    // つまり愚直に分岐するか @ で抑制するくらいしか多バージョン対応する術がない（7.1 の deprecated を解除して欲しい…）
                    $types[$type instanceof \ReflectionNamedType ? $type->getName() : (string) $type] = true;

                    if ($type->allowsNull()) {
                        $types['null'] = true;
                    }
                }

                if ($ignore_compatible) {
                    $types = array_filter($types, function ($type) use ($types) {
                        // いくつか互換のある内包疑似型が存在する（iterable は array を内包するし、 bool は false を内包する）
                        foreach (self::PSEUDO[$type] ?? [] as $parent) {
                            if (isset($types[$parent])) {
                                return false;
                            }
                        }
                        // さらに object 疑似型は全てのクラス名を内包する
                        if (isset($types['object']) && !isset(self::PSEUDO[$type])) {
                            return false;
                        }
                        return true;
                    }, ARRAY_FILTER_USE_KEY);
                }

                if ($sort) {
                    static $orders = null;
                    $orders = $orders ?? array_flip(array_keys(self::PSEUDO));
                    uksort($types, function ($a, $b) use ($orders) {
                        $issetA = isset($orders[$a]);
                        $issetB = isset($orders[$b]);
                        switch (true) {
                            case $issetA && $issetB:   // 共に疑似型
                                return $orders[$a] - $orders[$b];
                            case !$issetA && !$issetB: // 共にクラス名
                                return strcasecmp($a, $b);
                            case !$issetA && $issetB:  // A だけがクラス名
                                return -1;
                            case $issetA && !$issetB:  // B だけがクラス名
                                return +1;
                        }
                    });
                }
                return array_keys($types);
            }
        };
    }

    /**
     * クラス定数が存在するか調べる
     *
     * グローバル定数も調べられる。ので実質的には defined とほぼ同じで違いは下記。
     *
     * - defined は単一引数しか与えられないが、この関数は2つの引数も受け入れる
     * - defined は private const で即死するが、この関数はきちんと調べることができる
     * - ClassName::class は常に true を返す
     *
     * あくまで存在を調べるだけで実際にアクセスできるかは分からないので注意（`property_exists` と同じ）。
     *
     * Example:
     * ```php
     * // クラス定数が調べられる（1引数、2引数どちらでも良い）
     * that(const_exists('ArrayObject::STD_PROP_LIST'))->isTrue();
     * that(const_exists('ArrayObject', 'STD_PROP_LIST'))->isTrue();
     * that(const_exists('ArrayObject::UNDEFINED'))->isFalse();
     * that(const_exists('ArrayObject', 'UNDEFINED'))->isFalse();
     * // グローバル（名前空間）もいける
     * that(const_exists('PHP_VERSION'))->isTrue();
     * that(const_exists('UNDEFINED'))->isFalse();
     * ```
     *
     * @param string|object $classname 調べるクラス
     * @param ?string $constname 調べるクラス定数
     * @return bool 定数が存在するなら true
     */
    public static function const_exists($classname, $constname = null)
    {
        $colonp = strpos($classname, '::');
        if ($colonp === false && strlen($constname) === 0) {
            return defined($classname);
        }
        if (strlen($constname) === 0) {
            $constname = substr($classname, $colonp + 2);
            $classname = substr($classname, 0, $colonp);
        }

        try {
            $refclass = new \ReflectionClass($classname);
            if (strcasecmp($constname, 'class') === 0) {
                return true;
            }
            return $refclass->hasConstant($constname);
        }
        catch (\Throwable $t) {
            return false;
        }
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
     * that(object_dive($class, 'a.b.c'))->isSame('vvv');
     * that(object_dive($class, 'a.b.x', 9))->isSame(9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * that(object_dive($class, ['a', 'b', 'c']))->isSame('vvv');
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
     * クラス定数を配列で返す
     *
     * `(new \ReflectionClass($class))->getConstants()` とほぼ同じだが、可視性でフィルタができる。
     * さらに「自分自身の定義か？」でもフィルタできる。
     *
     * Example:
     * ```php
     * $class = new class extends \ArrayObject
     * {
     *     private   const C_PRIVATE   = 'private';
     *     protected const C_PROTECTED = 'protected';
     *     public    const C_PUBLIC    = 'public';
     * };
     * // 普通に全定数を返す
     * that(get_class_constants($class))->isSame([
     *     'C_PRIVATE'      => 'private',
     *     'C_PROTECTED'    => 'protected',
     *     'C_PUBLIC'       => 'public',
     *     'STD_PROP_LIST'  => \ArrayObject::STD_PROP_LIST,
     *     'ARRAY_AS_PROPS' => \ArrayObject::ARRAY_AS_PROPS,
     * ]);
     * // public のみを返す
     * that(get_class_constants($class, IS_PUBLIC))->isSame([
     *     'C_PUBLIC'       => 'public',
     *     'STD_PROP_LIST'  => \ArrayObject::STD_PROP_LIST,
     *     'ARRAY_AS_PROPS' => \ArrayObject::ARRAY_AS_PROPS,
     * ]);
     * // 自身定義でかつ public のみを返す
     * that(get_class_constants($class, IS_OWNSELF | IS_PUBLIC))->isSame([
     *     'C_PUBLIC'       => 'public',
     * ]);
     * ```
     *
     * @param string|object $class クラス名 or オブジェクト
     * @param ?int $filter アクセスレベル定数
     * @return array クラス定数の配列
     */
    public static function get_class_constants($class, $filter = null)
    {
        $class = ltrim(is_object($class) ? get_class($class) : $class, '\\');
        $filter = $filter ?? (IS_PUBLIC | IS_PROTECTED | IS_PRIVATE);

        $result = [];
        foreach ((new \ReflectionClass($class))->getReflectionConstants() as $constant) {
            if (($filter & IS_OWNSELF) && $constant->getDeclaringClass()->name !== $class) {
                continue;
            }
            $modifiers = $constant->getModifiers();
            $modifiers2 = 0;
            $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PUBLIC) ? IS_PUBLIC : 0;
            $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PROTECTED) ? IS_PROTECTED : 0;
            $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PRIVATE) ? IS_PRIVATE : 0;
            if ($modifiers2 & $filter) {
                $result[$constant->name] = $constant->getValue();
            }
        }
        return $result;
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
     * that(get_object_properties($object))->arraySubset([
     *     'message' => 'something',
     *     'code'    => 42,
     *     'oreore'  => 'oreore',
     * ]);
     * ```
     *
     * @param object $object オブジェクト
     * @return array 全プロパティの配列
     */
    public static function get_object_properties($object)
    {
        $fields = [];
        foreach ((array) $object as $name => $field) {
            if (preg_match('#\A\\000(.+?)\\000(.+)#usm', $name, $m)) {
                $name = $m[2];
            }
            if (!array_key_exists($name, $fields)) {
                $fields[$name] = $field;
            }
        }
        return $fields;
    }
}

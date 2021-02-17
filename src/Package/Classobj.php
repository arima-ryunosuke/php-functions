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
                            /** @var \ReflectionNamedType $rtype */
                            $rtype = $refmethod->getReturnType();
                            $declare .= ':' . ($rtype->allowsNull() ? '?' : '') . ($rtype->isBuiltin() ? '' : '\\') . $rtype->getName();
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
            $cachefile = (cachedir)() . '/' . rawurlencode(__FUNCTION__ . '-' . $classname);
            if (!file_exists($cachefile)) {
                touch($cachefile);
                $declares = "";
                foreach ($classmethods as $name => $method) {
                    $ref = $method->returnsReference() ? '&' : '';
                    $receiver = $method->isStatic() ? 'self::$__originalClass::' : '$this->__original->';
                    $modifier = implode(' ', \Reflection::getModifierNames($method->getModifiers()));

                    $params = (function_parameter)($method);
                    $prms = implode(', ', $params);
                    $args = implode(', ', array_keys($params));
                    $rtype = '';
                    if ($method->hasReturnType()) {
                        /** @var \ReflectionNamedType $rt */
                        $rt = $method->getReturnType();
                        $rtype = ':' . ($rt->allowsNull() ? '?' : '') . ($rt->isBuiltin() ? '' : '\\') . $rt->getName();
                    }
                    $declares .= "$modifier function $ref$name($prms)$rtype { \$return = $ref$receiver$name(...[$args]);return \$return; }\n";
                }
                $traitcode = "trait X{$classalias}Trait\n{{$template_source}{$declares}}";
                file_put_contents("$cachefile-trait.php", "<?php\n" . $traitcode, LOCK_EX);

                $classcode = "class X{$classalias}Class extends $classname\n{use X{$classalias}Trait;}";
                file_put_contents("$cachefile-class.php", "<?php\n" . $classcode, LOCK_EX);
            }
            require_once "$cachefile-trait.php";
            require_once "$cachefile-class.php";
            $spawners[$classname] = [
                'original' => $refclass,
                'methods'  => $classmethods,
                'trait'    => new \ReflectionClass("X{$classalias}Trait"),
                'class'    => new \ReflectionClass("X{$classalias}Class"),
            ];
        }

        $overrides = array_intersect_key($methods, $spawners[$classname]['methods']);
        if ($overrides) {
            $declares = "";
            foreach ($overrides as $name => $override) {
                $method = $spawners[$classname]['methods'][$name];
                $ref = $method->returnsReference() ? '&' : '';
                $receiver = $method->isStatic() ? 'self::$__originalClass::' : '$this->__original->';
                $modifier = implode(' ', \Reflection::getModifierNames($method->getModifiers()));

                [, $codeblock] = (callable_code)($override);
                /** @var \ReflectionFunctionAbstract $refmember */
                $refmember = (reflect_callable)($override);
                // 指定クロージャに引数が無くて、元メソッドに有るなら継承
                $params = (function_parameter)($override);
                if (!$refmember->getNumberOfParameters() && $method->getNumberOfParameters()) {
                    $params = (function_parameter)($method);
                }
                // 同上。返り値版
                $rtype = '';
                if (!$refmember->hasReturnType() && $method->hasReturnType()) {
                    $rt = $method->getReturnType();
                    $rtype = ':' . ($rt->allowsNull() ? '?' : '') . ($rt->isBuiltin() ? '' : '\\') . $rt->getName();
                }

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
                $declares .= "$modifier function $ref$name($prms)$rtype $codeblock";
            }
            $newclassname = "X{$classalias}Class" . md5(uniqid('RF', true));
            (evaluate)("class $newclassname extends $classname\n{use X{$classalias}Trait;\n$declares}");
            return new $newclassname($spawners[$classname]['original'], $object, $fields, $methods);
        }

        return $spawners[$classname]['class']->newInstance($spawners[$classname]['original'], $object, $fields, $methods);
    }

    /**
     * クラス定数が存在するか調べる
     *
     * グローバル定数も調べられる。ので実質的には defined とほぼ同じで違いは下記。
     *
     * - defined は単一引数しか与えられないが、この関数は2つの引数も受け入れる
     * - defined は private const で即死するが、この関数はきちんと調べることができる
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
     * @param string $constname 調べるクラス定数
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
        $refclass = new \ReflectionClass($classname);
        return $refclass->hasConstant($constname);
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
     * @param int $filter アクセスレベル定数
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
        if (function_exists('get_mangled_object_vars')) {
            get_mangled_object_vars($object); // @codeCoverageIgnore
        }

        static $refs = [];
        $class = get_class($object);
        if (!isset($refs[$class])) {
            // var_export や var_dump で得られるものは「親が優先」となっているが、不具合的動作だと思うので「子を優先」とする
            $refs[$class] = [];
            $ref = new \ReflectionClass($class);
            do {
                $refs[$ref->name] = (array_each)($ref->getProperties(), function (&$carry, \ReflectionProperty $rp) {
                    if (!$rp->isStatic()) {
                        $rp->setAccessible(true);
                        $carry[$rp->getName()] = $rp;
                    }
                }, []);
                $refs[$class] += $refs[$ref->name];
            } while ($ref = $ref->getParentClass());
        }

        // 配列キャストだと private で ヌル文字が出たり static が含まれたりするのでリフレクションで取得して勝手プロパティで埋める
        $vars = (array_map_method)($refs[$class], 'getValue', [$object]);
        $vars += get_object_vars($object);

        return $vars;
    }
}

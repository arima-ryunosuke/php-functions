<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_unset.php';
require_once __DIR__ . '/../funchand/is_bindable_closure.php';
require_once __DIR__ . '/../misc/evaluate.php';
require_once __DIR__ . '/../misc/php_tokens.php';
require_once __DIR__ . '/../reflection/callable_code.php';
require_once __DIR__ . '/../reflection/function_parameter.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

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
 * $implements でインターフェースの配列を渡すとすべてが動的に implement される。
 * つまり得られたオブジェクトが instanceof を通るようになる。
 * もちろんメソッド配列としてその名前が含まれていなければならない。
 *
 * 内部的にはいわゆる Decorator パターンを動的に実行しているだけであり、実行速度は劣悪。
 * 当然ながら final クラス/メソッドの拡張もできない。
 *
 * Example:
 * ```php
 * // Exception に「count」メソッドと「コードとメッセージを結合して返す」メソッドを動的に生やす
 * $object = new \Exception('hoge', 123);
 * $newobject = class_extends($object, [
 *     'count'       => function () { return $this->code; },
 *     'codemessage' => function () {
 *         // bind されるので protected フィールドが使える
 *         return $this->code . ':' . $this->message;
 *     },
 * ], [], [\Countable::class]);
 * that($newobject->count())->isSame(123);
 * that($newobject->codemessage())->isSame('123:hoge');
 * that($newobject)->isInstanceOf(\Countable::class); // instanceof をパスできる
 *
 * // オーバーライドもできる（ArrayObject の count を2倍になるように上書き）
 * $object = new \ArrayObject([1, 2, 3]);
 * $newobject = class_extends($object, [
 *     'count' => function () {
 *         // parent は元オブジェクトを表す
 *         return parent::count() * 2;
 *     },
 * ]);
 * that($newobject->count())->isSame(6);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @template T
 * @param T $object 対象オブジェクト
 * @param \Closure[] $methods 注入するメソッド
 * @param array $fields 注入するフィールド
 * @param array $implements 実装するインターフェース
 * @return T $object を拡張した object
 */
function class_extends($object, $methods, $fields = [], $implements = [])
{
    assert(is_array($methods));

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

                public function __clone()
                {
                    $this->__original = clone $this->__original;
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
            },
        );
        // @codeCoverageIgnoreEnd
        $sl = $template_reflection->getStartLine();
        $el = $template_reflection->getEndLine();
        $template_source = array_slice(file($template_reflection->getFileName()), $sl, $el - $sl - 1, true);
    }

    $parse = static function ($name, \ReflectionFunctionAbstract $reffunc) {
        if ($reffunc instanceof \ReflectionMethod) {
            $modifier = implode(' ', \Reflection::getModifierNames($reffunc->getModifiers()));
            $receiver = ($reffunc->isStatic() ? 'self::$__originalClass::' : '$this->__original->') . $name;
        }
        else {
            $bindable = is_bindable_closure($reffunc->getClosure());
            $modifier = $bindable ? '' : 'static ';
            $receiver = ($bindable ? '$this->__methods' : 'self::$__staticMethods') . "[" . var_export($name, true) . "]";
        }

        $ref = $reffunc->returnsReference() ? '&' : '';

        $params = function_parameter($reffunc);
        $prms = implode(', ', $params);
        $args = implode(', ', array_keys($params));

        $rtype = strval($reffunc->getReturnType());
        $return = $rtype === 'void' ? '' : 'return $return;';
        $rtype = $rtype ? ": $rtype" : '';

        return [
            "#[\ReturnTypeWillChange]\n$modifier function $ref$name($prms)$rtype",
            "{ \$return = $ref$receiver(...[$args]);$return }\n",
        ];
    };

    /** @var \ReflectionClass[][]|\ReflectionMethod[][][] $spawners */
    static $spawners = [];

    $classname = get_class($object);
    $classalias = str_replace('\\', '__', $classname);

    if (!isset($spawners[$classname])) {
        $template = $template_source;
        $template_methods = get_class_methods($template_reflection->getName());
        $refclass = new \ReflectionClass($classname);
        $classmethods = [];
        foreach ($refclass->getMethods() as $method) {
            if (in_array($method->getName(), $template_methods)) {
                if ($method->isFinal()) {
                    $template_method = $template_reflection->getMethod($method->name);
                    array_unset($template, range($template_method->getStartLine() - 1, $template_method->getEndLine()));
                }
            }
            else {
                if (!$method->isFinal() && !$method->isAbstract()) {
                    $classmethods[$method->name] = $method;
                }
            }
        }

        $cachefile = function_configure('cachedir') . '/' . rawurlencode(__FUNCTION__ . '-' . $classname) . '.php';
        if (!file_exists($cachefile)) {
            $declares = "";
            foreach ($classmethods as $name => $method) {
                $declares .= implode(' ', $parse($name, $method));
            }
            $traitcode = "trait X{$classalias}Trait\n{\n" . implode('', $template) . "{$declares}}";
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
        $params = function_parameter(!$refmember->getNumberOfParameters() && $method->getNumberOfParameters() ? $method : $override);
        $rtype = strval((!$refmember->hasReturnType() && $method->hasReturnType() ? $method : $refmember)->getReturnType());
        $rtype = $rtype ? ": $rtype" : '';

        [, $codeblock] = callable_code($override);
        $tokens = php_tokens('<?php ' . $codeblock);
        array_shift($tokens);
        $parented = null;
        foreach ($tokens as $n => $token) {
            if ($token->id !== T_WHITESPACE) {
                if ($token->id === T_STRING && $token->text === 'parent') {
                    $parented = $n;
                }
                elseif ($parented !== null && $token->id === T_DOUBLE_COLON) {
                    unset($tokens[$parented]);
                    $tokens[$n] = clone $tokens[$n];
                    $tokens[$n]->text = $receiver;
                }
                else {
                    $parented = null;
                }
            }
        }
        $codeblock = implode('', array_column($tokens, 'text'));

        $prms = implode(', ', $params);
        $declares .= "#[\ReturnTypeWillChange]\n$modifier function $ref$name($prms)$rtype $codeblock\n";
    }

    $newclassname = "X{$classalias}Class" . md5(uniqid('RF', true));
    $implements = $implements ? 'implements ' . implode(',', $implements) : '';
    evaluate("class $newclassname extends $classname $implements\n{\nuse X{$classalias}Trait;\n$declares}");
    return new $newclassname($spawners[$classname]['original'], $object, $fields, $methods);
}
